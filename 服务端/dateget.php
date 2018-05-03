<?php
  require("db_config.php");
  $mysqli= new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database);
  //mysqli->query("set names 'GBK'"); //数据库输出编码
  //mysqli_select_db($mysql_database); //打开数据库
  $result = $mysqli->query("select * from heartbeat_date") or die("error connecting");
  $data="";
  $array= array();
  class User{
    public $heartdate;
    public $updatetime;
  }
  while($row = $result->fetch_assoc()){
    $user=new User();
    $user->heartdate = $row['heartdate'];
    $user->updatetime = $row['updatetime'];
    $array[]=$user;
  }
  $data=json_encode($array);
  // echo "{".'"user"'.":".$data."}";
  echo $data;
?>