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
     

	  

        $('.registr-btn').click(function(){
    	    var destination = $(".head-form").offset().top - 50;
    	    $("body,html").animate({ scrollTop: destination}, 500 );
    	});



        function getRandomInt(min, max) {
          return Math.floor(Math.random() * (max - min + 1)) + min;
        }

        var max_number_local = 0, 
            left_tickets = 0, 
            cursor_position = 0, 
            cursor_position_local = 0, 
            period = 0, 
            count = 0,
            max_tickets = 300,
            prev_left_tickets = max_tickets;
       
        left_tickets = localStorage.left_tickets || getRandomInt(125, 150);
        localStorage.left_tickets = left_tickets;

        function registr() {
            period = getRandomInt(5000, 50000);
            prev_left_tickets = left_tickets;
                left_tickets = left_tickets - getRandomInt(1, 5);
            if (left_tickets < 10) {
                left_tickets = 10;
            }
            localStorage.left_tickets = left_tickets;

            cursor_position = (max_tickets - left_tickets)/ max_tickets *100;
            count++;

            if (count == 1) {
                prev_left_tickets = max_tickets;
            }


            $('#lines')
              .prop('number', prev_left_tickets)
              .animateNumber({
                  number: left_tickets,
                },
                5000,
                'linear'
              );

            $('.cursor').css({
                left : cursor_position + '%',
                transition : '5s',
            });
        }

        registr();
        setInterval(registr, period );

        $('.icon-hover_4').hover(function() {
            screen_interval_1 = setInterval(function(){
                $('.hover_4').not(this).animate({left: -20}, 400);
                setTimeout(function(){
                    $('.hover_4').not(this).animate({left: 20}, 400);
                }, 450);
                
            }, 800);
        },
        function() {
            clearInterval(screen_interval_1);
            $('.hover_4').not(this).animate({left: 0}, 500);
        });


    $("#xray-block").xray({x_width:25,x_height:35});

    if ($(window).width() > 1024) {
        var liSkills = $('.skills-item');
        var indexActive = 0;

        var $brain = $('.skills-img');


        function animateSkills() {
          var itemActive = $(liSkills[indexActive]);
          // itemActive.animate({opacity: 0}, 1500);
          $brain.addClass('brain-off');

          var nextItem = liSkills[++indexActive];
          if (!nextItem) {
            indexActive = 0;
            nextItem = liSkills[indexActive];
          }
           setTimeout(function() {
                $(nextItem).animate({
                    opacity: 1
                }, 1500);
                $brain.removeClass('brain-off');
           }, 1500)
        }
        setInterval(animateSkills, 6000);
        
    }

});


    