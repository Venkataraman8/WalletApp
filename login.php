<?php

$flag=0;
session_start();

require "database_connection.php";

$user_name=trim($_REQUEST["username"]);
$pass_word=trim($_REQUEST["password"]);



$select="SELECT * from users where user_name ='".$user_name. "'; ";

//resource
$result = mysqli_query($con,$select)
or die("Username does not exist".mysqli_error($con));

$row=mysqli_fetch_array($result);
$correct_password=$row["pass_word"];
$correct_user_id=$row["user_id"];

if(mysqli_error($con)) $flag=-1;

if($flag==0)
{
	if(password_verify($pass_word,$correct_password))
	{	
		$flag=1;
		
		$_SESSION["user_name"]=$user_name;
		$_SESSION["user_id"]=$correct_user_id;
		header("Location:dashboard.php");
		exit();
	}
	
	else 
	{
		echo "Password incorrect";
	}
	
}

?>

