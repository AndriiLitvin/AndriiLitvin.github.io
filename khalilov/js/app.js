$(window).scroll(function() {
  return $('.header').toggleClass("header_fixed", $(window).scrollTop() > 0);
});
jQuery(document).ready(function($){
  $('#menu-icon').click(function () {
    $('.menu-mob').hide();
    $(this).next().show();
    return false;
  });
  $('body, .menu-mob a').click(function () {
      $('.menu-mob').hide();
  });
});

$(function() {
  $('#what, #what-mob').click(function(){
    var destination = $("#understanding").offset().top - 50;
    $("body,html").animate({ scrollTop: destination}, 500 );
  });
  $('#who, #who-mob').click(function(){
    var destination = $("#training").offset().top - 50;
    $("body,html").animate({ scrollTop: destination}, 500 );
  });
  $('#task, #task-mob').click(function(){
    var destination = $("#business_task").offset().top - 10;
    $("body,html").animate({ scrollTop: destination}, 500 );
  });
  $('#progr, #progr-mob').click(function(){
    var destination = $("#program").offset().top - 50;
    $("body,html").animate({ scrollTop: destination}, 500 );
  });
  $('#coach, #coach-mob').click(function(){
    var destination = $("#training_leads").offset().top - 50;
    $("body,html").animate({ scrollTop: destination}, 500 );
  });
  $('#bonus, #bonus-mob').click(function(){
    var destination = $("#question").offset().top - 5;
    $("body,html").animate({ scrollTop: destination}, 500 );
  });
  $('#reg, #reg-mob,.register-btn-head, .register-btn, .registr-btn').click(function(){
    var destination = $("#registration").offset().top - 5;
    $("body,html").animate({ scrollTop: destination}, 500 );
  });
});