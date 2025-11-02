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
	
	var portfolioSetID = tgPortfolioFlowParams.portfolioSet;
	
	if (typeof portfolioSetID != "undefined")
	{
		imf.create("imageFlow", tgPortfolioFlowParams.ajaxurl+'?action=photography_script_image_portfolio_flow&portfolioset='+portfolioSetID, 0.6, 0.4, 0, 10, 8, 4);
	}
	else
	{
		if (tgPortfolioFlowParams.cache != 0)
		{
			imf.create("imageFlow", tgPortfolioFlowParams.cache, 0.6, 0.4, 0, 10, 8, 4);
		}
		else
		{
			imf.create("imageFlow", tgPortfolioFlowParams.ajaxurl+'?action=photography_script_image_portfolio_flow', 0.6, 0.4, 0, 10, 8, 4);
		}
	}
});