<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";

$userid=$_SESSION['userid'];

//insert
if(isset($_GET["mode"]) && $_GET["mode"] == "insert"){

    $user_name = test_input($_POST["user_name"]);
    $user_start = test_input($_POST["user_start"]);
    $user_end = test_input($_POST["user_end"]);
    $user_schedule = test_input($_POST["user_schedule"]);
    $user_to = test_input($_POST["user_to"]);
    $user_category = test_input($_POST["user_category"]);
    $user_rent_info = test_input($_POST["user_rent_info"]);
    $user_price = test_input($_POST["user_price"]);
    $user_content = test_input($_POST["user_content"]);
    $user_intro = test_input($_POST["user_intro"]);
    $q_user_name = mysqli_real_escape_string($conn, $user_name);
    $q_user_start = mysqli_real_escape_string($conn, $user_start);
    $q_user_end = mysqli_real_escape_string($conn, $user_end);
    $q_user_schedule = mysqli_real_escape_string($conn, $user_schedule);
    $q_user_to = mysqli_real_escape_string($conn, $user_to);
    $q_user_category = mysqli_real_escape_string($conn, $user_category);
    $q_user_rent_info = mysqli_real_escape_string($conn, $user_rent_info);
    $q_user_price = mysqli_real_escape_string($conn, $user_price);
    $q_user_intro = mysqli_real_escape_string($conn, $user_intro);


    //$regist_day = date("Y-m-d (H:i)")??
    // 파일 업로드 기능
    include "../lib/file_upload.php";

    //8. 파일의 실제명과 저장명을 각각 저장한다

    $sql= "INSERT INTO `user_club` VALUES (null, '$q_user_name', '$q_userid', '$user_content', '$q_user_category', '$q_user_to', '$q_user_rent_info', '$q_user_start', '$q_user_end', '$q_user_schedule', '$q_user_price', 'no','$user_image_name','$copied_image_name', '$user_file_name', '$copied_file_name', '$file_type[0]', '$q_user_intro');";

    $result = mysqli_query($conn,$sql);

    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }

    mysqli_close($conn);

    echo "<script> location.href = './user_request.php'</script>";
//환불신청
}else if(isset($_GET["mode"]) && $_GET["mode"] == "apply_cancle"){
    $buy_num = $_POST["buy_num"];

    $sql= "SELECT `buy_num` from buy where `buy_num`=$buy_num;";
    $result = mysqli_query($conn,$sql);

    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }
    $row = mysqli_fetch_array($result);
    $buy_num = $row["buy_num"];

    $sql= "UPDATE buy set `buy_cancle`= 'yes' where `buy_num`=$buy_num;";
    $result = mysqli_query($conn,$sql);

    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }
//정보수정
}else if(isset($_GET["mode"]) && $_GET["mode"] == "modify"){
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

  $q_phone1 = $_POST["phone1"];
  $q_phone2 = $_POST["phone2"];
  $q_phone3 = $_POST["phone3"];
  $q_address1 = $_POST["address1"];
  $q_address2 = $_POST["address2"];
  $q_address3 = $_POST["address3"];
  $q_email1 = $_POST["email1"];
  $q_email2 = $_POST["email2"];
  $q_phone=$q_phone1."-".$q_phone2."-".$q_phone3;
  $q_address=$q_address2."/".$q_address1."/".$q_address3;
  $q_email=$q_email1."@".$q_email2;

  $sql= "UPDATE membership SET name='$q_name', passwd='$q_passwd', phone='$q_phone', address='$q_address', email='$q_email'  where `id`='$q_id';";
  $result = mysqli_query($conn,$sql);

  if (!$result) {
    die('Error: ' . mysqli_error($conn));
  }
  echo "<script> location.href = './user_modify.php'</script>";
//장바구니 전체삭제
}else if(isset($_GET["mode"]) && $_GET["mode"] == "del_btn"){

  $cart_num =$_GET["cart_num"];

  $sql= "DELETE FROM cart where cart_num=$cart_num;";

  $result = mysqli_query($conn,$sql);

  if (!$result) {
    die('Error: ' . mysqli_error($conn));
  }
  echo "<script> location.href = './user_cart.php'</script>";
//장바구니 선택삭제
}else if(isset($_GET["mode"]) && $_GET["mode"] == "choice_del"){
  $cart_num =$_GET["cart_num"];
  $cart_num=explode(",", $cart_num);

  for($i=0; $i<count($cart_num); $i++){

    $sql= "DELETE FROM cart where cart_num=$cart_num[$i];";

    $result = mysqli_query($conn,$sql);

    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }
  }
  echo "<script> location.href = './user_cart.php'</script>";
}else if(isset($_GET["mode"]) && $_GET["mode"] == "agit_modal"){

 if (isset($_POST['agit_name'])) {
    $agit_name =$_POST["agit_name"];
  }

  $sql= "select * from agit where agit_name = '$agit_name'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($result);

  $agit_num=$row['agit_num'];
  $agit_address=$row['agit_address'];
  $agit_content=$row['agit_content'];
  $agit_content=htmlspecialchars_decode($agit_content);
  $agit_image_copied0=$row['agit_image_copied0'];
  $agit_image_copied1=$row['agit_image_copied1'];
  $agit_image_copied2=$row['agit_image_copied2'];
  $agit_image_copied3=$row['agit_image_copied3'];
  $agit_code=$row['agit_code'];

  $agit_content=preg_replace("/\s+/","***",$agit_content);

  echo '[{"agit_name":"'.$agit_name.'","agit_address":"'.$agit_address.'","agit_image_copied0":"'.$agit_image_copied0.'","agit_image_copied1":"'.$agit_image_copied1.'","agit_image_copied2":"'.$agit_image_copied2.'","agit_image_copied3":"'.$agit_image_copied3.'","agit_content":"'.$agit_content.'","agit_code":"'.$agit_code.'"}]';

}
