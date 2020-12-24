<?php
include("db_operation.php");
$db= new DBoperation;
$db->DB_connect();
session_start();
$user_id=$_SESSION['uid'];
$user_mail=$_SESSION['umail'];
//echo"<font color='#00ff00'>".$user_id."<br></font>";
$user_data=$db->search_user($user_mail);
if(!$user_data)
{
  echo"<font color='#ff0000'>**</font><br>";
  //header("Location: http://localhost/xampp/finmanage/login.php");
}
$user_data=mysqli_fetch_array($user_data);
$user_name=$user_data['customer_name'];
$user_money=$db->search_record($user_id,$print=false);
echo"<h1 style='text-align: Center;'><font color='#00ff00'>".$user_name."，歡迎來到個人帳簿<br></font></h1>";
//echo"<h3><font color='#00ff00'>您還有 ".$user_money." 元<br></font></h2>";
echo"<hr color='#00ff00'>";
$_SESSION['udata']=$user_data;
$user_profile_url="http://localhost/xampp/finmanage/user_profile.php?id=".$user_id;
$trans_detail_url="http://localhost/xampp/finmanage/transection_detail.php?id=".$user_id;
$new_trans_url="http://localhost/xampp/finmanage/new_trans.php?id=".$user_id;
 ?>
<html>
  <title>Personal balance</title>
  <body bgcolor="#000000">
    <h2 style="text-align: Center;"><font color='#00ff00'>帳戶餘額: <?php echo trim($user_money); ?> 元</font></h2>
    <hr color='#00ff00'>
    <h2 style="text-align: Center;"><font color='#00ff00'>功能列表</font></h2>
    <h3 style="text-align: Center;"><a href="<?php echo $user_profile_url; ?>"><font color='#00ffff'>使用者資料</font></a></h3>
    <h3 style="text-align: Center;"><a href="<?php echo $trans_detail_url; ?>"><font color='#00ffff'>交易明細</font></h3>
    <h3 style="text-align: Center;"><a href="<?php echo $new_trans_url; ?>"><font color="#00ffff">記帳</font></a></h3>
  </body>
</html>
