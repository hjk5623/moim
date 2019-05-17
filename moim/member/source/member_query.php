<?php
include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";
include $_SERVER['DOCUMENT_ROOT']."/moim/lib/create_table.php";

create_table($conn,'membership');
//id_check
if(isset($_GET["mode"]) && $_GET["mode"] == "id_check"){

  if(empty($_POST["id"])){
    echo '[{"id":"아이디를 입력해주세요.<br>영문,숫자 6~8자리"},{"row":"1"}]';
    return;
  }else{
    $id = test_input($_POST["id"]);
    if (!preg_match("/^[a-zA-Z0-9]{5,8}$/",$id)) {
      echo '[{"id":"아이디를 입력해주세요.<br>영문,숫자 6~8자리"},{"row":"1"}]';
      return;
    }
  }
  $id = test_input($_POST["id"]);
  $q_id = mysqli_real_escape_string($conn, $id);

  $sql="SELECT * FROM `membership` where id='$q_id'";

  $result = mysqli_query($conn,$sql);

  if (!$result) {
    die('Error: ' . mysqli_error($conn));
  }
  $rowcount=mysqli_num_rows($result);

  if ($rowcount) {
    $s = '[{"id":"중복된 아이디 입니다."},{"row":"'.$rowcount.'"}]';
  }else{
    $s = '[{"id":"사용 가능 합니다."},{"row":"'.$rowcount.'"}]';
  }
  echo $s;
//insert
}else if(isset($_GET["mode"]) && $_GET["mode"] == "insert"){
  if(empty($_POST["id"])){
    echo "<script>alert('아이디를 입력하세요.');history.go(-1);</script>";
    exit;
  }else{
    $id = test_input($_POST["id"]);
    if (!preg_match("/^[a-zA-Z0-9]{5,8}$/",$id)) {
      echo "<script>alert('아이디가 형식이 맞지 않습니다.');history.go(-1);</script>";
      exit;
    }
  }
  $q_id = mysqli_real_escape_string($conn, $id);
  $sql="SELECT * FROM `membership` where id='$q_id'";
  $result = mysqli_query($conn,$sql);

  if (!$result) {
    die('Error: ' . mysqli_error($conn));
  }
  $rowcount=mysqli_num_rows($result);

  if($rowcount){
    echo "<script>alert('해당 아이디가 존재합니다.');history.go(-1);</script>";
    exit;
  }else{
    if(empty($_POST["passwd"])){
      echo "<script>alert('패스워드를 입력하세요.');history.go(-1);</script>";
      exit;
    }else{
      $passwd = test_input($_POST["passwd"]);
      if (!preg_match("/(?=.*\d{1,10})(?=.*[~`!@#$%\^&*()-+=]{1,10})(?=.*[a-zA-Z]{1,10}).{8,20}$/",$passwd)) {
        echo "<script>alert('패스워드 형식이 맞지 않습니다.');history.go(-1);</script>";
        exit;
      }
    }
    $q_passwd = mysqli_real_escape_string($conn, $passwd);
    if(empty($_POST["name"])){
      echo "<script>alert('이름을 입력하세요.');history.go(-1);</script>";
      exit;
    }else{
      $name = test_input($_POST["name"]);
      if (!preg_match("/^[가-힣\x20]{2,6}$/u",$name)) {
        echo "<script>alert('이름 형식이 맞지 않습니다.');history.go(-1);</script>";
        exit;
      }
    }
    $q_name = mysqli_real_escape_string($conn, $name);
    if($_POST["phone1"]=="선택"){
      echo "<script>alert('핸드폰 번호 앞자리를 선택해주세요.');history.go(-1);</script>";
      exit;
    }else{
      $phone1 = test_input($_POST["phone1"]);
    }
    $q_phone1 = mysqli_real_escape_string($conn, $phone1);
    if(empty($_POST["phone2"])){
      echo "<script>alert('핸드폰 번호 두 번째를 입력해주세요.');history.go(-1);</script>";
      exit;
    }else{
      $phone2 = test_input($_POST["phone2"]);
    }
    $q_phone2 = mysqli_real_escape_string($conn, $phone2);
    if(empty($_POST["phone3"])){
      echo "<script>alert('핸드폰 번호 세 번째를 입력해주세요.');history.go(-1);</script>";
      exit;
    }else{
      $phone3 = test_input($_POST["phone3"]);
    }
    $q_phone3 = mysqli_real_escape_string($conn, $phone3);
    if(empty($_POST["address1"])){
      echo "<script>alert('주소를 입력해주세요.');history.go(-1);</script>";
      exit;
    }else{
      $address1 = test_input($_POST["address1"]);
    }
    if(empty($_POST["address2"])){
      echo "<script>alert('주소를 입력해주세요.');history.go(-1);</script>";
      exit;
    }else{
      $address2 = test_input($_POST["address2"]);
    }
    if(empty($_POST["address3"])){
      echo "<script>alert('주소를 입력해주세요.');history.go(-1);</script>";
      exit;
    }else{
      $address3 = test_input($_POST["address3"]);
    }
    $q_address1 = mysqli_real_escape_string($conn, $address1);
    $q_address2 = mysqli_real_escape_string($conn, $address2);
    $q_address3 = mysqli_real_escape_string($conn, $address3);
    $q_address = $q_address2."/".$q_address1."/".$q_address3;

    if(empty($_POST["email1"])){
      echo "<script>alert('이메일 첫 번째를 입력해주세요.');history.go(-1);</script>";
      exit;
    }else{
      $email1 = test_input($_POST["email1"]);
    }
    $q_email1 = mysqli_real_escape_string($conn, $email1);
    if($_POST["email2"]=="이메일을 선택하세요"){
      echo "<script>alert('이메일을 선택하세요.');history.go(-1);</script>";
      exit;
    }else{
      $email2 = test_input($_POST["email2"]);
    }
    $q_email2 = mysqli_real_escape_string($conn, $email2);

    $phone=$phone1."-".$phone2."-".$phone3;
    $q_email=$q_email1."@".$q_email2;

    $sql="insert into membership(id, name, passwd, phone, address, email) ";
    $sql.="values('$q_id','$q_name','$q_passwd','$phone','$q_address','$q_email');";
    $result = mysqli_query($conn,$sql);
    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }
    mysqli_close($conn);
    echo "<script> location.href = '../../login/login.php'; </script>";
  }
}
mysqli_close($conn);

?>
