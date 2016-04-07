var duration = 600;
var animation_type = 'easeInOutQuint';
var resize_timer = null;

function initSlider(slider){
    var act = 0;
    var arr_l = $(slider.find('.icon_arrow.left'));
    arr_l.hide();
    var arr_r = $(slider.find('.icon_arrow.right'));
    var items = slider.find('.item');
    var item_width = items.outerWidth(true);
    var animate_holder = $(slider.find('.items_holder'));
    animate_holder.scrollLeft(0);

    var sliderEvent = function(){
        removeSliderEvent();

        var next = act;
        var direction = 1;

        if( $(this).hasClass('left') ){
            next--;
            direction*=-1;
        } else {
            next++;
        }

        arr_l.fadeIn();
        arr_r.fadeIn();
        if( next == 0 ) arr_l.fadeOut();
        if( next == items.length-3 ) arr_r.fadeOut();

        animate_holder.animate({scrollLeft:'+='+direction*item_width},duration,animation_type,addSliderEvent);
        act = next;
    };

    var addSliderEvent = function(){
        arr_l.bind('click',sliderEvent);
        arr_r.bind('click',sliderEvent);
    };
    var removeSliderEvent = function(){
        arr_l.unbind('click',sliderEvent);
        arr_r.unbind('click',sliderEvent);
    };

    addSliderEvent();
}

$(document).ready(function() {
    if( $('.portfolio_slider').length ){
        initSlider($('.portfolio_slider'));
    }



    var nav_sections = $('[data-navigation]');
    var nav_links    = $('[data-link]');
    var header_h     = $('.header').outerHeight();

    $('.header').waypoint('sticky',{
        wrapper: '<div class="sticky_wrapper" />',
        stuckClass: 'stuck'
    });


    // highlights navigation
    nav_sections
        .waypoint(function(direction){
            var $links = $('a[data-link="' + $(this).data('navigation') + '"]');
            if( direction == 'down' ){
                $links.addClass('act');
            } else {
                $links.removeClass('act');
            }
        },{
            offset: header_h+2
        })
        .waypoint(function(direction){
            var $links = $('a[data-link="' + $(this).data('navigation') + '"]');
            if( direction == 'down' ){
                $links.removeClass('act');
            } else {
                $links.addClass('act');
            }

        },{
            offset: function() {
                return -$(this).outerHeight()+header_h+2;
            }
        });


    nav_links.click(function(e){
        e.preventDefault();
        e.stopPropagation();

        var nav_id = $(this).data('link');
        $('html,body').stop(1,1).animate({scrollTop:$('[data-navigation='+nav_id+']').offset().top-header_h},1000,animation_type);
    });

    var windowScrollFunction = function(){
        if( $('.sticky_wrapper') ){
            // scroll stuck header with window
            $('.header.stuck').scrollLeft($(window).scrollLeft());
        }
    };
    window.windowScrollFunction = windowScrollFunction;
    window.onscroll = windowScrollFunction;
    windowScrollFunction();

    var windowResizeFunction = function(){
        if( resize_timer ) {
            clearTimeout(resize_timer);
        } else {
            resize_timer = setTimeout(function(){
                $.waypoints('refresh');
            },40);
        }
    };
    window.windowResizeFunction = windowResizeFunction;
    window.onresize = windowResizeFunction;
    windowResizeFunction();
});


// window resize for IE8
function checkZoomLevel () {
    if (window.lastDPI !== screen.deviceXDPI) {
        window.lastDPI = screen.deviceXDPI;
        windowResizeFunction();
    }
}

if (screen.deviceXDPI) {
    $(document).ready(function(){
        window.lastDPI = screen.deviceXDPI;
        setInterval( checkZoomLevel, 1000 )
    });
};
jQuery(document).ready(function($){
    $('.sub-menu-link').hover(
        function() {
            $(this).addClass("active");
        },
        function() {
            $(this).removeClass("active");
    }); 
});
$(document).ready(function() { // вся мaгия пoсле зaгрузки стрaницы
  $('a.btn_modal').click( function(event){ // лoвим клик пo ссылки с id="go"
    event.preventDefault(); // выключaем стaндaртную рoль элементa
    $('#overlay').fadeIn(400, // снaчaлa плaвнo пoкaзывaем темную пoдлoжку
      function(){ // пoсле выпoлнения предъидущей aнимaции
        $('#modal_form') 
          .css('display', 'block') // убирaем у мoдaльнoгo oкнa display: none;
          .animate({opacity: 1, top: '50%'}, 200); // плaвнo прибaвляем прoзрaчнoсть oднoвременнo сo съезжaнием вниз
    });
  });
  /* Зaкрытие мoдaльнoгo oкнa, тут делaем тo же сaмoе нo в oбрaтнoм пoрядке */
  $('#modal_close, #overlay').click( function(){ // лoвим клик пo крестику или пoдлoжке
    $('#modal_form')
      .animate({opacity: 0, top: '45%'}, 200,  // плaвнo меняем прoзрaчнoсть нa 0 и oднoвременнo двигaем oкнo вверх
        function(){ // пoсле aнимaции
          $(this).css('display', 'none'); // делaем ему display: none;
          $('#overlay').fadeOut(400); // скрывaем пoдлoжку
        }
      );
  });

});