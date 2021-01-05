<?php
include("db_operation.php");
$msg="";
function register($user_data)
{
  global $msg;
  $db=new DBoperation;
  $db->db_connect();
  $c_mail=$user_data[1];
  $exist=$db->search_user($c_mail);
  if($exist)
  {
    echo"<font color='#ff0000'>User already exist</font><br>";
    header('Location: http://localhost/xampp/finmanage/login.php');
  }
  $status=$db->insert_user($user_data);
  if($status)
  {
    $msg="註冊成功<br><a href='http://localhost/xampp/finmanage/login.php'><font color='#00ff00'>此處登入</font></a>";
  }
  else
  {
    $msg="<font color='#ff0000'>註冊失敗</font>";
  }
}
if($_SERVER['REQUEST_METHOD']=='POST')
{
  $name=$_POST['c_name'];
  if(empty(trim($name)))
  {
    echo"<font color="."'"."#ff0000"."'".">請輸入使用者姓名</font><br>";
  }
  $addr=$_POST['c_mail'];
  if(empty(trim($addr)))
  {
    echo"<font color='#ff0000'>請輸入使用者信箱</font><br>";
  }
  $pwd=$_POST['c_pwd'];
  if(empty(trim($pwd)))
  {
    echo"<font color='#ff0000'>請輸入密碼</font><br>";
  }
  $h_pwd=hash('sha256',$pwd);
  $v_pwd=$_POST['v_pwd'];
  if(empty(trim($v_pwd)))
  {
    echo"<font color='#ff0000'>請驗證密碼</font><br>";
  }
  $v_pwd=hash('sha256',$v_pwd);
  if($h_pwd!=$v_pwd)
  {
    echo"<font color='#ff0000'>這些密碼不相符，請再試一次</font><br>";
  }
  $user_data=array($name,$addr,$h_pwd);
  register($user_data);
}
 ?>
<html>
  <head>
    <title>user register</title>
    <h1 style="text-align: center"><font color='#00ff00'>新用戶註冊</font></h1>
    <p style="text-align: center"><font color='#00ff00'>請先註冊使用者資料後再使用本系統</font></p>
    <hr color="#00ff00">
  </head>
  <body bgcolor="#000000">
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
      <div align="center">
        <label><font color="00FFFF">使用者姓名:<br></font></label>
        <input type="text" name="c_name"><br>
        <label><font color="#00ffff">使用者信箱:<br></font></label>
        <input type="text" name="c_mail"><br>
        <label><font color="#00ffff">設定密碼:<br></font></label>
        <input type="password" name="c_pwd"><br>
        <label><font color="#00ffff">再次輸入密碼</font><br></label>
        <input type="password" name="v_pwd"><br>
        <input type="submit" value="註冊帳號"><br>
        <p><?php echo $msg;?></p>
    </div>
  </body>
</html>
