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
    <link rel="stylesheet" href="../styleSheets/style_index.css">
    <link rel="stylesheet" href="../styleSheets/style_admin.css">
    <link rel="stylesheet" href="../styleSheets/admin_profile.css">
    <style>
        form button.mybtnn {
            border: 1px solid lightgray;
            background: #b9cce8;
            width: 65%;
            border-radius: 0;
            font-size: 15px;
            color: #a60808;
        }

        div.noti {
            background: #ffdede;
        }
        p.notific {
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>
    <?php
        include '../partials/_nav_admin.php';
        include '../partials/_dbconnect.php';
        include "../change_admin/username.php";
        include "../change_admin/deleteProfile.php";
        include "../change_admin/password.php";
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // create new session
            if(isset($_POST['new_session'])) {
                // checking for another session existance
                $sql = "SELECT * FROM `votingtitle`";
                $result = mysqli_query($conn, $sql);
                $no_of_rows = mysqli_num_rows($result);
                if($no_of_rows == 0) {
                    header('location: /php_tutorial/EVS/voting/voting_index.php');
                    exit;
                }
                else {
                    echo '<div class="alert alert-secondary alert-dismissible fade show" role="alert"><strong>Failed!</strong> Another session is already created. Delete the previous session to continue.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            
            // start session
            if(isset($_POST['start_session'])) {
                // checking for another session existance
                $sql = "SELECT * FROM `votingtitle` WHERE 1";
                $result = mysqli_query($conn, $sql);
                $no_of_rows = mysqli_num_rows($result);
                if($no_of_rows == 0) {
                    echo '<div class="alert alert-secondary alert-dismissible fade show" role="alert"><strong>Failed!</strong> You have not created any session yet.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
                else {
                    while($row = mysqli_fetch_assoc($result)) {
                        if($row['status'] == 1) {
                            echo '<div class="alert alert-secondary alert-dismissible fade show" role="alert">Session is already started. If it is a mistake stop it immediately or delete the session.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                        }
                        else {
                            $sqll = "UPDATE `votingtitle` SET `status`='1' WHERE 1";
                            $results= mysqli_query($conn, $sqll);
                            if($results) {
                                echo '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sucess!</strong> Session is started now.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                            }
                            else {
                                echo '<div class="alert alert-secondary alert-dismissible fade show" role="alert"><strong>Failed!</strong> Can not started the session<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                            }
                        }
                    }
                }
            }
            // stop session
            if(isset($_POST['stop_session'])) {
                // checking for another session existance
                $sql = "SELECT * FROM `votingtitle` WHERE 1";
                $result = mysqli_query($conn, $sql);
                $no_of_rows = mysqli_num_rows($result);
                if($no_of_rows == 0) {
                    echo '<div class="alert alert-secondary alert-dismissible fade show" role="alert"><strong>Failed!</strong> You have not created any session yet.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
                else {
                    while($row = mysqli_fetch_assoc($result)) {
                        if($row['status'] == 0) {
                            echo '<div class="alert alert-secondary alert-dismissible fade show" role="alert">Session is already stoped. If it is a mistake start it immediately.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                        }
                        else {
                            $sqll = "UPDATE `votingtitle` SET `status`='0' WHERE 1";
                            $results= mysqli_query($conn, $sqll);
                            if($results) {
                                echo '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sucess!</strong> Session is stoped now.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                            }
                            else {
                                echo '<div class="alert alert-secondary alert-dismissible fade show" role="alert"><strong>Failed!</strong> Can not stop the session<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                            }
                        }
                    }
                }
            }
            // delete session
            if(isset($_POST['del_session'])) {
                $sql = "DELETE FROM `votingtitle` WHERE 1";
                $result = mysqli_query($conn, $sql);
                
                if($result) {
                    $sql = "DELETE FROM `votingcandidate` WHERE 1";
                    $result = mysqli_query($conn, $sql);
                    if($result) {
                        $sql = "UPDATE `evsuser` SET `status`='0' WHERE 1";
                        $result = mysqli_query($conn, $sql);
                        if($result) {
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sucess!</strong> You can start a new session.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                        }
                        else {
                            echo '<div class="alert alert-secondary alert-dismissible fade show" role="alert"><strong>Failed!</strong> Another session is created. Delete the previous session to continue.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                        }
                    }
                    else {
                        echo '<div class="alert alert-secondary alert-dismissible fade show" role="alert"><strong>Failed!</strong> Another session is created. Delete the previous session to continue.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                    }
                }
                else {
                    echo '<div class="alert alert-secondary alert-dismissible fade show" role="alert"><strong>Failed!</strong> Another session is created. Delete the previous session to continue.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            // preview session
            if(isset($_POST['preview_session'])) {
                header('location: ../voting/preview_session.php');
                exit;
            }

            // voter details
            if(isset($_POST['check_voter'])) {
                header('location: /php_tutorial/EVS/voting/voter_details.php');
                exit;
            }

            // approve new voter
            if(isset($_POST['appr_voter'])) {
                $sql = "SELECT * FROM `evsuser` WHERE `approve` = 0";
                $result = mysqli_query($conn, $sql);
                $no_of_rows = mysqli_num_rows($result);
                if($no_of_rows > 0) {
                    header('location: /php_tutorial/EVS/voting/approve_voter.php');
                    exit;
                }
                else {
                    echo '<div class="alert alert-secondary alert-dismissible fade show" role="alert">No new voter to approve.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            // voteing results
            if(isset($_POST['see_result'])) {
                header('location: /php_tutorial/EVS/voting/voting_result.php');
                exit;
            }

            // remove rejected voter
            if(isset($_POST['rem_ac'])) {
                $sql ="DELETE FROM `evsuser` WHERE `approve` = '2'";
                $result = mysqli_query($conn, $sql);
                if($result) {
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sucess!</strong> All the rejected accounts are removed.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
                else {
                    echo '<div class="alert alert-secondary alert-dismissible fade show" role="alert"><strong>Warning!</strong> Failed to remove the rejected accounts.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            // clear all the account
            if(isset($_POST['clr_ac'])) {
                $sql ="DELETE FROM `evsuser` WHERE 1";
                $result = mysqli_query($conn, $sql);
                if($result) {
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sucess!</strong> All the voter accounts are removed.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
                else {
                    echo '<div class="alert alert-secondary alert-dismissible fade show" role="alert"><strong>Warning!</strong> Failed to remove the voter accounts.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
        }
    ?>

    <!-- Update profile -->
    <div class="modal fade" id="cumodal" tabindex="-1" aria-labelledby="cumodalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cumodalLabel">Update Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <form action="/php_tutorial/EVS/admin/admin_profile.php" method="post" autocomplete="off">
                            <input type="hidden" name="snoEdit" id="snoEdit">

                            <div class="mb-3">
                                <label for="curp" class="form-label">Password</label>
                                <input type="password" class="form-control" id="curp" aria-describedby="emailHelp"
                                    name="curp" required>
                            </div>
                            <div class="mb-3">
                                <label for="newun" class="form-label">New Username</label>
                                <input type="text" class="form-control" id="newun" aria-describedby="emailHelp"
                                    name="newun" required value="<?php echo $_SESSION['username']; ?>" maxlength="25">
                            </div>
                            <div class="mb-3">
                                <label for="newm" class="form-label">New Mobile No.</label>
                                <input type="text" class="form-control" id="newm" aria-describedby="emailHelp"
                                    name="newm" required value="<?php echo $_SESSION['mobile']; ?>" maxlength="10" minlength="10" oninvalid="this.setCustomValidity('Invalid mobile number!')" oninput="setCustomValidity('')">
                            </div>
                            <div class="mb-3">
                                <label for="newe" class="form-label">New email</label>
                                <input type="email" class="form-control" id="newe" aria-describedby="emailHelp"
                                    name="newe" required value="<?php echo $_SESSION['email']; ?>" maxlength="50">
                            </div>

                            <button type="submit" class="btn btn-primary" style="width: 100%;"
                                name="conun">CONFIRM</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- password edit modal -->
    <div class="modal fade" id="cpmodal" tabindex="-1" aria-labelledby="cpmodalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cpmodalLabel">Create new password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <form action="/php_tutorial/EVS/admin/admin_profile.php" method="post" autocomplete="off">
                            <input type="hidden" name="snoEdit" id="snoEdit">

                            <div class="mb-3">
                                <label for="curp" class="form-label">Current password</label>
                                <input type="password" class="form-control" id="curp" aria-describedby="emailHelp"
                                    name="curp" required>
                            </div>
                            <div class="mb-3">
                                <label for="newp" class="form-label">New password</label>
                                <input type="password" class="form-control" id="newp" aria-describedby="emailHelp"
                                    name="newp" required>
                            </div>
                            <div class="mb-3">
                                <label for="newcp" class="form-label">Confirm password</label>
                                <input type="password" class="form-control" id="newcp" aria-describedby="emailHelp"
                                    name="newcp" required>
                            </div>
                            <button type="submit" class="btn btn-primary" style="width: 100%;"
                                name="conpass">CONFIRM</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- delete profile -->
    <div class="modal fade" id="cdmodal" tabindex="-1" aria-labelledby="cdmodalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cdmodalLabel">Delete your account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <form action="/php_tutorial/EVS/admin/admin_profile.php" method="post" autocomplete="off">
                            <input type="hidden" name="snoEdit" id="snoEdit">

                            <div class="mb-3">
                                <label for="curp" class="form-label">Password</label>
                                <input type="password" class="form-control" id="curp" aria-describedby="emailHelp"
                                    name="curp" required>
                            </div>
                            <button type="submit" class="btn btn-primary" style="width: 100%;"
                                name="condel">DELETE</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container noti my-2">
        <?php
            $sql = "SELECT * FROM `evsuser` WHERE `approve` = 0";
            $result = mysqli_query($conn, $sql);
            $no_of_rows = mysqli_num_rows($result);
            if($no_of_rows > 0) {
                echo '<p class="notific"><b>Notification: </b>There is '. $no_of_rows . ' unapproved user/s.</p>';
            }
        ?>
    </div>
    <div class="container my-flex my-3 roww-1">
        <div class="coll-1 text-center my-flex" id="header_coll_1" style="background: #effaef">
            <div>
                <h2 class="navbar-brand"><span class="spn" id="e">E</span><span class="spn" id="v">V</span><span
                        class="spn" id="s">S</span></h2>
                <h3 class="text-danger">WELCOME</h3>
                <h4 class="text-success">
                    <?php echo $_SESSION['username']?>
                </h4>
            </div>

        </div>
        <div class="coll-2 my-flex text-center" id="header_coll_2" style="background: #e8e4f3">
            <div>
                <h3 class="text-primary">Profile</h3>
                <ul class="details">
                    <li>UserName :
                        <?php echo $_SESSION['username']; ?>
                    </li>
                    <li>Admin ID :
                        <?php 
                        echo $_SESSION['adminid']; 
                    ?>
                    </li>
                    <li>Mobile No. :
                        <?php echo $_SESSION['mobile']; ?>
                    </li>
                    <li>Email :
                        <?php echo $_SESSION['email']; ?>
                    </li>
                </ul>
                <button class="lg_b"><a href="logout_admin.php" class='logout_b'>Logout</a></button>
            </div>
        </div>
    </div>
    
    <div class="container my-flex option">
        <div class="colll my-flex op_col odd" method="post">
            <div>
                <h4 class="title">Update Profile</h4>
            </div>
            <div>
                <p>Update your profile</p>
            </div>
            <div class="cgbtn">
                <button id="cu" type="button" class="btn btn-sm btn-block fmbtn">Click here</button>
            </div>
        </div>
        <div class="colll my-flex op_col even">
            <div>
                <h4 class="title">Change Password</h4>
            </div>
            <div>
                <p>Change your password</p>
            </div>
            <div class="cgbtn">
                <button id="cp" type="button" class="btn btn-sm btn-block fmbtn">Click here</button>
            </div>
        </div>
        <div class="colll my-flex op_col odd">
            <div>
                <h4 class="title">Delete account</h4>
            </div>
            <div>
                <p>Delete your account</p>
            </div>
            <div class="cgbtn">
                <button id="cd" type="button" class="btn btn-sm btn-block fmbtn">Click here</button>
            </div>
        </div>
        <div class="colll my-flex op_col even">
            <div>
                <h4 class="title">New Admin</h4>
            </div>
            <div>
                <p>Create a new admin account</p>
            </div>
            <div class="cgbtn">
                <button id="" type="button" class="btn btn-sm btn-block fmbtn">Click here</button>
            </div>
        </div>
    </div>

    <div class="container py-3 my-3 text-center">
        <h4 style="color: blue;">EVS OPERATIONS</h4>
    </div>

    <div class="container my-flex option">
        <div class="colll my-flex op_col odd" method="post">
            <div>
                <h4 class="title">New Session</h4>
            </div>
            <div>
                <p>Create a new voting session.</p>
            </div>
            <div>
                <form action="/php_tutorial/EVS/admin/admin_profile.php" method="POST">
                    <button type="submit" class="btn btn-sm btn-block fmbtn mybtnn" name="new_session">Click here</button>
                </form>
            </div>
        </div>
        <div class="colll my-flex op_col even">
            <div>
                <h4 class="title">Start Voting</h4>
            </div>
            <div>
                <p>Start the voting processes</p>
            </div>
            <div>
                <form action="/php_tutorial/EVS/admin/admin_profile.php" method="POST">
                    <button type="submit" class="btn btn-sm btn-block fmbtn mybtnn" name="start_session">Click
                        here</button>
                </form>
            </div>
        </div>
        <div class="colll my-flex op_col odd">
            <div>
                <h4 class="title">Stop Voting</h4>
            </div>
            <div>
                <p>Stop the voting processes</p>
            </div>
            <div>
                <form action="/php_tutorial/EVS/admin/admin_profile.php" method="POST">
                    <button type="submit" class="btn btn-sm btn-block fmbtn mybtnn" name="stop_session">Click here</button>
                </form>
            </div>
        </div>
        <div class="colll my-flex op_col even">
            <div>
                <h4 class="title">Delete Session</h4>
            </div>
            <div>
                <p>Delete current voting session</p>
            </div>
            <div>
                <form action="/php_tutorial/EVS/admin/admin_profile.php" method="POST">
                    <button type="submit" class="btn btn-sm btn-block fmbtn mybtnn" name="del_session">Click here</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container my-flex option">
        <div class="colll my-flex op_col odd" method="post">
            <div>
                <h4 class="title">Preview Session</h4>
            </div>
            <div>
                <p>Preview the session here.</p>
            </div>
            <div>
                <form action="/php_tutorial/EVS/admin/admin_profile.php" method="POST">
                    <button type="submit" class="btn btn-sm btn-block fmbtn mybtnn" name="preview_session">Click here</button>
                </form>
            </div>
        </div>
        <div class="colll my-flex op_col even">
            <div>
                <h4 class="title">Voter Details</h4>
            </div>
            <div>
                <p>Check the voter details</p>
            </div>
            <div>
                <form action="/php_tutorial/EVS/admin/admin_profile.php" method="POST">
                    <button type="submit" class="btn btn-sm btn-block fmbtn mybtnn" name="check_voter">Click here</button>
                </form>
            </div>
        </div>
        <div class="colll my-flex op_col odd">
            <div>
                <h4 class="title">Approve Voter</h4>
            </div>
            <div>
                <p>Approve new registered voter</p>
            </div>
            <div>
                <form action="/php_tutorial/EVS/admin/admin_profile.php" method="POST">
                    <button type="submit" class="btn btn-sm btn-block fmbtn mybtnn" name="appr_voter">Click here</button>
                </form>
            </div>
        </div>
        <div class="colll my-flex op_col even">
            <div>
                <h4 class="title">Remove Account</h4>
            </div>
            <div>
                <p>Remove all rejected A/C</p>
            </div>
            <div>
                <form action="/php_tutorial/EVS/admin/admin_profile.php" method="POST">
                    <button type="submit" class="btn btn-sm btn-block fmbtn mybtnn" name="rem_ac">Click here</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container my-flex option">
        <div class="colll my-flex op_col odd" method="post">
            <div>
                <h4 class="title">Clear Voter</h4>
            </div>
            <div>
                <p>Remove all the voter account</p>
            </div>
            <div>
                <form action="/php_tutorial/EVS/admin/admin_profile.php" method="POST">
                    <button type="submit" class="btn btn-sm btn-block fmbtn mybtnn" name="clr_ac">Click here</button>
                </form>
            </div>
        </div>
        <div class="colll my-flex op_col even">
            <div>
                <h4 class="title">No Action</h4>
            </div>
            <div>
                <p>No action perform</p>
            </div>
            <div class="cgbtn">
                <button id="" type="button" class="btn btn-sm btn-block fmbtn mybtnn">Click here</button>
            </div>
        </div>
        
        <div class="colll my-flex op_col odd">
            <div>
                <h4 class="title">Voting Result</h4>
            </div>
            <div>
                <p>Check the voting result.</p>
            </div>
            <div>
                <form action="/php_tutorial/EVS/admin/admin_profile.php" method="POST">
                    <button type="submit" class="btn btn-sm btn-block fmbtn mybtnn" name="see_result">Click here</button>
                </form>
            </div>
        </div>
        <div class="colll my-flex op_col even">
            <div>
                <h4 class="title">No Action</h4>
            </div>
            <div>
                <p>No action perform</p>
            </div>
            <div class="cgbtn">
                <button id="" type="button" class="btn btn-sm btn-block fmbtn mybtnn">Click here</button>
            </div>
        </div>
    </div>


    <?php
        include '../partials/_footer.php';
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
        crossorigin="anonymous"></script>

    <script>
        let cu = document.getElementById('cu');
        cu.addEventListener('click', function () {
            $('#cumodal').modal('toggle');
        })

        let cd = document.getElementById('cd');
        cd.addEventListener('click', function () {
            $('#cdmodal').modal('toggle');
        })

        let cp = document.getElementById('cp');
        cp.addEventListener('click', function () {
            $('#cpmodal').modal('toggle');
        })
    </script>
</body>

</html>