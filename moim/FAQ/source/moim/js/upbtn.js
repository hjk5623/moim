$(document).ready(function() {
  $(window).scroll(function() {
    if($(this).scrollTop() > 40){
      $(".gotobtn").fadeIn();
    } else {
      $(".gotobtn").fadeOut();
    }
  });

  $(".gotobtn").click(function() {
    $('html, body').animate({scrollTop : 0}, 800);
  });
});
