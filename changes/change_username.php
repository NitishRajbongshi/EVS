<?php
// updating mobile number
if(isset($_POST['conusername'])) {
    $cp = $_POST['curp'];
    $un = $_POST['newun'];
    $rollno = $_SESSION['rollno'];

    $sql = "SELECT * FROM `evsuser` WHERE `username` = '$un'";
    $result = mysqli_query($conn, $sql);
    $no_row = mysqli_num_rows($result);
    if($no_row == 0) {
        $sql = "SELECT `password` FROM `evsuser` WHERE `rollno` = '$rollno'";
        $result = mysqli_query($conn, $sql);
        $no_row = mysqli_num_rows($result);
        if($no_row == 1) {            
            while($row = mysqli_fetch_assoc($result)) {
                $p = $row['password'];
                if(password_verify($cp, $p)) {
                    $matchPass = true;
                }
            }
            if($matchPass == true) {
                $sql = "UPDATE `evsuser` SET `username`='$un' WHERE `rollno` = '$rollno'";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Success!</strong> Your username has updated successfully.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
                else {           
                    echo '<div class="alert alert-secondary alert-dismissible fade show" role="alert"><strong>Failed!</strong> Failed to update your username.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            else {
                echo '<div class="alert alert-secondary alert-dismissible fade show" role="alert"><strong>Failed!</strong> Password is not match. Try again.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
        }
        else {
            echo '<div class="alert alert-secondary alert-dismissible fade show" role="alert"><strong>Failed!</strong> Failed to update your username. Please try again.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            
        }
    }
    else {
        echo '<div class="alert alert-secondary alert-dismissible fade show" role="alert"><strong>Failed!</strong> Username has already used by someone. Try another username.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    }
}
?>