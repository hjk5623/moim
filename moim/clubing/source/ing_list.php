<?php
session_start();
 include $_SERVER['DOCUMENT_ROOT']."/moim/lib/db_connector.php";
 include $_SERVER['DOCUMENT_ROOT']."/moim/lib/create_table.php";

create_table($conn, 'club');

 if(isset($_GET["mode"])){
   $mode= $_GET["mode"];
 }else{
   $mode= "";
 }

//---- 오늘 날짜
$thisyear = date('Y'); // 4자리 연도
$thismonth = date('n'); // 0을 포함하지 않는 월
$today = date('j'); // 0을 포함하지 않는 일

//------ $year, $month 값이 없으면 현재 날짜
$year = isset($_GET['year']) ? $_GET['year'] : $thisyear;
$month = isset($_GET['month']) ? $_GET['month'] : $thismonth;
$day = isset($_GET['day']) ? $_GET['day'] : $today;

$prev_month = $month - 1;
$next_month = $month + 1;
$prev_year = $next_year = $year;
if ($month == 1) {
    $prev_month = 12;
    $prev_year = $year - 1;
} else if ($month == 12) {
    $next_month = 1;
    $next_year = $year + 1;
}
$preyear = $year - 1;
$nextyear = $year + 1;

$predate = date("Y-m-d", mktime(0, 0, 0, $month - 1, 1, $year));
$nextdate = date("Y-m-d", mktime(0, 0, 0, $month + 1, 1, $year));

// 1. 총일수 구하기
$max_day = date('t', mktime(0, 0, 0, $month, 1, $year)); // 해당월의 마지막 날짜
//echo '총요일수'.$max_day.'<br />';

// 2. 시작요일 구하기
$start_week = date("w", mktime(0, 0, 0, $month, 1, $year)); // 일요일 0, 토요일 6

// 3. 총 몇 주인지 구하기
$total_week = ceil(($max_day + $start_week) / 7);

// 4. 마지막 요일 구하기
$last_week = date('w', mktime(0, 0, 0, $month, $max_day, $year));
?>

