<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/moim/lib/db_connector.php";
$perpage= 3;
$numpage= filter_var($_POST['page'], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);

$userid= (isset($_SESSION['userid'])) ? $_SESSION['userid'] : "";
$club_num= (isset($_GET["club_num"])) ? $_GET["club_num"] : "";

if(!is_numeric($numpage)){ //숫자타입이 아니면 에러메시지를 준다.
  // header('HTTP/1.1 500 Invalid page number!');
  echo "숫자타입이 아닙니다";
  exit();
}
$position= (($numpage-1) * $perpage);
$result= $conn->prepare("SELECT `c_ripple_name`, `c_ripple_date`, `c_ripple_content`, `c_ripple_id`, `c_ripple_num` FROM `club_ripple` WHERE `c_parent_num`=$club_num ORDER BY `c_ripple_num` desc LIMIT ?, ?");
$result-> bind_param("dd", $position, $perpage);
//이 함수는 매개 변수를 SQL 쿼리에 바인딩하고 데이터베이스에 매개 변수가 무엇인지 알려줍니다.
//d= double
$result-> execute();
$result-> bind_result($c_ripple_name, $c_ripple_date, $c_ripple_content, $c_ripple_id, $c_ripple_num);
while($result->fetch()){
  echo "<hr class='divider_ripple'>";
  echo "<div class='well well-sm'><b>".$c_ripple_name."</b>".$c_ripple_date.""; //후기 작성자의 이름, 작성날짜
  if(!empty($userid) && $userid===$c_ripple_id || $userid==="admin"){ ?>
    <button type="button" name="button" onclick="location.href='./ing_query.php?mode=c_delete_ripple&club_num=<?=$club_num?>&name=<?=$c_ripple_name?>&c_ripple_num=<?=$c_ripple_num?>'">삭제</button>
<?php
  }else{}//end of else
  echo "<br>".$c_ripple_content."</div>"; //후기 내용
}//end of while
?>
