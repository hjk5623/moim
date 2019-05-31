//후기
// $(document).ready(function() {
  var hidden_num= $("#hidden_num").val();
  var hidden_id= $("#hidden_id").val();
  var mypage= 1;
  mycontent(mypage);

    $(document).on("click",".ripple_delete",function(event){ //후기 '삭제' 버튼 클릭시
      var n= $('.ripple_delete').index(this);
      var del_ripple_num= $('.ripple_delete:eq('+n+')').val();

      $.post('ing_query.php?mode=c_delete_ripple&c_ripple_num='+del_ripple_num,{},function(data){
        $('.results').html("");
        mycontent(mypage);
      })
    });
    $('#ripple_btn').click(function(event) { //후기 '등록' 버튼 클릭시
      content_insert();
    });
  $('#loadmorebtn').click(function(event) { //후기 '더보기' 버튼 클릭시
    mypage++;
    mycontent(mypage);
  });
  function mycontent(mypage){ // 후기 더보기
    $.post('loadmore.php?club_num='+hidden_num, {page: mypage}, function(data) {
      if(data.trim().length==0){
        $('#loadmorebtn').text("더보기").hide()
      }
      $('.results').append(data)
      // $("html, body").animate({scrollTop: $('#loadmorebtn').offset().tap}, 800)
    })
  }//end of mycontent
  function content_insert(){ // 후기 등록
    var c_ripple_content= $('#c_ripple_content').val();

    if(c_ripple_content.length>0 && hidden_id != ""){
      console.log(c_ripple_content);
      $.post('ing_query.php?club_num='+hidden_num+'&mode=c_insert_ripple', {c_ripple_content: c_ripple_content}, function(data) {
        console.log("ResponseText: "+ data);
        $('.results').html(data)
        mycontent(mypage);
      })
    }else{
      modal_alert("알림","후기를 입력해주세요");
      console.log("textarea가 비었음");
    }

    $('#c_ripple_content').val(""); // 후기를 등록하면 textarea 비움
  }
// });
