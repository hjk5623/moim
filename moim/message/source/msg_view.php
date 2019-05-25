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

$sql = "SELECT * from `msg` where msg_num = '$num'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

$send_id=$row["send_id"];
$msg_name=$row["msg_name"];

$message_cont=$row["msg_content"];



$sql = "update msg SET msg_check = 'Y' where msg_num = '$num'";
mysqli_query($conn, $sql);

?>
<!DOCTYPE html>
	<html>
		<head>
			<meta charset="UTF-8">
			<title>테스트</title>
			<script type="text/javascript">
			function receive_message_close(){
				window.close();
				window.opener.location.reload(true);
			}
		</script>
	</head>
	<body>
  	<div id="head">
    	Message
  	</div>
  	<hr>

		<div>
			<?=$msg_name."님"?>&nbsp<?="( ".$send_id." ) 이 보낸 메세지 "?> <br> <textarea style="resize: none;" name="message_content" rows="10" cols="57" readonly style="margin-top: 5px;"><?= $message_cont?></textarea>
		</div>
		<div>
      <?php
       ?>
			<a href="./msg_form.php?send_id=<?= $send_id?>">[답장 보내기]</a>
		</div>
		<br>
		<div>
			<a href="#" onclick="receive_message_close()">[확인]</a>
			<a href="./msg_query.php?msg_num=<?=$num ?>">[삭제]</a>
		</div>

		</body>
		</html>
