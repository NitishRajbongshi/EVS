<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EVS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <link rel="stylesheet" href="styleSheets/logo.css">
    <link rel="stylesheet" href="styleSheets/style_index.css">
    <link rel="stylesheet" href="styleSheets/style_login.css">
</head>

<body>

    <?php
        include 'partials/_nav.php';
        include 'partials/_dbconnect.php';
        $match_password = false;
        $duplicate_user = false;
        $duplicate_roll = false;
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $rollno = $_POST['rollno'];
            $mobileno = $_POST['mobileno'];
            $emailid = $_POST['emailid'];
            $password = $_POST['password'];
            $cpassword = $_POST['cpassword'];
            $flag = 0;
            $approve = 0;

            $sql = "SELECT * FROM `evsuser` WHERE `username` = '$username'";
            $status = mysqli_query($conn, $sql);
            $no_rows = mysqli_num_rows($status);
            if($no_rows > 0) {
                $duplicate_user = true;
            }
            
            $sql = "SELECT * FROM `evsuser` WHERE `rollno` = '$rollno'";
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
                $sql = "INSERT INTO `evsuser`(`username`, `rollno`, `mobile`, `email`, `password`, `status`, `approve`) VALUES ('$username','$rollno','$mobileno','$emailid','$hash','$flag', '$approve')";
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
                    <strong>Failed!</strong> Rollno is already used.
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
    ?>

    <div class="loginform">
        <h5 class="text-center my-2 text-success">SIGNUP</h5>
        <p class="text-center my-2 text-success">Please fill the form carefully</p>
        <!-- form -->
        <form action="/php_tutorial/EVS/signup.php" method="POST" autocomplete="off">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp"
                    required maxlength="25">
            </div>
            <div class="mb-3">
                <label for="roll" class="form-label">Roll Number</label>
                <input type="text" class="form-control" id="roll" name="rollno" aria-describedby="emailHelp" required maxlength="12">
            </div>
            <div class="mb-3">
                <label for="mobile" class="form-label">Mobile Number</label>
                <input type="text" class="form-control" id="mobile" name="mobileno" aria-describedby="emailHelp"
                    required="" maxlength="10" minlength="10" oninvalid="this.setCustomValidity('Please enter valid mobile number')" oninput="setCustomValidity('')">
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
        <p class="text-center my-2">Already have an account?<a href="login.php">Click here</a></p>
    </div>

    <?php
        include 'partials/_footer.php';
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
        crossorigin="anonymous"></script>
</body>

</html>