<?php
/**
 * The template for displaying the footer.
 *
 * @package WordPress
 */

$photography_footer_content = get_theme_mod('photography_footer_content', 'sidebar');

if(is_single() && $post->post_type == 'galleries')
{
	//Check if password protected
	$gallery_password = get_post_meta($post->ID, 'gallery_password', true);
	
	if(!empty($gallery_password) && !isset($_SESSION['gallery_page_'.$post->ID]))
	{
		$photography_footer_content = 'hide';
	}
}

//Check if hide footer option is activated
$photography_page_hide_footer_default = 0;

//If a normal page
if(is_page())
{
	//Check if hide footer
	$photography_page_hide_footer_default = get_post_meta($post->ID, 'page_hide_footer', false);
}

// This is a 404 not found page
if( is_404() ) {
	$tg_pages_template_404 = get_theme_mod('tg_pages_template_404');
	if(!empty($tg_pages_template_404)) {
		$photography_page_hide_footer_default = get_post_meta($tg_pages_template_404, 'page_hide_footer', false);
	}
}

if(empty($photography_page_hide_footer_default))
{
?>
<div id="footer-wrapper">
<?php
	//if using footer post content
	if($photography_footer_content == 'content')
	{
		if(is_page())
		{
			$photography_footer_content_default = get_post_meta($post->ID, 'page_footer', true);
		}
		else
		{
			$photography_footer_content_default = get_theme_mod('photography_footer_content_default');
		}
		
		// This is a 404 not found page
		if( is_404() ) {
			$tg_pages_template_404 = get_theme_mod('tg_pages_template_404');
			if(!empty($tg_pages_template_404)) {
				$photography_footer_content_default = get_post_meta($tg_pages_template_404, 'page_footer', true);
			}
		}
		
		//If all custom footer page option is empty then use default one
		if(empty($photography_footer_content_default))
		{
			$photography_footer_content_default = get_theme_mod('photography_footer_content_default');
		}
		
		//Add Polylang plugin support
		if (function_exists('pll_get_post')) {
			$photography_footer_content_default = pll_get_post($photography_footer_content_default);
		}
		
		//Add WPML plugin support
		if (function_exists('icl_object_id')) {
			$photography_footer_content_default = icl_object_id($photography_footer_content_default, 'page', false, ICL_LANGUAGE_CODE);
		}
	
		if(!empty($photography_footer_content_default) && class_exists("\\Elementor\\Plugin"))
		{
			echo photography_get_elementor_content($photography_footer_content_default);
		}	
	}
	//end if using footer post content
	
	//if use footer sidebar as content
	else if($photography_footer_content == 'sidebar')
	{
		//Check if blank template
		global $photograhy_is_no_header;
		global $photography_screen_class;
		
		if(!is_bool($photograhy_is_no_header) OR !$photograhy_is_no_header)
		{
	
		global $photography_homepage_style;
		
		//If display photostream
		$pp_photostream = get_option('pp_photostream');
		if(THEMEDEMO && isset($_GET['footer']) && !empty($_GET['footer']))
		{
			$pp_photostream = 0;
		}
		$pp_photostream_row = 1;
		
		if(!empty($pp_photostream) && $photography_homepage_style != 'fullscreen_video')
		{
			$photos_arr = array();
		
			if($pp_photostream == 'flickr')
			{
				$pp_flickr_id = get_option('pp_flickr_id');
				$photos_arr = photography_get_flickr(array('type' => 'user', 'id' => $pp_flickr_id, 'items' => 12));
			}
			else
			{
				$pp_instagram_username = get_option('pp_instagram_username');
				$is_instagram_authorized = photography_check_instagram_authorization();
				
				if(is_bool($is_instagram_authorized) && $is_instagram_authorized)
				{
					$photos_arr = photography_get_instagram_using_plugin('photostream');
				}
				else
				{
					echo $is_instagram_authorized;
				}
			}
			
			if(!empty($photos_arr) && $photography_screen_class != 'split' && $photography_screen_class != 'split wide' && $photography_homepage_style != 'fullscreen' && $photography_homepage_style != 'flow')
			{
				wp_enqueue_script("photography-modernizr", get_template_directory_uri()."/js/modernizr.js", false, THEMEVERSION, true);
				wp_enqueue_script("photography-jquery-gridrotator", get_template_directory_uri()."/js/jquery.gridrotator.js", false, THEMEVERSION, true);
				wp_register_script("photography-script-footer-gridrotator", get_template_directory_uri()."/js/custom/footer-gridrotator.js", false, THEMEVERSION, true);	
				$params = array(
			  	'gridID' => 'footer_photostream',
			  	'rows' => $pp_photostream_row,
				);
				
				wp_localize_script("photography-script-footer-gridrotator", 'tgFooterParams', $params );
				wp_enqueue_script("photography-script-footer-gridrotator", get_template_directory_uri()."/js/custom/footer-gridrotator.js", false, THEMEVERSION, true);
	?>
	<br class="clear"/>
	<div id="footer_photostream" class="footer_photostream_wrapper ri-grid ri-grid-size-3">
		<h2 class="widgettitle photostream">
			<?php
				if($pp_photostream == 'instagram')
				{
			?>
				<a href="https://instagram.com/<?php echo esc_html($pp_instagram_username); ?>" target="_blank">
					<i class="fa fa-instagram marginright"></i><?php echo esc_html($pp_instagram_username); ?>
				</a>
			<?php
				}
				else
				{
			?>
				<i class="fa fa-flickr marginright"></i>Flickr
			<?php
				}
			?>
		</h2>
		<ul>
			<?php
				foreach($photos_arr as $photo)
				{
					if(isset($photo['cache_url']) && !empty($photo['cache_url'])) {
						$thumbnail_arr = wp_get_attachment_image_src($photo['attachment_id'], 'medium', true);
						$thumbnail_url = $thumbnail_arr[0];
					}
					else if(isset($photo['original_url']) && !empty($photo['original_url'])) {
						$thumbnail_url = $photo['original_url'];
					}
			?>
				<li><a target="_blank" href="<?php echo esc_url($photo['link']); ?>"><img src="<?php echo esc_url($thumbnail_url); ?>" alt="" /></a></li>
			<?php
				}
			?>
		</ul>
	</div>
	<?php
			}
		}
	?>
	
	<?php
		//Get Footer Sidebar
		$tg_footer_sidebar = get_theme_mod('tg_footer_sidebar');
		if(THEMEDEMO && isset($_GET['footer']) && !empty($_GET['footer']))
		{
	    	$tg_footer_sidebar = 0;
		}
	?>
	<div class="footer_bar <?php if(isset($photography_homepage_style) && !empty($photography_homepage_style)) { echo esc_attr($photography_homepage_style); } ?> <?php if(!empty($photography_screen_class)) { echo esc_attr($photography_screen_class); } ?> <?php if(empty($tg_footer_sidebar)) { ?>noborder<?php } ?>">
	
		<?php
	    	if(!empty($tg_footer_sidebar))
	    	{
	    		$footer_class = '';
	    		
	    		switch($tg_footer_sidebar)
	    		{
	    			case 1:
	    				$footer_class = 'one';
	    			break;
	    			case 2:
	    				$footer_class = 'two';
	    			break;
	    			case 3:
	    				$footer_class = 'three';
	    			break;
	    			case 4:
	    				$footer_class = 'four';
	    			break;
	    			default:
	    				$footer_class = 'four';
	    			break;
	    		}
	    		
	    		global $photography_homepage_style;
		?>
		<div id="footer" class="<?php if(isset($photography_homepage_style) && !empty($photography_homepage_style)) { echo esc_attr($photography_homepage_style); } ?>">
		<ul class="sidebar_widget <?php echo esc_attr($footer_class); ?>">
	    	<?php dynamic_sidebar('Footer Sidebar'); ?>
		</ul>
		</div>
		<br class="clear"/>
		<?php
	    	}
		?>
	
		<div class="footer_bar_wrapper <?php if(isset($photography_homepage_style) && !empty($photography_homepage_style)) { echo esc_attr($photography_homepage_style); } ?>">
			<?php
				//Check if display social icons or footer menu
				$tg_footer_copyright_right_area = get_theme_mod('tg_footer_copyright_right_area', 'social');
				
				if($tg_footer_copyright_right_area=='social')
				{
					if($photography_homepage_style!='flow' && $photography_homepage_style!='fullscreen' && $photography_homepage_style!='carousel' && $photography_homepage_style!='flip' && $photography_homepage_style!='fullscreen_video')
					{	
						//Check if open link in new window
						$tg_footer_social_link = get_theme_mod('tg_footer_social_link', 1);
				?>
				<div class="social_wrapper">
			    	<ul>
			    		<?php
			    			$pp_facebook_url = get_option('pp_facebook_url');
			    			
			    			if(!empty($pp_facebook_url))
			    			{
			    		?>
			    		<li class="facebook"><a <?php if(!empty($tg_footer_social_link)) { ?>target="_blank"<?php } ?> href="<?php echo esc_url($pp_facebook_url); ?>"><i class="fa fa-facebook-official"></i></a></li>
			    		<?php
			    			}
			    		?>
			    		<?php
			    			$pp_twitter_username = get_option('pp_twitter_username');
			    			
			    			if(!empty($pp_twitter_username))
			    			{
			    		?>
			    		<li class="twitter"><a <?php if(!empty($tg_footer_social_link)) { ?>target="_blank"<?php } ?> href="//twitter.com/<?php echo esc_attr($pp_twitter_username); ?>"><i class="fa fa-twitter"></i></a></li>
			    		<?php
			    			}
			    		?>
			    		<?php
			    			$pp_flickr_username = get_option('pp_flickr_username');
			    			
			    			if(!empty($pp_flickr_username))
			    			{
			    		?>
			    		<li class="flickr"><a <?php if(!empty($tg_footer_social_link)) { ?>target="_blank"<?php } ?> title="Flickr" href="//flickr.com/people/<?php echo esc_attr($pp_flickr_username); ?>"><i class="fa fa-flickr"></i></a></li>
			    		<?php
			    			}
			    		?>
			    		<?php
			    			$pp_youtube_url = get_option('pp_youtube_url');
			    			
			    			if(!empty($pp_youtube_url))
			    			{
			    		?>
			    		<li class="youtube"><a <?php if(!empty($tg_footer_social_link)) { ?>target="_blank"<?php } ?> title="Youtube" href="<?php echo esc_url($pp_youtube_url); ?>"><i class="fa fa-youtube"></i></a></li>
			    		<?php
			    			}
			    		?>
			    		<?php
			    			$pp_vimeo_username = get_option('pp_vimeo_username');
			    			
			    			if(!empty($pp_vimeo_username))
			    			{
			    		?>
			    		<li class="vimeo"><a <?php if(!empty($tg_footer_social_link)) { ?>target="_blank"<?php } ?> title="Vimeo" href="//vimeo.com/<?php echo esc_attr($pp_vimeo_username); ?>"><i class="fa fa-vimeo-square"></i></a></li>
			    		<?php
			    			}
			    		?>
			    		<?php
			    			$pp_tumblr_username = get_option('pp_tumblr_username');
			    			
			    			if(!empty($pp_tumblr_username))
			    			{
			    		?>
			    		<li class="tumblr"><a <?php if(!empty($tg_footer_social_link)) { ?>target="_blank"<?php } ?> title="Tumblr" href="//<?php echo esc_attr($pp_tumblr_username); ?>.tumblr.com"><i class="fa fa-tumblr"></i></a></li>
			    		<?php
			    			}
			    		?>
			    		<?php
			    			$pp_dribbble_username = get_option('pp_dribbble_username');
			    			
			    			if(!empty($pp_dribbble_username))
			    			{
			    		?>
			    		<li class="dribbble"><a <?php if(!empty($tg_footer_social_link)) { ?>target="_blank"<?php } ?> title="Dribbble" href="//dribbble.com/<?php echo esc_attr($pp_dribbble_username); ?>"><i class="fa fa-dribbble"></i></a></li>
			    		<?php
			    			}
			    		?>
			    		<?php
			    			$pp_linkedin_url = get_option('pp_linkedin_url');
			    			
			    			if(!empty($pp_linkedin_url))
			    			{
			    		?>
			    		<li class="linkedin"><a <?php if(!empty($tg_footer_social_link)) { ?>target="_blank"<?php } ?> title="Linkedin" href="<?php echo esc_url($pp_linkedin_url); ?>"><i class="fa fa-linkedin"></i></a></li>
			    		<?php
			    			}
			    		?>
			    		<?php
			            	$pp_pinterest_username = get_option('pp_pinterest_username');
			            	
			            	if(!empty($pp_pinterest_username))
			            	{
			        	?>
			        	<li class="pinterest"><a <?php if(!empty($tg_footer_social_link)) { ?>target="_blank"<?php } ?> title="Pinterest" href="//pinterest.com/<?php echo esc_attr($pp_pinterest_username); ?>"><i class="fa fa-pinterest"></i></a></li>
			        	<?php
			            	}
			        	?>
			        	<?php
			        		$pp_instagram_username = get_option('pp_instagram_username');
			        		
			        		if(!empty($pp_instagram_username))
			        		{
			        	?>
			        	<li class="instagram"><a <?php if(!empty($tg_footer_social_link)) { ?>target="_blank"<?php } ?> title="Instagram" href="//instagram.com/<?php echo esc_attr($pp_instagram_username); ?>"><i class="fa fa-instagram"></i></a></li>
			        	<?php
			        		}
			        	?>
			        	<?php
			        		$pp_behance_username = get_option('pp_behance_username');
			        		
			        		if(!empty($pp_behance_username))
			        		{
			        	?>
			        	<li class="behance"><a <?php if(!empty($tg_footer_social_link)) { ?>target="_blank"<?php } ?> title="Behance" href="//behance.net/<?php echo esc_attr($pp_behance_username); ?>"><i class="fa fa-behance-square"></i></a></li>
			        	<?php
			        		}
			        	?>
			        	<?php
					    	$pp_500px_url = get_option('pp_500px_url');
					    	
					    	if(!empty($pp_500px_url))
					    	{
						?>
						<li class="500px"><a <?php if(!empty($tg_footer_social_link)) { ?>target="_blank"<?php } ?> title="500px" href="<?php echo esc_url($pp_500px_url); ?>"><i class="fa fa-500px"></i></a></li>
						<?php
					    	}
						?>
			    	</ul>
				</div>
			<?php
					}
				} //End if display social icons
				else
				{
					if ( has_nav_menu( 'footer-menu' ) ) 
			    	{
				    	wp_nav_menu( 
				        		array( 
				        			'menu_id'			=> 'footer_menu',
				        			'menu_class'		=> 'footer_nav',
				        			'theme_location' 	=> 'footer-menu',
				        		) 
				    	); 
					}
				}
			?>
	    	<?php
	    		//Display copyright text
	        	$tg_footer_copyright_text = get_theme_mod('tg_footer_copyright_text');
	
	        	if(!empty($tg_footer_copyright_text))
	        	{
	        		echo '<div id="copyright">'.wp_kses_post(htmlspecialchars_decode($tg_footer_copyright_text)).'</div><br class="clear"/>';
	        	}
	    	?>
		</div>
	</div>
	<?php
		}
	?>
	<?php
		//Check if display to top button
		$tg_footer_copyright_totop = get_theme_mod('tg_footer_copyright_totop', 1);
		
		if(!empty($tg_footer_copyright_totop))
		{
	?>
		<a id="toTop"><i class="fa fa-angle-up"></i></a>
	<?php
		}
	?>
</div>
</div>
<?php
    } //End if not blank template
?>

<div id="overlay_background">
	<?php
		global $photography_page_gallery_id;
		
		//Check if display sharing buttons
		$tg_global_sharing = get_theme_mod('tg_global_sharing');
		
		if(is_single() OR !empty($photography_page_gallery_id) OR !empty($tg_global_sharing))
		{
	?>
	<div id="fullscreen_share_wrapper">
		<div class="fullscreen_share_content">
	<?php
			get_template_part("/templates/template-share");
	?>
		</div>
	</div>
	<?php
		}
	?>
</div>
<?php
	}
	//End if hide footer
