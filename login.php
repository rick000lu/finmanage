<html>
<body>
<title>login system</title>
<form method="post" action="<?php echo"$_SERVER['PHP_SELF'];" ?>">
  Address: <input type="text" name="Address">
  Password: <input type="Password" name="pwd">
  <input type="submit">
</form>
<?php
if($_SERVER['REQUEST_METHOD']=="post")
{
  $add=$_POST['Address'];
  $pwd=$_POST['pwd'];
  echo $add;
}
?>
</body>
</html>
