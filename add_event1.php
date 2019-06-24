<?php

session_start();

if(!($_SESSION["user_name"]))
{
header("Location:index.php");
exit();
}
?>

<html>
<head>
<Title>Add Event</Title>
</head>

<body>

<form action="add_event.php" METHOD="POST">
<fieldset>

<label for ="type">Type (I/E):</label>
<select name="type">
  <option value="I">I</option>
  <option value="E">E</option>

</select><br/><br/>

<label for ="title">Title:</label>
<input type="text" name="title" size="10"/><br/><br/>

<label for ="description">Description:</label>
<textarea rows=3 cols=20 name="description"></textarea><br/><br/>

<label for ="amount">Amount:</label>
<input type="text" name="amount" size="10"/><br/><br/>


</fieldset>
<input type="submit" value="Add Event" />
 <input type="reset" value="Clear and Restart" />
</form>

</body>
</html>