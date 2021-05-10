<?php
     session_start();
     $name = $_SESSION['uid'];
?>
<!DOCTYPE html>
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
    <title>Submissions</title>

    <style>
        .submissionCard{
            height: 800px;
            width: 800px;
            margin-top: 100px;
        }
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
            color: black;
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

            </ul>
        </div>
    </div>

</nav>
<br>
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link" aria-current="page" href="#">user</a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Settings</a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../edit/">Edit Details</a></li>
            <li><a class="dropdown-item" href="../changepwd/">Change Password</a></li>
        </ul>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="#">Recent Submissions</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">Codes Broken</a>
    </li>
</ul>
<br>
    <center>
        <table class="table table-striped table-dark" style="margin-top: 100px; width: 800px;">
            <thead>
              <tr>
                <th scope="col">#ID</th>
                <th scope="col">Problem Name</th>
                <th scope="col">Result</th>
                <th scope="col">Date</th>
              </tr>
            </thead>
            <tbody>
            <?php
              $name .= ".all.json";
              $data_results=file_get_contents($name);
              $arr=json_decode($data_results);
              if(empty($arr)){
                ?>
                <center><?php echo " No Recent Submissions";?></center>
                <?php
              }
              else{
                foreach($arr as $obj){ ?>
                  <tr>
                      <th scope="row"><?php echo $obj->id;?></th>
                      <td><a href="../prob/?id=<?php echo $obj->id;?>"><?php echo $obj->title;?></a></td>
                      <td><?php echo $obj->status;?></td>
                      <td><?php echo $obj->date;?></td>
                  </tr>
                <?php }
              }
              ?>
            </tbody>
          </table>
    </center>
</body>
</html>