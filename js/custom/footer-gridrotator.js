jQuery(document).ready(function(){ 
	var gridWrapper = jQuery( '#footer_photostream' );
	if (typeof tgFooterParams.gridID != "undefined")
	{
		var gridWrapper = jQuery( '#'+tgFooterParams.gridID );
	}
	
	var rows = 1;
	if (typeof tgFooterParams.rows != "undefined")
	{
		var rows = tgFooterParams.rows;
	}
			
    gridWrapper.gridrotator( {
    	rows : rows,
		columns : 8,
		interval : 2000,
		w1024 : {
		    rows : 1,
		    columns : 8
		},
		w768 : {
		    rows : 1,
		    columns : 6
		},
		w480 : {
		    rows : 2,
		    columns : 4
		},
		w320 : {
		    rows : 2,
		    columns : 3
		},
		w240 : {
		    rows : 2,
		    columns : 2
		},
    } );
});