<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link rel="stylesheet" href="../css/club.css">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script>
      var startHeightMin=0; //트리거 시작 스크롤 위치
      var itemHeight=100; // 아이템별 높이
      var itemMax=0; //현재 표시 아이템수
      var itemLimit=0; // 모든 아이템 수
      jQuery(window).scroll(function() {
      itemLimit=jQuery('.btm2_item').length; // 모든 아이템수 btm2_item css class 가 표시될 객채 li
      if(itemMax > itemLimit){ //표시 아이템 수가 모든 아이템수보다 높으면 작동 하지 말아야..
          return;
      }
      cehcksc();
      });
      function cehcksc(){
      //#startdiv 는 해당 객채를 지나가면 작동을 한다 알맞게 변경 (트리거)
          if (jQuery(window).scrollTop() >= ((jQuery(document).height() - jQuery(window).height()) - jQuery('#startdiv').innerHeight())) {
                //console.log(jQuery(window).scrollTop()); // startHeightMin 찾기
              var docHeight=jQuery(window).scrollTop() - startHeightMin;
              var itemLength=Math.floor(docHeight/itemHeight); // 스크롤 위치에서 시작 스크롤 위치를 -,출력할 아이템수를 설정
              if(itemMax<itemLength){ // 수가 낮아 졌을때는 표시 안함
                  itemMax=itemLength; // itemMax 갱신
                  jQuery('.btm2_item').each(function(index,item){ //btm2_item
                      if((itemMax-1) >= index){
                          if(jQuery(this).css("display") == "none"){
                              jQuery(this).fadeIn(2000);
                          }
                      }
                  });
              }
            }
        }
    </script>
    <style media="screen">
      table,tr,td{
        border: 1px solid lightgray;
        border-collapse: collapse;
      }
      td{
        width: 150px;
      }
      #cal_click{
        background-color: yellow;
      }
    </style>
  </head>
  <body>
    <nav>
      <div class="brand">
        <h2>Mo,im</h2>
      </div>
      <ul>
        <li><a href="../../mainpage.php">HOME</a></li>
        <li><a href="#">LOG OUT</a></li>
        <li><a href="#">CLUB LIST</a></li>
        <li><a href="#">INTRO</a></li>
        <li><a href="#">MY PAGE</a></li>
        <li><a href="#">HOME</a></li>
        <li><a href="#">HOME</a></li>
      </ul>
    </nav>

  <section class="sec10"></section>

  <div id="intd_warp">
    <div class="sline">
      <ul>
        <li><a href="ing_list.php">전체</a></li>
        <li><a href="ing_list.php?mode=write">글쓰기</a></li>
        <li><a href="ing_list.php?mode=cook">요리</a></li>
        <li><a href="ing_list.php?mode=movie">영화</a></li>
        <li><a href="ing_list.php?mode=art">미술</a></li>
      </ul>
    </div>

    <section class="bmt-section" id="startdiv">
      <div class="pt1">
      <p class="title_large">모든 모임 보기</p>
      </div>
      <div class="pt2 btm20">
      <p class="p2_desc_text">진행 중인 모든 모임을 보여줍니다.</p>
      </div>
      <div class="">
        <a href="ing_list.php?mode=calendar" id=cal_click>달력</a>
      </div>
    </section>
    <script type="text/javascript">
    $(document).ready(function(){
      $.ajax({
        url: './ing_schedule.php',
        type: 'POST',
        data: {
          year: <?=$year?>,
          month: <?=$month?>
        }
      })
      .done(function(result) {
        result=result.replace("\n","");
        result=result.replace("\r","");
        var value= result.split(",");
        console.log(value);
        for(i=0;i<value.length-1;i++){
          value_day = value[i].split("/");
          $("#schedule"+value_day[0]).append("<a href='./view.php?club_num="+value_day[2]+"'>"+value_day[1]+"<br></a>");
          $("#schedule"+value_day[0]).css("color","blue");
          console.log(value_day[2]);
        }
      })
      .fail(function() {
        console.log("error");
      })
      .always(function() {
        console.log("complete");
      });
    });

    </script>
    <section class="scroll-sec">
    <!--if mode=="calendar" 캘린더 보여주기-------------------------------------------------------------->
    <?php
      if(!empty($mode) && $mode==="calendar"){ ?>

      <div class="container">
      <table class="table table-bordered table-responsive">
        <tr align="center" >
          <td>
            <!-- 현재 보고있는 달의 작년 -->
            <a href=<?php echo 'ing_list.php?mode=calendar&year='.$preyear.'&month='.$month . '&day=1'; ?>>PRE YEAR</a>
          </td>
          <td>
            <!-- 이전달 -->
            <a href=<?php echo 'ing_list.php?mode=calendar&year='.$prev_year.'&month='.$prev_month . '&day=1'; ?>>◀</a>
          </td>
          <td height="50" bgcolor="#FFFFFF" colspan="3">
            <!-- 현재달력으로 돌아옴 -->
            <a href=<?php echo 'ing_list.php?mode=calendar&year=' . $thisyear . '&month=' . $thismonth . '&day=1'; ?>>
            <?php echo "&nbsp;&nbsp;" . $year . '년 ' . $month . '월 ' . "&nbsp;&nbsp;"; ?></a>
          </td>
          <td>
            <!-- 다음달 -->
            <a href=<?php echo 'ing_list.php?mode=calendar&year='.$next_year.'&month='.$next_month.'&day=1'; ?>>▶</a>
          </td>
          <td>
            <!-- 현재 보고있는 달의 내년 -->
            <a href=<?php echo 'ing_list.php?mode=calendar&year='.$nextyear.'&month='.$month.'&day=1'; ?>>NEXT YEAR</a>
          </td>
        </tr>
        <tr class="info">
          <th hight="30">일</td>
          <th>월</th>
          <th>화</th>
          <th>수</th>
          <th>목</th>
          <th>금</th>
          <th>토</th>
        </tr>
  <?php
    // 5. 화면에 표시할 화면의 초기값을 1로 설정
    $day=1;

    // 6. 총 주 수에 맞춰서 세로줄 만들기
    for($i=1; $i <= $total_week; $i++){?>
      <tr>
    <?php
    // 7. 총 가로칸 만들기
    for ($j = 0; $j < 7; $j++) {
        // 8. 첫번째 주이고 시작요일보다 $j가 작거나 마지막주이고 $j가 마지막 요일보다 크면 표시하지 않음
        echo '<td height="50" valign="top">';
        if (!(($i == 1 && $j < $start_week) || ($i == $total_week && $j > $last_week))) {
            if ($j == 0) {
                // 9. $j가 0이면 일요일이므로 빨간색
                $style = "holy";
            } else if ($j == 6) {
                // 10. $j가 0이면 토요일이므로 파란색
                $style = "blue";
            } else {
                // 11. 그외는 평일이므로 검정색
                $style = "black";
            }

            // 12. 오늘 날짜면 굵은 글씨
            if ($year == $thisyear && $month == $thismonth && $day == date("j")) {
                // 13. 날짜 출력
                echo '<font class='.$style.'>';
                echo $day;
                echo '</font>';
                echo " 오늘";
                echo " <div id='schedule".$day."'><div>";
            } else {
                echo '<font class='.$style.'>';
                echo $day;
                echo '</font>';
                echo "<div id='schedule".$day."'><div>";
            }
            // 14. 날짜 증가
            $day++;
        }
        echo '</td>';
    }
 ?>
  </tr>
  <?php } ?>
</table>
<?php } ?>
</div>
      <div class="img-table">
        <ul id="ullist">

          <?php
          if(!empty($mode)&&isset($mode)){
            $sql = "select * from club where club_category='$mode' order by club_hit desc";
          }else{
            $sql = "select * from club order by club_hit desc";
          }
            $result= mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $row_count= mysqli_num_rows($result);
            for($i=1; $i<=$row_count; $i++){
              $row= mysqli_fetch_array($result);
              $club_num= $row['club_num'];
              $club_name= $row['club_name'];
              $club_image_name= $row['club_image_name'];
          ?>
                <li class="btm2_item noshow">
                  <div class="container">
                    <div class="box">
                      <img src="../img/<?=$club_image_name?>" class="btm2_image">
                    </div>
                      <a href="./ing_view.php?no=<?=$club_num?>" class="club_info">
                      <div class="inner">
                        <h4 class="btm2_head">다양한 스킨</h4>
                      </div>
                      <p class="btm2_desc"><?=$club_name?></p>
                      <!-- <div class="details">
                        <div class="content">
                        <h2>모임1의 이름</h2>
                        <p>모임1의 정보입니다.간단한 정보와 이름, 특징을 나타내는 곳입니다.</p>
                        </div>
                      </div> -->
                    </a>
                  </div>
                </li>
          <?php
              }
          ?>
        </ul>
      </div>
    </section>
  </div>
  </body>
</html>
