jQuery(document).ready(function() {
	jQuery('.tg_animate_counter').each(function(){
		var endNumber = jQuery(this).attr('data-end');
		var elementID = jQuery(this).attr('id');
		
		setTimeout(function(){
		    jQuery('#'+elementID).html(endNumber);
		}, 1000);
	});
});