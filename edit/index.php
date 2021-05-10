<?php

session_start();

$conf = 0;
if (isset($_SESSION['sign']) && isset($_SESSION['uid']) && ($_SESSION['sign'] == 1 || $_SESSION['sign'] == "1")) {
    $conf = 1;
}
$flag = 0;
$err1 = 0;
$msg1 = "";
if (isset($_POST['update'])) {

    if (!preg_match("/^[a-zA-Z ]*$/", $_POST['fname']) || ctype_space($_POST['fname']) || $_POST['fname'] == "") {
        $msg1 =  $msg1 . "Invalid First Name<br>";
        $err1++;
    }

    if (!preg_match("/^[a-zA-Z ]*$/", $_POST['lname']) || ctype_space($_POST['lname']) || $_POST['lname'] == "") {
        $msg1 =  $msg1 . "Invalid Last Name<br>";
        $err1++;
    }

    // if (!preg_match("/^(\+\d{2,4})?\s?(\d{10})$/", $_POST['contact'])) {
    //     $msg1 =  $msg1 . "Invalid Contact No.<br>";
    //     $err1++;
    // }

    if ($err1 == 0) {

        $con = mysqli_connect("localhost", "root", "");

        if (mysqli_select_db($con, 'codebreak')) {

            $se_email = $_SESSION['uid'];

            $sqlu = "select * from users where username = '$se_email'";

            $queryu = mysqli_query($con, $sqlu);

            $rowsu = mysqli_fetch_assoc($queryu);

            $fname = mysqli_real_escape_string($con, trim($_POST['fname']));

            $lname = mysqli_real_escape_string($con, trim($_POST['lname']));

            // $contact = mysqli_real_escape_string($con, trim($_POST['contact']));

            $sql2 = "update users set fname='$fname',lname='$lname' where username='$se_email' ";

            $query2 = mysqli_query($con, $sql2);
            $extension = strtolower(pathinfo($_FILES["uploadfile"]["name"], PATHINFO_EXTENSION));
            // echo $extension . "asdasdas";
            $str = $rowsu['username'] . "_" . hrtime(true) . "." . $extension;

            $tempname = $_FILES["uploadfile"]["tmp_name"];

            // $folder = strtolower("../public/images/" . $str);
            $query;
            $folder = strtolower("../assets/dp/" . $str);
            if ($extension != null && $extension != "") {

                if (move_uploaded_file($tempname, $folder)) {

                    $sql3 = "select * from users where username = '$se_email' ";

                    $query3 = mysqli_query($con, $sql3);

                    $rows3 = mysqli_fetch_assoc($query3);

                    if ($rows3['profilephoto'] != "" && $rows3['profilephoto'] != null) {

                        $uri = $rows3['profilephoto'];

                        unlink("../assets/dp/$uri");
                    }

                    $sql = "update users set profilephoto='$str' where username='$se_email' ";

                    $query = mysqli_query($con, $sql);
                }
            } else {
                $flag = 5;
                $query = false;
            }

            if ($query2 || $query) {

                ?>

                <script>
                    window.location.href = "#saved";
                </script>

                <?php

                $flag = 1;
            } else {

                ?>

                <script>
                    window.location.href = "#wrong";
                </script>

                <?php
                if ($flag != 2)
                    $flag = 2;
            }
        } else {

            ?>

            <script>
                window.location.href = "#later";
            </script>

            <?php

            $flag = 3;
        }
    }
}

?>

<html>



