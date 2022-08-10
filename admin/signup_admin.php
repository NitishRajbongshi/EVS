<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EVS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <link rel="stylesheet" href="../styleSheets/logo.css">
    <link rel="stylesheet" href="../styleSheets/style_index.css">
    <link rel="stylesheet" href="../styleSheets/style_login.css">
</head>

<body>

    <?php
        include '../partials/_nav.php';
        include '../partials/_dbconnect.php';
        $match_password = false;
        $duplicate_user = false;
        $duplicate_roll = false;

        $adminid1 = 'adminid100';
        $adminid2 = 'adminid200';
        $adminid3 = 'adminid300';

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $adminid = $_POST['adminid'];
            $mobileno = $_POST['mobileno'];
            $emailid = $_POST['emailid'];
            $password = $_POST['password'];
            $cpassword = $_POST['cpassword'];

            if(($adminid1 == $adminid) || ($adminid2 == $adminid) || ($adminid3 == $adminid)) {

                $sql = "SELECT * FROM `evsadmin` WHERE `username` = '$username'";
                $status = mysqli_query($conn, $sql);
                $no_rows = mysqli_num_rows($status);
                if($no_rows > 0) {
                    $duplicate_user = true;
                }
                
                $sql = "SELECT * FROM `evsadmin` WHERE `adminid` = '$adminid'";
                $status= mysqli_query($conn, $sql);
                $no_of_rows = mysqli_num_rows($status);
                if($no_of_rows > 0) {
                    $duplicate_roll = true;
                }

                if ($password == $cpassword) {
                    $match_password = true;
                }

                if(($duplicate_user == false) && ($duplicate_roll == false) && $match_password) {
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $sql = "INSERT INTO `evsadmin`(`username`, `adminid`, `mobile`, `email`, `password`) VALUES ('$username','$adminid','$mobileno','$emailid','$hash')";
                    $status = mysqli_query($conn, $sql);
                    if($status) {
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> You successfully signup in EVS. Please remember your username and password.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    }
                    else {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Failed!</strong> Failed to signup. Please try again.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    }
                }
                else {
                    if($duplicate_user) {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Failed!</strong> Username is already used.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    }
                    if($duplicate_roll) {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Failed!</strong> Admin ID is already used.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    }
                    if(!$match_password) {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Failed!</strong> Password is not match
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
                    }
                }
            }
            else {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Failed!</strong> You are not a authorized person
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
            }
        }

    ?>

    <div class="loginform">
        <h5 class="text-center my-2 text-success">SIGNUP FOR ADMIN ACCOUNT</h5>
        <p class="text-center my-2 text-success">Please fill the form carefully</p>
        <!-- form -->
        <form action="/php_tutorial/EVS/admin/signup_admin.php" method="POST" autocomplete="off">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp"
                    required maxlength="25">
            </div>
            <div class="mb-3">
                <label for="adminid" class="form-label">Admin ID</label>
                <input type="password" class="form-control" id="adminid" name="adminid" aria-describedby="emailHelp" required maxlength="25">
            </div>
            <div class="mb-3">
                <label for="mobile" class="form-label">Mobile Number</label>
                <input type="text" class="form-control" id="mobile" name="mobileno" aria-describedby="emailHelp"
                    required maxlength="10" minlength="10" oninvalid="this.setCustomValidity('Invalid mobile number')" oninput="setCustomValidity('')">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email ID</label>
                <input type="email" class="form-control" id="email" name="emailid" aria-describedby="emailHelp"
                    required maxlength="50">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="cpassword" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="cpassword" name="cpassword" required>
            </div>
            <button type="submit" class="btn btn-primary loginbtn">Register</button>
        </form>
        <p class="text-center my-2">Already have an account?<a href="login_admin.php">Click here</a></p>
    </div>

    <?php
        include '../partials/_footer.php';
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
        crossorigin="anonymous"></script>
</body>

</html>