<?php
//connect.php
$server = '128.164.144.171';
$username   = 'junjie2412';
$password   = 'U~MqEPog';
$database   = 'junjie2412';

$conn = new mysqli($server, $username, $password, $database);

if(!$conn)
{
    die("Connection failed: " . mysqli_connect_error());
}

?>