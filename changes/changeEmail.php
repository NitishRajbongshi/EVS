<?php
// updating mobile number
if(isset($_POST['conemail'])) {
    $cp = $_POST['curp'];
    $nem = $_POST['newem'];
    $rollno = $_SESSION['rollno'];

    $sql = "SELECT `password` FROM `evsuser` WHERE `rollno` = '$rollno'";
    $result = mysqli_query($conn, $sql);
    $no_row = mysqli_num_rows($result);
    if($no_row == 1) {            
        while($row = mysqli_fetch_assoc($result)) {
            $p = $row['password'];
            if(password_verify($cp, $p)) {
                $updateEmail = true;
            }
        }
        if($updateEmail == true) {
            $sql = "UPDATE `evsuser` SET `email`='$nem' WHERE `rollno` = '$rollno'";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Success!</strong> Your email ID has updated successfully.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {           
                echo '<div class="alert alert-secondary alert-dismissible fade show" role="alert"><strong>Failed!</strong> Failed to update your email ID.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
        }
        else {
            echo '<div class="alert alert-secondary alert-dismissible fade show" role="alert"><strong>Failed!</strong> Password is not match. Try again.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        }
    }
    else {
        echo '<div class="alert alert-secondary alert-dismissible fade show" role="alert"><strong>Failed!</strong> Failed to update your email ID. Please try again.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        
    }
}
?>