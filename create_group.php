<?php

session_start();

if(!($_SESSION["user_name"]))
{
header("Location:index.php");
exit();
}

require "database_connection.php";


$group_name= $_REQUEST["group_name"];
$number; 
$members=array();



for($i=1 ; $i<=10 ; $i++)
{
	
	$members[$i - 1] = $_REQUEST["member{$i}"];
	if($members[$i -1] == "")
	{
		break;
	}
	
}

$number=$i - 1;

$insert1 = "INSERT INTO group_name (name,group_members) VALUES ('{$group_name}','{$number}');";

mysqli_query($con,$insert1)

or die("Error inserting into group_name table".mysqli_error($con));


for($j=1; $j<=$number; $j++)
{
	$member_name=$members[$j - 1];
	mysqli_query($con,"INSERT INTO groups VALUES ('{$group_name}','{$member_name}');") or die("Error inserting into groups table".mysqli_error($con));
	
}


header("Location: view_groups.php");


?>