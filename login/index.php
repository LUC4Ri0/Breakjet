<?php
session_start();
if (isset($_SESSION['sign']) && isset($_SESSION['uid']) && ($_SESSION['sign'] == 1 || $_SESSION['sign'] == "1")) {
    header("location:../");
}

//login
$c = 0;
$msg1 = "";
$err1 = 0;
if (isset($_POST['submit'])) {
    $con = mysqli_connect("localhost", "root", "", "codebreak");
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg1 =  $msg1 . "Invalid Email<br>";
        $err1++;
    }
    if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/", $_POST['password'])) {
        $msg1 =  $msg1 . "The password you wrote is not the usual kind we deal with.<br>";
        $err1++;
    }
    if ($err1 == 0) {
        $sql4 = "select * from users where email= '$email'";
        $query4 = mysqli_query($con, $sql4);
        $num4 = mysqli_num_rows($query4);
        if ($num4 == 0) {
            $msg1 =  $msg1 . "No account exists with that email.<br>";
        } else {
            $data = mysqli_fetch_assoc($query4);
            $hash = $data['password'];

            if (!password_verify($_POST['password'], $hash)) {
                $msg1 =  $msg1 . "The Password is wrong.<br>" . password_verify($_POST['password'], $hash);
            } else {
                $_SESSION['sign'] = 1;
                $_SESSION['uid'] = $data['username'];
                header("location:../");
            }
        }

        mysqli_close($con);
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
        .navbar-brand{
            font-family: 'Press Start 2P', cursive;
        }
        .nav-link{
            font-family: 'Press Start 2P', cursive;
        }
        .accordion{
            margin:50px;
        }
        .answer{
            width: 300px;
            height: 50px;
            border: 1px solid black;
            border-radius: 10px;
            padding: 10px;
        }
        .alert{
            width: 800px;
        }
        .body-text{
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
                margin: 7.5vw;
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
                    <a class="nav-link" href="../problems/">Problems</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../news/">News</a>
                </li>
            </ul>
        </div>
    </div>

</nav>
        <div class=c2>
            <center>
                <div class="card">

                    <br>Login<br><br>
                    <form method=post action="">
                        <input id=email autocomplete=off class="formstyle" type="email" name="email" placeholder="Email" value="<?php if (isset($_POST['email'])) {
                                                                                                                                    echo $_POST['email'];
                                                                                                                                } ?>"><br>
                        <br>
                        <input class="formstyle" type="password" name="password" placeholder="Password">
                        <br><br>
                        <?php if ($msg1 != "" && isset($msg1)) {
                            echo $msg1 . "<br>";
                        } ?>

                        <input class="formstyle" style="cursor:pointer;width:100px;background:orange;color:white;border:none;" type="submit" name="submit" value="Login">
                    </form>



                </div>

            </center>
        </div>
    </div>
<!--    <div class="footer">-->
<!--        <p>Copyright 2021 Daero | Privacy Policy</p>-->
<!--    </div>-->
</body>

</html>