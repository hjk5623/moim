<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/moim/lib/db_connector.php";

if(isset($_GET["no"])){
  $no= $_GET["no"];
}else{
  $no= "";
}

$mode= (isset($_GET["mode"])) ? $_GET["mode"] : "";
$name= (isset($_GET["name"]))? $_GET["name"] : "";
$c_ripple_num= (isset($_GET["c_ripple_num"]))? $_GET["c_ripple_num"] : "";
?>
<meta charset="utf-8">
<?php

$content= $q_content = $sql= $result = $userid="";
$userid = $_SESSION['userid'];
if(isset($_GET["mode"]) && $_GET["mode"] == "c_delete"){ // club_open= yes인 모임을 지운다
  $sql = "DELETE FROM `club` WHERE club_num='$no'";
  $result = mysqli_query($conn,$sql);
  if (!$result) {
    die('Error: ' . mysqli_error($conn));
  }
  echo "<script>location.href='ing_list.php';</script>";

}else if(isset($_GET["mode"]) && $_GET["mode"] == "c_insert_ripple"){ //후기 등록하기
  $c_ripple_content = test_input($_POST["c_ripple_content"]);
  if(empty($_POST["c_ripple_content"])){
    echo "<script>alert('내용입력요망!');history.go(-1);</script>";
    exit;
  }
  //로그인한 사람만 덧글 달기를 할 수 있음
  $q_userid = mysqli_real_escape_string($conn, $userid);
  $sql="select * from buy where buy_club_num='$no' and buy_id='$userid'";
  $result = mysqli_query($conn,$sql);
  if (!$result) {
    die('Error: ' . mysqli_error($conn));
  }
    $row= mysqli_fetch_array($result);
    $id= $row['buy_id'];
    $rowcount = mysqli_num_rows($result);


    if(!$rowcount){
      echo "<script>alert('강의를 구매자만 후기작성이 가능합니다.');history.go(-1);</script>";
      exit;
    }else{
      $sql= "SELECT name FROM membership where id='$id'";
      $result = mysqli_query($conn,$sql);
      $row= mysqli_fetch_array($result);
      $name= $row['name'];

      $c_parent_num= test_input($no);
      $c_ripple_name= test_input($name);
      $c_ripple_content= test_input($_POST["c_ripple_content"]);
      $q_c_ripple_content= mysqli_real_escape_string($conn, $c_ripple_content);
      $c_ripple_date= date("Y-m-d (H:i)");

      $sql="INSERT INTO `club_ripple` VALUES (null,'$c_parent_num','$c_ripple_name','$q_c_ripple_content','$c_ripple_date')";
      $result = mysqli_query($conn,$sql);
      if (!$result) {
        die('Error: ' . mysqli_error($conn));
      }
      mysqli_close($conn);
      echo "<script>location.href='ing_view.php?no=$no';</script>'";

    }//end of if rowcount
}else if(isset($_GET["mode"]) && $_GET["mode"] == "c_delete_ripple"){ //후기 지우기
  $name = test_input($_GET["name"]);
  $c_ripple_num = test_input($_GET["c_ripple_num"]);

  $sql = "DELETE FROM `club_ripple` WHERE c_ripple_num='$c_ripple_num'";
  $result = mysqli_query($conn,$sql);
  if (!$result) {
    die('Error: ' . mysqli_error($conn));
  }
  echo "<script>location.href='ing_view.php?no=$no';</script>";
}
 ?>