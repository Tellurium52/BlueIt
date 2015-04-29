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
$_SESSION['board_id'] = 2;
$_SESSION['board_name'] = 'Movies';
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>BlueIt - Movies</title>
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
						<h1>BlueIt</h1>
						<p>Welcome to BlueIt. Pick a board, pick a topic, and start discussing!</p>
					<div class ="boards">
						
						<h3>Movies</h3>
						<p>Film, actors, updates, directors, producers, and even the history of cinema. All of it can be found on the Movies board. </p>
						<?php
						if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true){
						echo
						' <form action="http://student.seas.gwu.edu/~junjie2412/InsertThread.php" method="get" id="thread">
						<input type="text" name="Threadname" value = "Thread title"><br>
						<textarea rows="4" cols="50" name = "description" >Enter your thread details</textarea>
						<input type="submit" value="Create thread"/>
						</form>';
						}
						?>
						</div>
						<table style="width:100%">
							<tr>
								<th width="50%">Thread Name</th>
								<th width="25%">Thread Op</th>		
								<th width="25%">Thread Post Date</th>
							</tr>
							</table>
						<?php
						$sql = "SELECT Threads.Thread_Name, idThreads, User.User_Name, Threads.Thread_Creation_Date, idUser
								FROM Threads
								INNER JOIN User
								ON Threads.User_idUser = User.idUser
								AND Threads.Board_idBoard = 2
								ORDER BY Bump_Date DESC";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
						while($row = $result->fetch_assoc()) {
							echo '<table style="width:100%">
									<tr>
										<th width="50%"><a href = "/~junjie2412/Thread.php?id=0000000'. $row["idThreads"].'">' . $row["Thread_Name"]. '</th>
										<th width="25%"><a href = "/~junjie2412/UserProfile.php?id=0000000'. $row["idUser"].'">' . $row["User_Name"]. '</th>
										<th width="25%">' . $row["Thread_Creation_Date"]. '</th>
									</tr>
									</table>';
							 }
						} else {
							 echo "0 results";
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