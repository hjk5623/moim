<?php
include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";
include $_SERVER['DOCUMENT_ROOT']."/moim/lib/create_table.php";

session_start();
//
// if(!empty($_SESSION['id'])){
//     $id = $_SESSION['id'];
// }else{
//     $id = "";
// }

//연도별 검색 (2019년~2013년)
if(!empty($_POST['find'])){
    $find = $_POST['find'];
}else{
    $find = date("Y");
}

$jan = "01";
$feb = "02";
$mar = "03";
$apr = "04";
$may = "05";
$jun = "06";
$jul = "07";
$aug = "08";
$sep = "09";
$oct = "10";
$nov = "11";
$dec = "12";

$jan_price =0;
$feb_price =0;
$mar_price =0;
$apr_price =0;
$may_price =0;
$jun_price =0;
$jul_price =0;
$aug_price =0;
$sep_price =0;
$oct_price =0;
$nov_price =0;
$dec_price =0;

$current_date = date("Y");    //현재년도

if($find){ // 연도별로 검색을 하면(select box에서 선택)
   $sql = "SELECT * from `club` where `club_end` like '$find%'";
}else{  // 연도별 검색을 하지 않는 경우에는 현재연도로
   // $sql = "SELECT * from `reserve_info` where `payment_date` like '$current_date%'";
}

$result = mysqli_query($conn,$sql) or die("실패원인1: ".mysqli_error($conn));

