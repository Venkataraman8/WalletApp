<?php

session_start();

$_SESSION["members"]=false;
if(!($_SESSION["user_name"]))
{
header("Location:index.php");
exit();
}


require "database_connection.php";

$user_name = trim($_SESSION["user_name"]);
$select = "SELECT * from groups where user_name='{$user_name}';";

$result=mysqli_query($con, $select) or die(mysqli_error($con));

echo "<h1>Your Groups </h1>";
echo "<table border=3>";
echo "<tr>";
echo"<th> Group Name </th>";
echo"<th> Members </th>";

echo"</tr>";

while($row=mysqli_fetch_row($result))
{

$name=$row[0];

$select2="SELECT * from group_name where name='{$name}';";
$result2=mysqli_query($con, $select2) or die(mysqli_error($con));
$row2=mysqli_fetch_row($result2);

$group_members=$row2[2];



echo "<tr>";
echo"<td>". $name."</td>";
echo"<td>".$group_members."</td>";
echo"</tr>";

}

echo"</table><br/>";

echo"<a href='create_group1.php'>Create New Group</a><br/>";
echo"<a href='exit_group1.php'>Exit Group</a><br/><br/><br/>";
echo "<a href='debts.php'>View Debts</a><br/><br/><br/><br/>";

$result=mysqli_query($con, $select) or die(mysqli_error($con));


echo"<form action='add_group_event1.php' METHOD='POST'>";
 echo"  <select name='group_name'>";
		
		while($row=mysqli_fetch_row($result))
		{
			$name=$row[0];
		     echo"<option value ='".$name."'>".$name."</option>";
		}
		
		
 echo"  </select>";


	  

echo"<input type='submit' value='Add New Group Event' /><br/><br/><br/><br/>";
	 echo "</form>";

echo"<a href='view_wallet.php'>Wallet</a><br/><br/>";
echo "<a href='dashboard.php'>Back to DashBoard</a><br/>";


?>

<html>
<head>

<Title>View Groups</Title>
</head>

<body>

	
</body>
</html>