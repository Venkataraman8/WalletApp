<?php

session_start();

if(!($_SESSION["user_name"]))
{
header("Location:index.php");
exit();
}

require "database_connection.php";

$user_name=($_SESSION["user_name"]);
$select1="SELECT * from debts where lender='{$user_name}';";
$result1=mysqli_query($con,$select1);

echo"<h3>You Owe</h3>";
echo "<table border=2>";
echo "<tr>";
echo"<th> Name </th>";
echo"<th> Amount </th>";

echo"</tr>";

while($row=mysqli_fetch_row($result1))
{
	if($row[2]!=0)
	{
		echo "<tr>";
		echo"<td>".$row[1]."</td>";
		echo"<td>".$row[2]."</td>";
		echo"</tr>";
	}
}

echo"</table>";
echo"<hr size='10' noshade>";

$select="SELECT * from debts where receiver='{$user_name}';";
$result=mysqli_query($con,$select);
echo"<h3>You are owed by</h3>";
echo "<table border=2>";
echo "<tr>";
echo"<th> Name </th>";
echo"<th> Amount </th>";

echo"</tr>";

while($row=mysqli_fetch_row($result))
{
	if($row[2]!=0)
	{
		echo "<tr>";
		echo"<td>".$row[0]."</td>";
		echo"<td>".$row[2]."</td>";
		echo"</tr>";
	}
}

echo"</table><br/><br/><br/><br/>";

echo"<form action='settle.php' METHOD='POST'>";
$select1="SELECT * from debts where lender='{$user_name}';";
$result1=mysqli_query($con,$select1);
 echo"  <select name='settle_member'>";
		
		while($row=mysqli_fetch_row($result1))
		{
			if($row[2]!=0)
			{
			$name=$row[1];
		     echo"<option value ='".$name."'>".$name."</option>";
			}
		}
		
		
 echo"  </select>";
 echo"<input type='submit' value='Settle' /><br/><br/>";
echo "</form>";

echo "<a href='view_groups.php'>Back to Groups</a><br/><br/>";
echo "<a href='dashboard.php'>Back to DashBoard</a><br/>";


?>