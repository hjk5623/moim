﻿<?php
include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";
include $_SERVER['DOCUMENT_ROOT']."/moim/lib/create_table.php";

session_start();

//연도별 검색 (2019년~2013년)
if(!empty($_POST['find'])){
    $find = $_POST['find'];
}else{  // 검색하지 않으면 현재연도로 기본값
    $find = date("Y");
}

$jan = "01"; $feb = "02"; $mar = "03";
$apr = "04"; $may = "05"; $jun = "06";
$jul = "07"; $aug = "08"; $sep = "09";
$oct = "10"; $nov = "11"; $dec = "12";

$jan_price =0; $feb_price =0; $mar_price =0;
$apr_price =0; $may_price =0; $jun_price =0;
$jul_price =0; $aug_price =0; $sep_price =0;
$oct_price =0; $nov_price =0; $dec_price =0;
$total_sales =0;
$current_date = date("Y");    //현재년도


$sql = "SELECT * from `club` where `club_end` like '$find%'";
$result = mysqli_query($conn,$sql) or die("실패원인1: ".mysqli_error($conn));
while($row = mysqli_fetch_array($result)){

$club_price = $row['club_price'];
$club_end = $row['club_end'];

// payment_date = 2019-05-05
// $payment_date = substr($payment_date, 5,2);    // 07/07/07/03 */   월별로 나오도록 자르기

//1월~12월까지의 쿼리문 -- 모집종료일 기준으로 월별매출 계산 (신청인원 * 모임가격)
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

$sql_total="SELECT sum(club_price * club_apply) AS '매출' from club where club_end like '$find%' and club_open='yes';";
$result_total = mysqli_query($conn,$sql_total) or die("실패원인1: ".mysqli_error($conn));
$row = mysqli_fetch_array($result_total);
$total_sales = $row['0'];
if(!$total_sales){ $total_sales =0;}
}


//모임의 카테고리의 개수 출력
$year=substr($find, 2,2); //19,18 이런식으로 검색되게끔 substr

$sql_c="SELECT distinct `club_category` from club where `club_schedule` like '$year%';";
$result_c = mysqli_query($conn,$sql_c);
$count_c = mysqli_num_rows($result_c);  // 중복제거 카테고리의 개수 출력
if (!$result_c) {
  alert_back('Error: ' . mysqli_error($conn));
}


