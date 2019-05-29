<?php
include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";
include $_SERVER['DOCUMENT_ROOT']."/moim/lib/create_table.php";


create_table($conn,'club');
create_table($conn,'agit');

//모임등록
if(isset($_GET["mode"]) && $_GET["mode"] == "clubinsert"){
  if(empty($_POST["club_name"])){
   echo "<script>alert('모임이름을 입력해주세요.'); history.go(-1);</script>";
   return;
 }else if(empty($_POST["club_to"]) || $_POST["club_to"] <0 ){
    echo "<script>alert('모임정원을 올바르게 입력해주세요.'); history.go(-1);</script>";
    return;
 }else if(empty($_POST["club_start"])){
   echo "<script>alert('모집시작일을 지정해주세요.');history.go(-1);</script>";
   return;
 }else if(empty($_POST["club_end"])){
   echo "<script>alert('모집종료일을 지정해주세요.'); history.go(-1);</script>";
   return;
 }else if(empty($_POST["club_price"])){
   echo "<script>alert('모임가격을 입력해주세요.'); history.go(-1);</script>";
   return;
 }else if(empty($_POST["club_schedule"])){
   echo "<script>alert('모임일정을 입력해주세요.'); history.go(-1);</script>";
   return;
 }else if(empty($_POST["club_category"])){
   echo "<script>alert('카테고리를 입력해주세요.'); history.go(-1);</script>";
   return;
 }else if(empty($_POST["club_rent_info1"]) || empty($_POST["club_rent_info2"]) ){
   echo "<script>alert('장소를 입력해주세요. 상세주소까지 입력해주세요.'); history.go(-1);</script>";
   return;
 }
 $club_name= test_input($_POST["club_name"]);                   //모임명
 $content=test_input($_POST["content"]);                       //모임내용
 $club_category=test_input($_POST["club_category"]);          //모임카테고리
 $club_price= test_input($_POST["club_price"]);               //모임 가격
 $club_to= test_input($_POST["club_to"]);                    //모집정원
 $club_intro= test_input($_POST["club_intro"]);                    //모집정원

 $club_rent_info1= test_input($_POST["club_rent_info1"]);      //모임장소(대관관련)
 $club_rent_info2= test_input($_POST["club_rent_info2"]);      //모임장소(대관관련)
 $club_rent_info=  $club_rent_info1."/".$club_rent_info2;  //모임장소(대관관련)


 $club_start= test_input($_POST["club_start"]);              //모집시작일  예)2019-05-17
 $club_end= test_input($_POST["club_end"]);         //모집종료일 예)2019-05-20
 $club_schedule= test_input($_POST["club_schedule"]); // 모임일정

 include $_SERVER['DOCUMENT_ROOT']."/moim/admin/lib/file_upload.php";

 $sql="INSERT INTO `club` VALUES (null,'$club_name','$content','$club_category','$club_price','$club_to','$club_rent_info','$club_start','$club_end',0,'$club_schedule',0,'no','$upimage_name','$copied_image_name','$upfile_name','$copied_file_name','$file_extension','$club_intro');";
 $result = mysqli_query($conn,$sql);
 if (!$result) {
   alert_back('Error: ' . mysqli_error($conn));
 }

 $sql="SELECT club_num from `club` order by club_num desc limit 1;";
   $result = mysqli_query($conn,$sql);
   if (!$result) {
     die('Error: ' . mysqli_error($conn));
   }
   $row=mysqli_fetch_array($result);
   $club_num = $row['club_num'];

  echo "<script> location.href='./admin_club_create_view.php?club_num=$club_num'; </script>";
}


//모임개설
if(isset($_GET["mode"]) && $_GET["mode"] == "clubaccept"){
  $club_num = test_input($_GET['club_num']);
  $q_club_num= mysqli_real_escape_string($conn,$club_num);
  $sql="UPDATE club set club_open='yes' where club_num='$q_club_num'";
  $result=mysqli_query($conn, $sql);
  if (!$result) {
    die('Error: ' . mysqli_error($conn));
  }
  echo "<script> location.href='./admin_club_accept.php'; </script>";
}



