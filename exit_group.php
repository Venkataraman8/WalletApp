<?php

session_start();

if(!($_SESSION["user_name"]))
{
header("Location:index.php");
exit();
}

require "database_connection.php";
$group_name= $_REQUEST["group_name"];
$user_name=trim($_SESSION["user_name"]);

$delete="DELETE FROM groups WHERE user_name='{$user_name}' and name='{$group_name}';";
mysqli_query($con,$delete) 
or die(mysqli_error($con));


$select="SELECT * FROM group_name where name='{$group_name}';";
$result=mysqli_query($con,$select);
$row=mysqli_fetch_row($result);
$members=$row[2];
$new_members=$members-1;


$update="UPDATE group_name SET group_members={$new_members} where name='{$group_name}';";
mysqli_query($con,$update)
or die(mysqli_error($con));

header("Location:view_groups.php")
?>
