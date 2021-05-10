<?php
session_start();
$conf = 0;
if (isset($_SESSION['sign']) && isset($_SESSION['uid']) && ($_SESSION['sign'] == 1 || $_SESSION['sign'] == "1")) {
    $conf = 1;
}
$conn = mysqli_connect("localhost", "root", "", "codebreak");
$sql = "SELECT * FROM problems";
$query = mysqli_query($conn, $sql);
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

            .table {
                margin: 0 auto;
                width: 400px;
            }
            .alert{
                margin: 50px;
            }
            .body-text {
                font-family: 'Fira Code', monospace;
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
                        <a class="nav-link" aria-current="page" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Problems</a>
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
    <br><br><br>
<?php if ($conf == 1) {  ?>
    <table class="table table-hover">
        <thead>
        <td>ID</td>
        <td>Name</td>
        <td>Link</td>

            <td>Submit </td>
            <td>Status</td>
        <td>Solved By</td>
        </thead>
        <tbody>
        <?php
        $c = mysqli_num_rows($query);
        $file2 = "../submission_data/";
        $file2.= $_SESSION['uid'];
        $file2.=".json";

        $data_results2 = file_get_contents($file2);
        $temp = json_decode( $data_results2 );
        $size = filesize($file2);
        while ($c > 0) {
            $sq = "SELECT * FROM problems WHERE id=$c";
            $query = mysqli_query($conn, $sq);
            $row = mysqli_fetch_assoc($query);
            $flag=false;
            if($size>0){
                foreach($temp as $obj) {
                    if ($obj->id == $c) {
                        $flag = true;
                    }
                }
            }

            ?>
            <tr>
                <td><?php echo $row["id"]; ?></td>
                <td><?php echo $row["name"]; ?></td>
                <td><a href="../prob?id=<?php echo $row['id']; ?>">View</a> </td>
                <?php if ($conf == 1) {  ?>
                    <td><a href="#">Submit</a> </td>
                    <td><?php
                        if($flag==true){
                            ?>
                            <img src="../images/check.png" style="width: 20px;height: 20px;">
                                <?php
                        }
                        ?>
                        </td>
                <?php } ?>
                <td><?php echo $row["solved"]; ?></td>
            </tr>
            <?php
            $c--;
        }
        ?>




        </tbody>

    </table>
<?php }
else{

    ?>
        <center>
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
        Please Login or Signup to solve problems and keep track of them.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
        </center>
    <table class="table table-hover">
        <thead>
        <td>ID</td>
        <td>Name</td>
        <td>Link</td>
        <td>Solved By</td>
        </thead>
        <tbody>
        <?php
        $c = mysqli_num_rows($query);
        $s = $c;
        while ($c > 0) {
            $sq = "SELECT * FROM problems WHERE id=$c";
            $query = mysqli_query($conn, $sq);
            $row = mysqli_fetch_assoc($query);

            ?>
            <tr>
                <td><?php echo $row["id"]; ?></td>
                <td><?php echo $row["name"]; ?></td>
                <td><a href="../prob?id=<?php echo $row['id']; ?>">View</a> </td>
                <td><?php echo $row["solved"]; ?></td>
            </tr>
            <?php
            $c--;
        }
        ?>




        </tbody>

    </table>
        <?php
}
?>
    </body>

    </html>

<?php
mysqli_close($conn);
?>