//모임삭제
if(isset($_GET["mode"]) && $_GET["mode"] == "clubdelete"){
  $club_num = test_input($_GET['club_num']);
  $q_club_num= mysqli_real_escape_string($conn,$club_num);     //삭제할때는 sql injection 을 반드시 방어해라~!

  //삭제할 게시물의 이미지파일명을 가져와서 삭제한다.
  $sql="SELECT `club_image_copied` from `club` where club_num='$q_club_num';";
  $result = mysqli_query($conn,$sql);
  if (!$result) {
    alert_back('Error: ' . mysqli_error($conn));
  }
  $row=mysqli_fetch_array($result);
  $club_image_copied = $row['club_image_copied'];

  if(!empty($club_image_copied)){ //이미지파일인지 아닌지 확인할 필요가 없음. db 에 $file_copied_0 가 있으면 그걸 지우면 되므로
    unlink("../data/".$club_image_copied);
  }

  //삭제할 게시물의 첨부파일명을 가져와서 삭제한다.
  $sql="SELECT `club_file_copied` from `club` where club_num='$q_club_num';";
  $result = mysqli_query($conn,$sql);
  if (!$result) {
    alert_back('Error: ' . mysqli_error($conn));
  }
  $row=mysqli_fetch_array($result);
  $club_file_copied = $row['club_file_copied'];

  if(!empty($club_file_copied)){ //이미지파일인지 아닌지 확인할 필요가 없음. db 에 $file_copied_0 가 있으면 그걸 지우면 되므로
    unlink("../data/".$club_file_copied);
  }

  $sql="DELETE from `club` where club_num='$q_club_num'";
  $result=mysqli_query($conn, $sql);
  if (!$result) {
    die('Error: ' . mysqli_error($conn));
  }


}

//회원삭제
if(isset($_GET["mode"]) && $_GET["mode"] == "memberdel"){
  $id=test_input($_POST['user_id']);
  // var_export($id);
  $sql="DELETE from `membership` where id='$id' ";
  $result=mysqli_query($conn, $sql);
  if (!$result) {
    alert_back('Error: ' . mysqli_error($conn));
  }

}

//모임수정

