<?php

session_start();
if(!($_SESSION["user_name"]))
{
header("Location:index.php");
exit();
}

require "database_connection.php";


$title = trim($_REQUEST["title"]);

$user_id= trim($_SESSION["user_id"]);
$delete="DELETE from wallet where user_id='{$user_id}' and title='{$title}';";

mysqli_query($con,$delete)
or die("Error ideleting value".mysqli_error($con));

header("Location:view_wallet.php");
?>