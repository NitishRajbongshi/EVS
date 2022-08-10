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
        
        $sql = "SELECT * FROM `evsuser` WHERE `approve` = '1'";
        $result = mysqli_query($conn, $sql);
        $total_voter = mysqli_num_rows($result);
        
        $sqll = "SELECT * FROM `evsuser` WHERE `status` = '1'";
        $results = mysqli_query($conn, $sqll);
        $total_vote = mysqli_num_rows($results);
        $remain_vote = $total_voter - $total_vote;
    ?>

    <div class="container px-4 py-5" id="featured-3">
        <h3 class="pb-2 border-bottom text-center">VOTER DETAILS</h3>
        <div class="row g-4 py-5 row-cols-1 row-cols-lg-3 text-center">
            <div class="feature col">
                <h4>VOTERS</h4>
                <p>Total number of voter</p>

                <span class="spn d-block p-2 fs-3 text-success"><?php echo $total_voter; ?></span>
            </div>
            <div class="feature col">
                <h4>VOTES</h4>
                <p>Total number of votes done</p>
                <span class="spn d-block p-2 fs-3 text-primary"><?php echo $total_vote; ?></span>
            </div>
            <div class="feature col">
                <h4>REMAINS</h4>
                <p>Yet to vote</p>
                <span class="spn d-block p-2 fs-3 text-danger"><?php echo $remain_vote; ?></span>
            </div>
        </div>
    </div>
    <div class="container my-2 mybox">
        <h5 class="text-center text-secondary">List of all voter</h5>
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Name</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Email</th>
                    <th scope="col">Voted</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // fetch data from the database
                    $sql = 'SELECT * FROM `evsuser` WHERE `approve` = "1"';
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
                                <td>'. $row["mobile"]. '</td>
                                <td>'. $row["email"]. '</td>';
                                if($row['status'] == 0) {
                                    echo '<td>No</td>';
                                }
                                else {
                                    echo '<td>Yes</td>';
                                }
                            echo '
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
    </script>
</body>

</html>