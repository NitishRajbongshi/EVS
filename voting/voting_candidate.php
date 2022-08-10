<?php
    session_start();
    if(!isset($_SESSION['login']) || $_SESSION['login'] != true) {
        header('location: /php_tutorial/EVS/login.php');
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
        include '../partials/_nav.php';
        include '../partials/_dbconnect.php';

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(isset($_POST['voting'])) {
                $id = $_POST['voting'];
                
                $sql = "SELECT * FROM `votingcandidate` WHERE `sno` = '$id'";
                $result = mysqli_query($conn, $sql);
                $no_row = mysqli_num_rows($result);
                if($no_row == 1) {
                    while($row = mysqli_fetch_assoc($result)) {
                        $vote_count = $row['count'] + 1;
                        
                        $sqll = "UPDATE `votingcandidate` SET `count`='$vote_count' WHERE `sno` = '$id'";
                        $results = mysqli_query($conn, $sqll);
                        if($results) {
                            $roll = $_SESSION['rollno'];
                            $sql_query = "UPDATE `evsuser` SET `status`='1' WHERE `rollno` = '$roll';";
                            $resultss = mysqli_query($conn, $sql_query);
                            if($resultss) {
                                $_SESSION['status'] = 1;
                                header('location: /php_tutorial/EVS/profile.php');
                                exit;
                            }
                        }
                        else {
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Failed!</strong>Failed to submit you vote. Logout and try again.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>';
                        }
                    }
                }
            }
        }        
    ?>
    <!-- voting modal -->
    <div class="modal fade" id="vote_modal" tabindex="-1" aria-labelledby="vote_modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cmmodalLabel">Confirm your vote</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <form action="/php_tutorial/EVS/voting/voting_candidate.php" method="post">
                            <input type="hidden" name="voting" id="conf">
                            <button type="submit" class="btn btn-success" style="width: 100%;">Confirm</button>
                        </form>
                    </div>
                </div> 
            </div>
        </div>
    </div>
    <div class="container my-5 mybox">
        <?php
        $sql = 'SELECT * FROM `votingtitle`';
        $result = mysqli_query($conn, $sql);
        $no_row = mysqli_num_rows($result);
        if($no_row == 1) {
            while($row = mysqli_fetch_assoc($result)) {
                echo '
                <div class="text-center my-4 prevw py-2">
                    <h5>' . $row["title"]. '</h5>
                    <h6>"'. $row["position"].'"</h6>
                    <p>'. $row["description"].'</p>
                </div>';
            }
        }
        ?>
        <div class="brdrt"></div>
        <h6 class="text-center text-secondary">List of Candidate</h6>
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Code</th>
                    <th scope="col">Name</th>
                    <th scope="col">identity</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // fetch data from the database
                    $sql = 'SELECT * FROM `votingcandidate` where 1';
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
                                <td><button id='.$row["sno"].' type="button" class="vote btn btn-outline-success mx-1 btn-sm px-3 my-2">Vote</button>
                            </tr>
                            ';
                        }
                    }
                ?>
            </tbody>
        </table>
        <div class="brdrb"></div>
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

        let approve = document.getElementsByClassName('vote')
        Array.from(approve).forEach((element) => {
            element.addEventListener('click', (e) => {
                console.log('clicked');
                let id = e.target.id;
                console.log(id);
                conf.value = id;
                // display the modal when btn is clicked
                $('#vote_modal').modal('toggle');
            })
        })
    </script>
</body>

</html>