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

    <link rel="stylesheet" href="../styleSheets/logo.css">
    <!-- <link rel="stylesheet" href="../styleSheets/style_index.css"> -->
    <!-- <link rel="stylesheet" href="../styleSheets/style_admin.css"> -->
    <!-- <link rel="stylesheet" href="../styleSheets/admin_profile.css"> -->
</head>

<body>
    <?php
        $flag = 1;
        include '../partials/_nav_admin.php';
        include '../partials/_dbconnect.php';

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            // checking for another session existance
            $sql = "SELECT * FROM `votingtitle`";
            $result = mysqli_query($conn, $sql);
            $no_of_rows = mysqli_num_rows($result);
            if($no_of_rows == 0) {
                $title = $_POST['title'];
                $position = $_POST['position'];
                $desc = $_POST['desc'];

                $sql = "INSERT INTO `votingtitle`(`title`, `position`, `description`, `status`) VALUES ('$title','$position','$desc','$flag')";
                $result = mysqli_query($conn, $sql);
                if($result) {
                    header('location: /php_tutorial/EVS/voting/add_candidate.php');
                    exit;
                }
                else {
                    echo '<div class="alert alert-secondary alert-dismissible fade show" role="alert"><strong>Failed!</strong> New session can not created. Try again.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            else {
                echo '<div class="alert alert-secondary alert-dismissible fade show" role="alert"><strong>Failed!</strong> Another session is already created. Delete the previous session to continue.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
        }

        mysqli_close($conn);
    ?>
    <div class="text-center text-success my-2">
        <h4>STEP 1</h4>
        <p>Header of the session</p>
    </div>
    <div class="container my-2">
        <form action="/php_tutorial/EVS/voting/voting_index.php" method="post" autocomplete="off">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" aria-describedby="emailHelp" name="title"
                    placeholder="eg.: General vote" required>
            </div>
            <div class="mb-3">
                <label for="position" class="form-label">Position</label>
                <input type="text" class="form-control" id="position" aria-describedby="emailHelp" name="position"
                    placeholder="eg.: General secratory" required>
            </div>
            <div class="mb-3">
                <label for="desc" class="form-label">Description</label>
                <input type="text" class="form-control" id="desc" aria-describedby="emailHelp" name="desc"
                    placeholder="eg.: Cast your vote" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%;" name="step1">Next</button>
        </form>
    </div>
    
    <?php
        include '../partials/_footer.php';
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
        crossorigin="anonymous"></script>


</body>

</html>