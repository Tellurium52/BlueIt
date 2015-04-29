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
function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}
$str = curPageURL();
$_SESSION['user_profile'] = substr($str,-7);
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<?php
		$UserProfile = intval($_SESSION["user_profile"]);
						$sql = "SELECT User_Name
								FROM User
								WHERE idUser = '$UserProfile'";
						$result = $conn->query($sql);
		if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
		echo '<title>' . $row["User_Name"]. ' at BlueIt</title>';
		}
		}
		?>
		<style type="text/css">
		
			table, th, td{
				border: 1px solid black;
				border-collapse: collapse;
				background-color: #F0F8FF;
				text-align: left;
				vertical-align: text-top;
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
					<div class ="boards">
					</div>
						<?php
						if ($_SESSION['user_id'] == $_SESSION['user_profile']){
						$UserProfile = intval($_SESSION["user_profile"]);
						$sql = "SELECT User_Name
								FROM User
								WHERE idUser = '$UserProfile'";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
						while($row = $result->fetch_assoc()) {
					    echo'<h1> This is your profile, ' . $row["User_Name"]. '</h1>';
						}
						}
						$sql = "SELECT Thread_Name, Thread_Description, Thread_Creation_Date, idThreads
								FROM Threads
								WHERE User_idUser = '$UserProfile'
								ORDER BY Thread_Creation_Date DESC";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
						echo'<h3>My Threads:</h3>';
						echo'<table style="width:100%">
							<tr>
								<th width="25%">Thread Name</th>
								<th width="60%">Thread Description</th>
								<th width="10%">Thread Post Date</th>
								<th width="5%"></th>
							</tr>
							</table>';
						while($row = $result->fetch_assoc()) {
						echo '<table style="width:100%">
							<tr>
								<th width="25%"><a href = "/~junjie2412/Thread.php?id=0000000'. $row["idThreads"].'">' . $row["Thread_Name"]. '</th>
								<th width="60%">' . $row["Thread_Description"]. '</th>
								<th width="10%">' . $row["Thread_Creation_Date"]. '</th>
								<th width="5%"><a href = "/~junjie2412/EditThread.php?id=0000000'. $row["idThreads"].'">edit</th>
							</tr>
						</table>';
						}
						}
						$UserProfile = intval($_SESSION["user_profile"]);
						$sql = "SELECT Comment.idComment, Comment_Description, Comment_Date, Thread_Name, idThreads, Comment.Threads_idThreads
								FROM Comment
								INNER JOIN Threads
								ON Comment.User_idUser = '$UserProfile'
								AND Threads.idThreads = Comment.Threads_idThreads
								ORDER BY Comment.Comment_Date DESC";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
						echo'<h3>My Comments:</h3>';
						echo'<table style="width:100%">
							<tr>
								<th width="55%">Comment</th>
								<th width="20%">Commented On</th>
								<th width="20%">Comment Post Date</th>
								<th width="5%"></th>
							</tr>
							</table>';
						while($row = $result->fetch_assoc()) {
						echo '<table style="width:100%">
							<tr>
								<th width="55%">' . $row["Comment_Description"]. '</th>
								<th width="20%"><a href = "/~junjie2412/Thread.php?id=0000000'. $row["idThreads"].'">' . $row["Thread_Name"]. '</th>
								<th width="20%">' . $row["Comment_Date"]. '</th>
								<th width="5%"><a href = "/~junjie2412/EditComment.php?id=0000000'. $row["idComment"].'">edit</th>
							</tr>
						</table>';
						}
						}
						}
						else{
						$UserProfile = intval($_SESSION["user_profile"]);
						$sql = "SELECT User_Name
								FROM User
								WHERE idUser = '$UserProfile'";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
						while($row = $result->fetch_assoc()) {
					    echo'<h1>Hello! My name is ' . $row["User_Name"]. '</h1>';
						}
						}
						$sql = "SELECT Thread_Name, Thread_Description, Thread_Creation_Date, idThreads
								FROM Threads
								WHERE User_idUser = '$UserProfile'
								ORDER BY Thread_Creation_Date DESC";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
						echo'<h3>My Threads:</h3>';
						echo'<table style="width:100%">
							<tr>
								<th width="30%">Thread Name</th>
								<th width="60%">Thread Description</th>
								<th width="10%">Thread Post Date</th>
							</tr>
							</table>';
						while($row = $result->fetch_assoc()) {
						echo '<table style="width:100%">
							<tr>
								<th width="30%"><a href = "/~junjie2412/Thread.php?id=0000000'. $row["idThreads"].'">' . $row["Thread_Name"]. '</th>
								<th width="60%">' . $row["Thread_Description"]. '</th>
								<th width="10%">' . $row["Thread_Creation_Date"]. '</th>
							</tr>
						</table>';
						}
						}
						$UserProfile = intval($_SESSION["user_profile"]);
						$sql = "SELECT Comment.idComment, Comment_Description, Comment_Date, Thread_Name, idThreads, Comment.Threads_idThreads
								FROM Comment
								INNER JOIN Threads
								ON Comment.User_idUser = '$UserProfile'
								AND Threads.idThreads = Comment.Threads_idThreads
								ORDER BY Comment.Comment_Date DESC";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
						echo'<h3>My Comments:</h3>';
						echo'<table style="width:100%">
							<tr>
								<th width="60%">Comment</th>
								<th width="20%">Commented On</th>
								<th width="20%">Comment Post Date</th>
							</tr>
							</table>';
						while($row = $result->fetch_assoc()) {
						echo '<table style="width:100%">
							<tr>
								<th width="60%">' . $row["Comment_Description"]. '</th>
								<th width="20%"><a href = "/~junjie2412/Thread.php?id=0000000'. $row["idThreads"].'">' . $row["Thread_Name"]. '</th>
								<th width="20%">' . $row["Comment_Date"]. '</th>
							</tr>
						</table>';
						}
						}
						}
						?>
					</div>
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