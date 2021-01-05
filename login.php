<?php
include 'db_operation.php';

//verify user information
function password_check($add,$pwd)
{
  $db=new DBoperation();
  $db->DB_connect();
  $is_user=$db->search_user($add);
  if(!$is_user)
  {
    echo "<font color='#ff0000'>沒有相對應的使用者</font><br>";
  }
  else
  {
    $user_data=mysqli_fetch_array($is_user);
    if($pwd==$user_data['customer_pwd'])
    {
      session_start();
      //connect to main page
      $_SESSION['uid']=$user_data['customer_id'];
      $_SESSION['umail']=$user_data['customer_mail'];
      $url="http://localhost/xampp/finmanage/main_page.php?id=".$_SESSION['uid'];
      header("Location:".$url);
      //echo"<font color='#00ff00'>Pass</font><br>";

    }
    else
    {
      echo"<font color="."'#"."FF0000'>使用者帳號或密碼錯誤<font>";
    }
  }
}

if($_SERVER['REQUEST_METHOD']=="POST")
{
  $add=$_POST['Address'];
  if(empty(trim($add)))
  {
    echo"<font color="."'"."#ff0000"."'".">請輸入使用者帳號<br></font>";
  }
  $pwd=$_POST['pwd'];
  if(empty(trim($pwd)))
  {
    echo"<font color="."'"."#ff0000"."'".">請輸入密碼<br></font>";
  }
  $pwd=hash('sha256',$pwd);
  password_check($add,$pwd);
}
?>
<html>
  <head>
    <h1 style="text-align: Center;" ><font color="#00FF00">個人帳簿系統</font></h1>
    <h3 style="text-align: Center;"><font color="#00FF00">請登錄以查閱個人帳簿</font></h3>
    <hr color="#00ff00">
    <title>login system</title>
  </head>
  <body bgcolor="#000000">
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <div align="center">
        <label >
          <font color="#00ffff">使用者帳號:<br></font>
        </label>
        <input type="text" name="Address"><br>
        <label>
          <font color="#00ffff">密碼:<br></font>
        </label>
        <input type="Password" name="pwd"><br>
        <input type="submit" value="登入"><br>
        <label>
          <font color="#ffffff">沒有帳號?</font>
          <a href='http://localhost/xampp/finmanage/register_page.php'><font color="#FF0000">註冊用戶</font></a>
        </label>
        <br>
        <label>
          <a href="http://localhost/xampp/finmanage/forget_password.php"><font color="#ff0000">忘記密碼</font></a>
        </label>
      </div>
    </form>
  </body>
</html>
