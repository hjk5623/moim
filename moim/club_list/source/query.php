<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/moim/lib/db_connector.php";

if(isset($_GET['id'])){
  $userid=$_GET['id'];
}
if(isset($_GET['club_num'])){
  $club_num=$_GET['club_num'];
}

if(isset($_GET['mode'])&&$_GET['mode']=="delete"){ //모임 삭제 했을 경우
    $club_num =$_GET['club_num'];
    // club 테이블의 club_image_copied가 해당된 club_num 일 때 가장 최근 것을 검색한다.
    $sql="select club_image_copied from club where club_num = $club_num order by club_num desc limit 1;";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $row=mysqli_fetch_array($result);
    $club_image_copied=$row['club_image_copyied'];

    if (!empty($club_image_copied)) {
      $del_file=unlink("../../admin/data/".$club_image_copied);
    }
    if (!empty($club_file_copied)) {
      $del_file2=unlink("../../admin/data/".$club_file_copied);
    }
    //club 테이블의 해당된 club_num 이면 데이터를 삭제한다.
    $sql="DELETE FROM club WHERE club_num=$club_num";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    //cart 테이블의 해당된 cart_club_num 이면 데이터를 삭제한다.
    $sql="DELETE FROM cart WHERE cart_club_num=$club_num";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    mysqli_close($conn);
    echo "<script>
      location.href='./list.php';
    </script>";
  }else if(isset($_GET['mode'])&&$_GET['mode']=="cart"){  //카트담기 했을 경우
      $sql="INSERT INTO `cart` VALUES (null,'$userid',$club_num);";
      $result = mysqli_query($conn,$sql);
    mysqli_close($conn);
    echo "<script>
      location.href='./view.php?club_num=$club_num';
    </script>";
  }else if(isset($_GET['mode'])&&$_GET['mode']=="pay"){  //결제 했을 경우
    $today = date("Y-m-d", time());
    $sql="INSERT INTO `buy` VALUES (null,'$userid',$club_num,'no','no','$today');";
    $result = mysqli_query($conn,$sql);

    $sql = "select * from club where club_num=$club_num";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $club_to =$row['club_to'];
    $club_apply =$row['club_apply'];

    // 결제완료시 지원한 인원수 증가
    if ($club_to>$club_apply) {
      $club_apply =$row['club_apply']+1;
      $sql= "update club set club_apply=$club_apply where club_num=$club_num";
      mysqli_query($conn, $sql) or die(mysqli_error($conn));
    }

    echo "<script>
      location.href='./list.php';
    </script>";

  }else if(isset($_GET["mode"]) && $_GET["mode"]=="download"){  //세부사항 다운로드 경우

    $sql="SELECT * from `club` where club_num = $club_num;";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $row=mysqli_fetch_array($result);
    $club_file_name=$row['club_file_name'];
    $club_file_copied=$row['club_file_copied'];
    $club_file_type=$row['club_file_type'];
    mysqli_close($conn);

    //1. 테이블에서 파일명이 있는지 점검
    if (empty($club_file_copied)) {
      alert_back('테이블에 파일명이 존재 하지 않습니다!');
    }

    $file_path ="../../admin/data/$club_file_copied";

    //2. 서버에 data영역에 실제 파일이 있는지 점검
    if (file_exists($file_path)) {
      $fp=fopen($file_path, "rb");    //$fp 파일 핸들값
      //지정된 파일타입일 경우에는 모든 브라우저 프로토콜 규약이 되어있음.
      if ($club_file_type) {
        header("Content-type:application/x-msdownload");
        header("Content-Length:".filesize($file_path));
        header("Content-Disposition:attachment; filename=$club_file_name");
        header("Content-Transfer-Encoding:binary");
        header("Content-Descriotion:File Transfer");
        header("Expires:0");
        //지정된 파일타입이 아닌 경우
      }else{
        //타입이 알려지지 않을 경우
        if(eregi("(MSIE 5.0 | MSIE 5.1 | MSIE 5.5 | MSIE 6.0)", $HTTP_USER_AGENT)) {
          header("Content-type:application/octet-stream");
          header("Content-Length:".filesize($file_path));
          header("Content-Disposition:attachment; filename=$club_file_name");
          header("Content-Transfer-Encoding:binary");
          header("Expires:0");
        }else{
          header("Content-type:file/unknown");
          header("Content-Length:".filesize($file_path));
          header("Content-Disposition:attachment; filename=$club_file_name");
          header("Content-Disposition: PHP3 Generated Data");
          header("Expires:0");
        }
      }
      fpassthru($fp);
      fclose($fp);
    }else{
      alert_back('서버에 실제파일이 존재 하지 않습니다!');
    }
  }

 ?>
