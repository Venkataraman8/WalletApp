<?php

session_start();

if(!($_SESSION["user_name"]))
{
header("Location:index.php");
exit();
}
?>
<html>

<h1>Welcome to Dashboard,  <?php echo "{$_SESSION["user_name"]}</h1>"?>

<br/><br/>
<a href="view_wallet.php">Wallet</a><br/><br/>
<a href="view_groups.php">Groups</a><br/><br/>
<a href="debts.php">Debts</a>

<br/>

<br/>
<br/>
<br/>
<br/>
<br/><br/>
<br/>
<a href="index.php">Logout</a>

</html>