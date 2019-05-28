<?php
session_start();
if(!isset($_SESSION['userid'])){
  echo "<script>alert('권한이 없습니다!');history.go(-1);</script>";
  exit;
}
 ?>
