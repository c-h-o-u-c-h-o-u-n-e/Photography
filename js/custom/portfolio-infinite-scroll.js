function loadPortfolioImage(wrapperID)
{
	if(jQuery('#'+wrapperID+'_status').val() == 0)
	{
		var currentOffset = parseInt(jQuery('#'+wrapperID+'_offset').val());
		jQuery('#'+wrapperID+'_loading').addClass('visible');
		
		var gutter = jQuery("#"+wrapperID).attr('data-gutter');
		var columns = parseInt(jQuery("#"+wrapperID).attr('data-columns'));
		var filter = jQuery("#"+wrapperID).attr('data-filter');
		var nextAction = jQuery("#"+wrapperID).attr('data-next-action');
		var cat = jQuery("#"+wrapperID).attr('data-cat');
		var type = jQuery("#"+wrapperID).attr('data-type');
		var layout = jQuery("#"+wrapperID).attr('data-layout');
		var items = parseInt(jQuery("#"+wrapperID).attr('data-items'));
		var itemsIni = parseInt(jQuery("#"+wrapperID).attr('data-items-ini'));
		var order = jQuery("#"+wrapperID).attr('data-order');
		var orderBy = jQuery("#"+wrapperID).attr('data-order-by');
	
		jQuery.ajax({
	        url: tgPortfolioInParams.ajaxurl,
	        type:'POST',
			cache: true,
	        data: 'action='+nextAction+'&cat='+cat+'&items='+items+'&items_ini='+itemsIni+'&offset='+currentOffset+'&columns='+columns+'&type='+type+'&order='+order+'&order_by='+orderBy+'&layout='+layout+'&tg_security='+tgPortfolioInParams.ajax_nonce, 
	        success: function(html)
	        {
		        if(html != '')
		        {
	        		jQuery('#'+wrapperID+'_offset').val(parseInt(currentOffset+itemsIni));
	        	}
	        	else
	        	{
		        	var currentTotal = parseInt(jQuery('#'+wrapperID+'_total').val());
		        	jQuery('#'+wrapperID+'_offset').val(currentTotal);
	        	}
	        	
	            var htmlObj = jQuery(html);
				
				jQuery('#'+wrapperID).append(htmlObj).imagesLoaded().done( function( instance ) {
					setTimeout(function(){
						jQuery('#'+wrapperID).masonry('appended',htmlObj, true);
						
						jQuery('#'+wrapperID).children('.element').children('.gallery_type').each(function(){
						    jQuery(this).addClass('fade-in');
					    });
					}, 500);
				});
				
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
	jQuery('.infinite_portfolio').each(function(){
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
		        loadPortfolioImage(wrapperID);
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
		    		loadPortfolioImage(wrapperID);
		    	}
		    }
		});
		
		if(filter==1)
		{
			var gutter = jQuery("#"+wrapperID).attr('data-gutter');
			var columns = parseInt(jQuery("#"+wrapperID).attr('data-columns'));
			var filter = jQuery("#"+wrapperID).attr('data-filter');
			var nextAction = jQuery("#"+wrapperID).attr('data-next-action');
			var cat = jQuery("#"+wrapperID).attr('data-cat');
			var type = jQuery("#"+wrapperID).attr('data-type');
			var layout = jQuery("#"+wrapperID).attr('data-layout');
			var items = parseInt(jQuery("#"+wrapperID).attr('data-items'));
			var itemsIni = parseInt(jQuery("#"+wrapperID).attr('data-items-ini'));
			var order = jQuery("#"+wrapperID).attr('data-order');
			var orderBy = jQuery("#"+wrapperID).attr('data-order-by');
			
			jQuery('#portfolio_wall_filters_'+wrapperID+' li a, #portfolio_wall_filters li a').click(function(){
			  	var selector = jQuery(this).attr('data-filter');
			  	
			  	jQuery('#portfolio_wall_filters_'+wrapperID+' li a, #portfolio_wall_filters li a').removeClass('active');
			  	jQuery(this).addClass('active');
	
			  	jQuery('#'+wrapperID).addClass('loading');
			  	
			  	jQuery.ajax({
			        url: tgPortfolioInParams.ajaxurl,
			        type:'POST',
					cache: true,
			        data: 'action='+nextAction+'&cat='+selector+'&items=-1&columns='+columns+'&type='+type+'&layout='+layout+'&tg_security='+tgPortfolioInParams.ajax_nonce, 
			        success: function(html)
			        {
				       	jQuery("#"+wrapperID).masonry('destroy');
			        	jQuery("#"+wrapperID).html(html);
			        	
			        	jQuery("#"+wrapperID).imagesLoaded().done( function( instance ) {
				        	jQuery("#"+wrapperID).masonry({
							  itemSelector: '.element',
							  columnWidth: '.element',
							  gutter: 30,
							  percentPosition: true,
							  transitionDuration: 0,
							});
							
							jQuery("#"+wrapperID).children(".element").children(".gallery_type").each(function(){
						        jQuery(this).addClass("fade-in");
						    });
						});
						
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
						
						jQuery("#"+wrapperID).removeClass('loading');
						jQuery('#'+wrapperID+'_total').val(0);
						
						setTimeout(function(){
							jQuery(window).scroll();
						}, 2000);
			        }
			    });
			  	
			  	return false;
			});
		}
	});
});