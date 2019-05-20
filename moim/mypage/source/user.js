$(document).ready(function() {

  $(".apply_cancle").click(function(event) {
    var apply_confirm = confirm("신청을 취소 하시겠습니까?");
    if(apply_confirm){
      $.ajax({
        url: './user_query.php?mode=apply_cancle',
        type: 'POST',
        data: {buy_num: $(this).val()}
      })
      .done(function(result) {
        console.log("success");
        location.href="./user_apply.php";
      })
      .fail(function() {
        console.log("error");
      })
      .always(function() {
        console.log("complete");
      });
    }
  });
});
