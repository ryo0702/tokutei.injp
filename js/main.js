$(document).ready(function() {
    $('.drawermenu_button,.drawermenu_close_button').on('click', function(){
        $('.drawermenu_button').toggleClass("active");
        $('.drawermenu').toggleClass("active");
      });
});