<head>

    <script>
        function validate() {

            var err = 0;

            var fname = document.getElementById("fname").value;

            var lname = document.getElementById("lname").value;

            // var contact = document.getElementById("contact").value;

            var p1 = /^[A-Za-z\s']+$/g;

            var p2 = /^[A-Za-z\s']+$/g;

            // var p2 = /^[0-9]+$/g;

            var r1 = p1.test(fname);

            var r2 = p2.test(lname);

            // var r2 = p2.test(contact);

            var a = "";



            if (r1 == false) {

                err++;

                a = a + "\nInvalid First Name";


            }



            if (r2 == false) {

                err++;

                a = a + "\nInvalid Last Name";


            }
            if (err > 0) {

                alert(a);

                return false;

            }
            return true;
        }
    </script>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
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
        .nav{
            font-family: 'Fira Code', monospace;
            margin: 10px;
            font-size: 13px;
        }
    </style>

</head>



<!-- Database Connection fetching through session -->

<?php

if (isset($_SESSION['uid'])) {

    $con = mysqli_connect("localhost", "root", "", "codebreak");

    $email = $_SESSION['uid'];

    $sql = "select * from users where username = '$email' ";

    $query = mysqli_query($con, $sql);

    $rows = mysqli_fetch_assoc($query);

    mysqli_close($con);
}

?>



<script>
    document.title = "<?php if (isset($_SESSION['uid'])) {
        echo $rows['fname'] . " " . $rows['lname'] . " - Break Code";
    }  ?>";
</script>

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
                    <a class="nav-link active" aria-current="page" href="../about/">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../problems/">Problems</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../news/">News</a>
                </li>
                <?php
                if($conf==1){
                    ?>
                    <li class="nav-item">
                        <a class="body-text" style="font-size: 15px;text-decoration: none;color: #414141;" href="../logout/">Logout</a>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>

</nav>
<br>
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link" aria-current="page" href="../user/"><?php echo $_SESSION['uid'];?></a>
    </li>
    <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle active" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Settings</a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../edit/">Edit Details</a></li>
            <li><a class="dropdown-item" href="../changepwd/">Change Password</a></li>
        </ul>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">Recent Submissions</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">Codes Broken</a>
    </li>
</ul><br>
<div class="container">

    <center>


        <br>

        <p class=text>

            <?php

            if (isset($_SESSION['uid'])) {

            ?>

        <form onsubmit="return validate()" method="post" action="" enctype="multipart/form-data">

                <span id="display">

                    <?php if (!isset($rows['profilephoto']) || $rows['profilephoto'] == "" || $rows['profilephoto'] == null) {

                        ?><img width=240 style="pointer-events:none;" class="profilephoto" src="../assets/dp/default.jpg"><br><?php
                    } else {

                        ?>
                        <img width=240 style="pointer-events:none;" class="profilephoto" src="../assets/dp/<?php echo $rows['profilephoto']; ?>">

                    <?php } ?>

                </span>

            <div id=input><input style="visibility:hidden" id="fileid" type="file" name="uploadfile" value="" accept="image/*" /></div>

            <center><label for="fileid"><span class="btn btn-success" style="font-size:17px">Select Image</span></label></center><br><br>
            <?php if ($msg1 != "" && isset($msg1)) {
                echo $msg1 . "<br>";
            } ?>
            <div class="mb-3">
                <!-- <label for="exampleFormControlInput1" class="form-label">Email address</label> -->
                <input style="text-align:center;" type="text" class="form-control" id="fname" name="fname" placeholder="First Name" value="<?php echo $rows['fname']; ?>">
            </div>
            <div class="mb-3">
                <!-- <label for="exampleFormControlInput1" class="form-label">Email address</label> -->
                <input style="text-align:center;" type="text" class="form-control" id="lname" name="lname" placeholder="Last Name" value="<?php echo $rows['lname']; ?>">
            </div>


            <br>

            <input class="btn btn-primary" style="font-size:17px;" type=submit name=update value="Update"><br><br>

        </form>

        <?php

        if ($flag == 1) {

            echo "<font id='saved' style='padding:10px;background:gainsboro;' color=green size=3>Successfully Changed</font>";
        } else if ($flag == 2) {

            echo "<font id='wrong' style='padding:10px;background:gainsboro;' color=red size=3>Something went Wrong. Please try again later.</font>";
        } else if ($flag == 3) {

            echo "<font id='later' style='padding:10px;background:gainsboro;' color=red size=3>Please Try Later</font>";
        } else if ($flag == 4) {

            echo "<font id='later' style='padding:10px;background:gainsboro;' color=red size=3>Max 2MB</font>";
        } else if ($flag == 5) {

            echo "<font id='later' style='padding:10px;background:gainsboro;' color=red size=3>No image selected.</font>";
        }

        ?>







        <?php

        } else {

            echo "Login to see this";

            // Code for inspiring them to signup / login

        }

        ?>

        </p>

    </center>

</div>

<script>
    window.onload = function() {

        var a = document.getElementById('fileid');

        var b = document.getElementById('display');

        a.addEventListener('change', function(e) {

            var file = a.files[0];



            if (file.type.match(/image.*/)) {

                if (file.size > 2097152) {



                    alert("Maximum file size allowed is 2MB");

                    a.value = "";
                    location.reload();

                } else {

                    var reader = new FileReader();

                    reader.onload = function(e) {

                        b.innerHTML = "";

                        var img = new Image();

                        img.src = reader.result;
                        img.width = 240;

                        b.appendChild(img);



                    }

                    document.getElementById('display').innerHTML = "";

                    reader.readAsDataURL(file);

                }

            } else {

                alert("Invalid File");

                a.value = "";

            }



        });

    }

    function logout() {

        window.location.href = "../signout";

    }

    function profile() {

        window.location.href = "../profile";

    }
</script>

</body>

</html>