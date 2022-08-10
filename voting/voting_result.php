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
        $winner = 0;
        $sql = "SELECT * FROM `votingcandidate` WHERE 1";
        $result = mysqli_query($conn, $sql);
        $total_can = mysqli_num_rows($result);
        if($total_can > 0) {
            while($row = mysqli_fetch_assoc($result)){
                if($row['count'] >= $winner) {
                    $winner = $row['count'];
                }
            }
        }
        
        $sqll = "SELECT * FROM `evsuser` WHERE `status` = '1'";
        $results = mysqli_query($conn, $sqll);
        $total_vote = mysqli_num_rows($results);
        
        // selecting the winner
        $winner_id = null;
        $sql = "SELECT * FROM `votingcandidate` WHERE `count` = '$winner'";
        $result = mysqli_query($conn, $sql);
        $winner_no = mysqli_num_rows($result);
        if($winner_no == 1) {
            while($row = mysqli_fetch_assoc($result)){
                $winner_id = $row['can_code'];
            }
        }
        elseif($winner_no == 0) {
            $winner_id = '---';
        }
        else {
            $winner_id = 'TIE';
        }
    ?>

    <div class="container px-4 py-5" id="featured-3">
        <h3 class="pb-2 border-bottom text-center">VOTING RESULTS</h3>
        <div class="row g-4 py-5 row-cols-1 row-cols-lg-3 text-center">
            <div class="feature col">
                <h4>CANDIDATE</h4>
                <p>Total number candidate</p>

                <span class="spn d-block p-2 fs-3 text-success"><?php echo $total_can; ?></span>
            </div>
            <div class="feature col">
                <h4>VOTE</h4>
                <p>Total number of votes</p>
                <span class="spn d-block p-2 fs-3 text-primary"><?php echo $total_vote; ?></span>
            </div>
            <div class="feature col">
                <h4 class="text-success">WINNER</h4>
                <p>Winner of the voting session</p>
                <span class="spn d-block p-2 fs-3 text-danger"><?php echo $winner_id;?></span>
            </div>
        </div>
    </div>
    <div class="container my-2 mybox">
        <h5 class="text-center text-secondary">List of all candidate</h5>
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">Code</th>
                    <th scope="col">Name</th>
                    <th scope="col">identity</th>
                    <th scope="col">Vote</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = 'SELECT * FROM `votingcandidate` where 1';
                    $result = mysqli_query($conn, $sql);
                    $no_row = mysqli_num_rows($result);
                    $sno = 0;
                    if($no_row > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            $sno = $sno + 1;
                            echo '
                            <tr>
                                <td>'. $row["can_code"]. '</td>
                                <td>'. $row["can_name"]. '</td>
                                <td>'. $row["can_identity"]. '</td>
                                <td>'. $row["count"]. '</td>
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