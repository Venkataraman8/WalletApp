<?php

session_start();

if(!($_SESSION["user_name"]))
{
header("Location:index.php");
exit();
}


require "database_connection.php";

$user_name=trim($_SESSION["user_name"]);
$receiver=$_REQUEST["settle_member"];
	date_default_timezone_set("Asia/Kolkata");
	$date_time = date("y-m-d")." ".date("H:i:s");
	
//amount
$select="SELECT * from debts where lender='{$user_name}' and receiver='{$receiver}';";
$result=mysqli_query($con,$select);
$row=mysqli_fetch_row($result);
$amount=$row[2];



$update="UPDATE debts SET amount=0 where lender='{$user_name}' and receiver='{$receiver}';";

mysqli_query($con,$update)
or die("Error in settling ".mysqli_error($con));




//receiver
$select="SELECT * from users where user_name='{$receiver}';";
$result=mysqli_query($con,$select);
$row=mysqli_fetch_row($result);
$receiver_id=$row[0];

$insert="INSERT INTO wallet values('{$receiver_id}','I','{$date_time}','{$user_name}','Settlement','{$amount}');";

mysqli_query($con,$insert)
or die("Error in inserting value".mysqli_error($con));


//user
$select="SELECT * from users where user_name='{$user_name}';";
$result=mysqli_query($con,$select);
$row=mysqli_fetch_row($result);
$user_id=$row[0];

$insert="INSERT INTO wallet values('{$user_id}','E','{$date_time}','{$receiver}','Settlement','{$amount}');";

mysqli_query($con,$insert)
or die("Error in inserting value".mysqli_error($con));


//success!
header("Location:debts.php");




?>
<html>
</html>