<?php
include('db_operation.php');
$db=new DBoperation;
$db->db_connect();
session_start();
$user_data=$_SESSION['udata'];
$user_id=$user_data['customer_id'];
$user_name=$user_data['customer_name'];
$user_mail=$user_data['customer_mail'];
$msg='';
if($_SERVER['REQUEST_METHOD']=="POST")
{
  $user_name=$_POST['c_name'];
  $user_mail=$_POST['c_mail'];
  $user_pwd=$_POST['c_pwd'];
  if(empty($user_pwd))
  {
    $user_pwd=$user_data['customer_pwd'];
  }
  else
  {
    $user_pwd=hash('sha256',$user_pwd);
  }
  $v_pwd=$_POST['v_pwd'];
  if(empty($v_pwd))
  {
    $v_pwd=$user_data['customer_pwd'];
  }
  else
  {
    $v_pwd=hash('sha256',$v_pwd);
  }
  if($user_pwd!=$v_pwd)
  {
    echo "<font color='#ff0000'>密碼驗證錯誤</font><br>";
  }
  $update_data=array($user_id,$user_name,$user_mail,$user_pwd);
  $status=$db->update_user($update_data);
  if($status)
  {
    $msg="更新成功";
  }
  else
  {
    $msg="更新失敗";
  }
}
 ?>
 <html>
  <head>
    <title> User profile update</title>
    <h1 style="text-align: Center;"><font color='#00ff00'>更新使用者資料</font></h1>
    <h2 style="text-align: Center;"><font color="#00ff00">請輸入更新資料以更新使用者資料</font></h2>
    <hr color="#00ff00">
  </head>
  <body bgcolor="#000000">
   <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
     <div align="center">
       <label><font color="#00ffff">使用者姓名</font></label><br>
       <input type="text" value="<?php echo $user_name; ?>" name="c_name"><br>
       <label><font color="#00ffff">使用者信箱</font></label><br>
       <input type="text" value="<?php echo $user_mail; ?>" name="c_mail"><br>
       <label><font color="#00ffff">更改密碼</font></label><br>
       <input type="password" name="c_pwd"><br>
       <label><font color="#00ffff">再次輸入密碼</font></label><br>
       <input type="password" name="v_pwd"><br>
       <input type="submit" value="更新"><br>
       <p><font color='#00ff00'><?php echo $msg; ?></font></p>
       <input type="button" value="回主頁" onclick="location.href='http://localhost/xampp/finmanage/main_page.php?id=<?php echo $user_id; ?>'">
     </div>
   </body>
</html>
