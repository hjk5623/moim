<?php
include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";
include $_SERVER['DOCUMENT_ROOT']."/moim/lib/create_table.php";



//카테고리의 개수 출력
$sql_c="SELECT distinct `club_category` from club;";
$result_c = mysqli_query($conn,$sql_c);
$count_c = mysqli_num_rows($result_c);  // 중복제거 카테고리의 개수 출력
if (!$result_c) {
  alert_back('Error: ' . mysqli_error($conn));
}

//for 문
for($i=0;$i<$count_c;$i++){   // 카테고리의 수만큼  for문
  $row_c=mysqli_fetch_array($result_c); //각 카테고리의 이름 뽑아오기.

  $category[$i]=$row_c[0];
  // var_export($category[$i]);

  $sql_cc="SELECT count('모임의 수') from `club` where `club_category` like '$category[$i]';";
  $result_cc = mysqli_query($conn,$sql_cc);
  if (!$result_cc) {
    alert_back('Error: ' . mysqli_error($conn));
  }
  $row_cc=mysqli_fetch_array($result_cc);
  // var_export($row1[0]);
  $cat[$i] =$row_cc[0];
  var_export($row_cc[0]);
  // $count2 = mysqli_num_rows();
}

?>
<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
          var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            <?php
            for($i=0;$i<$count_c;$i++){
              if($i!=$count_c-1){
                echo "['".$category[$i]."',".$cat[$i]."],";
              }else{
                  echo "['".$category[$i]."',".$cat[$i]."]";
              }
            }
            ?>

          ]);


        var options = {
          title: 'My Daily Activities'
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
    <div id="piechart" style="width: 900px; height: 500px; margin-top:100px;"></div>
  </body>
</html>
