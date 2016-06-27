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
        var max_number_local, max_number, placesWidth, placesWidth_local;
       
        max_number = getRandomInt(1, 300);
        placesWidth = (300 - max_number)/ 300 *100;

        /*if (max_number_local != null && max_number_local < max_number) {
            max_number = localStorage.getItem("max_number_local");
            placesWidth = localStorage.getItem("placesWidth_local");
        }

        max_number_local = localStorage.setItem("max_number_local", max_number);
        placesWidth_local = localStorage.setItem("placesWidth_local", placesWidth);*/
  

      var padding_zeros = '';
      for(var i = 0, l = max_number.toString().length; i < l; i++) {
        padding_zeros += '0';
      }

      var padded_now, numberStep = function(now, tween) {
        var target = $(tween.elem),
            rounded_now = Math.round(now);

        var rounded_now_string = rounded_now.toString()
        padded_now = padding_zeros + rounded_now_string;
        padded_now = padded_now.substring(rounded_now_string.length);

        target.prop('number', rounded_now).text(padded_now);
      };

        $('#lines').animateNumber({
          number: max_number,
          numberStep: numberStep
        }, 5000);

        $('.places').css({
            width : placesWidth + '%',
            transition : '5s',
        });


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

    if ($(window).width() > 1024) {}

        var liSkills = $('.skills-item');
        var indexActive = 0;

        var $brain = $('.skills-img img');


        function animateSkills() {
          var itemActive = $(liSkills[indexActive]);
          itemActive.animate({opacity: 0}, 1500);
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
});


    