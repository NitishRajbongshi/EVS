<?php
$matchPass = false;
// delete admin profile
if(isset($_POST['condel'])) {
    $cp = $_POST['curp'];
    
    $adminid = $_SESSION['adminid'];

    $sql = "SELECT `password` FROM `evsadmin` WHERE `adminid` = '$adminid'";
    $result = mysqli_query($conn, $sql);
    $no_row = mysqli_num_rows($result);
    if($no_row == 1) {            
        while($row = mysqli_fetch_assoc($result)) {
            $p = $row['password'];
            if(password_verify($cp, $row['password'])) {
                $matchPass = true;
            }
        }
        if($matchPass == true) {
            $sql = "DELETE FROM `evsadmin` WHERE `adminid`= '$adminid'";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Success!</strong> Your profile has delete successfully.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                header('location: /php_tutorial/EVS/admin/login_admin.php');
            }
            else {           
                echo '<div class="alert alert-secondary alert-dismissible fade show" role="alert"><strong>Failed!</strong> Failed to delete your profile.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
        }
        else {
            echo '<div class="alert alert-secondary alert-dismissible fade show" role="alert"><strong>Failed!</strong> Password is not match. Try again.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        }
    }
    else {
        echo '<div class="alert alert-secondary alert-dismissible fade show" role="alert"><strong>Failed!</strong> Failed to delete your profile. Please try again.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        
    }
}
?>