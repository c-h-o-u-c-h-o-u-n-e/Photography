jQuery(document).ready(function() {
	jQuery("#portfolio_filter_wrapper").imagesLoaded().done( function( instance ) {
		setTimeout(function(){
		    jQuery("#portfolio_filter_wrapper").children(".element").children(".gallery_type").each(function(){
		        jQuery(this).addClass("fade-in");
		    });
	    }, 500);
	    
	    jQuery(window).trigger('hwparallax.reconfigure');
	});
	
	jQuery('.portfolio_filter_wrapper').each(function(){
		var gridWrapper = jQuery(this);
		
		gridWrapper.imagesLoaded().done( function( instance ) {
			setTimeout(function(){
			    gridWrapper.children(".element").children(".gallery_type").each(function(){
			        jQuery(this).addClass("fade-in");
			    });
		    }, 500);
		    
		    jQuery(window).trigger('hwparallax.reconfigure');
		});
	});
	
	jQuery('.portfolio_mixed_filter_wrapper').each(function(){
		var gridWrapper = jQuery(this);
		
		gridWrapper.imagesLoaded().done( function( instance ) {
			setTimeout(function(){
			    gridWrapper.children(".element").children(".gallery_type").each(function(){
			        jQuery(this).addClass("fade-in");
			    });
		    }, 500);
		    
		    jQuery(window).trigger('hwparallax.reconfigure');
		});
	});
});