<?php
    session_start();
    if(!isset($_SESSION['login']) || $_SESSION['login'] != true) {
        header('location: /php_tutorial/EVS/admin/login_admin.php');
        exit;
    }
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EVS</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

    <link rel="stylesheet" href="../styleSheets/logo.css">
    <style>
        .prevw, .brdrt, .brdrb{
            background-color: #ebebeb;
        }

        .brdrt {
            height: 10px;
            margin: 5px 0;
            border-radius: 7px 7px 0 0;
        }
        .brdrb {
            height: 10px;
            margin: 5px 0;
            border-radius: 0 0 7px 7px;
        }
    </style>
</head>

<body>
    <?php
        $flag = 1;
        $vote_count = 0;
        $candidate_id_match = false;
        include '../partials/_nav_admin.php';
        include '../partials/_dbconnect.php';
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(isset($_POST['add_can'])) {
                $can_code = $_POST['can_code'];
                $can_name = $_POST['can_name'];
                $can_identity = $_POST['can_identity'];
                $count = $vote_count;
                
                $sql = "SELECT * FROM `votingcandidate` WHERE `can_code` = '$can_code'";
                $status = mysqli_query($conn, $sql);
                $no_rows = mysqli_num_rows($status);
                if($no_rows > 0) {
                    $candidate_id_match = true;
                }
    
                $sql = "SELECT `status` FROM `votingtitle` WHERE 1";
                $result = mysqli_query($conn, $sql);
                $no_of_rows = mysqli_num_rows($result);
                if(($no_of_rows == 1) && $candidate_id_match == false) {
                    while($row = mysqli_fetch_assoc($result)) {
                        $status = $row['status'];
                        if($status == 1) {
                            $sqll = "INSERT INTO `votingcandidate`(`can_code`, `can_name`, `can_identity`, `count`) VALUES ('$can_code','$can_name','$can_identity','$count')";
                            $results = mysqli_query($conn, $sqll);
                            if($results) {
                                echo '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sucess!</strong> New candidate added successfully.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                            }
                            else {
                                echo '<div class="alert alert-secondary alert-dismissible fade show" role="alert"><strong>Failed!</strong> Candidate can not be added.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                            }
                        }
                        else {
                            echo '<div class="alert alert-secondary alert-dismissible fade show" role="alert"><strong>Failed!</strong> Session is not started. Can not add candidate<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                        }
                    }
                }
                else {
                    echo '<div class="alert alert-secondary alert-dismissible fade show" role="alert"><strong>Failed!</strong> Candidate can not be added. Fill the informations correctly.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            if(isset($_POST['confirm'])) {
                $sql = "SELECT * FROM `votingcandidate` WHERE 1";
                $result = mysqli_query($conn, $sql);
                $no_of_rows = mysqli_num_rows($result);
                if($no_of_rows >= 2) { 
                    header('location: /php_tutorial/EVS/admin/admin_profile.php');
                    exit;
                }
                else {
                    echo '<div class="alert alert-secondary alert-dismissible fade show" role="alert"><strong>Failed!</strong> Add atleast two candidate to start the voting process.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
        }
    ?>
    <div class="text-center text-success my-2">
        <h4>STEP 2</h4>
        <p>Add Candidate for the session</p>
    </div>
    <div class="container my-2">
        <form action="/php_tutorial/EVS/voting/add_candidate.php" method="post" autocomplete="off">
            <div class="mb-3">
                <label for="can_code" class="form-label">Candidate code(unique)</label>
                <input type="text" class="form-control" id="can_code" aria-describedby="emailHelp" name="can_code" placeholder="eg.: candidate1" required>
            </div>
            <div class="mb-3">
                <label for="can_name" class="form-label">Candidate name</label>
                <input type="text" class="form-control" id="can_name" aria-describedby="emailHelp" name="can_name" placeholder="eg.: XXXYYYZZZ" required>
            </div>
            <div class="mb-3">
                <label for="can_identity" class="form-label">Candidate identity</label>
                <input type="text" class="form-control" id="can_identity" aria-describedby="emailHelp" name="can_identity" placeholder="eg.: Flower" required>
            </div>
            <button id="step2" type="submit" class="btn btn-primary" style="width: 100%;" name="add_can">Add Candidate</button>
        </form>
    </div>
    <div class="container my-5">
        <h4 class="text-primary text-center">Preview</h4>
        <?php
                $sql = 'SELECT * FROM `votingtitle`';
                $result = mysqli_query($conn, $sql);
                $no_row = mysqli_num_rows($result);
                if($no_row == 1) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo '
                        <div class="text-center my-4 prevw py-2">
                            <h5>' . $row["title"]. '</h5>
                            <h6>'. $row["position"].'</h6>
                            <p>'. $row["description"].'</p>
                        </div>
                        ';
                    }
                }
        ?>
        <div class="brdrt"></div>
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Code</th>
                    <th scope="col">Name</th>
                    <th scope="col">identity</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // fetch data from the database
                    $sql = 'SELECT * FROM `votingcandidate`';
                    $result = mysqli_query($conn, $sql);
                    $no_row = mysqli_num_rows($result);
                    $sno = 0;
                    if($no_row > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            $sno = $sno + 1;
                            echo '
                            <tr>
                                <th scope="row">'. $sno. '</th>
                                <td>'. $row["can_code"]. '</td>
                                <td>'. $row["can_name"]. '</td>
                                <td>'. $row["can_identity"]. '</td>
                            </tr>
                            ';
                        }
                    }
                ?>
            </tbody>
        </table>
        <div class="brdrb"></div>
    </div>
    <div class="container">
        <form action="/php_tutorial/EVS/voting/add_candidate.php" method="post" autocomplete="off">
            <button id="step2" type="submit" class="btn btn-danger" style="width: 100%;" name="confirm">Start Session</button>
        </form>
    </div>
    <?php
        include '../partials/_footer.php';
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
        crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();
        });
    </script>
</body>

</html>