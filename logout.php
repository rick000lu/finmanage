<?php
session_start();
unset($_SESSION['udata']);
unset($_SESSION['uid']);
unset($_SESSION['umail']);
 ?>
 <html>
  <head>
    <title>Logout</title>
    <h1 style="text-align: center;"><font color="#00ff00">Bye~~</font></h1>
    <hr color="#00ff00">
  </head>
  <body bgcolor="#000000">
    <div align="center">
      <h2 ><font color="#00ff00">Hope to see you again</font></h2>
      <a href="http://localhost/xampp/finmanage/login.php"><font color="#0000ff">回到登入頁面</font></a>
    </div>
  </body>
</html>
