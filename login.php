<?php
include 'db_operation.php';

function password_check($add,$pwd)
{
  $db=new DBoperation();
  $db->DB_connect();
  $is_user=$db->search_user($add);
  if(!$is_user)
  {
    if((!(empty(trim($add))))&&(!(empty(trim($pwd)))))
    {
      header("Location: http://localhost/xampp/finmanage/register_page.php");
    }
  }
  else
  {
    $user_data=mysqli_fetch_array($is_user);
    if($pwd==$user_data['customer_pwd'])
    {
      //connect to main page
      echo"<font color='#00ff00'>Pass</font><br>";

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
    <title>login system</title>
  </head>
  <body bgcolor="#000000">
    <h1><font color="00FF00">個人帳簿系統</font></h1>
    <h3><font color="00FF00">請登錄以查閱個人帳簿</font></h3>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <label>
        <font color="#00ffff">使用者帳號:<br></font>
      </label>
      <input type="text" name="Address"><br>
      <label>
        <font color="#00ffff">密碼:<br></font>
      </label>
      <input type="Password" name="pwd"><br>
      <input type="submit" value="登入">
    </form>
  </body>
</html>
