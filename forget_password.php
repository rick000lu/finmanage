<?php
include("PHPMailer-5.2-stable/PHPMailerAutoload.php");
include("db_operation.php");
$user_mail="";
$msg="";
$db=new DBoperation;
$db->DB_connect();
$mail=new PHPMailer;      //New PHPMailer instance
$mail->SMTPDebug=0;       //Use debug mode
$mail->IsSMTP();          //Use SMTP
$mail->SMTPAuth=true;     //SMTP authentication
$mail->SMTPSecure="ssl";  //Gmail SMTP host require ssl
$mail->Host="smtp.gmail.com"; //gmail SMTP host
$mail->Port=465;              //Gmail SMTP port number
$mail->CharSet="utf-8";
$mail->Encoding="base64";
$mail->IsHTML(true);    //mail format is HTML
$mail->WordWrap=50;     //Each line has 50 character
$mail->Username="finmanagetest@gmail.com";  //authentication mail address
$mail->Password="finmanageadmin";           //authentication mail address password
$mail->From="finmanagetest@gmail.com";    //mail address which sent email
$mail->FromName="Finmanage 測試";         //name for sender mail address
$mail->Subject="finmanage 重設密碼";
$mail->Body="請點選以下連結重設密碼: http://localhost/xampp/finmanage/password_reset.php";   //mail content
if($_SERVER['REQUEST_METHOD']=='POST')
{
  $user_mail=$_POST['mail_addr'];
  if(!$db->search_user($user_mail))
  {
    header("location: http://localhost/xampp/finmanage/register_page.php");
  }
  session_start();
  $_SESSION['umail']=$user_mail;
  $mail->AddAddress($user_mail);  //set receiver mail address
  if($mail->Send())
  {
    $msg="<font color='#00ff00'>信件已寄至".$user_mail.", 請查閱信箱</font>";
  }
  else
  {
    $msg="<font color='#ff0000'>寄信失敗</font>";
  }
}

?>
<html>
  <head>
    <title>Forget Password</title>
    <h1 style = "text-align: center"><font color="#00ff00">忘記密碼</font></h1>
    <hr color="#00ff00">
  </head>
  <body bgcolor="#00000">
    <h3 style="text-align: center;"><font color="#00ff00">請輸入您的電子信箱，我們將寄信給您</font></h3>
    <form  action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
      <div align="center">
        <label><font color="#00ffff">使用者信箱</font></label>
        <input type="text" name="mail_addr" value="">
        <input type="submit" value="提交"><br>
        <p><?php echo $msg; ?></p>
      </div>
    </form>
  </body>
</html>
