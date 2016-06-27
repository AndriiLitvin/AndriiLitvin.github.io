$(function(){
 $.fn.viewportChecker = function(useroptions){
        // Define options and extend with user
        var options = {
            classToAdd: 'visible',
            offset: 100,
            callbackFunction: function(elem){}
        };
        $.extend(options, useroptions);

        // Cache the given element and height of the browser
        var $elem = this,
            windowHeight = $(window).height();

        this.checkElements = function(){
            // Set some vars to check with
            var scrollElem = ((navigator.userAgent.toLowerCase().indexOf('webkit') != -1) ? 'body' : 'html'),
                viewportTop = $(scrollElem).scrollTop(),
                viewportBottom = (viewportTop + windowHeight);

            $elem.each(function(){
                var $obj = $(this);
                // If class already exists; quit
                if ($obj.hasClass(options.classToAdd)){
                    return;
                }

                // define the top position of the element and include the offset which makes is appear earlier or later
                var elemTop = Math.round( $obj.offset().top ) + options.offset,
                    elemBottom = elemTop + ($obj.height());

                // Add class if in viewport
                if ((elemTop < viewportBottom) && (elemBottom > viewportTop)){
                    $obj.addClass(options.classToAdd);

                    // Do the callback function. Callback wil send the jQuery object as parameter
                    options.callbackFunction($obj);
                }
            });
        };

        // Run checkelements on load and scroll
        $(window).scroll(this.checkElements);
        this.checkElements();

        // On resize change the height var
        $(window).resize(function(e){
            windowHeight = e.currentTarget.innerHeight;
        });
    };



    $(window).scroll(function() {
      return $('.head').toggleClass("header_fixed", $(window).scrollTop() > 0);
    });
	$(document).ready(function() { // вся мaгия пoсле зaгрузки стрaницы
		$('#modal_close, #overlay').click( function(){ // лoвим клик пo крестику или пoдлoжке
			$('#modal_form')
				.animate({opacity: 0, top: '45%'}, 200,  // плaвнo меняем прoзрaчнoсть нa 0 и oднoвременнo двигaем oкнo вверх
					function(){ // пoсле aнимaции
						$(this).css('display', 'none'); // делaем ему display: none;
					}
				);
		});
	});    
     


	$("#phone").inputmask("+38(999)999-99-99"); //маска
	  $("#phone_1").inputmask("+38(999)999-99-99"); //маска
	  $('#registration-form').on('submit', function (e) {
	    $('#registration-btn').addClass('inactive');
	    $('#registration-btn').prop('disabled', true);
	  });
	  $('#registration-form_1').on('submit', function (e) {
	    $('#registration-btn_1').addClass('inactive');
	    $('#registration-btn_1').prop('disabled', true);
	  });

        $('.menu-mob').click(function () {
	        $('.menu').toggle();
	        $('.head').toggleClass('white-bg');
	        $('.head-logo img').toggleClass('invert');
	    });

    $('.trends').click(function(){
	    var destination = $(".advantages").offset().top - 50;
	    $("body,html").animate({ scrollTop: destination}, 500 );
	});




    if ($(window).width() > 1024) {

         var waypoint_trends = new Waypoint({
            element: $('.advantages'),
            handler: function(dir) {
                if (dir == 'up') {
                    $('.trends').removeClass('active');
                } else {
                    $('.trends').toggleClass('active');
                    $('.review').removeClass('active');
                }
              },
              offset: '30%'
            });
        

        $('.head-logo').addClass("hidden_animation").viewportChecker({
            classToAdd: 'visible animated fadeInDown', // Class to add to the elements when they are visible
            offset: 0    
        });

         $("#xray-block").xray({x_width:25,x_height:35});
    }

});


    