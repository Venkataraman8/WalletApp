<?php

require "database_connection.php";

$user_name=trim($_REQUEST["user_name"]);
$pass_word=trim($_REQUEST["pass_word"]);
$hash = password_hash($pass_word, PASSWORD_DEFAULT);
$first_name=trim($_REQUEST["first_name"]);
$last_name=trim($_REQUEST["last_name"]);
$email=trim($_REQUEST["user_name"]);
$phone_no=trim($_REQUEST["phone_no"]);
$address=trim(preg_replace("/ [ \r\n]+ /","</p><p>",$_REQUEST["address"]));

$insert="INSERT INTO users (user_name, pass_word, first_name, last_name, email, phone_no, address)".
			"VALUES ('{$user_name}','{$hash}','{$first_name}','{$last_name}','{$email}','{$phone_no}','{$address}');";

mysqli_query($con,$insert)
or die("Error in inserting values".mysqli_error($con));

header("Location:index.html");

?>