if(isset($_GET["mode"]) && $_GET["mode"] == "update"){

    if(empty($_POST["club_name"])){
     echo "<script>alert('모임이름을 입력해주세요.'); history.go(-1);</script>";
     return;
   }else if(empty($_POST["club_to"]) || $_POST["club_to"] <0 ){
      echo "<script>alert('모임정원을 올바르게 입력해주세요.'); history.go(-1);</script>";
      return;
   }else if(empty($_POST["club_start"])){
     echo "<script>alert('모집시작일을 지정해주세요.');history.go(-1);</script>";
     return;
   }else if(empty($_POST["club_end"])){
     echo "<script>alert('모집종료일을 지정해주세요.'); history.go(-1);</script>";
     return;
   }else if(empty($_POST["club_price"])){
     echo "<script>alert('모임가격을 입력해주세요.'); history.go(-1);</script>";
     return;
   }else if(empty($_POST["club_schedule"])){
     echo "<script>alert('모임일정을 입력해주세요.'); history.go(-1);</script>";
     return;
   }else if($_POST["club_category"] =="선택"){
     echo "<script>alert('카테고리를 입력해주세요.'); history.go(-1);</script>";
     return;
   }else if(empty($_POST["club_rent_info1"]) || empty($_POST["club_rent_info2"]) ){
     echo "<script>alert('장소를 입력해주세요. 상세주소까지 입력해주세요.'); history.go(-1);</script>";
     return;
   }
     $club_num = $_POST["club_num"];

     $club_name = test_input($_POST["club_name"]);                   //모임명
     $content = test_input($_POST["content"]);                       //모임내용
     $club_category = test_input($_POST["club_category"]);          //모임카테고리
     $club_price = test_input($_POST["club_price"]);               //모임 가격
     $club_to= test_input($_POST["club_to"]);                    //모집정원
     $club_intro= test_input($_POST["club_intro"]);                    //모집정원

     $club_rent_info1= test_input($_POST["club_rent_info1"]);      //모임장소(대관관련)
     $club_rent_info2= test_input($_POST["club_rent_info2"]);      //모임장소(대관관련)
     $club_rent_info=  $club_rent_info1."/".$club_rent_info2;  //모임장소(대관관련)


     $club_start= test_input($_POST["club_start"]);              //모집시작일  예)2019-05-17
     $club_end= test_input($_POST["club_end"]);         //모집종료일 예)2019-05-20
     $club_schedule= test_input($_POST["club_schedule"]); // 모임일정

     /////////////////////파일 이미지 수정 처리 ////////////////////////////////////
     include $_SERVER['DOCUMENT_ROOT']."/moim/admin/lib/file_upload.php";

     //기존의 이미지를 삭제하는 경우
     if(isset($_POST['del_img']) && $_POST['del_img']=='1'){
       $sql="SELECT `club_image_copied` from `club` where club_num='$club_num';";
       $result = mysqli_query($conn,$sql);
      if (!$result) {
        alert_back('Error: ' . mysqli_error($conn));
      }
      $row=mysqli_fetch_array($result);
      $club_image_copied = $row['club_image_copied'];
      if(!empty($club_image_copied)){
        unlink("../data/".$club_image_copied);
      }
      $sql="UPDATE `club` SET  `club_image_name`='', `club_image_copied`='' WHERE `club_num` ='$club_num';";
      $result = mysqli_query($conn,$sql);
      if (!$result) {
        alert_back('Error: ' . mysqli_error($conn));
      }
     }
     //내용을 수정하든 안하든 이미지첨부을 첨부하면__이미지가 업로드가 되었느냐, 안되었느냐만 체크
    if(!empty($_FILES['upimage']['name'])){
      //파일업로드기능 include

      $sql="UPDATE `club` SET  `club_image_name` = '$upimage_name', `club_image_copied` = '$copied_image_name'  WHERE `club_num` =$club_num;";
      $result = mysqli_query($conn,$sql);
      if (!$result) {
        die('Error: ' . mysqli_error($conn));
      }
    }

    //기존의 파일을 삭제하고 새로 등록하는 경우
    if(isset($_POST['del_file']) && $_POST['del_file']=='1'){
      $sql="SELECT `club_file_copied` from `club` where club_num='$club_num';";
      $result = mysqli_query($conn,$sql);
     if (!$result) {
       alert_back('Error: ' . mysqli_error($conn));
     }
     $row=mysqli_fetch_array($result);
     $club_file_copied = $row['club_file_copied'];
     if(!empty($club_file_copied)){
       unlink("../data/".$club_file_copied);
     }
     $sql="UPDATE `club` SET  `club_file_name`='', `club_file_copied`='', `club_file_type`=''  WHERE `club_num` ='$club_num';";
     $result = mysqli_query($conn,$sql);
     if (!$result) {
       alert_back('Error: ' . mysqli_error($conn));
     }
    }

    //내용을 수정하든 안하든 이미지첨부을 첨부하면__이미지가 업로드가 되었느냐, 안되었느냐만 체크
   if(!empty($_FILES['upfile']['name'])){

     $sql="UPDATE `club` SET  `club_file_name` = '$upfile_name', `club_file_copied` = '$copied_file_name', `club_file_type`='$file_extension'   WHERE `club_num` =$club_num;";
     $result = mysqli_query($conn,$sql);
     if (!$result) {
       die('Error: ' . mysqli_error($conn));
     }
   }
   //파일과 상관없이 내용이나 제목등을 바꾸려면
  $sql="UPDATE `club` SET `club_name`='$club_name', `club_content`='$content',
           `club_category`='$club_category',`club_price` = '$club_price',
            `club_to`='$club_to',`club_rent_info` = '$club_rent_info',
             `club_start`='$club_start',`club_end` = '$club_end',
             `club_schedule` = '$club_schedule',`club_intro`='$club_intro'
            WHERE `club_num` =$club_num;";
  $result = mysqli_query($conn,$sql);
      if (!$result) {
        die('Error: ' . mysqli_error($conn));
      }
    // mysqli_close($conn);
    echo "<script> location.href='./admin_club_create_view.php?club_num=$club_num'; </script>"; //자기가 쓴 글 페이지로 보여준다.(수정내용)

}

//환불관련  -----
if(isset($_GET["mode"]) && $_GET["mode"] == "refund_update"){
  $buy_id = $_POST['buy_id'];
  $buy_club_num = $_POST['buy_club_num'];
  $refund_ok_date = date("Y-m-d");  // 환불처리날짜를 현재날짜로(관리자가 환불을 처리한 시점)

  $sql="UPDATE `buy` SET `buy_refund`='yes', `buy_process_date`='$refund_ok_date' WHERE `buy_club_num` ='$buy_club_num' and `buy_id`= '$buy_id' ";
  $result = mysqli_query($conn,$sql);
      if (!$result) {
        die('Error: ' . mysqli_error($conn));
  }
  echo "<script> location.href='./admin_refund.php'; </script>";
}

