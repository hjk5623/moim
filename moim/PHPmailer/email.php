<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";

$email="";
if(isset($_GET["mode"]) && $_GET["mode"]=="find_passwd"){
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

//개설된모임 신청자에게 단체메일보내기
}else if(isset($_GET["mode"]) && $_GET["mode"]=="open"){
  $club_num = $_POST['club_num'];
  $sql="SELECT buy_id from `buy` where `buy_club_num` ='$club_num'; ";
  $result=mysqli_query($conn,$sql);
  if (!$result) {
    alert_back('Error: ' . mysqli_error($conn));
  }
  $rowcount=mysqli_num_rows($result);
  for($i=0;$i<$rowcount;$i++){
    $row = mysqli_fetch_array($result);
    $open_id[$i] = $row['buy_id'];
  }
  include './Sendmail.php';

  for($i=0; $i<count($open_id); $i++){
    $sql="SELECT email from `membership` where `id` ='$open_id[$i]'; ";
    $result=mysqli_query($conn,$sql);
    if (!$result) {
      alert_back('Error: ' . mysqli_error($conn));
    }
      $row = mysqli_fetch_array($result);
      $open_email[$i]=$row['email'];
      $to=$open_email[$i];
      var_dump($to);
      $from="Mo,im";
      $subject="Mo,im 모임 개설";
      $body="고객님이 신청하신 모임이 개설되었습니다. \n 홈페이지에서 확인하세요.";
      $cc_mail="";
      $bcc_mail="";   /*메일 보내기*/
      $sendmail->send_mail($to,$from,$subject,$body,$cc_mail,$bcc_mail );
  }
    echo '[{"email": "메일 발송 완료"}]';

}
?>
