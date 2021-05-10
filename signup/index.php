<?php
session_start();
if (isset($_SESSION['sign']) && isset($_SESSION['uid']) && ($_SESSION['sign'] == 1 || $_SESSION['sign'] == "1")) {
    header("location:../");
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
//registration
$c = 0;
$msg1 = "";
$err1 = 0;
if (isset($_POST['submit'])) {
    $con = mysqli_connect("localhost", "root", "", "codebreak");
    $fname = trim(mysqli_real_escape_string($con, $_POST['fname']));
    $lname = trim(mysqli_real_escape_string($con, $_POST['lname']));
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $username = strtolower($fname . "." . $lname);
    if (!preg_match("/^[a-zA-Z]*$/", $fname) || ctype_space($_POST['fname']) || $fname == "") {
        $msg1 =  $msg1 . "Invalid First Name<br>";
        $err1++;
    }
    if (!preg_match("/^[a-zA-Z]*$/", $lname) || ctype_space($_POST['lname']) || $lname == "") {
        $msg1 =  $msg1 . "Invalid Last Name<br>";
        $err1++;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg1 =  $msg1 . "Invalid Email<br>";
        $err1++;
    }
    if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/", $_POST['password'])) {
        $msg1 =  $msg1 . "Password must contain <br>minimum eight characters <br>at least one letter <br>one number <br>one special character <br>";
        $err1++;
    }
    if ($err1 == 0) {
        $sql4 = "select * from users where username='$username' ";
        $query4 = mysqli_query($con, $sql4);
        $num4 = mysqli_num_rows($query4);
        if ($num4 != 0) {
            for ($i = 1; $i <= 1000; $i++) {
                $username = strtolower($fname . "." . $lname . "." . $i);
                $sql4 = "select * from users where username='$username' ";
                $query4 = mysqli_query($con, $sql4);
                $num4 = mysqli_num_rows($query4);
                if ($num4 != 0) {
                    continue;
                } else {
                    break;
                }
            }
        }
        $sql = "select * from users where email= '$email'";
        $query = mysqli_query($con, $sql);
        $num = mysqli_num_rows($query);
        // $otp = mt_rand(100000,999999); 
        if ($num == 0) {
            //$sql2 = "insert into users(fname,lname,email,password,username) values('$fname','$lname','$email','$password','$username')";
            //$query2 = mysqli_query($con,$sql2);
            //if($query2){
            $_SESSION['vc'] = mt_rand(100000, 999999);
            require_once "../vendor/autoload.php";
            $mail = new PHPMailer(true); //Argument true in constructor enables exceptions
            $mail->IsSMTP();
            $mail->Host = "smtp.hostinger.in";
            $mail->SMTPDebug = 0;
            // optionals
            // used only when SMTP requires authentication  
            $mail->SMTPAuth = true;
            $mail->Username = 'team@itoi.club';
            $mail->Password = 'weare420daero';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            //From email address and name
            $mail->From = "team@itoi.club";
            $mail->FromName = "Code Break";
            //To address and name
            $mail->addAddress($email, $fname . " " . $lname);
            //Address to which recipient will reply
            $mail->addReplyTo("team@itoi.club", "Reply");
            //CC and BCC
            //Send HTML or Plain Text email
            $mail->isHTML(true);
            $mail->Subject = "Code Break Verification Code";
            $mail->Body = "Your verification code is : " . $_SESSION['vc'];
            try {
                $mail->send();
                $c = 1;
                $_SESSION['email'] = $email;
                $_SESSION['det'] = $fname . " " . $lname . " " . $password . " " . $username;
            } catch (Exception $e) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            }
            //   $_SESSION['email']=$email;          
            //} else {
            //$msg1 =  $msg1."Something went wrong";
            //}
        } else {
            $msg1 =  $msg1 . "Account Exists";
        }
        mysqli_close($con);
    }
}
$v = 0;
if (isset($_POST['verify'])) {
    if ($_POST['vcode'] == $_SESSION['vc']) {
        $con = mysqli_connect("localhost", "root", "", "codebreak");
        $email = $_SESSION['email'];
        $arr = explode(" ", $_SESSION['det']);

        $fname = $arr[0];
        $lname = $arr[1];
        $password = $arr[2];
        $username = $arr[3];
        $_SESSION['sign'] = 1;
        $_SESSION['uid'] = $username;
        $sql = "insert into users(fname,lname,email,password,username,verified) values('$fname','$lname','$email','$password','$username','1')";
        $query2 =  mysqli_query($con, $sql);
        $fp = fopen('../submission_data/' . $username . '.json', 'w+');
        fclose($fp);
        $fp2 = fopen('../submission_data/' . $username . '.all.json', 'w+');
        fclose($fp2);
        if ($query2 && $fp && $fp2) {
            $c = 3;
            $v = 1;
            unset($_SESSION['det']);
            unset($_SESSION['vc']);
        } else {
            $v = 3;
            $c = 3;
        }
    } else {
        $c = 1;
        $v = 2;
    }
}
?>

