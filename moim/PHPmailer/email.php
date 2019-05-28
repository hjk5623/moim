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

}else if(isset($_GET["mode"]) && $_GET["mode"]=="open"){
  include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";
  $club_num=$_POST['club_num'];

  $sql="SELECT * FROM membership inner join buy on membership.id = buy.buy_id where buy_club_num=$club_num";  // 해당 모임을 구매한 사람의 id
  $result = mysqli_query($conn,$sql);
  if (!$result) {
    die('Error: ' . mysqli_error($conn));
  }
  $count=mysqli_num_rows($result);
  include './Sendmail.php';
  for($i=0;$i<$count;$i++){

    $row = mysqli_fetch_array($result);
    $email=$row['email'];
    $to=$email;
    $from="관리자";
    $subject="Mo,im 모임개설";
    $body="Mo,im 고객님이 신청하신 모임이 개설되었습니다. \n 홈페이지에서 확인하세요.";
    $cc_mail="";
    $bcc_mail=""; /* 메일 보내기*/
    $sendmail->send_mail($to, $from, $subject, $body,$cc_mail,$bcc_mail);

  // 이용자의 신청모임을 등록할 경우 이메일 보내기
  }

}else if(isset($_GET["mode"]) && $_GET["mode"]=="request_approve"){

    include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";
    $user_num=$_POST['user_num'];
    //신청자개설모임을 신청한 사람의 이메일을 가져온다.
    $sql="SELECT * FROM membership inner join user_club on membership.id = user_club.user_id where user_num=$user_num";
    $result = mysqli_query($conn,$sql);
    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }
    include './Sendmail.php';

    $row = mysqli_fetch_array($result);
    $user_name=$row['user_name']; //신청자모임의 모임이름
    $user_num=$row['user_num'];
    $email=$row['email'];
    var_dump($email);

    $to=$email;
    $from="관리자";
    $subject="Mo,im 신청모임등록완료";
    $body="Mo,im 고객님이 신청하신 모임 [모임명:$user_name]이 등록되었습니다. \n 홈페이지에서 확인하세요.";
    $cc_mail="";
    $bcc_mail=""; /* 메일 보내기*/
    $sendmail->send_mail($to, $from, $subject, $body,$cc_mail,$bcc_mail);

  }else if(isset($_GET["mode"]) && $_GET["mode"]=="request_disapprove"){
    //신청자모임 취소시 신청자이메일로 취소내용 보내기
    include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";
    $user_num=$_POST['user_num'];
    //신청자개설모임을 신청한 사람의 이메일을 가져온다.
    $sql="SELECT * FROM membership inner join user_club on membership.id = user_club.user_id where user_num=$user_num";
    $result = mysqli_query($conn,$sql);
    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }
    include './Sendmail.php';

    $row = mysqli_fetch_array($result);
    $user_name=$row['user_name']; //신청자모임의 모임이름
    $user_num=$row['user_num'];
    $email=$row['email'];
    var_dump($email);

    $to=$email;
    $from="관리자";
    $subject="Mo,im 신청모임취소";
    $body="Mo,im 고객님이 신청하신 모임 [모임명:$user_name]이 등록여건에 맞지 않아 취소되었습니다. \n 홈페이지에서 확인하세요.";
    $cc_mail="";
    $bcc_mail=""; /* 메일 보내기*/
    $sendmail->send_mail($to, $from, $subject, $body,$cc_mail,$bcc_mail);

  }

?>
