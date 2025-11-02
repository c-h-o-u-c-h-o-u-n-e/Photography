jQuery(document).ready(function() {
	jQuery('.slider_wrapper').each(function(){
		var autoplay = jQuery(this).attr('data-autoplay');
		var timer = jQuery(this).attr('data-timer');
		
		jQuery(this).flexslider({
	      animation: "fade",
	      animationLoop: true,
	      itemMargin: 0,
	      minItems: 1,
	      maxItems: 1,
	      slideshow: parseInt(autoplay),
	      controlNav: false,
	      smoothHeight: true,
	      slideshowSpeed: parseInt(timer*1000),
	      animationSpeed: 1000,
	      move: 1
		});
	});
});