<?php
session_start();
$user_data=$_SESSION['udata'];
$user_id=$user_data['customer_id'];
$user_name=$user_data['customer_name'];
$user_mail=$user_data['customer_mail'];
 ?>
<html>
<head>
  <title>User Profile</title>
</head>
<body bgcolor="#000000">
  <h1 style="text-align: Center;"><font color='#00ff00'>使用者個人資料</font></h1>
  <hr color='#00ff00'>
    <table border="1" bordercolor="#00ff00" align="center" style="text-align: center;">
        <div >
          <thead>
            <tr>
              <th colspan="2"><font color='#00ff00'>個人資料</font></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><font color='#00ff00'>使用者帳號</font></td>
              <td><font color='#00ff00'><?php echo $user_mail; ?></font></td>
            </tr>
            <tr>
              <td><font color='#00ff00'>使用者姓名</font></td>
              <td><font color='#00ff00'><?php echo $user_name; ?></font></td>
            </tr>
          </tbody>
      </div>
    </table>
    <div align="center">
        <input type='button' value='更新資料' onclick="location.href='http://localhost/xampp/finmanage/update_user_profile.php?id=<?php echo $user_id; ?>'">
    </div>
</body>
</html>
