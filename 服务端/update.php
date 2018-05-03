<?php
require("db_config.php");
date_default_timezone_set("Asia/Shanghai");
$heartbeat = $_POST["heartbeat"];
$spO2 = md5($_POST["spO2"]);
$usernick =$_POST["nick"];
$date = date("Y-m-d H:i,:sa");
$mysqli= new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database);
if($heartbeat!=""&&$spO2!=""&&$usernick!="")
{
	$mysqli->query("insert into heartbeat_date(usernick, heartdate, spO2,updatetime) values('$usernick', '$heartbeat', '$spO2','$date')")or die("error connecting");
	echo 1;
}

?>