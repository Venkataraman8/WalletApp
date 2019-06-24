<?php
require"database_connection.php";

$create1="CREATE TABLE IF NOT EXISTS users(
		user_id int AUTO_INCREMENT PRIMARY KEY,
		user_name varchar(20) NOT  NULL,
		pass_word varchar(80) NOT  NULL,
		first_name varchar(10) NOT  NULL,
		last_name varchar(10) NOT  NULL,
		email varchar(20) NOT  NULL,
		phone_no varchar(10) NOT  NULL,
		address varchar(50) NOT  NULL
    	
		);";

$create2="CREATE TABLE IF NOT EXISTS groups(
	
	name varchar(20) NOT NULL,
	user_name varchar(20) NOT NULL

);";

$create3="CREATE TABLE IF NOT EXISTS group_name(

		group_id int AUTO_INCREMENT PRIMARY KEY,
		name varchar(20) NOT NULL,
		group_members int NOT NULL
);";

$create4="CREATE TABLE IF NOT EXISTS wallet(
	user_id int Not NULL,
	type varchar(10) NOT NULL,
    date_time datetime NOT NULL,
    title varchar(10) NOT NULL,
    description varchar(100) NOT NULL,
    amount int NOT NULL
	);";
	
$create5="CREATE TABLE IF NOT EXISTS events (

	name varchar(20) NOT NULL,
	event varchar(20) NOT NULL,
	total_cost int NOT NULL,
	user_name varchar(20) NOT NULL,
	amount_paid int NOT NULL,
	amount_split float NOT NULL,
	amount_due float NOT NULL
);";

$create6="CREATE TABLE IF NOT EXISTS debts(

	lender varchar(20) NOT NULL,
	receiver varchar(20) NOT NULL,
	amount float NOT NULL
);";

mysqli_query($con,$create1) or die(mysqli_error($con));
mysqli_query($con,$create2) or die(mysqli_error($con));
mysqli_query($con,$create3) or die(mysqli_error($con));
mysqli_query($con,$create4) or die(mysqli_error($con));
mysqli_query($con,$create5) or die(mysqli_error($con));
mysqli_query($con,$create6) or die(mysqli_error($con));
?>