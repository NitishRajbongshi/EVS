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
        include '../partials/_nav_admin.php';
        include '../partials/_dbconnect.php';
    ?>

    <div class="container my-5">
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