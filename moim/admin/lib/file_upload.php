<?php
// 사진첨부 업로드과정
//1. $_FILES['upimage']로부터 5가지 배열명을 가져온다.
//한개의 파일 업로드 정보가(5가지 정보) 배열로 들어있다.
$upimage = $_FILES['upimage'];
$upimage_name = $_FILES['upimage']['name'];
$upimage_type = $_FILES['upimage']['type'];
$upimage_tmp_name = $_FILES['upimage']['tmp_name'];
$upimage_error = $_FILES['upimage']['error'];
$upimage_size = $_FILES['upimage']['size'];

//2. 파일명과 확장자를 구분해서 저장한다
$image_file = explode(".", $upimage_name);  //파일명과 확장자 구분에서
$image_file_name = $image_file[0];              //파일명
$image_file_extension = $image_file[1];        //확장자

//3.업로드된 이미지를 저장하는 장소(폴더) 지정
$upload_dir="../data/";


//4. 이미지 업로드가 성공되었는지 점검한다. __ 성공이면 0, 실패면 1
//성공되었으면 파일명이 중복되지 않도록 임의의 파일명을 정한다.
if(!$upimage_error){
  $new_image_name = date("Y_m_d_H_i_s");
  $new_image_name = $new_image_name."_"."0";
  $copied_image_name = $new_image_name.".".$image_file_extension;
  $uploaded_image = $upload_dir.$copied_image_name;
  // $new_file_name= "2019_04_22_15_09_30";
  // $new_file_name="2019_04_22_15_09_30_0";
  // $copied_file_name="2019_04_22_15_09_30_0.jpg";
  // $upload_file="./data/2019_04_22_15_09_30_0.jpg";
}
//5. 업로드된 파일사이즈(500kb)를  체크해서 크기가 넘어버리면 돌려보낸다.
if($upimage_size>2000000){
  alert_back('2.이미지사이즈가 2MB 이상입니다.');
}

//5.업로드된 파일 확장자 체크한다.
$type=explode("/",$upimage_type);

switch ($type[1]){
  case 'gif':   case 'jpg':  case 'png':
  case 'jpeg':  case 'pjpeg': break;
  default: alert_back('3.gif,jpg,png 이미지 파일만 업로드 가능합니다.');
  break;
}
//7. 임시저장소에 있는 파일을 서버에 지정한 위치로 이동시킨다.
if(!move_uploaded_file($upimage_tmp_name ,$uploaded_image)){
echo "<script>alert('이미지_서버전송오류');</script>";
}

/////////////////////////////////////////////////////////////////
//첨부파일 업로드과정

//1. $_FILES['upfile']로부터 5가지 배열명을 가져온다.
//한개의 파일 업로드 정보가(5가지 정보) 배열로 들어있다.
$upfile = $_FILES['upfile'];
$upfile_name = $_FILES['upfile']['name'];
$upfile_type = $_FILES['upfile']['type'];
$upfile_tmp_name = $_FILES['upfile']['tmp_name'];
$upfile_error = $_FILES['upfile']['error'];
$upfile_size = $_FILES['upfile']['size'];

//2. 파일명과 확장자를 구분해서 저장한다
$file = explode(".", $upfile_name);  //파일명과 확장자 구분에서
$file_name = $file[0];              //파일명
$file_extension = $file[1];        //확장자

//3.업로드된 파일을 저장하는 장소(폴더) 지정
$upload_dir="../data/";


//4. 파일 업로드가 성공되었는지 점검한다. __ 성공이면 0, 실패면 1
//성공되었으면 파일명이 중복되지 않도록 임의의 파일명을 정한다.
if(!$upfile_error){
  $new_file_name = date("Y_m_d_H_i_s");
  $new_file_name = $new_file_name."_"."0";
  $copied_file_name = $new_file_name.".".$file_extension;
  $uploaded_file = $upload_dir.$copied_file_name;
  // $new_file_name= "2019_04_22_15_09_30";
  // $new_file_name="2019_04_22_15_09_30_0";
  // $copied_file_name="2019_04_22_15_09_30_0.jpg";
  // $upload_file="./data/2019_04_22_15_09_30_0.jpg";
}
//5. 업로드된 파일사이즈(500kb)를  체크해서 크기가 넘어버리면 돌려보낸다.
if($upfile_size>2000000){
  alert_back('2.파일사이즈가 2MB 이상입니다.');
}

//5.업로드된 파일 확장자 체크한다.
$file_type=explode("/",$upfile_type);
//
// switch ($type[1]){
//   case 'gif':   case 'jpg':  case 'png':
//   case 'jpeg':  case 'pjpeg': break;
//   default: alert_back('3.gif,jpg,png 이미지 파일만 업로드 가능합니다.');
//   break;
// }
//7. 임시저장소에 있는 파일을 서버에 지정한 위치로 이동시킨다.
if(!move_uploaded_file($upfile_tmp_name ,$uploaded_file)){
echo "<script>alert('파일_서버전송오류');</script>";
}


?>
