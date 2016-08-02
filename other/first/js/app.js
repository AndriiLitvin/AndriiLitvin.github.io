$(function(){
    $(window).scroll(function() {
      return $('.head').toggleClass("header_fixed", $(window).scrollTop() > 0);
    });

  if ($(window).width() > 1200) {
      $('.head .phone-icon').click(function () {
        $('.head  .phone-item').slideToggle(400);
      });
      $('.footer .phone-icon').click(function () {
        $('.footer .phone-item').slideToggle(400);
      });
  }

  $('.more-btn').click(function() {
      $(this).parents('.reviews-info').find('.reviews-more').slideToggle(400);
      if (this.textContent == 'Cкрыть')
          this.textContent = 'Читать далее...';
      else
          this.textContent = 'Cкрыть';
  });

  $('.tech-link').click(function() {
      $('#tech-link').addClass('active');
      $('#soft-link').removeClass('active');
      $('#engl-link').removeClass('active');
      $('#career-link').removeClass('active');
  });
  $('.soft-link').click(function() {
      $('#tech-link').removeClass('active');
      $('#soft-link').addClass('active');
      $('#engl-link').removeClass('active');
      $('#career-link').removeClass('active');
  });
  $('.engl-link').click(function() {
      $('#tech-link').removeClass('active');
      $('#soft-link').removeClass('active');
      $('#engl-link').addClass('active');
      $('#career-link').removeClass('active');
  });
  $('.career-link').click(function() {
      $('#tech-link').removeClass('active');
      $('#soft-link').removeClass('active');
      $('#engl-link').removeClass('active');
      $('#career-link').addClass('active');
  });
$('.order-add').click(function () {
      $('#orderType').val('order-add');
      $('.live_workshops_yes').addClass('active');
      $('.live_workshops_no').removeClass('active');

  });
  $('.order-no').click(function () {
      $('#orderType').val('order-no');
      $('.live_workshops_no').addClass('active');
      $('.live_workshops_yes').removeClass('active');
  });

  $("#phone").inputmask("+38(999)999-99-99");

  $('.standart').on('click', function(e){
    e.preventDefault();
      $('#registrationType').val('standart');
    $('#comment').val('Заявка на курс JUNIOR STANDARD');
  });
  $('.super').on('click', function(e){
    e.preventDefault();
      $('#registrationType').val('super');
    $('#comment').val('Заявка на курс SUPER JUNIOR');
  });
  $('.default_registration').on('click', function(e){
      e.preventDefault();
      $('#registrationType').val('default_registration');
  });

  $('#add').on('click', function(){
    $('#offline').val(', Хочет пакет с Оффлайн встречам');
  });
  $('#no-add').on('click', function(){
    $('#offline').val(' ');
  });    

  $('.why_java-link').click(function(){
    var destination = $(".why_java").offset().top - 0;
    $("body,html").animate({ scrollTop: destination}, 500 );
  });

  $('.career-link-menu').click(function(){
    var destination = $(".career").offset().top - 50;
    $("body,html").animate({ scrollTop: destination}, 500 );
  });

  $('.way_java-link').click(function(){
    var destination = $(".way_java").offset().top - 50;
    $("body,html").animate({ scrollTop: destination}, 500 );
  });

  $('.week-link').click(function(){
    var destination = $(".week").offset().top - 0;
    $("body,html").animate({ scrollTop: destination}, 500 );
  });
  $('.price-link').click(function(){
    var destination = $(".price").offset().top - 50;
    $("body,html").animate({ scrollTop: destination}, 500 );
  });
  $('.registration-link, .reg-scroll').click(function(){
    var destination = $(".registration").offset().top - 50;
    $("body,html").animate({ scrollTop: destination}, 500 );
  });

  $(document).ready(function () {
    $('#registration-form').on('submit', function (e) {
      $('#registration-btn').addClass('inactive');
      $('#registration-btn').prop('disabled', true);
    });
  });

  $('.reg-scroll').click(function(){
    var count_val = $(this).parents('.start').find('.start-info span').text();
      if (count_val==0) {
        count_val = 1;
      }
      count_val = parseFloat(count_val)-1;
      var val = localStorage.setItem("val", count_val);
        val = localStorage.getItem("val");
    if (val == 16) {
        $('.start-info span').text(val);
    }
  });
   val = localStorage.getItem("val");
     if (val != null) {
        $('.start-info span').text('10');
    }


   
  if ($(window).width() < 1200) {
      $('.menu-item').click(function () {
        $('.menu').hide();
    });
  }
  var waypoint_mac = new Waypoint({
    element: $('.mac-box'),
    handler: function(dir) {
        if (dir == 'up') {
             $('.mac').removeClass('fixed')
            
        } else {
             $('.mac').addClass('fixed')
        }
      },
      offset: '0%'
  });
  var waypoint_mac_off = new Waypoint({
    element: $('.block5'),
    handler: function(dir) {
      if (dir == 'up') {
             $('.mac').addClass('fixed')
             $('.mac').css({
              'top' : '62px',
            });
            
        } else {
             $('.mac').removeClass('fixed')
             $('.mac').css({
              'top' : '75%',
            });
        }
    },
    offset: '90%'
  });
  var waypoint_block2 = new Waypoint({
    element: $('.block2'),
    handler: function(dir) {
      if (dir == 'up') {
             
            
        } else {
           $('.mac-block1').not(this).animate({opacity: 1}, 1000);
        }
    },
    offset: '0%'
  });
  var waypoint_block3 = new Waypoint({
    element: $('.block3'),
    handler: function(dir) {
      if (dir == 'up') {
            $('.mac-block2').not(this).animate({opacity: 0}, 1000); 
        } else {
           $('.mac-block2').not(this).animate({opacity: 1}, 1000);
        }
    },
    offset: '0%'
  });
  var waypoint_block4 = new Waypoint({
    element: $('.block4'),
    handler: function(dir) {
      if (dir == 'up') {
            $('.mac-block3').not(this).animate({opacity: 0}, 1000);
        } else {
           $('.mac-block3').not(this).animate({opacity: 1}, 1000);
        }
    },
    offset: '10%'
  });

  var waypoint_block4 = new Waypoint({
    element: $('.block4'),
    handler: function(dir) {
      $('#percent1').animateNumber(
        {
          number: 20,
          easing: 'easeInQuad'
        },
        2000
      );
      $('#percent2').animateNumber(
        {
          number: 60,
          easing: 'easeInQuad'
        },
        3000
      );
      $('#dol1').animateNumber(
        {
          number: 300,
          easing: 'easeInQuad'
        },
        4000
      );
      $('#dol2').animateNumber(
        {
          number: 500,
          easing: 'easeInQuad'
        },
        5000
      );

    },
    offset: '-100%'
  });



});
