<?php 
header("content-type: application/x-javascript"); 

$pp_gallery_cat = '';
	
if(isset($_GET['gallery_id']))
{
    $pp_gallery_cat = $_GET['gallery_id'];
}

$all_photo_arr = get_post_meta($pp_gallery_cat, 'wpsimplegallery_gallery', true);

//Get global gallery sorting
$all_photo_arr = photography_resort_gallery_img($all_photo_arr);

$count_photo = count($all_photo_arr);

//Get timer setting				
$tg_kenburns_timer = get_theme_mod('tg_kenburns_timer', 7);

if(empty($tg_kenburns_timer))
{
	$tg_kenburns_timer = 5000;
}
else
{
	$tg_kenburns_timer = $tg_kenburns_timer*1000;
}

//Get zoom level
$tg_kenburns_zoom = get_theme_mod('tg_kenburns_zoom', 2);
if(empty($tg_kenburns_zoom))
{
	$tg_kenburns_zoom = 1.1;
}
else
{
	$tg_kenburns_zoom = 1+($tg_kenburns_zoom/10);
}

//Get transition speed
$tg_kenburns_trans = get_theme_mod('tg_kenburns_trans', 1000);
if(empty($tg_kenburns_trans))
{
	$tg_kenburns_trans = 1000;
}

$pp_kenburns_frames_rate = 100;
?>					  
jQuery(document).ready(function(){ 
	var $canvas = jQuery('#kenburns');
	
    $canvas.attr('width', jQuery(window).width());
    $canvas.attr('height', jQuery(window).height());

    var kb = $canvas.kenburned({
        images : [
        <?php
	    	$key = 0;
	        foreach($all_photo_arr as $photo_id)
	        {
	            $image_url = wp_get_attachment_image_src($photo_id, 'original', true);
	    
	    ?>
	    		'<?php echo esc_url($image_url[0]); ?>'
	    <?php
	    		if($count_photo > ($key+1))
	    		{
	    			echo ',';
	    		}
	    		$key++;
	    	}
	    ?>
        ],
        frames_per_second: <?php echo esc_js($pp_kenburns_frames_rate); ?>,
	    display_time: <?php echo esc_js($tg_kenburns_timer); ?>,
	    zoom: <?php echo esc_js($tg_kenburns_zoom); ?>,
	    fade_time: <?php echo esc_js($tg_kenburns_trans); ?>,
    });
    
    jQuery(window).resize(function() {
		jQuery('#kenburns').remove();
		jQuery('#kenburns_overlay').remove();
		
		jQuery('body #wrapper').append('<canvas id="kenburns"></canvas>');
		jQuery('body #wrapper').append('<div id="kenburns_overlay"></div>');
	
	  	var $canvas = jQuery('#kenburns');

	    $canvas.attr('width', jQuery(window).width());
	    $canvas.attr('height', jQuery(window).height());
	
	    var kb = $canvas.kenburned({
	        images : [
	        <?php
		    	$key = 0;
		        foreach($all_photo_arr as $photo_id)
		        {
		            $image_url = wp_get_attachment_image_src($photo_id, 'original', true);
		    
		    ?>
		    		'<?php echo esc_url($image_url[0]); ?>'
		    <?php
		    		if($count_photo > ($key+1))
		    		{
		    			echo ',';
		    		}
		    		$key++;
		    	}
		    ?>
	        ],
	        frames_per_second: <?php echo esc_js($pp_kenburns_frames_rate); ?>,
		    display_time: <?php echo esc_js($tg_kenburns_timer); ?>,
		    zoom: <?php echo esc_js($tg_kenburns_zoom); ?>,
		    fade_time: <?php echo esc_js($tg_kenburns_trans); ?>,
	    });
	});
    
    jQuery('#kb-prevslide ').click(function(ev) {
        ev.preventDefault();
        kb.prevSlide();
    });

    jQuery('#kb-nextslide').click(function(ev) {
        ev.preventDefault();
        kb.nextSlide();
    });
		
});