

<?php
//signout.php

$server = 'student.seas.gwu.edu';
$username   = 'junjie2412';
$password   = 'secret15';
$database   = 'junjie2412';

$link = mysqli_connect($server, $username, $password, $database);
session_start();

if(mysqli_connect_error()){
    die('Connect failed: ' . mysqli_connect_error());
}

echo '<h3>Sign out</h3>';


if($_SESSION['signed_in'] != true)
{
    echo 'You are not signed in. Try <a href="login.php">signing in</a> if you want.';
}
else
{

    if($_SERVER['REQUEST_METHOD'] != 'POST')
    {
        /*the form hasn't been posted yet, display it
          note that the action="" will cause the form to post to the same page it is on */
        echo '<form action="" method="post">
        Are you sure you want to sign out? <br><input type="submit" value="Yes" />
        </form>';

    }
    else
    {
        session_unset();
    }
}


echo '<h4><a href="frontpage.php">Return to Homepage</a></h4>';

include 'footer.php';
?>



<style type="text/css">

    body{
        padding-left: 15px;
        padding:0;
        font-family: Sans-Serif;
        line-height: 1.5em;
        background: #DAE7FF;
    }

    main {
        padding-bottom: 10010px;
        padding-left: 15px;
        margin-bottom: -10000px;
        float: left;
        width: 100%;
        background: #DAE7FF;
    }

    #nav {
        float: left;
        width: 230px;
        margin-left: -100%;
        padding-bottom: 10010px;
        margin-bottom: -10000px;
        background: #FFFFFF;
        color: #366899;

    }

    #li {
        float: left;
        width: 230px;
        margin-left: -100%;
        padding-bottom: 10010px;
        margin-bottom: -10000px;
        background: #FFFFFF;
        color: #366899;

    }

    #wrapper {
        overflow: hidden;
    }

    #content {
        margin-left: 230px; /* Same as 'nav' width */
    }

    .innertube{
        margin: 15px; /* Padding for content */
        margin-top: 0;
    }

    p {
        color: #555;
    }

    nav ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
    }

    nav ul a {
        color: #6B8A99;
        text-decoration: none;
    }
    h1 {
        font-size: 40px;
        font-family: sans-serif;

    }
    h3 {
        font-size: 25px;
        padding-left: 10px;

    }

</style>
		
		