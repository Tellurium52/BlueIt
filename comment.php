<!DOCTYPE html>
<!-- group members: Junjie Wang, Marwa Roshan, Tristan Gounard -->
<?php
include 'header.php';

$server = 'student.seas.gwu.edu';
$username   = 'junjie2412';
$password   = 'secret15';
$database = 'junjie2412';

$conn = mysqli_connect($server, $username, $password, $database);
session_start();
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$BoardID = $_SESSION["board_id"];
$UserID = $_SESSION["user_id"];
$CommentDes = $_GET["descr"];
$ThreadID = $_SESSION["thread_id"];
$Int = rand(0, 10000000);
$sql = "INSERT INTO Comment (idComment, Comment_Description, Comment_Date, Threads_idThreads, User_idUser)
VALUES (FLOOR('$Int'), '".$conn->real_escape_string($CommentDes)."', NOW(), '$ThreadID', '$UserID')";
if ($conn->query($sql) === TRUE) {
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$sql = "UPDATE Comment
SET Comment_Description = REPLACE(Comment_Description, CHAR(10), ' </br> ')
WHERE idComment = FLOOR($Int)";
if ($conn->query($sql) === TRUE) {
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>BlueIt - Comment</title>
		<style type="text/css">
		
			table, th, td{
				border: 1px solid black;
				border-collapse: collapse;
				background-color: #F0F8FF;
			}
			body{
				margin:0;
				padding:0;
				font-family: Sans-Serif;
				line-height: 1.5em;
			}
			
			main {
				padding-bottom: 10010px;
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
				color: #6B8A99
				
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
				color: #366899;
				text-decoration: none;
			}
			h1 {
				font-size: 40px;
				font-family: sans-serif; 
				
			}
			h3 {
				font-size: 25px;
				
			}
			
			
		</style>
		
			
	
	</head>
	
	<body>
		<div id="wrapper">
		
			<main>
				<div id="content">
					<div class="innertube">
						<h1>Your comment has been posted!</h1>
						<?php
						   echo '<li><a href="/~junjie2412/Thread.php?id = '. $_SESSION["thread_id"].'">Back to the thread.</a></li>';
                        ?>
				</div>
			</main>
			
			<nav id="nav">
				<div class="innertube">
					
					<h4>Site Navigation</h4>
					<ul>
						<?php
                        if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true){
                           echo 'You are signed in as ' . $_SESSION['user_name'];
						   echo '<li><a href="/~junjie2412/UserProfile.php?id=0000000'. $_SESSION['user_id'].'">Your Profile Page</a></li>';
						   echo '<li><a href="/~junjie2412/Userlist.php">Users List</a></li>';
						   echo '<li><a href="/~junjie2412/signout.php">Sign Out</a></li>';
                        }
                        else{
                            echo '<li><a href="/~junjie2412/login.php">Sign In</a></li>';
                            echo '<li><a href="/~junjie2412/signup.php">Sign Up</a></li>';
                            echo $_SESSION['user_name'];
                        }
                        ?>
						<li><a href="/~junjie2412/frontpage.php">Home</a></li>
					</ul>
					<h4>About the creators</h4>
					<ul>
						<li>BlueIt was created by Junjie Wang, Marwa Roshan, and Tristan Gounard as part of a Database Systems project meant to implement a complex, MySQL-based website. </li>
						
					</ul>
					<h4>Boards</h4>
					<ul>
						<li><a href="/~junjie2412/NewsBoard.php">News and Announcements</a></li>
						<li><a href="/~junjie2412/GamesBoard.php">Games</a></li>
						<li><a href="/~junjie2412/MoviesBoard.php">Movies</a></li>
						<li><a href="/~junjie2412/AnimeBoard.php">Anime</a></li>
						<li><a href="/~junjie2412/MiscBoard.php">Misc.</a></li>
					</ul>
                    <br>
                    <ul>
                        <?php
                        if(isset($_SESSION['admin_id'])){
                            echo '<li><a href="/~junjie2412/makemod.php">Make a Moderator</a></li>';
                            echo '<li><a href="/~junjie2412/makeAdmin.php">Make an Admin</a></li>';
                        }
                        ?>
                    </ul>
				</div>
			</nav>
			
		</div>
	</body>
</html>