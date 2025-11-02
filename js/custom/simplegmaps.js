jQuery(document).ready(function(){ 
	
	jQuery('.map_shortcode_wrapper').each(function(){
		var mapWrapper = jQuery(this);
		var mapWrapperID = jQuery(this).attr('id');
		var mapType = jQuery(this).attr('data-maptype');
		var mapZoom = jQuery(this).attr('data-zoom');
		var mapStyles = '';
		if (typeof tgMap.styles != "undefined")
		{
			mapStyles = JSON.parse(tgMap.styles);
		}

		mapWrapper.simplegmaps(
			{ MapOptions: { mapTypeId: google.maps.MapTypeId.mapType, zoom: parseInt(mapZoom), scrollwheel: false, styles: mapStyles } }
		); 
	});
});