//for 문
for($i=0;$i<$count_c;$i++){   // 카테고리의 수만큼  for문
  $row_c=mysqli_fetch_array($result_c); //각 카테고리의 이름 뽑아오기.
  $category[$i]=$row_c[0];

  $sql_cc="SELECT count('모임의 수') from `club` where `club_category`='$category[$i]' and `club_schedule` like '$year%';";
  $result_cc = mysqli_query($conn,$sql_cc);
  if (!$result_cc) {
    alert_back('Error: ' . mysqli_error($conn));
  }
  $row_cc=mysqli_fetch_array($result_cc);
  $cat[$i] =$row_cc[0];

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
  <link rel="stylesheet" type="text/css" href="../css/admin_sales.css">
  <script type="text/javascript">
    $(document).ready(function() {
      $("#find").val("<?=$find?>").prop("selected", true);
    });
    google.charts.load('current', {
      'packages': ['line']
    }); /*LINE차트를 사용하기 위한 준비  */
    google.charts.setOnLoadCallback(drawChart); /* 로딩 완료시 함수 실행하여 차트 생성 */

    function drawChart() {
      // 구글차트를 그리기 위한 데이터를 google.visualization.DataTable  객체에 삽입하여 차트로 바인딩

      //방법1. 자바스크립트 상에서 비어있는 DataTable 객체를 만들어놓고, 칼럼값들을 정의하고 그리고 데이터 값(rows)들을 추가
      var data = new google.visualization.DataTable(); //DataTable 객체 생성
      //↓그래프에 표시할 칼럼 추가
      //↓column 값은 (데이터형식, 컬럼명) 이렇게 쌍으로 입력 --- 데이터형식은 'string', 'number','boolean','date','datetime','timeofday' 중 하나 선택
      data.addColumn('number', 'Month');
      data.addColumn('number', '매출');
      //데이터 헤더부분을 정의하고나면, 데이터를 셋팅 -- 한번에 여러 row 들을 셋팅하는 addRows  를 사용하므로
      //배열 형식으로 [] 로 묶인다. 그 안의 값도  ['Month'의 값 , '매출'의 값] 이런 포맷의 array 형식으로 이루어져 있다.
      data.addRows([
        [1, <?= $jan_price ?>],
        [2, <?= $feb_price ?>],
        [3, <?= $mar_price ?>],
        [4, <?= $apr_price ?>],
        [5, <?= $may_price ?>],
        [6, <?= $jun_price ?>],
        [7, <?= $jul_price ?>],
        [8, <?= $aug_price ?>],
        [9, <?= $sep_price ?>],
        [10, <?= $oct_price ?>],
        [11, <?= $nov_price ?>],
        [12, <?= $dec_price ?>]
      ]);

      // 차트의 이름이  Monthly payment history , 크기를 지정해줌
      var options = {
        chart: {
          title: '월별 매출 현황',
          subtitle: 'in won (KRW)'
        },
        width: 600,
        height: 500
      };
      // 그려진 차트가 들어가는  div의 이름이 'linechart'
      // 마지막으로 라인차트를 그려주면 된다.
      var chart = new google.charts.Line(document.getElementById('linechart'));
      chart.draw(data, google.charts.Line.convertOptions(options));
    }

    // 매출내역 상세확인버튼을 누르면  엑셀파일을 다운받을 수 있다.
    $(document).ready(function() {
      $("#btnExport").click(function(e) {
        //  div id=dvData 여기 안의 내용 (테이블표) 을 엑셀파일로 전달.
        window.open('data:application/vnd.ms-excel;chsarset=utf-8,\uFEFF' + encodeURI($('#dvData').html()));
        e.preventDefault();
      });

    });

    google.charts.load('current', {
      'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart1);

    function drawChart1() {
      var data = google.visualization.arrayToDataTable([
        ['category', 'category'],
        <?php
       for($i=0; $i<$count_c ; $i++){
         if($i != $count_c-1){
           echo "['".$category[$i]."',".$cat[$i]."],";
         }else{
            echo "['".$category[$i]."',".$cat[$i]."]";
         }
       }
       ?>

      ]);
      var options = {
        chart:{
          title: '카테고리별 모임현황'
        },
        width: 600,
        height: 400,
      };

      var chart = new google.visualization.PieChart(document.getElementById('piechart'));

      chart.draw(data, options);
    }
  </script>
</head>

<body>
  <?php
    include $_SERVER['DOCUMENT_ROOT']."/moim/admin/source/admin.php";
  ?>
  <h1 id="hr"></h1><br>
  <div id="sales_main_div">
    <div id="sales_div">
      <h1>월별 매출 현황</h1>
      <hr class="memberlist_hr">
      <div class="search_div">
        <form name="month_form" action="admin_sales.php" method="post" class="year_form">
          <select name="find" id="find">
            <option value="<?= $current_date ?>"><?= $current_date ?>년</option>
            <option value="<?= $current_date -1 ?>"><?= $current_date -1 ?>년</option>
            <option value="<?= $current_date -2 ?>"><?= $current_date -2 ?>년</option>
            <option value="<?= $current_date -3 ?>"><?= $current_date -3 ?>년</option>
            <option value="<?= $current_date -4 ?>"><?= $current_date -4 ?>년</option>
            <option value="<?= $current_date -5 ?>"><?= $current_date -5 ?>년</option>
            <option value="<?= $current_date -6 ?>"><?= $current_date -6 ?>년</option>
          </select>
          <input type="submit" value="검색">
        </form>
      </div>
    </div>
    <br>
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
      $total_sales = number_format($total_sales);

      ?>
      <div class="table_div">
        <table class="salestable">
        <thead>
          <tr>
            <td style="text-align:center">구분</td>
            <td style="text-align:center">기간</td>
            <td style="text-align:center">매출액</td>
          </tr>
        </thead>
        <tbody class="uptbody">
          <tr>
            <td rowspan="6" style="text-align:center;">상반기</td>
            <td>1월</td>
            <td><?=$jan_price?>원</td>
          </tr>
          <tr>
            <td>2월</td>
            <td><?=$feb_price?>원</td>
          </tr>
          <tr>
            <td>3월</td>
            <td><?=$mar_price?>원</td>
          </tr>
          <tr>
            <td>4월</td>
            <td><?=$apr_price?>원</td>
          </tr>
          <tr>
            <td>5월</td>
            <td><?=$may_price?>원</td>
          </tr>
          <tr>
            <td>6월</td>
            <td><?=$jun_price?>원</td>
          </tr>
          </tbody>
          <tbody class="downtbody">
          <tr>
            <td rowspan="6"  style="text-align:center;">하반기</td>
            <td>7월</td>
            <td><?=$jul_price?>원</td>
          </tr>
          <tr>
            <td>8월</td>
            <td><?=$aug_price?>원</td>
          </tr>
          <tr>
            <td>9월</td>
            <td><?=$sep_price?>원</td>
          </tr>
          <tr>
            <td>10월</td>
            <td><?=$oct_price?>원</td>
          </tr>
          <tr>
            <td>11월</td>
            <td><?=$nov_price?>원</td>
          </tr>
          <tr>
            <td>12월</td>
            <td><?=$dec_price?>원</td>
          </tr>
          </tbody>
            <tr class="lasttbody">
              <td colspan="2">&nbsp&nbsp&nbsp<?=$find?>년도 매출총액 </td>
              <td><?=$total_sales?>원</td>
            </tr>
        </table>
      </div>

    <div class="chart_div">
      <h2>월별 매출 및 카테고리별 모임현황</h2>
      <hr class="memberlist_hr">
      <div id="linechart">
        <!--라인차트가 그려지는 부분  -->
      </div>
      <div id="piechart">
        <!--파인차트가 그려지는 부분  -->
      </div>
    </div>
    <?php
    //---------------------------------------------------------------------------------------------------
    //엑셀파일로 내역확인하기
    ?>
    <button id="btnExport">매출 내역 상세확인</button>

    <div id="dvData">
      <table id="excel_table" style="visibility: hidden;border-collapse: collapse; font-family: " Trebuchet MS", Helvetica, sans-serif;">
      <?php
      $i=0;
      $total=0;

      $sql0="SELECT sum(club_price) from buy inner join club on buy_club_num=club_num where buy_cancle='no' and buy_process_date like '$find%' ;";
      $result0=mysqli_query($conn, $sql0) or die("실패원인 : " . mysqli_error($conn));
      $row0=mysqli_fetch_array($result0);
      $total=$row0[0];

      $sql ="SELECT * from buy inner join club on buy_club_num = club_num where buy_cancle='no' and buy_process_date like '$find%';";
      $result = mysqli_query($conn, $sql) or die("실패원인 : " . mysqli_error($conn));
      ?>
        <tr>
          <td style="border: 1px solid black; text-align: center;">번호</td>
          <td style="border: 1px solid black; text-align: center;">아이디</td>
          <td style="border: 1px solid black; text-align: center;">모임이름</td>
          <td style="border: 1px solid black; text-align: center;">구매날짜</td>
          <td style="border: 1px solid black; text-align: center;">결제금액</td>
        </tr>
        <?php

        while($row = mysqli_fetch_array($result)){

           $buy_id = $row['buy_id'];
           $club_name = $row['club_name'];
           $buy_process_date = $row['buy_process_date'];
           $club_price = $row['club_price'];

        ?>
        <tr>
          <td style="border: 1px solid black; text-align: center;"><?= $i+1 ?></td>
          <td style="border: 1px solid black; text-align: center;"><?= $buy_id ?></td>
          <td style="border: 1px solid black; text-align: center;"><?=$club_name ?></td>
          <td style="border: 1px solid black; text-align: center;"><?= $buy_process_date ?></td>
          <td style="border: 1px solid black; text-align: center;"><?= $club_price ?></td>
        </tr>
        <?php
        $i++;
        }
        ?>
        <tr>
          <td colspan="3"  style="border: 1px solid black; text-align: center;">총 매출</td>
          <td colspan="2"  style="border: 1px solid black; text-align: center;"><?=$total?>원</td>
        </tr>
      </table>
      <br><br>
      <!--  월별매출액테이블-->
      <div class="table_div">
        <table class="salestable" style="visibility: hidden;border-collapse: collapse; font-family: " Trebuchet MS", Helvetica, sans-serif;" >
        <thead>
          <tr>
            <td style="border: 1px solid black; text-align: center;">구분</td>
            <td style="border: 1px solid black; text-align: center;">기간</td>
            <td style="border: 1px solid black; text-align: center;">매출액</td>
          </tr>
        </thead>
        <tbody class="uptbody">
          <tr>
            <td rowspan="6" style="border: 1px solid black; text-align: center;">상반기</td>
            <td style="border: 1px solid black; text-align: center;">1월</td>
            <td style="border: 1px solid black; text-align: center;"><?=$jan_price?>원</td>
          </tr>
          <tr>
            <td style="border: 1px solid black; text-align: center;">2월</td>
            <td style="border: 1px solid black; text-align: center;"><?=$feb_price?>원</td>
          </tr>
          <tr>
            <td style="border: 1px solid black; text-align: center;">3월</td>
            <td style="border: 1px solid black; text-align: center;"><?=$mar_price?>원</td>
          </tr>
          <tr>
            <td style="border: 1px solid black; text-align: center;">4월</td>
            <td style="border: 1px solid black; text-align: center;"><?=$apr_price?>원</td>
          </tr>
          <tr>
            <td style="border: 1px solid black; text-align: center;">5월</td>
            <td style="border: 1px solid black; text-align: center;"><?=$may_price?>원</td>
          </tr>
          <tr>
            <td style="border: 1px solid black; text-align: center;">6월</td>
            <td style="border: 1px solid black; text-align: center;"><?=$jun_price?>원</td>
          </tr>
          </tbody>
          <tbody class="downtbody">
          <tr>
            <td rowspan="6" style="border: 1px solid black; text-align: center;">하반기</td>
            <td style="border: 1px solid black; text-align: center;">7월</td>
            <td style="border: 1px solid black; text-align: center;"><?=$jul_price?>원</td>
          </tr>
          <tr>
            <td style="border: 1px solid black; text-align: center;">8월</td>
            <td style="border: 1px solid black; text-align: center;"><?=$aug_price?>원</td>
          </tr>
          <tr>
            <td style="border: 1px solid black; text-align: center;">9월</td>
            <td style="border: 1px solid black; text-align: center;"><?=$sep_price?>원</td>
          </tr>
          <tr>
            <td style="border: 1px solid black; text-align: center;">10월</td>
            <td style="border: 1px solid black; text-align: center;"><?=$oct_price?>원</td>
          </tr>
          <tr>
            <td style="border: 1px solid black; text-align: center;">11월</td>
            <td style="border: 1px solid black; text-align: center;"><?=$nov_price?>원</td>
          </tr>
          <tr>
            <td style="border: 1px solid black; text-align: center;">12월</td>
            <td style="border: 1px solid black; text-align: center;"><?=$dec_price?>원</td>
          </tr>
          </tbody>
            <tr class="lasttbody">
              <td colspan="2" style="border: 1px solid black; text-align: center;"><?=$find?>년도 매출총액 </td>
              <td style="border: 1px solid black; text-align: center;"><?=$total_sales?>원</td>
            </tr>
        </table>
      </div>
      <br><br>
      <!--  월별매출액테이블-->
      <div class="category_div">
        <table style="visibility: hidden;border-collapse: collapse; font-family: " Trebuchet MS", Helvetica, sans-serif;">
          <tr>
            <td style="border: 1px solid black; text-align: center;">카테고리</td>
            <td style="border: 1px solid black; text-align: center;">모임수</td>
          </tr>

          <?php
            for($i=0;$i<$count_c;$i++){
           ?>
            <tr>
              <td style="border: 1px solid black; text-align: center;"><?=$category[$i]?></td>
              <td style="border: 1px solid black; text-align: center;"><?=$cat[$i]?></td>
            </tr>

          <?php
            }
          ?>
        </table>
      </div>

    </div>
  </div>
</body>

</html>
