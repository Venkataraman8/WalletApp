<?php

session_start();
if(!($_SESSION["user_name"]))
{
header("Location:index.php");
exit();
}

require "database_connection.php";

date_default_timezone_set("Asia/Kolkata");
$user_id=$_SESSION["user_id"];
$type = trim($_REQUEST["type"]);
$date_time = date("y-m-d")." ".date("H:i:s");
$title = trim($_REQUEST["title"]);
$description = trim(preg_replace("/ [ \r\n]+ /","</p><p>",$_REQUEST["description"]));
$amount = trim($_REQUEST["amount"]);


$insert="INSERT INTO wallet values('{$user_id}','{$type}','{$date_time}','{$title}','{$description}','{$amount}');";

mysqli_query($con,$insert)
or die("Error in inserting value".mysqli_error($con));

header("Location:view_wallet.php");
?>