while($row = mysqli_fetch_array($result)){

$club_price = $row['club_price'];
$club_end = $row['club_end'];


// payment_date = 2019-05-05
// $payment_date = substr($payment_date, 5,2);    // 07/07/07/03 */   월별로 나오도록 자르기


//1월~12월까지의 쿼리문
// 모집종료일 기준으로 월별매출 계산 (신청인원 * 모임가격)
$sql1 = "SELECT sum(`club_price` * `club_apply`) AS '매출' from `club` where club_end like '_____$jan%'  and `club_end` like '$find%'  and club_open='yes'; ";
$result1 = mysqli_query($conn,$sql1) or die("실패원인1: ".mysqli_error($conn));
$row = mysqli_fetch_array($result1);
$jan_price = $row['0'];
if(!$jan_price){$jan_price =0;}


$sql2 = "SELECT sum(`club_price` * `club_apply`) AS '매출' from `club` where club_end like '_____$feb%'  and `club_end` like '$find%'  and club_open='yes'; ";
$result2 = mysqli_query($conn,$sql2) or die("실패원인1: ".mysqli_error($conn));
$row = mysqli_fetch_array($result2);
$feb_price = $row['0'];
if(!$feb_price){$feb_price =0;}

$sql3 = "SELECT sum(`club_price` * `club_apply`) AS '매출' from `club` where club_end like '_____$mar%'  and `club_end` like '$find%'  and club_open='yes'; ";
$result3 = mysqli_query($conn,$sql3) or die("실패원인1: ".mysqli_error($conn));
$row = mysqli_fetch_array($result3);
$mar_price = $row['0'];
if(!$mar_price){$mar_price =0;}

$sql4 ="SELECT sum(`club_price` * `club_apply`) AS '매출' from `club` where club_end like '_____$apr%'  and `club_end` like '$find%'  and club_open='yes'; ";
$result4 = mysqli_query($conn,$sql4) or die("실패원인1: ".mysqli_error($conn));
$row = mysqli_fetch_array($result4);
$apr_price = $row['0'];
if(!$apr_price){$apr_price =0;}

$sql5 = "SELECT sum(`club_price` * `club_apply`) AS '매출' from `club` where club_end like '_____$may%'  and `club_end` like '$find%'  and club_open='yes'; ";
$result5 = mysqli_query($conn,$sql5) or die("실패원인1: ".mysqli_error($conn));
$row = mysqli_fetch_array($result5);
$may_price = $row['0'];
if(!$may_price){$may_price =0;}

$sql6 ="SELECT sum(`club_price` * `club_apply`) AS '매출' from `club` where club_end like '_____$jun%'  and `club_end` like '$find%'  and club_open='yes'; ";
$result6 = mysqli_query($conn,$sql6) or die("실패원인1: ".mysqli_error($conn));
$row = mysqli_fetch_array($result6);
$jun_price = $row['0'];
if(!$jun_price){$jun_price =0;}

$sql7 = "SELECT sum(`club_price` * `club_apply`) AS '매출' from `club` where club_end like '_____$jul%'  and `club_end` like '$find%' and club_open='yes'; ";
$result7 = mysqli_query($conn,$sql7) or die("실패원인1: ".mysqli_error($conn));
$row = mysqli_fetch_array($result7);
$jul_price = $row['0'];
if(!$jul_price){$jul_price =0;}

$sql8 ="SELECT sum(`club_price` * `club_apply`) AS '매출' from `club` where club_end like '_____$aug%'  and `club_end` like '$find%' and club_open='yes'; ";
$result8 = mysqli_query($conn,$sql8) or die("실패원인1: ".mysqli_error($conn));
$row = mysqli_fetch_array($result8);
$aug_price = $row['0'];
if(!$aug_price){$aug_price =0;}

$sql9 ="SELECT sum(`club_price` * `club_apply`) AS '매출' from `club` where club_end like '_____$sep%'  and `club_end` like '$find%' and club_open='yes'; ";
$result9 = mysqli_query($conn,$sql9) or die("실패원인1: ".mysqli_error($conn));
$row = mysqli_fetch_array($result9);
$sep_price = $row['0'];
if(!$sep_price){$sep_price =0;}

$sql10 = "SELECT sum(`club_price` * `club_apply`) AS '매출' from `club` where club_end like '_____$oct%'  and `club_end` like '$find%'  and club_open='yes'; ";
$result10 = mysqli_query($conn,$sql10) or die("실패원인1: ".mysqli_error($conn));
$row = mysqli_fetch_array($result10);
$oct_price = $row['0'];
if(!$oct_price){$oct_price =0;}

$sql11 = "SELECT sum(`club_price` * `club_apply`) AS '매출' from `club` where club_end like '_____$nov%'  and `club_end` like '$find%' and club_open='yes'; ";
$result11 = mysqli_query($conn,$sql11) or die("실패원인1: ".mysqli_error($conn));
$row = mysqli_fetch_array($result11);
$nov_price = $row['0'];
if(!$nov_price){$nov_price =0;}

$sql12 ="SELECT sum(`club_price` * `club_apply`) AS '매출' from `club` where club_end like '_____$dec%'  and `club_end` like '$find%' and club_open='yes'; ";
$result12 = mysqli_query($conn,$sql12) or die("실패원인1: ".mysqli_error($conn));
$row = mysqli_fetch_array($result12);
$dec_price = $row['0'];

if(!$dec_price){
  $dec_price =0;
}

}
?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
<head>
<meta charset="UTF-8">
<title></title>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>

<script type="text/javascript">

google.charts.load('current', {'packages':['line']});	/*LINE차트를 사용하기 위한 준비  */
google.charts.setOnLoadCallback(drawChart);		/* 로딩 완료시 함수 실행하여 차트 생성 */

