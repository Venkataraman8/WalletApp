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
<Title>Remove Event</Title>
</head>

<body>

<form action="remove_event.php" METHOD="POST">
<fieldset>


<label for ="title">Title:</label>
<input type="text" name="title" size="10"/><br/><br/>


</fieldset>
<input type="submit" value="Remove Event" />
 <input type="reset" value="Clear and Restart" />
</form>

</body>
</html>