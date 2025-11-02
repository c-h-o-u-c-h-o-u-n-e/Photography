jQuery(document).ready(function() {
	jQuery("#portfolio_mixed_filter_wrapper").imagesLoaded().done( function( instance ) {
		var gutter = jQuery("#portfolio_mixed_filter_wrapper").attr('data-gutter');
		
		setTimeout(function(){
			jQuery('#portfolio_mixed_filter_wrapper').masonry({
			  itemSelector: '.element',
			  columnWidth: '.element.normal_size',
			  gutter: parseInt(gutter),
			  percentPosition: true,
			  transitionDuration: 0,
			});
	
		    jQuery("#portfolio_mixed_filter_wrapper").children(".element").children(".gallery_type").each(function(){
		        jQuery(this).addClass("fade-in");
		    });
		    
		    jQuery(window).trigger('hwparallax.reconfigure');
		}, 500);
	});
	
	jQuery('.portfolio_mixed_filter_wrapper').each(function(){
		var gridWrapper = jQuery(this);
		var gutter = gridWrapper.attr('data-gutter');

		setTimeout(function(){
			gridWrapper.masonry({
			  itemSelector: '.element',
			  columnWidth: '.element.normal_size',
			  gutter: parseInt(gutter),
			  percentPosition: true,
			  transitionDuration: 0,
			});
	
		    gridWrapper.children(".element").children(".gallery_type").each(function(){
		        jQuery(this).addClass("fade-in");
		    });
		    
		    jQuery(window).trigger('hwparallax.reconfigure');
		}, 500);
	});
});