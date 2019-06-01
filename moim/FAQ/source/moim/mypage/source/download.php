<?php
include $_SERVER['DOCUMENT_ROOT']."/moim/lib/session_call.php";
include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";

if(isset($_GET["mode"]) && $_GET["mode"] == "download"){
  $user_num = test_input($_GET["user_num"]);

  $sql="SELECT * from `user_club` where user_num ='$user_num';";

  $result = mysqli_query($conn,$sql);
  if (!$result) {
  alert_back('Error: 1' . mysqli_error($conn));
  // die('Error: ' . mysqli_error($conn));
}
  $row = mysqli_fetch_array($result);
  $user_check=$row['user_check'];
  $user_file_name=$row['user_file_name'];
  $user_file_copied=$row['user_file_copied'];
  $user_file_type=$row['user_file_type'];

  mysqli_close($conn);
}
//1. 테이블에 파일명이 있는지 점검
if(empty($user_file_copied) || $user_file_type =='image'){
  alert_back('테이블에 파일이 존재하지 않거나 이미지 파일입니다.');
}

if($user_check=="yes"){
  $file_path = "../../admin/data/$user_file_copied";
}else{
  $file_path = "../data/$user_file_copied";
}
//2. 서버에 data영역에 실제 파일이 있는지 점검

if(file_exists($file_path)){
  $fp = fopen($file_path, "rb"); //$fp 파일 핸들 값
//지정된 파일 타입일 경우
  if($user_file_type){
    Header("Content-type: application/x-msdownload");
    Header("Content-Length:".filesize($file_path));
    Header("Content-Disposition: attachment; filename=$user_file_name");
    Header("Content-Transfer-Encoding: binary");
    Header("Content-Description: File Transfer");
    Header("Expires: 0");
  }else{
    //알려진 타입이 아닐경우의 프로토콜(익스플로러 6.0이하일경우)
    if(eregi("(MSIE 5.0 | MSIE 5.1 | MSIE 5.5 | MSIE 6.0)", $_SERVER['HTTP_USER_AGENT'])){
      Header("Content-type: application/octet-stream");
      Header("Content-Length:".filesize($file_path));
      Header("Content-Disposition: attachment; filename=$user_file_name");
      Header("Content-Transfer-Encoding: binary");
      Header("Expires: 0");
    //알려진 타입이 아닐경우의 프로토콜
    }else{
      Header("Content-type: file/application/unknown");
      Header("Content-Length:".filesize($file_path));
      Header("Content-Disposition: attachment; filename=$user_file_name");
      Header("Content-Disposition: PHP3 Generated Data");
      Header("Expires: 0");
    }
  }
fpassthru($fp);
fclose($fp);
}else{
  alert_back('서버에 실제 파일이 존재하지 않습니다.');
}
?>
