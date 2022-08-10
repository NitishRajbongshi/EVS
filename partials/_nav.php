<?php
$logedin = false;
if(isset($_SESSION['login']) && $_SESSION['login'] == true) {
  $logedin = true;
}
echo '
<nav class="navbar navbar-expand-lg bg-light fs-5">
        <div class="container-fluid">
            <h2 class="navbar-brand"><span class="spn" id="e">E</span><span class="spn" id="v">V</span><span class="spn"
                    id="s">S</span></h2>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    ';
                    if(!$logedin) {
                        echo '
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/php_tutorial/EVS">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/php_tutorial/EVS/login.php">Login</a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-danger" href="/php_tutorial/EVS/admin/login_admin.php">Admin</a>
                        </li>';
                    }
                    if($logedin) {
                        echo '
                        <li class="nav-item">
                            <a class="nav-link" href="/php_tutorial/EVS/profile.php">Profile</a>
                        </li>';
                    }
                    echo '
                </ul>
            </div>
        </div>
</nav>';
?>