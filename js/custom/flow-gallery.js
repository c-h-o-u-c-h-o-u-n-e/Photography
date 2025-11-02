jQuery(document).ready(function() {
	var calScreenWidth = jQuery(window).width();
	var imgFlowSize = 0.6;
	if(calScreenWidth > 480)
	{
	imgFlowSize = 0.4;
	}
	else
	{
	imgFlowSize = 0.2;
	}
	
	var galleryID = tgFlowParams.galleryID;

	if (typeof galleryID != "undefined")
	{
		if (tgFlowParams.cache != 0)
		{
			imf.create("imageFlow", tgFlowParams.cache, 0.6, 0.4, 0, 10, 8, 4);
		}
		else
		{
			imf.create("imageFlow", tgFlowParams.ajaxurl+'?action=photography_script_image_flow&gallery_id='+galleryID, 0.6, 0.4, 0, 10, 8, 4);
		}
	}
	else
	{
		if (tgFlowParams.cache != 0)
		{
			imf.create("imageFlow", tgFlowParams.cache, 0.6, 0.4, 0, 10, 8, 4);
		}
		else
		{
			imf.create("imageFlow", tgFlowParams.ajaxurl+'?action=photography_script_image_flow', 0.6, 0.4, 0, 10, 8, 4);
		}
	}
});