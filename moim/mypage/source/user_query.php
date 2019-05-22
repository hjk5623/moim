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

    //$regist_day = date("Y-m-d (H:i)")??

    //파일 업로드 기능
    include "../lib/file_upload.php";

    //8. 파일의 실제명과 저장명을 각각 저장한다

    $sql= "INSERT INTO `user_club` VALUES (null, '$userid', '$user_name', '$user_content', '$user_category', '$user_to', '$user_rent_info', '$user_start', '$user_end', '$user_schedule', '$user_price', 'no','$user_image_name','$copied_image_name', '$user_file_name', '$copied_file_name', '$file_type[0]', '$user_intro');";

    $result = mysqli_query($conn,$sql);

    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }

    mysqli_close($conn);

    echo "<script> location.href = './user_request.php'</script>";
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
}else if(isset($_GET["mode"]) && $_GET["mode"] == "modify"){
  $id = $_POST["id"];
  $name = $_POST["name"];
  $passwd = $_POST["passwd"];
  $phone1 = $_POST["phone1"];
  $phone2 = $_POST["phone2"];
  $phone3 = $_POST["phone3"];
  $address1 = $_POST["address1"];
  $address2 = $_POST["address2"];
  $address3 = $_POST["address3"];
  $email1 = $_POST["email1"];
  $email2 = $_POST["email2"];
  $phone=$phone1."-".$phone2."-".$phone3;
  $address=$address2."/".$address1."/".$address3;
  $email=$email1."@".$email2;
  $sql= "UPDATE membership SET name='$name', passwd='$passwd', phone='$phone', address='$address', email='$email'  where `id`='$id';";
  $result = mysqli_query($conn,$sql);

  if (!$result) {
    die('Error: ' . mysqli_error($conn));
  }
  $row = mysqli_fetch_array($result);

  if (!$result) {
    die('Error: ' . mysqli_error($conn));
  }
  echo "<script> location.href = './user_modify.php'</script>";
}else if(isset($_GET["mode"]) && $_GET["mode"] == "del_btn"){

  $cart_num =$_GET["cart_num"];

  $sql= "DELETE FROM cart where cart_num=$cart_num;";

  $result = mysqli_query($conn,$sql);

  if (!$result) {
    die('Error: ' . mysqli_error($conn));
  }
  echo "<script> location.href = './user_cart.php'</script>";
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
}
