<?php
include('db_operation.php');
session_start();
$user_mail=$_SESSION['umail'];
$msg="";
$db=new DBoperation;
$db->DB_connect();
if($_SERVER['REQUEST_METHOD']=="POST")
{
  $new_pwd=$_POST['new_pwd'];
  $new_pwd=hash('sha256',$new_pwd);
  $v_pwd=$_POST['v_pwd'];
  $v_pwd=hash('sha256',$v_pwd);
  if($new_pwd!=$v_pwd)
  {
    $msg="<font color='#ff0000'>這些密碼不相符，請再試一次</font>";
  }
  $user_data=$db->search_user($user_mail);
  if(!$user_data)
  {
    echo "no user";
    //header("Location: http://localhost/xampp/finmanage/register_page.php");
  }
  else
  {
    $user_data=mysqli_fetch_array($user_data);
    $uid=$user_data['customer_id'];
    $uname=$user_data['customer_name'];
    $umail=$user_data['customer_mail'];
    $upwd=$new_pwd;
    $update_data=array($uid,$uname,$umail,$upwd);
    if($db->update_user($update_data))
    {
      $msg="<font color='#00ff00'>密碼變更成功，5秒後回到登入頁面</font>";
      sleep(5);
      unset($_SESSION['umail']);
      header("Location: http://localhost/xampp/finmanage/login.php");
    }
  }
}
 ?>
 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title>Reset password</title>
     <h1 style="text-align: Center;"><font color="#00ff00">請設立一個新的密碼</font></h1>
     <hr color="#00ff00">
   </head>
   <body bgcolor="#000000">
     <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
       <div align="center">
         <label><font color="#00ffff">設定密碼</font></label><br>
         <input type="password" name="new_pwd"><br>
         <label><font color="#00ffff">再次輸入密碼</font></label><br>
         <input type="password" name="v_pwd"><br>
         <input type="submit" value="設定密碼">
         <p><?php echo $msg; ?></p>
       </div>
     </form>
   </body>
 </html>