//신청모임등록//****************************************************************************************************/
if(isset($_GET["mode"]) && $_GET["mode"] == "request_create"){
    include $_SERVER['DOCUMENT_ROOT']."/moim/admin/lib/file_upload.php";
    // $user_num = $_GET["user_num"];

    if(empty($_POST["club_name"])){
     echo "<script>alert('모임이름을 입력해주세요.'); history.go(-1);</script>";
     return;
   }else if(empty($_POST["club_to"]) || $_POST["club_to"] <0 ){
      echo "<script>alert('모임정원을 올바르게 입력해주세요.'); history.go(-1);</script>";
      return;
   }else if(empty($_POST["club_start"])){
     echo "<script>alert('모집시작일을 지정해주세요.');history.go(-1);</script>";
     return;
   }else if(empty($_POST["club_end"])){
     echo "<script>alert('모집종료일을 지정해주세요.'); history.go(-1);</script>";
     return;
   }else if(empty($_POST["club_price"])){
     echo "<script>alert('모임가격을 입력해주세요.'); history.go(-1);</script>";
     return;
   }else if(empty($_POST["club_schedule"])){
     echo "<script>alert('모임일정을 입력해주세요.'); history.go(-1);</script>";
     return;
   }else if($_POST["club_category"] =="선택"){
     echo "<script>alert('카테고리를 입력해주세요.'); history.go(-1);</script>";
     return;
   }else if(empty($_POST["club_rent_info1"]) || empty($_POST["club_rent_info2"]) ){
     echo "<script>alert('장소를 입력해주세요. 상세주소까지 입력해주세요.'); history.go(-1);</script>";
     return;
   }

     $club_name = test_input($_POST["club_name"]);                   //모임명
     $content = test_input($_POST["content"]);                       //모임내용
     $club_category = test_input($_POST["club_category"]);          //모임카테고리
     $club_price = test_input($_POST["club_price"]);               //모임 가격
     $club_to= test_input($_POST["club_to"]);                    //모집정원
     $club_intro= test_input($_POST["club_intro"]);                    //모집정원

     $club_rent_info1= test_input($_POST["club_rent_info1"]);      //모임장소(대관관련)
     $club_rent_info2= test_input($_POST["club_rent_info2"]);      //모임장소(대관관련)
     $club_rent_info=  $club_rent_info1."/".$club_rent_info2;  //모임장소(대관관련)


     $club_start= test_input($_POST["club_start"]);              //모집시작일  예)2019-05-17
     $club_end= test_input($_POST["club_end"]);         //모집종료일 예)2019-05-20
     $club_schedule= test_input($_POST["club_schedule"]); // 모임일정 19-05-05 , 19-06-06

     /////////////////////파일 이미지 수정 처리 ////////////////////////////////////


     //기존의 이미지를 삭제하는 경우
     if(isset($_POST['del_img']) && $_POST['del_img']=='1'){
     $sql="SELECT `user_image_copied` from `user_club` where user_num='$user_num';";
     $result = mysqli_query($conn,$sql);
      if (!$result) {
        alert_back('8Error: ' . mysqli_error($conn));
      }
      $row=mysqli_fetch_array($result);
      $user_image_copied = $row['user_image_copied'];
      if(!empty($user_image_copied)){
        unlink("../../mypage/data/".$user_image_copied);
      }
      $sql="UPDATE `user_club` SET  `user_image_name`='', `user_image_copied`='' WHERE `user_num` ='$user_num';";
      $result = mysqli_query($conn,$sql);
      if (!$result) {
        alert_back('7Error: ' . mysqli_error($conn));
      }
     }
     //내용을 수정하든 안하든 이미지첨부을 첨부하면__이미지가 업로드가 되었느냐, 안되었느냐만 체크
    if(!empty($_FILES['upimage']['name'])){
      //파일업로드기능 include

      $sql="UPDATE `user_club` SET  `user_image_name` = '$upimage_name', `user_image_copied` = '$copied_image_name'  WHERE `user_num` ='$user_num';";
      $result = mysqli_query($conn,$sql);
      if (!$result) {
        die('6Error: ' . mysqli_error($conn));
      }
    }

    //기존의 파일을 삭제하고 새로 등록하는 경우
    if(isset($_POST['del_file']) && $_POST['del_file']=='1'){
      $sql="SELECT `user_file_copied` from `user_club` where user_num='$user_num';";
      $result = mysqli_query($conn,$sql);
     if (!$result) {
       alert_back('5Error: ' . mysqli_error($conn));
     }
     $row=mysqli_fetch_array($result);
     $user_file_copied = $row['user_file_copied'];
     if(!empty($club_file_copied)){
       unlink("../../mypage/data/".$club_file_copied);
     }
     $sql="UPDATE `user_club` SET  `user_file_name`='', `user_file_copied`='', `user_file_type`=''  WHERE `user_num` ='$user_num';";
     $result = mysqli_query($conn,$sql);
     if (!$result) {
       alert_back('4Error: ' . mysqli_error($conn));
     }
    }

    //내용을 수정하든 안하든 파일첨부을 첨부하면__이미지가 업로드가 되었느냐, 안되었느냐만 체크
   if(!empty($_FILES['upfile']['name'])){
     $sql="UPDATE `user_club` SET  `user_file_name` = '$upfile_name', `user_file_copied` = '$copied_file_name', `user_file_type`='$file_extension'   WHERE `user_num`='$user_num';";
     $result = mysqli_query($conn,$sql);
     if (!$result) {
       die('3Error: ' . mysqli_error($conn));
     }
    }


   $sql="INSERT INTO `club` VALUES (null,'$club_name','$content','$club_category','$club_price','$club_to','$club_rent_info','$club_start','$club_end',0,'$club_schedule',0,'no','$upimage_name','$copied_image_name','$upfile_name','$copied_file_name','$file_extension','$club_intro');";
   $result = mysqli_query($conn,$sql);
   if (!$result) {
     alert_back('2Error: ' . mysqli_error($conn));
   }


   $sql="UPDATE `user_club` SET  `user_check`='yes' WHERE `user_num` ='$user_num';";
   $result = mysqli_query($conn,$sql);
   if (!$result) {
     alert_back('1Error: ' . mysqli_error($conn));
   }


   $sql="SELECT club_num from `club` order by club_num desc limit 1;";
     $result = mysqli_query($conn,$sql);
     if (!$result) {
       die('Error: ' . mysqli_error($conn));
     }
     $row=mysqli_fetch_array($result);
     $club_num = $row['club_num'];

  // mysqli_close($conn);
  echo "<script> location.href='./admin_club_create_view.php?club_num=$club_num'; </script>";
}

