$(document).ready(function() { 

	$('.slider-arr-right').click(function() {
	    $($('.slider-box li.active').next()).find('a').trigger( "click" );

	    $( '.slider' ).append( $( '.slider .slide-img' ).first().clone() );
	    $( '.slider .slide-img ' ).first().remove();
	});

	$('.slider-arr-left').click(function() {
	    
	    $( '.slider' ).prepend( $( '.slider .slide-img' ).last().clone() );
	    $( '.slider .slide-img ' ).last().remove();
	    $($('.slider-box li.active').prev()).find('a').trigger( "click" );
	});

	 var waypoint_statistics = new Waypoint({
	  element: $('.statistics .statistics-box-title'),
	  handler: function(dir) {
	    if (dir == 'up') {
	      $(".statistics-img img").rotate(+60);
	    }else{
	      $(".statistics-img img").rotate(0);
	    }
	  },
	  offset: '40%'
	});
	 $('.carousel-indicators li').click(function(){
	 	$('.carousel-indicators li').removeClass('active');
	 	$(this).addClass('active');
	 });
	 $('.right.carousel-control').click(function(){
	 	$('.carousel-indicators li.active').next().trigger( "click" );
	 })
	 $('.left.carousel-control').click(function(){
	 	$('.carousel-indicators li.active').prev().trigger( "click" );
	 });

	if ($(window).width() < 1200) {
		$('.mobile-btn').click(function(){
			$('.menu').toggle();
		});
		$('.menu-item').click(function(){
			$('.menu').toggle();
		});
	}

});