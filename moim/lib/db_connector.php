<?php
date_default_timezone_set("Asia/Seoul");
// $servername = "localhost";
// $username = "root";
// $password = "123456";
// $dbflag="NO";

$servername = "192.168.0.190";
$username = "moim_team";
$password = "12!@ahdla";
$dbflag="NO";

//1. Create connection (mysql -u root -p 123456 -h 192.168.0.190)
$conn = mysqli_connect($servername, $username, $password);
if (!$conn) {    die("Connection failed: " . mysqli_connect_error()); }

$sql = "show databases";
$result = mysqli_query($conn, $sql) or die('Error: ' . mysqli_error($conn));

while ($row=mysqli_fetch_row($result)) {
  if($row[0]==='moim'){
    $dbflag="OK";
    break;
  }
}
if($dbflag=="NO"){
  $sql = "create database moim";
  if(mysqli_query($conn,$sql)){
    echo "<script>alert('moim DB가 생성되었습니다.');</script>";
  }else{
    echo "실패원인".mysqli_error($conn);
  }
}

//2. 데이타베이스 선택 (use kdhong_db)
$dbconn = mysqli_select_db($conn, "moim") or die('Error: ' . mysqli_error($conn));

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
function alert_back($data){
  echo "<script>alert('$data');history.go(-1);</script>";
  exit;
}
 ?>
