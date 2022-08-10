<?php
    session_start();
    if(!isset($_SESSION['login']) || $_SESSION['login'] != true) {
        header('location: /php_tutorial/EVS/login.php');
        exit;
    }
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="styleSheets/logo.css">
    <link rel="stylesheet" href="styleSheets/style_index.css">
    <link rel="stylesheet" href="styleSheets/style_profile.css">

    <style>
        input#log_out {
            width: 150px;
            margin: auto;
        }

        div.coll button {
            width: 100%;
            padding: 5px 0;
            margin: 3px 0;
            background: #1d4faa24;
            color: #000000;
            border: none;
            border-radius: 0;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <?php
        include 'partials/_nav.php';
        include 'partials/_dbconnect.php';
        $oldpassmatch = false;
        $matchPass = false;
        $updateEmail = false;

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(isset($_POST['logout'])) {
                header('location: /php_tutorial/EVS/logout.php');
            }
            include 'changes/change_username.php';
            include 'changes/changePassword.php';
            include 'changes/changeMobileNo.php';
            include 'changes/changeEmail.php';

            if(isset($_POST['vote'])) {
                $usrname = $_SESSION["username"];
                $roll = $_SESSION["rollno"];
                $sql = "SELECT * FROM `evsuser` WHERE `username` = '$usrname' AND `rollno` = '$roll'";
                $result = mysqli_query($conn, $sql);
                $no_row = mysqli_num_rows($result);
                if($no_row == 1) {
                    while($row = mysqli_fetch_assoc($result)) {
                        $approve = $row['approve'];
                        $voted = $row['status'];
                        if($approve != 1) {
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Failed! </strong> Your account is not approved by the voting controller.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>';
                        }
                        else {
                            if($voted == 1) {
                                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Warning!</strong> You already have submitted your vote.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>';                          
                            }
                            else {
                                $sqll = "SELECT * FROM `votingtitle` WHERE 1";
                                $results = mysqli_query($conn, $sqll);
                                $no_rows = mysqli_num_rows($results);
                                if($no_rows == 0) {
                                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Notification!</strong>There is no voting process running now.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>';                                   
                                }
                                else {
                                    while($row = mysqli_fetch_assoc($results)) {
                                        $started = $row['status'];
                                        if($started == 0) {
                                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>Notification!</strong> The voting process yet to start.
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>';
                                        }
                                        else {
                                            header('location: /php_tutorial/EVS/voting/voting_candidate.php');
                                            exit;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                else {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Warning!</strong> Your profile may updated. Please login again to continue.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>'; 
                }
            }
        }
    ?>

    <!-- user name edit modal -->
    <div class="modal fade" id="cumodal" tabindex="-1" aria-labelledby="cumodalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cumodalLabel">Update Username</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <form action="/php_tutorial/EVS/profile.php" method="post" autocomplete="off">
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

                            <button type="submit" class="btn btn-primary" style="width: 100%;"
                                name="conusername">CONFIRM</button>
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
                        <form action="/php_tutorial/EVS/profile.php" method="post" autocomplete="off">
                            <input type="hidden" name="snoEdit" id="snoEdit">

                            <div class="mb-3">
                                <label for="curp" class="form-label">Current password</label>
                                <input type="password" class="form-control" id="curp" aria-describedby="emailHelp"
                                    name="curp" required>
                            </div>
                            <div class="mb-3">
                                <label for="newp" class="form-label">New password</label>
                                <input type="password" class="form-control" id="newp" aria-describedby="emailHelp"
                                    name="newp" required maxlength="30">
                            </div>
                            <div class="mb-3">
                                <label for="newcp" class="form-label">Confirm password</label>
                                <input type="password" class="form-control" id="newcp" aria-describedby="emailHelp"
                                    name="newcp" required maxlength="30">
                            </div>
                            <button type="submit" class="btn btn-primary" style="width: 100%;"
                                name="conpass">CONFIRM</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- mobile number edit modal -->
    <div class="modal fade" id="cmmodal" tabindex="-1" aria-labelledby="cmmodalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cmmodalLabel">Update Mobile Number</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <form action="/php_tutorial/EVS/profile.php" method="post" autocomplete="off">
                            <input type="hidden" name="snoEdit" id="snoEdit">

                            <div class="mb-3">
                                <label for="curp" class="form-label">Password</label>
                                <input type="password" class="form-control" id="curp" aria-describedby="emailHelp"
                                    name="curp" required>
                            </div>
                            <div class="mb-3">
                                <label for="newm" class="form-label">New Mobile Number</label>
                                <input type="text" class="form-control" id="newm" aria-describedby="emailHelp"
                                    name="newm" required value="<?php echo $_SESSION['mobile']; ?>" maxlength="10" minlength="10"
                                    oninvalid="this.setCustomValidity('Invalid mobile number!')" oninput="setCustomValidity('')">
                            </div>

                            <button type="submit" class="btn btn-primary" style="width: 100%;"
                                name="conmob">CONFIRM</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- email id edit modal -->
    <div class="modal fade" id="cemodal" tabindex="-1" aria-labelledby="cemodalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cemodalLabel">Update Email ID</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <form action="/php_tutorial/EVS/profile.php" method="post" autocomplete="off">
                            <input type="hidden" name="snoEdit" id="snoEdit">

                            <div class="mb-3">
                                <label for="curp" class="form-label">Password</label>
                                <input type="password" class="form-control" id="curp" aria-describedby="emailHelp"
                                    name="curp" required>
                            </div>
                            <div class="mb-3">
                                <label for="newem" class="form-label">New Email ID</label>
                                <input type="email" class="form-control" id="newem" aria-describedby="emailHelp"
                                    name="newem" required value="<?php echo $_SESSION['email']; ?>" maxlength="50">
                            </div>

                            <button type="submit" class="btn btn-primary" style="width: 100%;"
                                name="conemail">CONFIRM</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container welcome">
        <?php
            echo '<h4 class="text-primary">Hello, ' . $_SESSION['username'] . '</h4>';
        ?>
        <h6>Welcome to E-Voting System.</h6>
    </div>

    <div class="container myflex">
        <div class="coll">
            <h4 style="color: rgb(6, 78, 10);">-:Profile:-</h4>
            <ul>
                <li>UserName :
                    <?php echo $_SESSION['username']; ?>
                </li>
                <li>Roll No. :
                    <?php 
                        echo $_SESSION['rollno']; 
                    ?>
                </li>
                <li>Mobile No. :
                    <?php echo $_SESSION['mobile']; ?>
                </li>
                <li>Email :
                    <?php echo $_SESSION['email']; ?>
                </li>
                <?php
                    if($_SESSION['approve'] == 0) {
                        echo '<li> Status: Waiting</li>';
                    }
                    if($_SESSION['approve'] == 1) {
                        echo '<li> Status: Approved</li>';
                    }
                    if($_SESSION['approve'] == 2) {
                        echo '<li> Status: Rejected</li>';
                    }
                ?>
                <?php
                    if($_SESSION['status'] == 0) {
                        echo '<li> Voted: NO</li>';
                    }
                    if($_SESSION['status'] == 1) {
                        echo '<li> Voted: YES</li>';
                    }
                ?>
                <form action="#" method="POST">
                    <input id="log_out" type="submit" name="logout" value="LOGOUT" class="my-3 text-danger">
                </form>
            </ul>
        </div>
        <div class="coll" id="">
            <h4 style="color: red;">What you are looking for?</h4>
            <button id="cu" type="button" class="btn btn-sm btn-block fmbtn">CHANGE USERNAME</button>
            <button id="cp" type="button" class="btn btn-sm btn-block fmbtn">CHANGE PASSWORD</button>
            <button id="cm" type="button" class="btn btn-sm btn-block fmbtn">CHANGE MOBILE NUMBER</button>
            <button id="ce" type="button" class="btn btn-sm btn-block fmbtn">CHANGE EMAIL ID</button>
            <div class="text-center" id="op">
                <form action="/php_tutorial/EVS/profile.php" method="POST">
                    <input type="submit" name="vote" value="CLICK HERE TO VOTE">
                </form>
            </div>
        </div>
    </div>

    <?php
        include 'partials/_footer.php';
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
        crossorigin="anonymous"></script>

    <script>
        let cp = document.getElementById('cp');
        let cm = document.getElementById('cm');
        let ce = document.getElementById('ce');
        let cu = document.getElementById('cu');
        cp.addEventListener('click', function () {
            $('#cpmodal').modal('toggle');
        })
        cm.addEventListener('click', function () {
            $('#cmmodal').modal('toggle');
        })
        ce.addEventListener('click', function () {
            $('#cemodal').modal('toggle');
        })
        cu.addEventListener('click', function () {
            $('#cumodal').modal('toggle');
        })
    </script>
</body>

</html>