<?php session_start();
include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";

// $result = mysqli_query($conn, $sql) or die('Error: ' . mysqli_error($conn));
if(isset($_GET["mode"]) && $_GET["mode"]=="find_id"){
  $name = test_input($_POST["name"]);
  $phone = test_input($_POST["phone"]);

  $sql="SELECT id FROM `membership` where name='$name' and phone='$phone'";
  $result = mysqli_query($conn,$sql);
  if (!$result) {
    die('Error: ' . mysqli_error($conn));
  }
  $row = mysqli_fetch_array($result);
  $rowcount=mysqli_num_rows($result);
  if(!$rowcount){
    $s = '[{"id":"실패"}]';
  }else{
    $s = '[{"id":"'.$row["id"].'"}]';
  }
  echo $s;
}else if(isset($_GET["mode"]) && $_GET["mode"]=="kakao_check"){
  $kakao_id = test_input($_POST["kakao_id"]);
  $sql="SELECT id,name FROM `membership` where `kakao_id`='$kakao_id';";

  $result = mysqli_query($conn,$sql);
  if (!$result) {
    die('Error: ' . mysqli_error($conn));
  }
  $rowcount=mysqli_num_rows($result);
  if(!$rowcount){
    $s = '[{"kakao_id":"실패"}]';
  }else{
    $row = mysqli_fetch_array($result);
    $_SESSION['userid']=$row['id'];
    $_SESSION['username']=$row['name'];
    $s = '[{"kakao_id":"성공"}]';
  }
  echo $s;
}else if(!(isset($_POST["id"]) && isset($_POST["passwd"])) || (empty($_POST["id"]) || empty($_POST["passwd"]))){
    $s = '[{"id":"존재하지 않는 아이디입니다."}]';
    mysqli_close($conn);
}else{
  $id = test_input($_POST["id"]);
  $passwd = test_input($_POST["passwd"]);

  $q_id = mysqli_real_escape_string($conn, $id);
  $q_passwd = mysqli_real_escape_string($conn, $passwd);

  $sql="SELECT * FROM `membership` where id='$q_id'";
  $result = mysqli_query($conn,$sql);
  if (!$result) {
    die('Error: ' . mysqli_error($conn));
  }
  $rowcount=mysqli_num_rows($result);
  if(!$rowcount){
    $s = '[{"id":"존재하지 않는 아이디입니다."}]';
  }else{
    $sql="SELECT * FROM `membership` where id='$q_id' AND passwd='$q_passwd'";

    $result = mysqli_query($conn,$sql);

    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }

    $rowcount=mysqli_num_rows($result);

    if(!$rowcount){
      $s = '[{"id":"패스워드가 일치하지 않습니다."}]';
    }else{
      $row = mysqli_fetch_array($result);
      $_SESSION['userid']=$row['id'];
      $_SESSION['username']=$row['name'];
      $s = '[{"id":"성공"}]';
    }
  }
  echo $s;
}
mysqli_close($conn);

?>
