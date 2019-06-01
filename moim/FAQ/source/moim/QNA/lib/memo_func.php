<?php
function memo_delete($id1,$num1,$page1,$page){
  $message="";
  if($_SESSION['userid']=="admin"||$_SESSION['userid']==$id1){
    $message='<form style="display:inline" action="'.$page1.'?mode=delete_memo&page='.$page.'" method="post">
    <input type="hidden" name="num" value="'.$num1.'">
    <input type="submit" value="삭제">
    </form>';
  }
  return $message;
}
function memo_ripple_delete($id1,$num1,$page1,$page){
  $message="";
  if($_SESSION['userid']=="admin"||$_SESSION['userid']==$id1){
    $message='<form style="display:inline" action="'.$page1.'?mode=delete_ripple&page='.$page.'" method="post">
    <input type="hidden" name="num" value="'.$num1.'">
    <input type="submit" value="삭제">
    </form>';
  }
  return $message;
}
?>



<!-- if($_SESSION['$userid']=="admin" || $_SESSION['$userid']==$memo_id){
  echo('<form action="delete.php" method="post">
    <input type="hidden" name="num" value="'.$memo_num.'">
    <input type="submit" value="삭제">
  </form>');
}else{

} -->
