$(document).ready(function() {
  var menu = $(".sub_menu").offset();
  $(window).scroll(function() {
    if ($(document).scrollTop() > menu.top) {
      $(".sub_menu").addClass('fixed');
    }else{
      $(".sub_menu").removeClass('fixed');
    }
  });
});
