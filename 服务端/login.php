<?php
require("db_config.php");
$user = $_POST["user"];
$pwd = md5($_POST["pwd"]);
$mysqli= new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database);
$row=$mysqli->query("select * from user_test where user = '{$user}' and password = '{$pwd}'") or die("error connecting");
$result = mysqli_affected_rows($mysqli);
if ($result==0)
{
	echo 1;
}
else 
{
	$data=$row->fetch_assoc();
	$nick=$data['nick'];
	echo $nick;
}
?>