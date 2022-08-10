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
</head>

<body>
    <?php
        include 'partials/_nav.php';

    ?>
    <div class="container my-flex my-5 roww-1">
        <div class="coll-1 text-center my-flex" id="header_coll_1">
            <div>
                <h2 class="navbar-brand"><span class="spn" id="e">E</span><span class="spn" id="v">V</span><span
                        class="spn" id="s">S</span></h2>
                <h3 class="text-danger">E-Voting System</h3>
            </div>

        </div>
        <div class="coll-2 my-flex text-center" id="header_coll_2">
            <div>
                <h3 class="text-primary">WELCOME</h3>
                <h6 class="text-secondary">EVS is a Voting Sytem used to collect votes from the students for an Institutional Election.
                    It makes voting process digital and simple for the students.</h6>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="roww-2 mx-1">
            <h3 id="proc">Procedures</h3>
            <ul class="text-secondary">
                <li>Login to your account with your valid username and password.</li>
                <li>If you have not created your account, signup first for login.</li>
                <li>After login successfully you can see your profile and lots of buttons.</li>
                <li>Select the <b>Click here to vote</b> button to submit your valuable vote.</li>
                <li>After that a page will open where you can vote your favourite candidate by clicking the <b>VOTE</b> button.</li>
                <li>You can also update your profile by selecting the specific button.</li>
                <li>Remember, you can not vote more than one time, so select your candidate carefully.</li>
                <li>It is better to logout if your voting process is success. For any query contact to your authority.</li>
            </ul>
            <p class="text-secondary">Happy voting...</p>
        </div>
    </div>

    <?php
        include 'partials/_footer.php';
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
        crossorigin="anonymous"></script>
</body>

</html>