<?php
require("db_config.php");
$user = $_POST["user"];
$pwd = md5($_POST["pwd"]);
$nick =$_POST["nick"];
$mysqli= new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database);
$mysqli->query("select * from user_test where user = '{$user}'") or die("error connecting");
$result =  mysqli_affected_rows($mysqli);
if ($result==0)
{
	$mysqli->query("insert into user_test(user, password, nick) values('$user', '$pwd', '$nick')")or die("error connecting");
	echo 1;
}
else 
{
	echo 2;
}
?>