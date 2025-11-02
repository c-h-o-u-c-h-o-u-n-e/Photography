jQuery(document).ready(function(){ 
	jQuery('.gallery_gridrotator').each(function(){
		var gridWrapper = jQuery(this);
		var rows = jQuery(this).attr('data-rows');
	
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
});