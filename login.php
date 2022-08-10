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
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user = $_POST['username'];
            $pass = $_POST['password'];

            $sql = "SELECT * FROM `evsuser` WHERE `username` = '$user'";
            $result = mysqli_query($conn, $sql);
            $no_rows = mysqli_num_rows($result);

            if($no_rows == 1) {
                while($row = mysqli_fetch_assoc($result)) {
                    if(password_verify($pass, $row['password'])) {
                        session_start();
                        $_SESSION['login'] = true;
                        $_SESSION['username'] = $row['username'];
                        $_SESSION['rollno'] = $row['rollno'];
                        $_SESSION['mobile'] = $row['mobile'];
                        $_SESSION['email'] = $row['email'];
                        $_SESSION['status'] = $row['status'];
                        $_SESSION['approve'] = $row['approve'];      
                        header('location: /php_tutorial/EVS/profile.php');
                    }
                    else {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Failed!</strong> Failed to login. Please try again.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                    }
                }
            }
            else {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Failed!</strong> Failed to login. Please try again.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
        }
    ?>
        
        <div class="loginform"> 
            <h5 class="text-center my-4 text-success">LOGIN</h5>
            <!-- form -->
            <form action="/php_tutorial/EVS/login.php" method="POST" autocomplete="off">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp" required>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                
                <button type="submit" class="btn btn-primary loginbtn">Login</button>
            </form>
            <p class="text-center my-2">Not registered yet?<a href="signup.php">Click here</a></p>
            <p class="text-center">Can not remember the password?<a href="#">Click here</a></p>
        </div>
    <?php
        include 'partials/_footer.php';
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
        crossorigin="anonymous"></script>
</body>

</html>