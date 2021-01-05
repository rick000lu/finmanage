<?php
include('db_operation.php');
session_start();
$user_data=$_SESSION['udata'];
$user_name=$user_data['customer_name'];
$user_id=$user_data['customer_id'];
$db=new DBoperation;
$db->DB_connect();
 ?>
<html>
  <head>
    <title>Personal Transection Detil</title>
    <h1 style="text-align: Center"><font color='#00ff00'><?php echo $user_name;?> 的交易明細表</font></h1>
    <hr color='#00ff00'>
  </head>
  <body bgcolor='#000000'>
    <p><?php $db->search_record($user_id); ?></p>
    <div align="center">
      <input type="button" value="回主頁" onclick="location.href='http://localhost/xampp/finmanage/main_page.php?id=<?php echo $user_id?>'">
      <input type="button" value="記帳" onclick="location.href='http://localhost/xampp/finmanage/new_trans.php?id=<?php echo $user_id?>'">
    </div>
  </body>
</html>
