jQuery(function($){
		var galleryImages = JSON.parse(tgGalleryParams.images);
		alert(galleryImages);
		console.log(galleryImages);
		$.supersized({
		
						//Functionality
			slideshow               :   1,		//Slideshow on/off
			autoplay				:	1,		//Slideshow starts playing automatically
			start_slide             :   1,		//Start slide (0 is random)
			random					: 	0,		//Randomize slide order (Ignores start slide)
			slide_interval          :   9000,	//Length between transitions
						transition              :   1, 		//0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
			transition_speed		:	800,	//Speed of transition
			new_window				:	1,		//Image links open in new window/tab
			pause_hover             :   1,		//Pause slideshow on hover
			keyboard_nav            :   1,		//Keyboard navigation on/off
			performance				:	1,		//0-Normal, 1-Hybrid speed/quality, 2-Optimizes image quality, 3-Optimizes transition speed // (Only works for Firefox/IE, not Webkit)
			image_protect			:	0,		//Disables image dragging and right click with Javascript

			//Size & Position
			min_width		        :   0,		//Min width allowed (in pixels)
			min_height		        :   0,		//Min height allowed (in pixels)
			vertical_center         :   1,		//Vertically center background
			horizontal_center       :   1,		//Horizontally center background
						fit_portrait         	:   0,		//Portrait images will not exceed browser height
			fit_landscape			:   0,		//Landscape images will not exceed browser width
			fit_always				: 	0,
			
			//Components
			navigation              :   0,		//Slideshow controls on/off
			thumbnail_navigation    :  	0,		//Thumbnail navigation
			slide_counter           :   0,		//Display slide numbers
			slide_captions          :   0,		//Slide caption (Pull from "title" in slides array)
			progress_bar			:	0,
			slides 					:  	galleryImages
										
		}); 
	});

jQuery(document).ready(function(){ 
	jQuery('html[data-style=fullscreen]').touchwipe({
		wipeLeft: function(){ 
			api.prevSlide();
		  },
		   wipeRight: function(){ 
			   api.nextSlide();
		   }
	});
	
	var isDisableDragging = jQuery('#pp_enable_dragging').val();
	
	if(isDisableDragging!='')
	{
		jQuery("img").mousedown(function(){
			return false;
		});
	}
});