?>

<?php
    //Check if theme demo then enable layout switcher
    if(THEMEDEMO)
    {
?>
    <div id="option_wrapper">
    <div class="inner">
    	<div style="text-align:center">
	    	<div class="purchase_theme_button">
				<a class="button" href="<?php echo esc_url(THEMEGOODS_PURCHASE_URL); ?>" target="_blank">Purchase Theme</a>
			</div>
			
			<h5>Demo Homepages</h5>
			<p>
				Here are example of homepage that can be imported within one click.
			</p>
	    	<?php
	    		$customizer_styling_arr = array( 
					array(
						'id'	=>	'7-7-demo2', 
						'url' => 'https://photographyv7-7.themegoods.com/demo2/',
						'new' => true,
					),
					array(
						'id'	=>	'7-7-demo1', 
						'url' => 'https://photographyv7-7.themegoods.com/',
						'new' => true,
					),
					array(
						'id'	=>	'7-6-demo3', 
						'url' => 'https://photographyv7-6.themegoods.com/demo3/',
						'new' => true,
					),
					array(
						'id'	=>	'7-6-demo2', 
						'url' => 'https://photographyv7-6.themegoods.com/demo2/',
						'new' => true,
					),
					array(
						'id'	=>	'7-6-demo1', 
						'url' => 'https://photographyv7-6.themegoods.com/',
						'new' => true,
					),
					array(
						'id'	=>	'7-4-demo6', 
						'url' => 'https://photographyv7-4-1.themegoods.com/demo6/',
						'new' => false,
					),
					array(
						'id'	=>	'7-4-demo5', 
						'url' => 'https://photographyv7-4-1.themegoods.com/demo5/',
						'new' => false,
					),
					array(
						'id'	=>	'7-4-demo4', 
						'url' => 'https://photographyv7-4-1.themegoods.com/demo4/',
						'new' => false,
					),
					array(
						'id'	=>	'7-4-demo3', 
						'url' => 'https://photographyv7-4-1.themegoods.com/demo3/',
						'new' => false,
					),
					array(
						'id'	=>	'7-4-demo2', 
						'url' => 'https://photographyv7-4-1.themegoods.com/demo2/',
						'new' => false,
					),
					array(
						'id'	=>	'7-4-demo1', 
						'url' => 'https://photographyv7-4-1.themegoods.com/',
						'new' => false,
					),
					array(
						'id'	=>	'7-home1', 
						'url' => 'https://photographyv7-4.themegoods.com/',
						'new' => false,
					),
					array(
						'id'	=>	'7-home2', 
						'url' => 'https://photographyv7-4.themegoods.com/home-2/',
						'new' => false,
					),
					array(
						'id'	=>	'7-home3', 
						'url' => 'https://photographyv7-4.themegoods.com/home-3/',
						'new' => false,
					),
					array(
						'id'	=>	'7-home4', 
						'url' => 'https://photographyv7-4.themegoods.com/home-4/',
						'new' => false,
					),
					array(
						'id'	=>	'7-home5', 
						'url' => 'https://photographyv7-4.themegoods.com/home-5/',
						'new' => false,
					),
					array(
						'id'	=>	'7-home6', 
						'url' => 'https://photographyv7-4.themegoods.com/home-6/',
						'new' => false,
					),
					array(
						'id'	=>	'7-home7', 
						'url' => 'https://photographyv7-4.themegoods.com/home-7/',
						'new' => false,
					),
					array(
						'id'	=>	'7-home8', 
						'url' => 'https://photographyv7-4.themegoods.com/home-8/',
						'new' => false,
					),
					array(
						'id'	=>	'7-home9', 
						'url' => 'https://photographyv7-4.themegoods.com/home-9/',
						'new' => false,
					),
					array(
						'id'	=>	'4-5-home1', 
						'url' => 'https://themes.themegoods.com/photography/demo4/',
						'new' => false,
					),
					array(
						'id'	=>	'4-5-home2', 
						'url' => 'https://themes.themegoods.com/photography/demo4/home/home-2-kenburns/',
						'new' => false,
					),
					array(
						'id'	=>	'4-5-home3', 
						'url' => 'https://themes.themegoods.com/photography/demo4/home/home-3-gallery-archive/',
						'new' => false,
					),
					array(
						'id'	=>	'4-5-home4', 
						'url' => 'https://themes.themegoods.com/photography/demo4/home/home-4-photographer/',
						'new' => false,
					),
					array(
						'id'	=>	'4-5-home5', 
						'url' => 'https://themes.themegoods.com/photography/demo4/home/home-5-photographer-2/',
						'new' => false,
					),
					array(
						'id'	=>	'4-5-home6', 
						'url' => 'https://themes.themegoods.com/photography/demo4/home/home-6-creative/',
						'new' => false,
					),
					array(
						'id'	=>	'4-5-home7', 
						'url' => 'https://themes.themegoods.com/photography/demo4/home/home-7-creative-2/',
						'new' => false,
					),
					array(
						'id'	=>	'4-5-home8', 
						'url' => 'https://themes.themegoods.com/photography/demo4/home/home-8-agency/',
						'new' => false,
					),
					array(
						'id'	=>	'4-5-home9', 
						'url' => 'https://themes.themegoods.com/photography/demo4/home/home-9-freelancer/',
						'new' => false,
					),
					array(
						'id'	=>	'1-home1', 
						'url' => 'https://themes.themegoods.com/photography/demo1/',
						'new' => false,
					),
					array(
						'id'	=>	'1-home2', 
						'url' => 'https://themes.themegoods.com/photography/demo1/home/home-creative-2/?menulayout=centeralign',
						'new' => false,
					),
					array(
						'id'	=>	'1-home3', 
						'url' => 'https://themes.themegoods.com/photography/demo1/home/home-revolution-slider/?topbar=1',
						'new' => false,
					),
					array(
						'id'	=>	'1-home4', 
						'url' => 'https://themes.themegoods.com/photography/demo1/home/home-10-masonry-gallery/?menulayout=hammenufull',
						'new' => false,
					),
					array(
						'id'	=>	'1-home5', 
						'url' => 'https://themes.themegoods.com/photography/demo1/pages/about-us-2/?menulayout=leftmenu',
						'new' => false,
					),
					array(
						'id'	=>	'1-home6', 
						'url' => 'https://themes.themegoods.com/photography/demo1/home/home-15-animated-grid/?frame=1&frame_color=black',
						'new' => false,
					),
				);
	    	?>
	    	<ul class="demo_list">
	    		<?php
	    			foreach($customizer_styling_arr as $customizer_styling)
	    			{
	    		?>
	    		<li>
	        		<img src="<?php echo get_template_directory_uri(); ?>/cache/demos/screenshots/<?php echo esc_html($customizer_styling['id']); ?>.jpg" alt="" <?php if(empty($customizer_styling['url'])) { ?>class="no_blur"<?php } ?>/>
	        		<?php 
		        		if($customizer_styling['new'])
		        		{
			        ?>
	        			<span class="label_new">New</span>
	        		<?php 
		        		}
		        		
		        		if(!empty($customizer_styling['url']))
		        		{
			        ?>
	        		<div class="demo_thumb_hover_wrapper">
	        		    <div class="demo_thumb_hover_inner">
	        		    	<div class="demo_thumb_desc">
	    	    	    		<a href="<?php echo esc_url($customizer_styling['url']); ?>" target="_blank" class="button white">Launch</a>
	        		    	</div> 
	        		    </div>	   
	        		</div>		
	        		<?php
		        		}
		        	?>   
	    		</li>
	    		<?php
	    			}
	    		?>
	    	</ul>
			
			<div class="view_more_button">
				<a class="button" href="https://themes.themegoods.com/landing/photography-v7-4-all-demos/" target="_blank">View More Demos</a>
			</div>
    	</div>
    </div>
    </div>
    <div id="option_btn">
    	<a href="javascript:;" class="demotip" title="Choose Theme Demo"><span class="ti-settings"></span></a>
    	
    	<a href="https://themegoods.com/contact/" class="demotip" title="Presale Question" target="_blank"><span class="ti-comment"></span></a>
    	
    	<a href="https://docs.themegoods.com/photography/" class="demotip" title="Theme Documentation" target="_blank"><span class="ti-book"></span></a>
    	
    	<a href="<?php echo esc_url(THEMEGOODS_PURCHASE_URL); ?>" class="demotip" title="Purchase Theme" target="_blank"><span class="ti-shopping-cart"></span></a>
    </div>
<?php
    	wp_enqueue_script("jquery.cookie", get_template_directory_uri()."/js/jquery.cookie.js", false, THEMEVERSION, true);
    	wp_enqueue_script("script-demo", get_template_directory_uri()."/js/custom_demo.js", false, THEMEVERSION, true);
    }
