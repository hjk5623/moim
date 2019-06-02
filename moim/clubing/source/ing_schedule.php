<?php
include $_SERVER['DOCUMENT_ROOT']."/moim/lib/db_connector.php";

$data= array();
$color= "black";
$sql = "SELECT * FROM club WHERE club_open='yes'"; // 종료된 모임까지 다 보여준다.
$statement= $conn->prepare($sql);
$statement-> execute();
$result= $statement->get_result();
foreach($result as $row){
  $club_num= $row['club_num'];
  $club_name= $row['club_name'];
  $club_schedule= $row["club_schedule"];
  $club_category= $row["club_category"];
  switch ($club_category) {
    case '글쓰기': $color= "#f6ea8c"; break; //오렌지
    case '요리': $color= "#fcbe32"; break; //노랑
    case '영화': $color= "#a5dff9"; break; //연파랑
    case '미술': $color= "#ef5285"; break; //핑크
    case '사진': $color= "#dd512c"; break; //브라운
    case '디자인': $color= "#60c5ba"; break; //민트
    case '경제/경영': $color= "#A593E0"; break; //연보라
    case '취미생활/기타': $color= "#D09E88"; break; //연브라운
  }
  $schedule= substr($club_schedule,0,8);
  $data[]= array(
    'title' =>"$club_name",
    'url'   =>'http://localhost/moim/clubing/source/ing_view.php?club_num='."$club_num",
    'start' =>"20$schedule",
    'color' =>"$color"
  );
}
echo json_encode($data);
?>
