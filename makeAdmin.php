<html>
<head>
    <title>BlueIt - Make a Mod</title>
</head>
</html>

<?php
//makeAdmin.php
$server = 'student.seas.gwu.edu';
$username   = 'junjie2412';
$password   = 'secret15';
$database   = 'junjie2412';

$link = mysqli_connect($server, $username, $password, $database);

if(mysqli_connect_error()){
    die('Connect failed: ' . mysqli_connect_error());
}
session_start();

echo '<h3>Make a Administrator</h3>';

if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true){

    if($_SERVER['REQUEST_METHOD'] != 'POST'){

        if(!isset($_SESSION['admin_id'])){
            //User isn't an admin
            echo 'Administrators only!';
        }
        else{
            //User is an admin
            echo '*Note: To make a user an Administrator they must first be a Moderator.<br>';
            echo '<form action="" method="post">
            Username: <input type="text" name="username"/><br>
            Home Address: <input type="text" name="address"/><br><br>
            <input type="submit"/>
            </form>';
        }
    }
    else{
        $errors = array();

        if(!isset($_POST['username']) || trim($_POST['username']) == ''){
            $errors[] = 'The username field must not be empty.';
        }
        if(!isset($_POST['address']) || trim($_POST['address']) == ''){
            $errors[] = 'The address field must not be empty.';
        }
        if(!empty($errors)){
            echo 'Uh-oh.. a couple of fields are not filled in correctly..';
            echo '<ul>';
            foreach($errors as $key => $value) /* walk through the array so all the errors get displayed */
            {
                echo '<li>' . $value . '</li>'; /* this generates a nice error list */
            }
            echo '</ul>';
            echo '<a href="makeAdmin.php">Try again</a>';
        }
        else{
            $username = $link->real_escape_string($_POST['username']);
            $address = $link->real_escape_string($_POST['address']);

            //query that finds the user id from username and mod id
            $id ="SELECT
                    idUser, User_Name, idModerator
                  FROM
                    User, Moderator
                  WHERE
                    User_Name = '$username'
                  AND
                    User_idUser = idUser";
            $result = $link->query($id);
            if(!$result){
                //something went wrong, display the error
                echo 'Something went wrong while looking for user id. ';
                echo '<a href="makeAdmin.php">Try again?</a> ';
                //echo $link->error; //for debugging, uncomment when needed
            }
            else{
                if(mysqli_num_rows($result) == 0){
                    echo 'There is no user with username: ' . $username. ' or the user is not a mod.';
                    echo ' <a href="makeAdmin.php">Try again?</a>';
                }
                else{
                    $row = $result->fetch_assoc();
                    $idUser = $row['idUser'];
                    $idMod = $row['idModerator'];

                    $sql="INSERT INTO
                            Administrator(idAdministrator, Admin_Home_Address, Moderator_idModerator, User_idUser)
                          VALUES (FLOOR(RAND()*1000), '$address', '$idMod', '$idUser')";
                    $result = $link->query($sql);

                    if(!$result){
                        //something went wrong, display the error
                        echo 'Something went wrong while making an Admin. ';
                        echo '<a href="makeAdmin.php">Try again?</a> ';
                        echo $link->error;
                    }
                    else{
                        echo 'Success! ' . $username . ' is now an Admin.';
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