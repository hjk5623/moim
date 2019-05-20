<?php
include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";
include $_SERVER['DOCUMENT_ROOT']."/moim/lib/create_table.php";

create_table($conn,'club');

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

 $club_rent_info1= test_input($_POST["club_rent_info1"]);      //모임장소(대관관련)
 $club_rent_info2= test_input($_POST["club_rent_info2"]);      //모임장소(대관관련)
 $club_rent_info=  $club_rent_info1."/".$club_rent_info2;  //모임장소(대관관련)


 $club_start= test_input($_POST["club_start"]);              //모집시작일  예)2019-05-17
 $club_end= test_input($_POST["club_end"]);         //모집종료일 예)2019-05-20
 $club_schedule= test_input($_POST["club_schedule"]); // 모임일정


 include $_SERVER['DOCUMENT_ROOT']."/moim/admin/lib/file_upload.php";

 // var_export($file_extension);
   $sql="INSERT INTO `club` VALUES (null,'$club_name','$content','$club_category','$club_price','$club_to','$club_rent_info','$club_start','$club_end',0,'$club_schedule',0,'no','$upimage_name','$copied_image_name','$upfile_name','$copied_file_name','$file_extension');";
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

  // mysqli_close($conn);
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
  $sql="SELECT `club_image_copyied` from `club` where club_num='$q_club_num';";
  $result = mysqli_query($conn,$sql);
  if (!$result) {
    alert_back('Error: ' . mysqli_error($conn));
  }
  $row=mysqli_fetch_array($result);
  $club_image_copyied = $row['club_image_copyied'];

  if(!empty($club_image_copyied)){ //이미지파일인지 아닌지 확인할 필요가 없음. db 에 $file_copied_0 가 있으면 그걸 지우면 되므로
    unlink("../data/".$club_image_copyied);
  }

  //삭제할 게시물의 첨부파일명을 가져와서 삭제한다.
  $sql="SELECT `club_file_copyied` from `club` where club_num='$q_club_num';";
  $result = mysqli_query($conn,$sql);
  if (!$result) {
    alert_back('Error: ' . mysqli_error($conn));
  }
  $row=mysqli_fetch_array($result);
  $club_file_copyied = $row['club_file_copyied'];

  if(!empty($club_file_copyied)){ //이미지파일인지 아닌지 확인할 필요가 없음. db 에 $file_copied_0 가 있으면 그걸 지우면 되므로
    unlink("../data/".$club_file_copyied);
  }

  $sql="DELETE from `club` where club_num='$q_club_num'";
  $result=mysqli_query($conn, $sql);
  if (!$result) {
    die('Error: ' . mysqli_error($conn));
  }

  echo "<script> location.href='./admin_club_accept.php'; </script>";

}

//회원삭제
if(isset($_GET["mode"]) && $_GET["mode"] == "memberdel"){
  $id=test_input($_POST['id']);
  var_export($id);
  $sql="DELETE from `membership` where id='$id' ";
  $result=mysqli_query($conn, $sql);
  if (!$result) {
    alert_back('Error: ' . mysqli_error($conn));
  echo "<script> alert('회원탈퇴 완료');
          location.href='admin_member.php';
        </script>
        ";
  }
}


 ?>
