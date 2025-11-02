function infiniteLoadGalleryImage(wrapperID)
{
	if(jQuery('#'+wrapperID+'_status').val() == 0)
	{
		var currentOffset = parseInt(jQuery('#'+wrapperID+'_offset').val());
		jQuery('#'+wrapperID+'_loading').addClass('visible');
		
		var galleryID = jQuery('#'+wrapperID).attr('data-gallery-id');
		var items = parseInt(jQuery('#'+wrapperID).attr('data-items'));
		var columns = parseInt(jQuery('#'+wrapperID).attr('data-columns'));
		var type = jQuery('#'+wrapperID).attr('data-type');
		
		jQuery.ajax({
	        url: tgGalleryInfiniteParams.ajaxurl,
	        type:'POST',
			cache: true,
	        data: 'action=photography_gallery_grid&gallery_id='+galleryID+'&items='+items+'&offset='+currentOffset+'&columns='+columns+'&type='+type+'&tg_security='+tgGalleryInfiniteParams.ajax_nonce, 
	        success: function(html)
	        {
	        	jQuery('#'+wrapperID+'_offset').val(parseInt(currentOffset+items));
	            
	            if(type == 'grid')
	            {
		            jQuery('#'+wrapperID).append(html);
		            
		            jQuery('#'+wrapperID).imagesLoaded().done( function( instance ) {
			            setTimeout(function(){
							jQuery('#'+wrapperID).children('.element').children('.gallery_type').each(function(){
							    jQuery(this).addClass('fade-in');
						    });
						}, 500);
					});
				}
				else
				{
					var htmlObj = jQuery(html);
				
					jQuery('#'+wrapperID).append(htmlObj).imagesLoaded().done( function( instance ) {
						setTimeout(function(){
							jQuery('#'+wrapperID).masonry('appended',htmlObj, true);
							
							jQuery('#'+wrapperID).children('.element').children('.gallery_type').each(function(){
							    jQuery(this).addClass('fade-in');
						    });
					    }, 500);
					});
				}
	        				
				if(jQuery('#tg_lightbox_enable').val() != '')
				{
					if(jQuery('#tg_lightbox_plugin').val() == 'modulobox')
					{
						mobx.destroy();
						mobx.init();
					}
					else
					{
						jQuery(document).setLightbox();
					}
				}
				
				jQuery('#'+wrapperID+'_loading').removeClass('visible');
	        }
	    });
	}
}

jQuery(window).load(function(){ 
	jQuery('.infinite_grid').each(function(){
		var wrapperID = jQuery(this).attr('id');
		
		jQuery(document).ajaxStart(function() {
		  	jQuery('#'+wrapperID+'_status').val(1);
		});
		
		jQuery(document).ajaxStop(function() {
		  	jQuery('#'+wrapperID+'_status').val(0);
		});
	
		if (jQuery(document).height() <= jQuery(window).height())
		{
	        var currentOffset = parseInt(jQuery('#'+wrapperID+'_offset').val());
			var total = parseInt(jQuery('#'+wrapperID+'_total').val());
			
			if (currentOffset > total)
		    {
		        return false;
		    }
		    else
		    {
		        infiniteLoadGalleryImage(wrapperID);
		    }
	    }
	
		jQuery(window).on('scroll', function() {
			var currentOffset = parseInt(jQuery('#'+wrapperID+'_offset').val());
			var total = parseInt(jQuery('#'+wrapperID+'_total').val());
			var wrapperHeight = jQuery(this).height();
			
			if(jQuery(window).height() > 1000)
			{
			    var targetOffset = parseInt(jQuery('#'+wrapperID).offset().top/2);
			}
			else
			{
			    var targetOffset = jQuery('#'+wrapperID).offset().top;
			}
	
		
		    if(jQuery(window).scrollTop() > targetOffset)
		    {
		    	if (currentOffset >= total)
		    	{
		    		return false;
		    	}
		    	else
		    	{
		    		infiniteLoadGalleryImage(wrapperID);
		    	}
		    }
		});
	});
});