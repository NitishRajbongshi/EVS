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

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

    <link rel="stylesheet" href="../styleSheets/logo.css">
    <style>
    </style>
</head>

<body>
    <?php
        include '../partials/_nav_admin.php';
        include '../partials/_dbconnect.php';
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(isset($_POST['approve'])) {
                $id = $_POST['approve'];
                $sql = "UPDATE `evsuser` SET `approve`='1' WHERE `sn` = '$id'";
                $result = mysqli_query($conn, $sql);
                if($result) {
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>SUCCESS!</strong> New voter account is approved successfully.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
                }
                else {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Failed!</strong>Failed to approved the voter account.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
                    }
            }
            if(isset($_POST['remove'])) {
                $id = $_POST['remove'];
                $sql = "UPDATE `evsuser` SET `approve`='2' WHERE `sn` = '$id'";
                $result = mysqli_query($conn, $sql);
                if($result) {
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>SUCCESS!</strong> New voter account is reject successfully.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
                }
                else {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Failed!</strong>Failed to reject the voter account.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
                    }
            }
        }
    ?>
    <!-- approve modal -->
    <div class="modal fade" id="approve_modal" tabindex="-1" aria-labelledby="approve_modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="approve_modalLabel">Approve the voter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <form action="/php_tutorial/EVS/voting/approve_voter.php" method="post">
                            <input type="hidden" name="approve" id="apr">
                            <button type="submit" class="btn btn-primary" style="width: 100%;">Approve now</button>
                        </form>
                    </div>
                </div> 
            </div>
        </div>
    </div>
    <!-- remove unapproved modal -->
    <div class="modal fade" id="remove_modal" tabindex="-1" aria-labelledby="remove_modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="remove_modalLabel">Reject the voter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <form action="/php_tutorial/EVS/voting/approve_voter.php" method="post">
                            <input type="hidden" name="remove" id="remove">
                            <button type="submit" class="btn btn-primary" style="width: 100%;">Reject now</button>
                        </form>
                    </div>
                </div> 
            </div>
        </div>
    </div>
    <div class="container my-5 mybox">
        <h5 class="text-center text-secondary">Approve new voter</h5>
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Name</th>
                    <th scope="col">Roll no</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Email</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // fetch data from the database
                    $sql = 'SELECT * FROM `evsuser` where approve = 0';
                    $result = mysqli_query($conn, $sql);
                    $no_row = mysqli_num_rows($result);
                    $sno = 0;
                    if($no_row > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            $sno = $sno + 1;
                            echo '
                            <tr>
                                <th scope="row">'. $sno. '</th>
                                <td>'. $row["username"]. '</td>
                                <td>'. $row["rollno"]. '</td>
                                <td>'. $row["mobile"]. '</td>
                                <td>'. $row["email"]. '</td>
                                <td><button id='.$row["sn"].' type="button" class="approve_btn btn btn-outline-success mx-1 btn-sm px-3 my-2">Approve</button><button id=r'.$row["sn"].' type="button" class="remove_btn btn btn-outline-danger mx-1 btn-sm px-3 my-2">Reject</button>
                            </tr>
                            ';
                        }
                    }
                ?>
            </tbody>
        </table>
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

        let approve = document.getElementsByClassName('approve_btn')
        Array.from(approve).forEach((element) => {
            element.addEventListener('click', (e) => {
                let id = e.target.id;
                apr.value = id;
                $('#approve_modal').modal('toggle');
            })
        })

        const rmv = document.getElementsByClassName('remove_btn');
        Array.from(rmv).forEach((element) => {
            element.addEventListener('click', (e) => {
                let del_id = e.target.id.substr(1,);
                console.log (del_id); 
                remove.value = del_id;
                $('#remove_modal').modal('toggle');
            })
        })
    </script>
</body>

</html>