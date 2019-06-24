<?php

session_start();

if(!($_SESSION["user_name"]))
{
header("Location:index.php");
exit();
}

$user_name=$_SESSION["user_name"];
?>

<html>
<head>
<Title>Create New Group</Title>
</head>

<body>
<h1>Enter Group details</h1>

<form action="create_group.php" method="POST">

<fieldset>
<label for ="group_name">GROUPNAME:</label>
<input type="text" name="group_name" size="20"/><br/><br/>

<label for = "member1">Member 1 :</label>

<?php
echo "<input type='text' name='member1' value='" .$user_name. "' size='20' readonly/>";
?>

<br/><label for = "member2">Member 2 :</label>
<input type="text" name="member2"  size="20"><br/>

<label for = "member3">Member 3 :</label>
<input type="text" name="member3"  size="20"><br/>

<label for = "member4">Member 4 :</label>
<input type="text" name="member4"  size="20"><br/>

<label for = "member5">Member 5 :</label>
<input type="text" name="member5"  size="20"><br/>

<label for = "member6">Member 6 :</label>
<input type="text" name="member6"  size="20"><br/>

<label for = "member7">Member 7 :</label>
<input type="text" name="member7"  size="20"><br/>

<label for = "member8">Member 8 :</label>
<input type="text" name="member8"  size="20"><br/>

<label for = "member9">Member 9 :</label>
<input type="text" name="member9"  size="20"><br/>

<label for = "member10">Member10:</label>
<input type="text" name="member10"  size="20"><br/>

</fieldset>

<input type="submit" value="Create Group" />
 <input type="reset" value="Clear and Restart" />
</form>
</body>
</html>