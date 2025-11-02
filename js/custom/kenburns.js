jQuery(document).ready(function(){ 
	var $canvas = jQuery('#kenburns');
	var galleryImages = JSON.parse(tgKenburnsParams.images);

	var timer = $canvas.attr('data-timer');
	var zoom = $canvas.attr('data-zoom');
	var trans = $canvas.attr('data-trans');

    $canvas.attr('width', jQuery(window).width());
    $canvas.attr('height', jQuery(window).height());

    var kb = $canvas.kenburned({
        images : galleryImages,
	    frames_per_second: 100,
		display_time: parseInt(timer),
		zoom: parseFloat(zoom),
		fade_time: parseInt(trans),
    });
    
    jQuery(window).resize(function() {
		jQuery('#kenburns').remove();
		jQuery('#kenburns_overlay').remove();
		
		jQuery('body #wrapper').append('<canvas id="kenburns"></canvas>');
		jQuery('body #wrapper').append('<div id="kenburns_overlay"></div>');
	
	  	var $canvas = jQuery('#kenburns');

	    $canvas.attr('width', jQuery(window).width());
	    $canvas.attr('height', jQuery(window).height());
	
	    var kb = $canvas.kenburned({
	        images : galleryImages,
	        frames_per_second: 100,
		    display_time: parseInt(timer),
		    zoom: parseFloat(zoom),
		    fade_time: parseInt(trans),
	    });
	});
    
    jQuery('#kb-prevslide ').click(function(ev) {
        ev.preventDefault();
        kb.prevSlide();
    });

    jQuery('#kb-nextslide').click(function(ev) {
        ev.preventDefault();
        kb.nextSlide();
    });
		
});