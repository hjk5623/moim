<?php session_start();
include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";

$result = mysqli_query($conn, $sql) or die('Error: ' . mysqli_error($conn));

if(!(isset($_POST["id"]) && isset($_POST["passwd"])) || (empty($_POST["id"]) || empty($_POST["passwd"]))){
    echo "<script>alert('id와 pass 모두 입력해주세요.');history.go(-1);</script>";
    mysqli_close($conn);
    exit;
  }else{
    $id = test_input($_POST["id"]);
    $passwd = test_input($_POST["passwd"]);

    $q_id = mysqli_real_escape_string($conn, $id);
    $q_passwd = mysqli_real_escape_string($conn, $passwd);

    $sql="SELECT * FROM `membership` where id='$q_id' AND passwd='$q_passwd'";

    $result = mysqli_query($conn,$sql);

    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }

    $rowcount=mysqli_num_rows($result);

    if(!$rowcount){
      echo "<script>alert('로그인 실패.');history.go(-1);</script>";
      mysqli_close($conn);
      exit;
    }else{
      $row = mysqli_fetch_array($result);
      $_SESSION['userid']=$row['id'];
      $_SESSION['username']=$row['name'];
      ;
    }
}
mysqli_close($conn);

Header("Location:../../mainpage.php");

?>
