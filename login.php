<html>
    <head>
        <title>BlueIt - Sign in</title>
    </head>
</html>

<?php
//login.php
//include 'connect.php';
//include 'header.php';

$server = 'student.seas.gwu.edu';
$username   = 'junjie2412';
$password   = 'secret15';
$database   = 'junjie2412';

$link = mysqli_connect($server, $username, $password, $database);
session_start();

if(mysqli_connect_error()){
    die('Connect failed: ' . mysqli_connect_error());
}
 
echo '<h3>Sign in</h3>';

 
//first, check if the user is already signed in. If that is the case, there is no need to display this page
if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)
{
    echo 'You are already signed in, you can <a href="signout.php">sign out</a> if you want.';
}
else
{
    if($_SERVER['REQUEST_METHOD'] != 'POST')
    {
        /*the form hasn't been posted yet, display it
          note that the action="" will cause the form to post to the same page it is on */
        echo '<form method="post" action="">
            Username: <input type="text" name="user_name" />
            Password: <input type="password" name="user_pass">
            <input type="submit" value="Sign in" />
         </form>';
  
    }
    else
    {
        /* so, the form has been posted, we'll process the data in three steps:
            1.  Check the data
            2.  Let the user refill the wrong fields (if necessary)
            3.  Varify if the data is correct and return the correct response
        */
        $errors = array(); /* declare the array for later use */
         
        if(!isset($_POST['user_name']) || trim($_POST['user_name'] == ''))
        {
            $errors[] = 'The username field must not be empty.';
        }
         
        if(!isset($_POST['user_pass']) || trim($_POST['user_pass'] == ''))
        {
            $errors[] = 'The password field must not be empty.';
        }
         
        if(!empty($errors)) /*check for an empty array, if there are errors, they're in this array (note the ! operator)*/
        {
            echo 'Uh-oh.. a couple of fields are not filled in correctly..';
            echo '<ul>';
            foreach($errors as $key => $value) /* walk through the array so all the errors get displayed */
            {
                echo '<li>' . $value . '</li>'; /* this generates a nice error list */
            }
            echo '</ul>';
            echo '<a href="login.php">Try again</a>';
        }
        else
        {
            //the form has been posted without errors, so save it
            //notice the use of mysql_real_escape_string, keep everything safe!
            //also notice the sha1 function which hashes the password
            $user_name = $link->real_escape_string($_POST['user_name']);
            $user_pass = $link->real_escape_string($_POST['user_pass']);
            $sql = "SELECT 
                        idUser,
                        User_Name
                    FROM
                        User
                    WHERE
                        User_Name = '$user_name'
                    AND
                        User_Password = '$user_pass'";

            $result = $link->query($sql);
            if(!$result)
            {
                //something went wrong, display the error
                echo 'Something went wrong while signing in. Please try again later.';
                //echo mysql_error(); //debugging purposes, uncomment when needed
            }
            else
            {
                //the query was successfully executed, there are 2 possibilities
                //1. the query returned data, the user can be signed in
                //2. the query returned an empty result set, the credentials were wrong
                if(mysqli_num_rows($result) == 0)
                {
                    echo 'You have supplied a wrong user/password combination. Please <a href="login.php">try again</a>.';
                }
                else
                {
                    //set the $_SESSION['signed_in'] variable to TRUE
                    $_SESSION['signed_in'] = true;

                    $row = $result->fetch_assoc();
                    $_SESSION['user_id']    = $row['idUser'];
                    $_SESSION['user_name']  = $row['User_Name'];

                    //Adds mod id to the session if the user is a mod
                    $idUser = $row['idUser'];
                    $sql = "SELECT
                              User_idUser,
                              idModerator
                            FROM
                              Moderator
                            WHERE
                              User_idUser = '$idUser'";

                    $result2 = $link->query($sql);
                    if(!$result2){
                        //Display error
                        echo 'Error occurred during Mod idUser query: ';
                        echo $link->error;
                    }
                    else{
                        if(mysqli_num_rows($result2) != 0){
                            $mod = $result2->fetch_assoc();
                            $_SESSION['mod_id'] = $mod['idModerator'];
                            //for debugging:
                            //echo 'The mod_id has been made and is: ' . $_SESSION['mod_id'];
                        }
                    }

                    $query = "SELECT
                              User_idUser,
                              idAdministrator
                            FROM
                              Administrator
                            WHERE
                              User_idUser = '$idUser'";

                    $result3 = $link->query($query);
                    if(!$result3){
                        //Display error
                        echo 'Error occurred during Admin idUser query: ';
                        echo $link->error;
                    }
                    else{
                        if(mysqli_num_rows($result3) != 0){
                            $admin = $result3->fetch_assoc();
                            $_SESSION['admin_id'] = $admin['idAdministrator'];
                            //for debugging:
                            //echo 'idAdministrator is: ' . $admin['idAdministrator'];
                            //echo 'The admin_id has been made and is: ' . $_SESSION['admin_id'];
                        }
                    }



                    echo 'Welcome, ' . $_SESSION['user_name'] . '. <a href="frontpage.php">Proceed to Homepage</a>.';
                }
            }
        }
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
		
		