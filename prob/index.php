<?php
session_start();

$conf = 0;
$userid;
if (isset($_SESSION['sign']) && isset($_SESSION['uid']) && ($_SESSION['sign'] == 1 || $_SESSION['sign'] == "1")) {
    $conf = 1;
    $userid = $_SESSION['uid'];
}
$idver = 0;
$conn = mysqli_connect("localhost", "root", "", "codebreak");
$sql = "SELECT * FROM problems";
$query = mysqli_query($conn, $sql);


$id;
$problem_data;
if ($_GET['id'] && !is_nan($_GET['id'])) {

    $id = $_GET['id'];
    $idcheck = "select * from problems where id = $id";
    $idcheck_query = mysqli_query($conn, $idcheck);
    if (mysqli_num_rows($idcheck_query) == 1) {
        $idver = 1;
        $problem_data = mysqli_fetch_assoc($idcheck_query);
    }
}

if ($idver == 0) {
    header("HTTP/1.0 404 Not Found");
    die("The Problem could not be found");
}

$probname = $problem_data['name'];
$probstat = $problem_data['statement'];
$probtest = $problem_data['sample_testcase'];
$probtask = $problem_data['task'];

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
            width: 600px;
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

        .heading {
            font-family: 'Fira Code', monospace;
            font-size: 30px;
        }
        .card{
            margin: 20px;
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
                    <a class="nav-link active" aria-current="page" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../problems/">Problems</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../news/">News</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../user/"><?php if($conf==1){echo $_SESSION['uid'];}?></a>
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
<center>
    <span class="heading"> <?php echo $probname; ?></span>
</center>
<br>
<div class="card">
    <div class="card-header">
        Problem Statement
    </div>
    <div class="card-body">
        <blockquote class="blockquote mb-0">
            <?php echo $probstat; ?>
        </blockquote>
    </div>
</div>
<div class="card">
    <div class="card-header">
        Sample Test Data
    </div>
    <div class="card-body">
        <blockquote class="blockquote mb-0">
            <?php echo $probtest; ?>
        </blockquote>
    </div>
</div>
<div class="card">
    <div class="card-header">
        User Task
    </div>
    <div class="card-body">
        <blockquote class="blockquote mb-0">
            <?php echo $probtask; ?>
            <?php if ($conf == 1) { ?>
                <form action="../checker/" method="post">
                    <input name="id" type="number" value="<?php echo $id;?>" style="visibility: hidden">
                    <input name="name" type="text" value="<?php echo $probname;?>" style="visibility: hidden">
                    <input name="userid" type="text" value="<?php echo $userid;?>" style="visibility: hidden">
                    <br>
                    <textarea id="solution" class="answer" name="user_solution" type="text" required></textarea><br>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

            <?php  } else { ?>
                Login to Submit your solution
            <?php  } ?>
        </blockquote>
    </div>
</div>
<br><br>
<center>


</center>
<br>

</body>

</html>