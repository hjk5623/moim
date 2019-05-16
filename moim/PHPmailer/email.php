<?php
session_start();

$email="";
if(isset($_GET["mode"]) && $_GET["mode"]=="find_passwd"){
  include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";
  $id = $_POST['id'];
  $email = $_POST['email'];

  $sql="SELECT passwd FROM `membership` where id='$id' and email='$email'";
  $result = mysqli_query($conn,$sql);
  if (!$result) {
    die('Error: ' . mysqli_error($conn));
  }
  $row = mysqli_fetch_array($result);
  $rowcount=mysqli_num_rows($result);
  if(!$rowcount){
    echo '[{"passwd":"실패"}]';
    exit;
  }
  include './Sendmail.php';

  srand((double)microtime()*1000000); //난수값 초기화
  $passwd=rand(10000000,99999999);

  $sql="UPDATE membership SET passwd='$passwd' where id='$id' and email='$email'";
  $result = mysqli_query($conn,$sql);
  if (!$result) {
    die('Error: ' . mysqli_error($conn));
  }

  $to=$email;
  $from="관리자";
  $subject="Mo,im 고객님의 임시 비밀번호 입니다.";
  $body="Mo,im 고객님의 임시 비밀번호 입니다.\n임시비밀번호 : ".$passwd."\n로그인 후 수정하세요.";
  $cc_mail="";
  $bcc_mail=""; /* 메일 보내기*/
  $sendmail->send_mail($to, $from, $subject, $body,$cc_mail,$bcc_mail);

  echo '[{"passwd":"'.$passwd.'"}]';

}else if(isset($_GET["mode"]) && $_GET["mode"]=="send_code"){
  $email= $_POST['email1']."@".$_POST['email2'];

  include './Sendmail.php';

  srand((double)microtime()*1000000); //난수값 초기화
  $_SESSION['code']=rand(100000,999999);
  $code=$_SESSION['code'];
  unset($_SESSION['code']);
  $count=1;
  $to=$email;
  $from="관리자";
  $subject="Mo,im 회원 가입 인증번호입니다.Good";
  $body="Mo,im 회원가입 인증번호 입니다.\n인증번호 : ".$code."\n정확히 입력해주세요.";
  $cc_mail="";
  $bcc_mail=""; /* 메일 보내기*/
  $sendmail->send_mail($to, $from, $subject, $body,$cc_mail,$bcc_mail);

  echo '[{"code":"'.$code.'"}]';

}
?>
