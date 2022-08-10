<?php
$matchPass = false;
// updating user name
if(isset($_POST['conun'])) {
    $cp = $_POST['curp'];
    $newun = $_POST['newun'];
    $newm = $_POST['newm'];
    $newe = $_POST['newe'];
    $adminid = $_SESSION['adminid'];

    $sql = "SELECT `password` FROM `evsadmin` WHERE `adminid` = '$adminid'";
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
            $sql = "UPDATE `evsadmin` SET `username`='$newun', `mobile`='$newm', `email`='$newe' WHERE `adminid` = '$adminid'";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Success!</strong> Your profile has updated successfully.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {           
                echo '<div class="alert alert-secondary alert-dismissible fade show" role="alert"><strong>Failed!</strong> Failed to update your profile.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
        }
        else {
            echo '<div class="alert alert-secondary alert-dismissible fade show" role="alert"><strong>Failed!</strong> Password is not match. Try again.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        }
    }
    else {
        echo '<div class="alert alert-secondary alert-dismissible fade show" role="alert"><strong>Failed!</strong> Failed to update your profile. Please try again.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        
    }
}
?>