?>

<?php
    $tg_frame = get_theme_mod('tg_frame');
    if(THEMEDEMO && isset($_GET['frame']) && !empty($_GET['frame']))
    {
	    $tg_frame = 1;
    }
    
    if(!empty($tg_frame))
    {
    	wp_enqueue_style("tg_frame", get_template_directory_uri()."/css/tg_frame.css", false, THEMEVERSION, "all");
?>
    <div class="frame_top"></div>
    <div class="frame_bottom"></div>
    <div class="frame_left"></div>
    <div class="frame_right"></div>
<?php
    }
    if(THEMEDEMO && isset($_GET['frame_color']) && !empty($_GET['frame_color']))
    {
?>
<style>
.frame_top, .frame_bottom, .frame_left, .frame_right { background: <?php echo esc_html($_GET['frame_color']); ?> !important; }
</style>
<?php
	}
	
		//Display fullscreen menu
		$photography_fullmenu_default = get_theme_mod('tg_fullmenu_default');
		
		if(is_page())
		{
			$photography_fullmenu_default = get_post_meta($post->ID, 'page_fullmenu', true);
			
			if(empty($photography_fullmenu_default))
			{
				$photography_fullmenu_default = get_theme_mod('tg_fullmenu_default');
			}
		}
		
		if(!empty($photography_fullmenu_default))
		{
			//Add Polylang plugin support
			if (function_exists('pll_get_post')) {
				$photography_fullmenu_default = pll_get_post($photography_fullmenu_default);
			}
			
			//Add WPML plugin support
			if (function_exists('icl_object_id')) {
				$photography_fullmenu_default = icl_object_id($photography_fullmenu_default, 'page', false, ICL_LANGUAGE_CODE);
			}
			
			if(!empty($photography_fullmenu_default) && class_exists("\\Elementor\\Plugin"))
			{
	?>
		<div id="fullmenu-wrapper-<?php echo esc_attr($photography_fullmenu_default); ?>" class="fullmenu-wrapper">
	<?php
				echo photography_get_elementor_content($photography_fullmenu_default);
	?>
		</div>
	<?php
			}
		}
	?>

<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
</body>
</html>
