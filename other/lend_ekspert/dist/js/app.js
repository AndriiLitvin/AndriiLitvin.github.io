$(document).ready(function(){$.fn.viewportChecker=function(e){var i={classToAdd:"visible",offset:100,callbackFunction:function(e){}};$.extend(i,e);var o=this,a=$(window).height();this.checkElements=function(){var e=navigator.userAgent.toLowerCase().indexOf("webkit")!=-1?"body":"html",d=$(e).scrollTop(),s=d+a;o.each(function(){var e=$(this);if(!e.hasClass(i.classToAdd)){var o=Math.round(e.offset().top)+i.offset,a=o+e.height();o<s&&a>d&&(e.addClass(i.classToAdd),i.callbackFunction(e))}})},$(window).scroll(this.checkElements),this.checkElements(),$(window).resize(function(e){a=e.currentTarget.innerHeight})},$(".box-title").click(function(){$(this).toggleClass("active"),$(this).parent(".answer-box").find(".box-info").slideToggle(400)}),$(".modal-btn").click(function(){$("#"+$(this).data("modal")).show(),$("body").addClass("overl-h"),$(".overlow-modal").show()}),$(".overlow-modal, .close").click(function(){$("body").removeClass("overl-h"),$(".modal").hide(),$(".overlow-modal").hide()}),$(window).width()>1200&&($(".right").addClass("hidden_animation").viewportChecker({classToAdd:"visible animated fadeInRight",offset:0}),$(".left, .question-list li, .program-box, .answer-box").addClass("hidden_animation").viewportChecker({classToAdd:"visible animated fadeInLeft",offset:0}),$(".up").addClass("hidden_animation").viewportChecker({classToAdd:"visible animated fadeInUp",offset:0}),$(".down").addClass("hidden_animation").viewportChecker({classToAdd:"visible animated fadeInDown",offset:0}),$(".zmnd").addClass("hidden_animation").viewportChecker({classToAdd:"visible animated zoomInDown",offset:0}),$(".flp").addClass("hidden_animation").viewportChecker({classToAdd:"visible animated tada",offset:10}))});