<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";

if(isset($_GET["mode"]) && $_GET["mode"]== "delete") {
  $msg_num = $_GET['msg_num'];

  $sql = "delete from msg where msg_num = '$msg_num'";
  mysqli_query($conn, $sql);

  mysqli_close($conn);

  echo "<script> window.close(); alert('삭제 되었습니다.');
  window.opener.location.reload(true);
  </script>";
}else if(isset($_GET["mode"]) && $_GET["mode"]== "send"){
  $send_id = $_SESSION['userid'];
  $msg_name = $_SESSION['username'];

  $receive_id = $_POST['receive_id'];
  $msg_content =$_POST['msg_content'];
  $msg_check = 'N';
  $msg_date = date("Y-m-d (H:i)");
  $sql ="SELECT * from `membership` where id = '$receive_id'";
  $result = mysqli_query($conn, $sql);
  $row=mysqli_fetch_array($result);
  if(mysqli_num_rows($result) == 0){
      echo "<script>
              alert('잘못된 아이디 입니다.');
              window.history.go(-1);
            </script>";
  }else if(empty($msg_content)){
      echo "<script>
              alert('메세지를 입력해 주세요.');
              window.history.go(-1);
            </script>";
  }else{
      //send_id가 내아이디 receive_id가 받는사람아이디
      $sql = "INSERT into `msg` values(null, '$msg_name', '$send_id', '$receive_id', '$msg_content', '$msg_date', '$msg_check')";
      mysqli_query($conn, $sql) or die(mysqli_error($con));

      echo "<script>
              window.close();
              alert('전송됐습니다.');
              window.history.go(-1);
            </script>";
  }
}

?>
