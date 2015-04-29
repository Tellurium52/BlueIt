<html>
<head>
    <title>BlueIt - Sign up</title>
</head>
</html>
<?php
//signup.php
//include 'connect.php';
include 'header.php';
 
echo '<h3>Sign up</h3>';

$server = 'student.seas.gwu.edu';
$username   = 'junjie2412';
$password   = 'secret15';
$database   = 'junjie2412';

$link = mysqli_connect($server, $username, $password, $database);

if(mysqli_connect_error()){
    die('Connect failed: ' . mysqli_connect_error());
}
 
if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    /*the form hasn't been posted yet, display it
      note that the action="" will cause the form to post to the same page it is on */
    echo '<form method="post" action="">
        Username: <input type="text" name="user_name" />
        Password: <input type="password" name="user_pass">
        Password again: <input type="password" name="user_pass_check">
        E-mail: <input type="email" name="user_email">
        <input type="submit" value="Create Account" />
     </form>';
}
else
{
    /* so, the form has been posted, we'll process the data in three steps:
        1.  Check the data
        2.  Let the user refill the wrong fields (if necessary)
        3.  Save the data 
    */
    $errors = array(); /* declare the array for later use */
     
    if(isset($_POST['user_name']) || trim($_POST['user_name']) != '')
    {
        //the user name exists
        if(!ctype_alnum($_POST['user_name']))
        {
            $errors[] = 'The username can only contain letters and digits.';
        }
        if(strlen($_POST['user_name']) > 30)
        {
            $errors[] = 'The username cannot be longer than 30 characters.';
        }
    }
    else
    {
        $errors[] = 'The username field must not be empty.';
    }
     
     
    if(isset($_POST['user_pass']) || trim($_POST['user_pass']) != '')
    {
        if($_POST['user_pass'] != $_POST['user_pass_check'])
        {
            $errors[] = 'The two passwords did not match.';
        }
    }
    else
    {
        $errors[] = 'The password field cannot be empty.';
    }

    if(!isset($_POST['user_email']) || trim($_POST['user_email']) == '')
    {
        $errors[] = 'No email address supplied.';
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
    }
    else
    {
        //the form has been posted without, so save it
        //notice the use of mysql_real_escape_string, keep everything safe!
        //also notice the sha1 function which hashes the password
        $username = $link->real_escape_string($_POST['user_name']);
        $password = $link->real_escape_string($_POST['user_pass']);//($_POST['user_pass']);//password_hash($_POST['user_pass'],PASSWORD_DEFAULT);
        $email = $link->real_escape_string($_POST['user_email']);
        $date = date("Ymd");

        $dup = "SELECT
                        User_Name
                    FROM
                        User
                    WHERE
                        (User_Name = '$username')";
        $result1 = $link->query($dup);

        if($result1->num_rows > 0){ //|| $result1->num_rows > 0) {
            echo 'Username taken. <a href="signup.php">Try again.';
        }
        else{
            $sql = "INSERT INTO
                      User(idUser, User_Name, User_Password, User_Email ,User_Creation_Date)
                    VALUES(FLOOR(RAND()*10000000),'$username', '$password', '$email', '$date')";
            $result2 = $link->query($sql);
            if (!$result2) {
                //something went wrong, display the error
                echo 'Something went wrong while registering. Please try again later.';
                //echo mysql_error(); //debugging purposes, uncomment when needed
            } else {
                echo 'Successfully registered. You can now <a href="login.php">sign in</a> and start posting! :-)';
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