//신청모임 승인 거절//****************************************************************************************************/

if(isset($_GET["mode"]) && $_GET["mode"] == "request_disapprove"){
  $user_num=$_GET['user_num'];

  $sql="UPDATE `user_club` SET  `user_check`='yes' WHERE `user_num` ='$user_num';";
  $result = mysqli_query($conn,$sql);
  if (!$result) {
    alert_back('4Error: ' . mysqli_error($conn));
  }
  echo "<script> location.href='./admin_request_list.php'; </script>";

}


//아지트등록
if(isset($_GET["mode"]) && $_GET["mode"] == "agit_create"){
  if(empty($_POST["agit_name"])){
     echo "<script>alert('모임이름을 입력해주세요.'); history.go(-1);</script>";
     return;
   }else if(empty($_POST["agit_rent_info1"]) || empty($_POST["agit_rent_info2"]) ){
     echo "<script>alert('장소를 입력해주세요. 상세주소까지 입력해주세요.'); history.go(-1);</script>";
     return;
   }
   $agit_name= test_input($_POST["agit_name"]);   //모임명
   $content=test_input($_POST["content"]);        //모임내용
   $agit_code=test_input($_POST["agit_code"]);    //아지트코드


   $agit_rent_info1= test_input($_POST["agit_rent_info1"]);      //모임장소(대관관련)
   $agit_rent_info2= test_input($_POST["agit_rent_info2"]);      //모임장소(대관관련)
   $agit_rent_info=  $agit_rent_info1."/".$agit_rent_info2;  //모임장소(대관관련)


     $files = $_FILES["upfile"];
     $count = count($files["name"]);

     $upload_dir = '../data/';
     for ($i = 0; $i < $count; $i ++) {
       $upfile_name[$i] = $files["name"][$i];//실제 파일명
       $upfile_tmp_name[$i] = $files["tmp_name"][$i];//서버에 임시 저장될 파일명.
       $upfile_type[$i] = $files["type"][$i];//파일 형식
       $upfile_size[$i] = $files["size"][$i];//파일 크기
       $upfile_error[$i] = $files["error"][$i];//에러 발생확인


       // var_dump($upfile_name[$i]);



       $file = explode(".",$upfile_name[$i]);
       $file_name = $file[0];
       $file_ext  = $file[1];

       //파일값이 비어있으면 에러입니다. 비어있을시 실행을 안하는 것.
       if(!$upfile_error[$i]){
         $new_file_name = date("Y_m_d_H_i_s");//날짜
         $new_file_name = $new_file_name."_".$i;//날짜_i
         $copied_file_name[$i] = $new_file_name.".".$file_ext;//날짜_i.확장자명.
         $uploaded_file[$i] = $upload_dir.$copied_file_name[$i];//.data/날짜_i.확장자명.
         if($upfile_size[$i]  > 5000000 ) {//size가 500KB초과일시.
           echo("<script>alert('업로드 파일 크기가 지정된 용량(500KB)을 초과합니다!<br>파일 크기를 체크해주세요! '); history.go(-1) </script>");
           exit;
         }
         if (($upfile_type[$i] != "image/gif") && ($upfile_type[$i] != "image/jpeg") && ($upfile_type[$i] != "image/pjpeg") && ($upfile_type[$i] != "image/png")){
           echo("<script> alert('JPG와 GIF 이미지 파일만 업로드 가능합니다!'); history.go(-1)</script> ");
           exit;
         }
         if (!move_uploaded_file($upfile_tmp_name[$i],$uploaded_file[$i])){//1번째 인자(임시파일)를 2번째 인자에 넣겠다.
           echo("<script>alert('파일을 지정한 디렉토리에 복사하는데 실패했습니다.');</script>");
           exit;
         }
       }
     }

      $sql="INSERT INTO `agit` VALUES (null,'$agit_name','$agit_rent_info','$upfile_name[0]','$upfile_name[1]','$upfile_name[2]','$upfile_name[3]','$copied_file_name[0]','$copied_file_name[1]','$copied_file_name[2]','$copied_file_name[3]','$content','$agit_code');";
      $result = mysqli_query($conn,$sql);
      if (!$result) {
        alert_back('1Error: ' . mysqli_error($conn));
      }

      echo "<script> location.href='./admin_agit_list.php'; </script>";


}

