<?php

session_start();
$conf = 0;
if (isset($_SESSION['sign']) && isset($_SESSION['uid']) && ($_SESSION['sign'] == 1 || $_SESSION['sign'] == "1")) {
    $conf = 1;
}

$uid = $_SESSION['uid'];
$conn = mysqli_connect("localhost","root","","codebreak");
$sql = "SELECT * FROM users WHERE username='$uid'";
$query = mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($query);

?>

<!doctype html>
<html lang="en">
<head>
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
        .nav{
            font-family: 'Fira Code', monospace;
            margin: 10px;
            font-size: 13px;
        }
    </style>
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
                    <a class="nav-link " aria-current="page" href="#">About</a>
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
        <a class="nav-link active" aria-current="page" href="#"><?php echo $_SESSION['uid'];?></a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Settings</a>
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
</ul>
<br>
<center>
    <div class="proCard">
        <div class="card mb-3" style="max-width: 800px;">
            <div class="row g-0">
                <div class="col-md-4">
                    <img id="proPic" style="height: 300px; width: 250px;" src="../assets/dp/<?php echo $row['profilephoto']?>" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h1 class="card-title"><?php echo $row['fname']." ".$row['lname']?></h1>
                            <h5 class="card-title"><div id="country">India</div></h5>
                            <h5 class="card-title"><div id="SubsCount">Email: <?php echo $row['email']?></div></h5>

                    </div>
                </div>
            </div>
        </div>
    </div>
</center>
<div class="footer">
    <p>Copyright 2021 Daero | Privacy Policy</p>
</div>
</body>
</html>