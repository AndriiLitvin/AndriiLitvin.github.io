$(function(){
    $(window).scroll(function() {
      return $('.menu').toggleClass("header_fixed", $(window).scrollTop() > 0);
    });

  if ($(window).width() > 1200) {
      
  }
    $('.mob-btn').click(function () {
      $('.menu-list').toggle();
      $('.menu').toggleClass('white-bg');
    });
    if ($(window).width() < 1200) {
        $('.menu-item').click(function () {
          $('.menu-list').hide();
          $('.menu').removeClass('white-bg');
      });
    }

  $('.advantages-link').click(function(){
    var destination = $(".intelligence").offset().top - 10;
    $("body,html").animate({ scrollTop: destination}, 500 );
  });

  $('.methods-link').click(function(){
    var destination = $(".methods").offset().top - 10;
    $("body,html").animate({ scrollTop: destination}, 500 );
  });
  /*$('.insert-link').click(function(){
    var destination = $("#registration").offset().top - 0;
    $("body,html").animate({ scrollTop: destination}, 500 );
  });*/
  $(document).ready(function () {
  var select_active;
    $('.registr-form').on('submit', function (e) {
      $('.insert-btn').addClass('inactive');
      $('.insert-btn').prop('disabled', true);
      select_active = $('#city option:selected').val(); 
      select_active = localStorage.setItem("select_active", select_active);
    });
    select_active = localStorage.getItem("select_active");
    console.log(select_active);
    $('.'+ select_active).trigger('click');
  });

});