function drawChart() {
 // 구글차트를 그리기 위한 데이터를 google.visualization.DataTable  객체에 삽입하여 차트로 바인딩

 //방법1. 자바스크립트 상에서 비어있는 DataTable 객체를 만들어놓고, 칼럼값들을 정의하고 그리고 데이터 값(rows)들을 추가
   var data = new google.visualization.DataTable();  //DataTable 객체 생성
  //↓그래프에 표시할 칼럼 추가
  //↓column 값은 (데이터형식, 컬럼명) 이렇게 쌍으로 입력 --- 데이터형식은 'string', 'number','boolean','date','datetime','timeofday' 중 하나 선택
   data.addColumn('number', 'Month');
   data.addColumn('number', '매출');
   //데이터 헤더부분을 정의하고나면, 데이터를 셋팅 -- 한번에 여러 row 들을 셋팅하는 addRows  를 사용하므로
   //배열 형식으로 [] 로 묶인다. 그 안의 값도  ['Month'의 값 , '매출'의 값] 이런 포맷의 array 형식으로 이루어져 있다.
   data.addRows([
     [1,  <?= $jan_price ?>],
     [2,  <?= $feb_price ?>],
     [3,  <?= $mar_price ?>],
     [4,  <?= $apr_price ?>],
     [5,  <?= $may_price ?>],
     [6,  <?= $jun_price ?>],
     [7,  <?= $jul_price ?>],
     [8,  <?= $aug_price ?>],
     [9,  <?= $sep_price ?>],
     [10, <?= $oct_price ?>],
     [11, <?= $nov_price ?>],
     [12, <?= $dec_price ?>]

   ]);

   // 차트의 이름이  Monthly payment history , 크기를 지정해줌
   var options = {
     chart: {
       title: 'Monthly payment history',
       subtitle: 'in won (KRW)'
     },
     width: 815,
     height: 500
   };
   // 그려진 차트가 들어가는  div의 이름이 'linechart'
   // 마지막으로 라인차트를 그려주면 된다.
   var chart = new google.charts.Line(document.getElementById('linechart'));
   chart.draw(data, google.charts.Line.convertOptions(options));
}

// 매출내역 상세확인버튼을 누르면  엑셀파일을 다운받을 수 있다.
$(document).ready(function() {
    $("#btnExport").click(function (e) {
      //  div id=dvData 여기 안의 내용 (테이블표) 을 엑셀파일로 전달.
       window.open('data:application/vnd.ms-excel;chsarset=utf-8,\uFEFF' + encodeURI($('#dvData').html()));
        e.preventDefault();
    });

 });

</script>

</head>
<body>

<nav>
  <?php
  include $_SERVER['DOCUMENT_ROOT']."/moim/admin/source/admin.php";
  ?>
</nav>

<h1 style="padding-top:40px; margin:0 auto; margin-top:20px; text-align: center"></h1><br>
<div id ="ticket_box45">
<div id="select_ticket"><h4>매출 내역</h4></div>
<form name="month_form" action="admin_flight_sales.php" method="post">
  <select name="find" style="width: 100px; height:30px;">
        <option value="<?= $current_date ?>"><?= $current_date ?>년</option>
        <option value="<?= $current_date -1 ?>"><?= $current_date -1 ?>년</option>
        <option value="<?= $current_date -2 ?>"><?= $current_date -2 ?>년</option>
        <option value="<?= $current_date -3 ?>"><?= $current_date -3 ?>년</option>
        <option value="<?= $current_date -4 ?>"><?= $current_date -4 ?>년</option>
        <option value="<?= $current_date -5 ?>"><?= $current_date -5 ?>년</option>
        <option value="<?= $current_date -6 ?>"><?= $current_date -6 ?>년</option>
   </select>
   <input type="submit" value="검색" style="width: 60px; height:30px;">
</form>
<?php
// if($find){
//    $sql = "SELECT payment_price,payment_date from reserve_info where payment_date like '$find%'";
// }else{
//    $sql = "SELECT payment_price,payment_date from reserve_info where payment_date like '$current_date%'";
// }
$result = mysqli_query($conn,$sql) or die("실패원인1: ".mysqli_error($con));
$total=0;
while($row = mysqli_fetch_array($result)){
   // $payment_price = $row['payment_price'];
   // $total = $total + $payment_price;
}
$total = number_format($total);
if($find){
?>
   <div style="float:right;"><span style='font-size: 17pt; font-weight: 550;'><?= $find ?>년도 전체 매출 내역 : <?= $total ?> 원</span></div><br><br>
<?php
}else{
?>
   <div style="float:right;"><span style='font-size: 17pt;'><?= $current_date ?>년도 전체 매출 내역 : <?= $total ?> 원</span></div><br><br>
<?php
}
?>
<?php
$jan_price = number_format($jan_price);
$feb_price = number_format($feb_price);
$mar_price = number_format($mar_price);
$apr_price = number_format($apr_price);
$may_price = number_format($may_price);
$jun_price = number_format($jun_price);
$jul_price = number_format($jul_price);
$aug_price = number_format($aug_price);
$sep_price = number_format($sep_price);
$oct_price = number_format($oct_price);
$nov_price = number_format($nov_price);
$dec_price  = number_format($dec_price);
?>

