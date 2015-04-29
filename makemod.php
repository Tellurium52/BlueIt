<html>
<head>
    <title>BlueIt - Make a Mod</title>
</head>
</html>

<?php
//makemode.php
$server = 'student.seas.gwu.edu';
$username   = 'junjie2412';
$password   = 'secret15';
$database   = 'junjie2412';

$link = mysqli_connect($server, $username, $password, $database);

if(mysqli_connect_error()){
    die('Connect failed: ' . mysqli_connect_error());
}
session_start();

echo '<h3>Make a Moderator</h3>';

if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true){
    if($_SERVER['REQUEST_METHOD'] != 'POST'){
        if(!isset($_SESSION['admin_id'])){
            //User isn't a mod
            echo 'Moderators only!';
        }
        else{
            echo '<form action="" method="post">
            Moding Board: <input type="text" name="board"/><br>
            Username: <input type="text" name="username"/><br>
            Full Name: <input type="next" name="real_name"/><br>
            Phone Number: <input type="text" maxlength="10" name="phone"/> *no () or - allowed<br><br>
            <input type="submit"/>
            </form>';
        }
    }
    else{

        $errors = array();

        if(!isset($_POST['board']) || trim($_POST['board']) == ''){
            $errors[] = 'The moding board field must not be empty.';
        }
        if(!isset($_POST['username']) || trim($_POST['username']) == ''){
            $errors[] = 'The username field must not be empty.';
        }
        if(!isset($_POST['real_name']) || trim($_POST['real_name']) == ''){
            $errors[] = 'The full name field must not be empty.';
        }
        if(!isset($_POST['phone']) || trim($_POST['phone']) == ''){
            $errors[] = 'The phone number field must not be empty.';
        }

        if(!empty($errors)){
            echo 'Uh-oh.. a couple of fields are not filled in correctly..';
            echo '<ul>';
            foreach($errors as $key => $value) /* walk through the array so all the errors get displayed */
            {
                echo '<li>' . $value . '</li>'; /* this generates a nice error list */
            }
            echo '</ul>';
            echo '<a href="makemod.php">Try again</a>';
        }
        else{
            $board = $link->real_escape_string($_POST['board']);
            $username = $link->real_escape_string($_POST['username']);
            $real_name = $link->real_escape_string($_POST['real_name']);
            $phone = $link->real_escape_string($_POST['phone']);
            $date = date("Ymd");
            $idUser;
            $id = "SELECT
                          idUser,
                          User_Name
                        FROM
                          User
                        WHERE
                          User_Name = '$username'";
            $result = $link->query($id);
            if(!$result){
                //something went wrong, display the error
                echo 'Something went wrong while making a mod. Please try again later.';
                //echo $link->error;
            }
            else{
                if(mysqli_num_rows($result) == 0){
                    echo 'There is no user with username: ' . $username;
                    echo ' <a href="makemod.php">Try again?</a>';
                }
                else{
                    $row = $result->fetch_assoc();
                    $idUser = $row['idUser'];

                    $sql = "INSERT INTO
                              Moderator(idModerator, Moderator_Phone_Number, Modded_Date, Mod_Real_Name, User_idUser, Board)
                            VALUES
                              (FLOOR(RAND()*1000), '$phone', '$date', '$real_name','$idUser', '$board')";

                    $result2 = $link->query($sql);
                    if(!$result2){
                        //something went wrong, display the error
                        echo 'Something went wrong while making a mod. ';
                        echo '<a href="makemod.php">Try again?</a>';
                        echo $link->error;
                    }
                    else{
                        echo 'Successfully created. ' . $username . ' is now a mod of board ' . $board;
                    }
                }
            }


        }
    }
}
else{
    echo 'Off Limits';
}



echo '<h4><a href="frontpage.php">Return to Homepage</a></h4>';
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