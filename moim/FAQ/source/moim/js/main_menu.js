// Menu-toggle button
$(document).ready(function() {
      $(".header_top .menu_icon").on("click", function() {
            $(".header_top nav ul").toggleClass("showing");
      });
});
// Scrolling Effect
$(window).on("scroll", function() {
      if($(window).scrollTop()) {
            $(".header_top nav").addClass("black");
      }
      else {
            $(".header_top nav").removeClass("black");
      }
});
