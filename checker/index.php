<?php
if(isset($_POST['id'])&&isset($_POST['name'])&&isset($_POST['user_solution'])&&isset($_POST['userid'])){
    $id=$_POST['id'];
    $conn = mysqli_connect("localhost","root","","codebreak");
    $sql = "SELECT * FROM problems WHERE id='$id'";
    $query = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($query);
    $sol = $row['solution'];
    $date = date("Y-m-d h:i:sa");
    if($_POST['user_solution']==$sol){
        $additionalArray = array(
            'id' => $id,
            'title' => $_POST['name'],
            'date' => $date,
            'status' =>"accepted"
        );
        $file = "../submission_data/";
        $file.= $_POST['userid'];
        $file.=".all.json";
        $data_results = file_get_contents($file);
        $tempArray = json_decode($data_results);

        $tempArray[] = $additionalArray ;
        $jsonData = json_encode($tempArray);

        file_put_contents($file, $jsonData);

        $additionalArray2 = array(
            'id' => $id,
            'title' => $_POST['name'],
            'date'=>$date
        );


        $file2 = "../submission_data/";
        $file2.= $_POST['userid'];
        $file2.=".json";

        $data_results2 = file_get_contents($file2);
        $temp = json_decode( $data_results2 );
        $jsonfile = json_decode( $data_results2 );
        $jsonfile[] = $additionalArray2;
        $flag = false;
        if(count($jsonfile)==1){
            $temp[] = $additionalArray2;
            $jsonData2 = json_encode($temp);
            file_put_contents($file2, $jsonData2);
            $solved = $row['solved'];
            $solve=$solved+1;
            $sql_count_new = "UPDATE problems SET solved='$solve' WHERE id='$id'";
            $query_count_new = mysqli_query($conn,$sql_count_new);
        }
        else{
            foreach($temp as $obj){
                if($obj->id==$id){
                    $flag=true;
                }
            }
            if($flag==false){
                $temp[] = $additionalArray2;
                $jsonData2 = json_encode($temp);
                file_put_contents($file2, $jsonData2);
                $solved = $row['solved'];
                $solve=$solved+1;
                $sql_count_new = "UPDATE problems SET solved='$solve' WHERE id='$id'";
                $query_count_new = mysqli_query($conn,$sql_count_new);
            }
        }
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
                .alert{
                    margin: 60px;
                }
            </style>
        </head>

        <body>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Code Break</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="#">About</a>
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
        <br><br>
        <center>
            <div class="alert alert-success" role="alert">
                <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
                <lottie-player src="https://assets2.lottiefiles.com/packages/lf20_dpqpppvf.json"  background="transparent"  speed="1"  style="width: 100px; height: 100px;"  loop  autoplay></lottie-player>
                <br>
                <strong>ACCEPTED!</strong><br> You have successfully solved <?php echo $_POST['name']?>.
            </div>
        <br><br>
            <a href="../problems/"><button type="button" class="btn btn-primary">Try more problems</button></a>
        </center>

        <div class="footer">
            <p>Copyright 2021 Daero | Privacy Policy</p>
        </div>
        </body>

        </html>
<?php


    }
    else{
        $additionalArray = array(
            'id' => $id,
            'title' => $_POST['name'],
            'date' => $date,
            'status' =>"wrong answer"
        );
        $file = "../submission_data/";
        $file.= $_POST['userid'];
        $file.=".all.json";
        $data_results = file_get_contents($file);
        $tempArray = json_decode($data_results);

        $tempArray[] = $additionalArray ;
        $jsonData = json_encode($tempArray);

        file_put_contents($file, $jsonData);
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
                .alert{
                    margin: 60px;
                }
            </style>
        </head>

        <body>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Code Break</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="#">About</a>
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
        <br><br>
        <center>
            <div class="alert alert-danger" role="alert">
                <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
                <lottie-player src="https://assets2.lottiefiles.com/temp/lf20_yYJhpG.json"  background="transparent"  speed="1"  style="width: 100px; height: 100px;"  loop autoplay></lottie-player><br>
                <strong>WRONG ANSWER!</strong><br> That was an incorrect answer.
            </div>
            <br><br>
            <a href="../prob/?id=<?php echo $id;?>"><button type="button" class="btn btn-primary">Try again</button></a>
        </center>

        <div class="footer">
            <p>Copyright 2021 Daero | Privacy Policy</p>
        </div>
        </body>

        </html>
<?php
    }
}