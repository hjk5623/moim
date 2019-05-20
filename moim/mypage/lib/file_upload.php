<?php
//1 업로드 파일의 5가지 정보를 갖고 와서 저장
if(isset($_FILES['user_image']['name'])){
  $user_image = $_FILES['user_image'];
  $user_image_name = $_FILES['user_image']['name'];//f03.jpg
  $user_image_type = $_FILES['user_image']['type'];//image/gif, file/txt
  $user_image_tmp_name = $_FILES['user_image']['tmp_name'];
  $user_image_error = $_FILES['user_image']['error'];
  $user_image_size = $_FILES['user_image']['size'];
  //2
  $image = explode(".", $user_image_name); // 파일명과 확장자를 구분
  $image_name = $image[0];              // 파일명
  $image_extension = $image[1];         // 확장자
  //3
  $upload_dir = "../data/"; // 업로드된 파일을 저장하는 장소 지정
  //4. 파일 업로드가 성공되었는지 점검
  //파일명이 중복되지 않도록 임의의 파일명 정의
  if(!$user_image_error){
    $new_image_name = date("Y_m_d_H_i_s"); //"2019_04_22_15_09_30"
    $new_image_name = $new_image_name."_"."0"; //"2019_04_22_15_09_30_0"
    $copied_image_name = $new_image_name.".".$image_extension; //"2019_04_22_15_09_30_0.jpg"
    $uploaded_image=$upload_dir.$copied_image_name; // "./data/2019_04_22_15_09_30_0.jpg"
  }
  //5. 업로드된 파일 확장자를 체크한다.
  $image_type = explode("/",$user_image_type);

  switch ($image_type[1]) {
    case 'gif': case 'jpg': case 'jpeg': case 'png': case 'pjpeg':
      break;
      default:
      alert_back('gif, jpeg, png, pjpeg 확장자만 가능합니다!');
      break;
    }

  //6. 업로드된 파일사이즈를(2MB) 체크해서 넘어버리면 돌려보낸다.
  if($user_image_size>2000000){
    alert_back('파일사이즈는 2MB를 초과할 수 없습니다.!');
  }
  //7. 임시 저장소에 있는 파일을 서버에 지정한 위치로 이동한다.
  if(!move_uploaded_file($user_image_tmp_name, $uploaded_image)){
    alert_back('서버 전송 에러!');
  }
}
if(isset($_FILES['user_file']['name'])){
  $user_file = $_FILES['user_file'];
  $user_file_name = $_FILES['user_file']['name'];//f03.jpg
  $user_file_type = $_FILES['user_file']['type'];//image/gif, file/txt
  $user_file_tmp_name = $_FILES['user_file']['tmp_name'];
  $user_file_error = $_FILES['user_file']['error'];
  $user_file_size = $_FILES['user_file']['size'];
  //2
  $file = explode(".", $user_file_name); // 파일명과 확장자를 구분
  $file_name = $file[0];              // 파일명
  $file_extension = $file[1];         // 확장자
  //3
  $upload_dir = "../data/"; // 업로드된 파일을 저장하는 장소 지정
  //4. 파일 업로드가 성공되었는지 점검
  //파일명이 중복되지 않도록 임의의 파일명 정의
  if(!$user_file_error){
    $new_file_name = date("Y_m_d_H_i_s"); //"2019_04_22_15_09_30"
    $new_file_name = $new_file_name."_"."0"; //"2019_04_22_15_09_30_0"
    $copied_file_name = $new_file_name.".".$file_extension; //"2019_04_22_15_09_30_0.jpg"
    $uploaded_file=$upload_dir.$copied_file_name; // "./data/2019_04_22_15_09_30_0.jpg"
  }
  //5. 업로드된 파일 확장자를 체크한다.
  $file_type = explode("/",$user_file_type);

  //5. 업로드된 파일사이즈를(2MB) 체크해서 넘어버리면 돌려보낸다.
  if($user_file_size>500000){
    alert_back('파일사이즈는 500KB를 초과할 수 없습니다.!');
  }

  if(!move_uploaded_file($user_file_tmp_name, $uploaded_file)){
    alert_back('서버 전송 에러!');
  }
}

 ?>
