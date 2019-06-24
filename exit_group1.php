<?php

session_start();

if(!($_SESSION["user_name"]))
{
header("Location:index.php");
exit();
}

require "database_connection.php";
$user_name = trim($_SESSION["user_name"]);
$select = "SELECT * from groups where user_name='{$user_name}';";
$result=mysqli_query($con, $select) or die(mysqli_error($con));
?>

<html>
<head>
<Title>Exit Group</Title>
</head>

<body>
<h2>Exit Group Name</h2>

<form action="exit_group.php" method="POST">
<?php

 echo"  <select name='group_name'>";
		
		while($row=mysqli_fetch_row($result))
		{
			$name=$row[0];
		     echo"<option value ='".$name."'>".$name."</option>";
		}
		
		
 echo"  </select>";
 
?>
<input type="submit" value="Exit Group" />

</form>
</body>
</html>