// 아지트 삭제
if(isset($_GET["mode"]) && $_GET["mode"] == "agit_delete"){
  $agit_num=$_POST['agit_num'];
  //삭제할 게시물의 이미지파일명을 가져와서 삭제한다.
  $sql="SELECT `agit_image_copied0`,`agit_image_copied1`,`agit_image_copied2`,`agit_image_copied3` from `agit` where agit_num='$agit_num';";
  $result = mysqli_query($conn,$sql);
  if (!$result) {
    alert_back('Error: ' . mysqli_error($conn));
  }
  $row=mysqli_fetch_array($result);
  $agit_image_copied0 = $row['agit_image_copied0'];
  $agit_image_copied1 = $row['agit_image_copied1'];
  $agit_image_copied2 = $row['agit_image_copied2'];
  $agit_image_copied3 = $row['agit_image_copied3'];

  if(!empty($agit_image_copied0)){
    unlink("../data/".$agit_image_copied0);
    unlink("../data/".$agit_image_copied1);
    unlink("../data/".$agit_image_copied2);
    unlink("../data/".$agit_image_copied3);
  }
  $sql="DELETE from `agit` where agit_num='$agit_num'";
  $result=mysqli_query($conn, $sql);
  if (!$result) {
    die('Error: ' . mysqli_error($conn));
  }



}



//아지트 modal
if(isset($_GET["mode"]) && $_GET["mode"] == "agit_modal"){

  if(isset($_POST["hidden_agit"])){
  $hidden_agit = $_POST["hidden_agit"];
  }else{
    $hidden_agit="";
  }

$sql = "SELECT * from `agit` where agit_num = '$hidden_agit';";
$result = mysqli_query($conn,$sql);

if (!$result) {
  die('Error: ' . mysqli_error($conn));
}

$row=mysqli_fetch_array($result);
$agit_name = $row['agit_name'];
$agit_content = $row['agit_content'];
$agit_content=htmlspecialchars_decode($agit_content);
$agit_address = $row['agit_address'];
$agit_content=preg_replace("/\s+/","***",$agit_content);

$agit_image_copied0= $row['agit_image_copied0'];
$agit_image_copied1= $row['agit_image_copied1'];
$agit_image_copied2= $row['agit_image_copied2'];
$agit_image_copied3= $row['agit_image_copied3'];


echo '[{"agit_name":"'.$agit_name.'"},{"agit_content":"'.$agit_content.'"},{"agit_address":"'.$agit_address.'"},{"agit_image_copied0":"'.$agit_image_copied0.'"},{"agit_image_copied1":"'.$agit_image_copied1.'"},{"agit_image_copied2":"'.$agit_image_copied2.'"},{"agit_image_copied3":"'.$agit_image_copied3.'"}]';

}

mysqli_close($conn);




 ?>
