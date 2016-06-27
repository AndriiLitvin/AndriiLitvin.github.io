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

       
     


	$("#phone").inputmask("+38(999)999-99-99"); //маска
	  $('#registration-form').on('submit', function (e) {
	    $('#registration-btn').addClass('inactive');
	    $('#registration-btn').prop('disabled', true);
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

    }
         $("#xray-block").xray({x_width:25,x_height:35});

});


    