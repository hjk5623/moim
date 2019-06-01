<?php

  if(isset($_FILES['upfile']) && !empty($_FILES['upfile'])){
      $upfile = $_FILES['upfile'];//파일 1개의 업로드 정보 (->5가지 배열 요소)
      $upfile_name = $upfile['name'];
      $upfile_type = $upfile['type'];
      $upfile_tmp_name = $upfile['tmp_name'];
      $upfile_error = $upfile['error'];
      $upfile_size = $upfile['size'];

      $file = explode(".", $upfile_name);
      $file_name=$file[0];
      $file_extension=$file[1];

      //mkdir(data)
      $upload_dir="../data/"; //임의의 업로드된 파일을 저장하는 폴더 지정.

      //파일업로드가 성공되었는 지 점검  (성공 : 0 실패 : 1)
      //파일명 중복 방지
      if(!$upfile_error){
        $new_file_name=date("Y_m_d_H_i_s");
        $new_file_name.="_"."0";
        $copied_file_name=$new_file_name.".".$file_extension;
        $uploaded_file=$upload_dir.$copied_file_name;
      }
      //파일 이름 30자까지만 허용
      if(strlen($upfile_name)>30){
        alert_back('파일명은 30자이하로 허용됩니다.');
      }

      //파일 용량(2mb) 초과 시 방어 (php.ini 에 있는 용량제한)
      if($upfile_size>2000000){
        alert_back('2MB이하의 파일만 허용됩니다.');
      }

      //업로드된 파일 확장자를 체크 "image/jpg"
      // $type = explode("/", $upfile_type);
      $file_type = $upfile_type;
      // switch ($type[1]) {
      //   case 'gif':  case 'jpeg':  case 'png':  case 'jpg':  case 'pjpeg':
      //     break;
      //   default:  alert_back('gif jpeg png jpg pjpeg 파일만 허용됩니다.');
      //     break;
      // }

      //임시 저장소에 있는 파일을 서버에 지정한 위치로 이동
      if(!move_uploaded_file($upfile_tmp_name, $uploaded_file)){
        alert_back('서버 전송 에러');
      }
  }
 ?>
