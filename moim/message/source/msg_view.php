<?php
session_start();
if(!isset($_SESSION['userid'])){
  echo "<script>alert('권한이 없습니다');
  window.close();
  </script>";
  exit;
}
$id = $_SESSION['userid'];
$name = $_SESSION['username'];
include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";

$num = $_GET['msg_num'];
$mode = $_GET["mode"];
$sql = "SELECT * from `msg` where msg_num = '$num'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

$send_id=$row["send_id"];
$msg_name=$row["msg_name"];

$message_cont=$row["msg_content"];



$sql = "update msg SET msg_check = 'Y' where msg_num = '$num'";
mysqli_query($conn, $sql);
// var_dump($mode);
?>
<!DOCTYPE html>
   <html>
      <head>
         <meta charset="UTF-8">
         <title>테스트</title>
      <link rel="stylesheet" href="../css/msg.css">
         <script type="text/javascript">
         function receive_message_close(){
            window.close();
            window.opener.location.reload(true);
         }
      </script>
   </head>
   <body>
    <div class="view_div">
      <div class="send_id_div">
        <h3><?="".$send_id.""?></h3>
        <p>님이 보낸 메세지</p>
      </div>
      <hr>
        <div class="view_textarea">
           <textarea name="message_content" rows="8" cols="50" readonly ><?= $message_cont?></textarea>
        </div>
      <?php
      if($_GET["mode"]== "send"){
         ?>

      <?php
    }else{
      ?>
      <div class="msg_send">
        <a href="./msg_form.php?send_id=<?= $send_id?>">답장 보내기</a>
      </div>
      <?php
    }
       ?>
      <hr>
        <div class="msg_check_btn">
           <a href="#" onclick="receive_message_close()">확인</a>
           <a href="./msg_query.php?mode=delete&msg_num=<?=$num ?>">삭제</a>
        </div>
    </div>

      </body>
      </html>
