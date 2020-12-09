<html>
<body>
<title>login system</title>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  Address: <input type="text" name="Address"><br>
  Password: <input type="Password" name="pwd"><br>
  <input type="submit">
</form>
<?php
if($_SERVER['REQUEST_METHOD']=="POST")
{
  $add=$_POST['Address'];
  $pwd=$_POST['pwd'];
  echo $add."<br>";
  $pwd=hash('sha256',$pwd);
  echo $pwd;
}
?>
</body>
</html>
