jQuery(document).ready(function() {
	var gutter = jQuery("#single_recent_portfolio").attr('data-gutter');
	var columns = jQuery("#single_recent_portfolio").attr('data-columns');
	var type = jQuery("#single_recent_portfolio").attr('data-type');
	var layout = jQuery("#single_recent_portfolio").attr('data-layout');
	var pageID = jQuery("#single_recent_portfolio").attr('data-page-id');
	
	jQuery("#single_recent_portfolio").imagesLoaded().done( function( instance ) {
		setTimeout(function(){
			jQuery('#single_recent_portfolio').masonry({
			  itemSelector: '.element',
			  columnWidth: '.element',
			  gutter: parseInt(gutter),
			  percentPosition: true,
			  transitionDuration: 0,
			});
	
		    jQuery("#single_recent_portfolio").children(".element").children(".gallery_type").each(function(){
		        jQuery(this).addClass("fade-in");
		    });
		    
		    jQuery(window).trigger('hwparallax.reconfigure');
		}, 500);
	});
});