<html lang="en">

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@300&display=swap" rel="stylesheet">
    <title>Break Code</title>
    <style>
        .navbar-brand {
            font-family: 'Press Start 2P', cursive;
        }

        .nav-link {
            font-family: 'Press Start 2P', cursive;
        }

        .accordion {
            margin: 50px;
        }

        .answer {
            width: 300px;
            height: 50px;
            border: 1px solid black;
            border-radius: 10px;
            padding: 10px;
        }

        .alert {
            width: 800px;
        }

        .body-text {
            font-family: 'Fira Code', monospace;
        }

        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            color: #414141;
            font-family: 'Fira Code', monospace;
            text-align: center;
        }
    </style>
    <!-- <script>
function showHint(str) {
  if (str.length == 0) {
    document.getElementById("follow").innerHTML = "";
    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("follow").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("POST", "data.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    
    xmlhttp.send("email="+str);
  }
}
</script> -->
    <style>
        body,
        html {
            margin: 0;
            box-sizing: border-box;
            font-family: sans-serif;
        }

        @media only screen and (min-width: 768px) {
            .content {
                width: 100%;
                height: 100%;
                display: grid;
                grid-template-columns: 40% 60%;
            }

            .c1 {
                background: black;
                text-align: center;
                color: white;
                padding: 15px;
                font-size: 5vw;

            }

            .c2 {
                background: #ffffff;
                text-align: center;
                color: white;
                padding: 10px;
                font-size: 5vw;
                align-content: center;
            }

            .card {
                margin: 2.5vw;
                background: white;
                border-radius: 5px;
                width: 70%;
                padding: 10px;
                font-size: 15px;
                color: black;

            }

            .formstyle {
                margin: 5px;
                font-size: 2.3vh;
                padding: 10px;
                outline: none;
                border: 1px solid grey;
                text-align: center;
                border-radius: 5px;
            }

        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="../">Code Break</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="problems/">Problems</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Forum</a>
                    </li>
                </ul>
            </div>
        </div>

    </nav>
    <div class=c2>
        <center>
            <div class="card">
                <?php if ($c == 0) { ?>
                    <br>Signup<br><br>
                    <form method=post action="">
                        <input class="formstyle" type="text" name="fname" placeholder="First Name" value="<?php if (isset($_POST['fname'])) {
                                                                                                                echo $_POST['fname'];
                                                                                                            } ?>">
                        <br><br>
                        <input class="formstyle" type="text" name="lname" placeholder="Last Name" value="<?php if (isset($_POST['lname'])) {
                                                                                                                echo $_POST['lname'];
                                                                                                            } ?>">
                        <br><br>
                        <input id=email autocomplete=off class="formstyle" type="email" name="email" placeholder="Email" value="<?php if (isset($_POST['email'])) {
                                                                                                                                    echo $_POST['email'];
                                                                                                                                } ?>"><br>
                        <br>
                        <input class="formstyle" type="password" name="password" placeholder="Password">
                        <br><br>
                        <?php if ($msg1 != "" && isset($msg1)) {
                            echo $msg1 . "<br>";
                        } ?>

                        <input class="formstyle" style="cursor:pointer;width:100px;background:orange;color:white;border:none;" type="submit" name="submit" value="Signup">
                    </form>
                <?php } else if ($c == 1) {
                ?>
                    <form method=post action="">
                        <input class="formstyle" type="number" name="vcode" placeholder="Enter Verification Code">

                        <br><br>

                        <?php
                        if ($v == 2) {
                            echo "Wrong code<br><br>";
                        }
                        ?>
                        <input class="formstyle" style="cursor:pointer;width:100px;background:orange;color:white;border:none;" type="submit" name="verify" value="Verify">
                    </form>
                <?php
                } ?>
                <?php if ($v == 1) {
                    echo "Verified<br>You will be redirected to dashboard<br>";
                ?>
                    <script>
                        setTimeout(function() {
                            window.location.href = '../';
                        }, 5000);
                    </script>
                <?php
                } ?>
                <?php if ($v == 3) {
                    echo "Something went wrong. Try again later.<br>";
                }
                ?>
            </div>

        </center>
    </div>
    </div>
    <div class="footer">
        <p>Copyright 2021 Daero | Privacy Policy</p>
    </div>
</body>

</html>