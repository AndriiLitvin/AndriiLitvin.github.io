$(function(){
    $(window).scroll(function() {
      return $('.menu').toggleClass("header_fixed", $(window).scrollTop() > 0);
    });

  if ($(window).width() > 1200) {
      
  }

  $('.why_java-link').click(function(){
    var destination = $(".why_java").offset().top - 0;
    $("body,html").animate({ scrollTop: destination}, 500 );
  });

  $(document).ready(function () {
    $('#registration-form').on('submit', function (e) {
      $('#registration-btn').addClass('inactive');
      $('#registration-btn').prop('disabled', true);
    });
  });

});
