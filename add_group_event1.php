<?php

session_start();

if(!($_SESSION["user_name"]))
{
header("Location:index.php");
exit();
}

require "database_connection.php";

$user_name = trim($_SESSION["user_name"]);
$group_name = $_REQUEST['group_name'];
$select = "SELECT * from groups where name='{$group_name}';";

$result=mysqli_query($con, $select) or die(mysqli_error($con));
?>

<html>
<head>
<Title>Add Group Event</Title>
</head>

<body>



<h2>Add A New Group Event</h2>
<form action="add_group_event.php" METHOD="POST">
<fieldset>

<?php

echo"<label for ='name'>Group Name:</label>";
echo"<input type='text' name='name' size='20'  value='".$group_name."'readonly /><br/><br/>";
?>

<label for ="event">EventName:</label>
<input type="text" name="event" size="20"/><br/><br/>



<label for ="total_cost">Total Cost:</label>
<input type="text" name="total_cost" size="20"/><br/><br/>

<?php

$member_name=array();
$i=0;
while($row=mysqli_fetch_row($result))
{
	$i++;
	$member_name[$i - 1]=$row[1];
	echo "<label for ='member".$i."'>".$member_name[$i - 1].":</label>";
	echo "<input type='text' value=0 name='member".$i."' size='20'/><br/><br/>";
}

$_SESSION["members"]=$member_name;



?>





</fieldset>
<input type="submit" value="Add Group Event" />
 <input type="reset" value="Clear and Restart" /><br/><br/>
 <a href="view_wallet.php">Wallet</a><br/>
<a href='view_groups.php'>Back to Groups</a><br/>
</form>

</body>
</html>