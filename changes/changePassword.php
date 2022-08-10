<?php
// updating password
if(isset($_POST['conpass'])) {
    $op = $_POST['curp'];
    $np = $_POST['newp'];
    $ncp = $_POST['newcp'];
    $rollno = $_SESSION['rollno'];

    $sql = "SELECT `password` FROM `evsuser` WHERE `rollno` = '$rollno'";
    $result = mysqli_query($conn, $sql);
    $no_row = mysqli_num_rows($result);
    if($no_row == 1) {            
        while($row = mysqli_fetch_assoc($result)) {
            $p = $row['password'];
            if(password_verify($op, $p)) {
                $oldpassmatch = true;
            }
        }
        if(($np == $ncp) && $oldpassmatch == true) {
            $new_hash = password_hash($np, PASSWORD_DEFAULT);
            $sql = "UPDATE `evsuser` SET `password`='$new_hash' WHERE `rollno` = '$rollno'";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Success!</strong> Your password has updated successfully.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {           
                echo '<div class="alert alert-secondary alert-dismissible fade show" role="alert"><strong>Failed!</strong> Failed to update your password.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
        }
        else {
            echo '<div class="alert alert-secondary alert-dismissible fade show" role="alert"><strong>Failed!</strong> Password is not match. Try again.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        }
    }
    else {
        echo '<div class="alert alert-secondary alert-dismissible fade show" role="alert"><strong>Failed!</strong> Failed to update your password. Please try again.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        
    }
}
?>