$(function(){
var slides = $('.step-image');
var currentSlide = 0;
		
function nextSlide() {
	goToSlide($(this).siblings('.step-image'), currentSlide+1);
};

function previousSlide() {
   goToSlide($(this).siblings('.step-image'),currentSlide-1);
};

function goToSlide(img, n) {
    img[currentSlide].className = 'step-image';
    currentSlide = (n+img.length)%img.length;
    img[currentSlide].className = 'step-image showing';
};	
$('.slider-button-right').click(nextSlide);

$('.slider-button-left').click(previousSlide);
});

$(function(){
function randomPage(){
  			var number = Math.floor((Math.random() * 20)+1);
  			return number;
		}

	function load(){
			
			var URL = "https://pixabay.com/api/?key=5276352-5eeec9953d725415cb7dab763" + "&q="  + "&image_type=photo" + "&min_width=350" + + "&min_height=300" + "&page=" + randomPage() + "&per_page=7" ;
			$.getJSON(URL, function(data){
		    if (parseInt(data.totalHits) > 0 )
	        $.each(data.hits, function(i, hit){
	        	var nom = $("<h4 class='grid__text'></h4>").append(hit.tags);
	        
	        	$("<div class='grid__box persent-size'></div>").appendTo(".grid-block").append("<img class='grid__item ' src=" + hit.webformatURL + ">").append(nom);
	        	
	        	});
	    
			});
	};
		    	  
load();

	function clickFun(e){
		$(".grid__box").detach();
		e.preventDefault();
		var search = $('.holiday-cattegory__search-block').val();
		var URL = "https://pixabay.com/api/?key=5276352-5eeec9953d725415cb7dab763" + "&q=" + search + "&image_type=photo" + "&min_width=350" + "&min_height=300"  + "&page=" + randomPage() + "&per_page=7";
		$.getJSON(URL, function(data){
			
	   if (parseInt(data.totalHits) > 0 )
	        $.each(data.hits, function(i, hit){
	        	var nom = $("<h4 class='grid__text'></h4>").append(hit.tags);
	        
	        	$("<div class='grid__box persent-size'></div>").appendTo(".grid-block").append("<img class='grid__item ' src=" + hit.webformatURL + ">").append(nom);
	        	
	        });
	    
		});
	};

	$('.holiday-cattegory__search-button').click(clickFun);
	
});






