
function check_delete(num) {
  var result=confirm("한번 삭제한 자료는 복구할 수 없습니다.?\n정말 삭제하시겠습니까?");
  if(result){
    window.location.href='./admin_query.php?mode=clubdelete&club_num='+num;
  }
}

// function club_accept(club_num){
//   var result=confirm("한번 삭제한 자료는 복구할 수 없습니다.?\n정말 삭제하시겠습니까?");
//   if(result){
//     window.location.href='./admin_query.php?mode=clubaccept&club_num='+num;
//   }
// }
