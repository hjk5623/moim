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

    //$regist_day = date("Y-m-d (H:i)")??

    //파일 업로드 기능
    include "../lib/file_upload.php";

    //8. 파일의 실제명과 저장명을 각각 저장한다

    $sql= "INSERT INTO `user_club` VALUES (null, '$userid', '$user_name', '$user_content', '$user_category', '$user_to', '$user_rent_info', '$user_start', '$user_end', '$user_schedule', '$user_price', 'no','$user_image_name','$copied_image_name', '$user_file_name', '$copied_file_name', '$file_type[0]');";
    $result = mysqli_query($conn,$sql);

    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }

    mysqli_close($conn);

    echo "<script> location.href = './user_request.php'</script>";
}else if(isset($_GET["mode"]) && $_GET["mode"] == "apply_cancle"){
    $buy_num = $_POST["buy_num"];

    $sql= "SELECT `buy_club_num` from buy where `buy_num`=$buy_num;";
    $result = mysqli_query($conn,$sql);

    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }
    $row = mysqli_fetch_array($result);
    $buy_club_num = $row["buy_club_num"];

    $sql= "UPDATE club set `club_apply`= `club_apply`-1 where `club_num`=$buy_club_num;";
    $result = mysqli_query($conn,$sql);

    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }

    $sql= "DELETE FROM buy where `buy_num`=$buy_num";
    $result = mysqli_query($conn,$sql);

    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }


}