<div id="linechart"></div>
<div style="float:right; margin:-400px 30px 0 0;">
<ul style="list-style: none;">
<li>01 월  : <?= $jan_price ?> 원</li>
<li>02 월  : <?= $feb_price ?> 원</li>
<li>03 월  : <?= $mar_price ?> 원</li>
<li>04 월  : <?= $apr_price ?> 원</li>
<li>05 월  : <?= $may_price ?> 원</li>
<li>06 월  : <?= $jun_price ?> 원</li>
<li>07 월  : <?= $jul_price ?> 원</li>
<li>08 월  : <?= $aug_price ?> 원</li>
<li>09 월  : <?= $sep_price ?> 원</li>
<li>10 월  : <?= $oct_price ?> 원</li>
<li>11 월  : <?= $nov_price ?> 원</li>
<li>12 월  : <?= $dec_price ?> 원</li>
</ul>
<hr style="width:100px; border:2px solid gray;">
<span style="float:right; margin:0 0px 0 0; font-size:13pt;">총액 : <?= $total ?> 원</span></div>

<?php
//---------------------------------------------------------------------------------------------------
//엑셀파일로 내역확인하기
?>
<button id="btnExport" style="float:right;">매출 내역 상세확인</button>

<div id="dvData">
<table style="visibility: hidden;border-collapse: collapse; font-family: "Trebuchet MS", Helvetica, sans-serif;">

<?php
  // $sql = "SELECT * from reserve_info";
  // $result = mysqli_query($con, $sql) or die("실패원인 : " . mysqli_error($con));
?>
 <tr>
      <td style="border: 1px solid black; text-align: center;">번 호</td>
      <td style="border: 1px solid black; text-align: center;">아 이 디</td>
      <td style="border: 1px solid black; text-align: center;">항공권 번호</td>
      <td style="border: 1px solid black; text-align: center;">항공권 예매번호</td>
      <td style="border: 1px solid black; text-align: center;">예매 날짜</td>
      <td style="border: 1px solid black; text-align: center;">결제 금액(원)</td>
   </tr>
<?php
   $i=0;
   $total2=0;
while($row = mysqli_fetch_array($result)){

   $id1 = $row['id'];
   $start_apnum1 = $row['start_apnum'];
   $back_apnum1 = $row['back_apnum'];
   $reserve_num1 = $row['reserve_num'];
   $payment_price1 = $row['payment_price'];
   $payment_date1 = $row['payment_date'];
   $total2 = $total2 + $payment_price1;

?>
 <tr>
      <td style="border: 1px solid black; text-align: center;" ><?= $i+1 ?></td>
      <td style="border: 1px solid black;text-align: center;"><?= $id1 ?></td>
      <td style="border: 1px solid black;text-align: center;"><?= $start_apnum1,$back_apnum1 ?></td>
      <td style="border: 1px solid black;text-align: center;"><?= $reserve_num1 ?></td>
      <td style="border: 1px solid black;text-align: center;"><?= $payment_date1 ?></td>
      <td style="border: 1px solid black;text-align: center;"><?= number_format($payment_price1) ?></td>
 </tr>
<?php
$i++;
}
?>
   <tr>
      <td colspan="3" style="border: 1px solid black; text-align: center;" >총 매출</td>
      <td colspan="3"  style="border: 1px solid black;text-align: center;"><?=number_format($total2) ?>원</td>
   </tr>
</table>
<?php
//---------------------------------------------------------------------------------------------------
?>
</div>
</div><!-- end of ticketbox-->
<br><br>
<footer>

</footer>
</body>
</html>
