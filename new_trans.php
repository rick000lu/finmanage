<?php
include("db_operation.php");
session_start();
$db=new DBoperation;
$db->DB_connect();
$user_data=$_SESSION['udata'];
$user_id=$user_data['customer_id'];
$msg="";
$result=false;
if($_SERVER['REQUEST_METHOD']=='POST')
{
  $income=$_POST['income'];
  $cost=$_POST['cost'];
  $detail=$_POST['detail'];
  $rec_data=array($user_id,$income,$cost,$detail);
  $result=$db->insert_record($rec_data);
  if($result)
  {
    //$msg="上傳成功";
    header("Location: http://localhost/xampp/finmanage/transection_detail.php?id=".$user_id);
  }
  else
  {
    $msg="上傳失敗";
  }
}
 ?>
 <html>
  <head>
    <title>Add new transection</title>
    <h1 style="text-align: center;"><font color="#00ff00">新增帳單</font></h1>
    <hr color='#00ff00'>
  </head>
  <body bgcolor="#ffffff">
    <form method="post" action=<?php echo $_SERVER['PHP_SELF'] ?>>
      <div align="center">
        <label><font color="#00ffff">收入</font><br></label>
        <input type="text" name="income"><br>
        <label><font color="#00ffff">支出</font><br></label>
        <input type="text" name="cost"><br>
        <label><font color="#00ffff">明細</font><br></label>
        <input type="text" name="detail" maxlength="100"><br>
        <input type="submit" value="新增" height="200" width="200">
        <p><font color="#ff0000"><?php echo $msg; ?></font></p>
        <input type="button" value="回主頁" onclick="location.href='http://localhost/xampp/finmanage/main_page.php?id=<?php echo $user_id; ?>'">
      </div>
  </body>
</html>
