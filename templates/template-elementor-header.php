<?php
	//Check if using normal or transparent header
	if(is_page() OR is_single() OR (class_exists('Woocommerce') && photography_is_woocommerce_page()))
	{
		//Check if Woocommerce is installed	
		if(class_exists('Woocommerce') && photography_is_woocommerce_page())
		{
			$current_page_id = get_option('woocommerce_shop_page_id');
			$page_menu_transparent = get_post_meta($current_page_id, 'page_menu_transparent', true);
		}
		else
		{
			$current_page_id = $post->ID;
		}	
		
		
		//Check if page
		if(is_page())
		{
			$page_menu_transparent = get_post_meta($current_page_id, 'page_menu_transparent', true);
		
			//Check if Woocommerce is installed	
			if(class_exists('Woocommerce') && photography_is_woocommerce_page())
			{
				$page_menu_transparent = get_post_meta($current_page_id, 'page_menu_transparent', true);
			}
		}
		
		// This is a 404 not found page
		if( is_404() ) {
			$tg_pages_template_404 = get_theme_mod('tg_pages_template_404');
			
			if(!empty($tg_pages_template_404)) {
				$page_menu_transparent = get_post_meta($tg_pages_template_404, 'page_menu_transparent', true);
			}
		}
		
		//Check if single post page
		if (is_singular('post')) 
		{
			$page_menu_transparent = get_post_meta($current_page_id, 'post_menu_transparent', true);
		}
		
		if(is_single() && $post->post_type == 'galleries')
		{
			//Check if password protected
			$gallery_password = get_post_meta($post->ID, 'gallery_password', true);
			
			if(!empty($gallery_password) && !isset($_SESSION['gallery_page_'.$post->ID]))
			{
				$page_menu_transparent = 1;
			}
		}
		
		if(is_single() && $post->post_type == 'portfolios')
		{
			//Check if password protected
			$page_menu_transparent = get_post_meta($post->ID, 'portfolio_menu_transparent', true);
		}
		
		//If normal header
		if(empty($page_menu_transparent))
		{
			$photography_header_content_default = get_post_meta($current_page_id, 'page_header', true);

			if(empty($photography_header_content_default))
			{
				$photography_header_content_default = get_theme_mod('photography_header_content_default');
			}
			else
			{
				$photography_header_content_default = $photography_header_content_default;
			}
		}
		//if transparent header
		else
		{
			$photography_transparent_header_content_default = get_post_meta($current_page_id, 'page_transparent_header', true);
		
			if(empty($photography_transparent_header_content_default))
			{
				$photography_header_content_default = get_theme_mod('photography_transparent_header_content_default');
			}
			else
			{
				$photography_header_content_default = $photography_transparent_header_content_default;
			}
		}
	}
	else
	{
		$page_menu_transparent = 0;
		
		//If normal header
		if(empty($page_menu_transparent))
		{
			$photography_header_content_default = get_theme_mod('photography_header_content_default');
		}
		//if transparent header
		else
		{
			$photography_header_content_default = get_theme_mod('photography_transparent_header_content_default');
		}
	}
	
	if(!empty($photography_header_content_default))
	{
		//Add Polylang plugin support
		if (function_exists('pll_get_post')) {
			$photography_header_content_default = pll_get_post($photography_header_content_default);
		}
		
		//Add WPML plugin support
		if (function_exists('icl_object_id')) {
			$photography_header_content_default = icl_object_id($photography_header_content_default, 'page', false, ICL_LANGUAGE_CODE);
		}
?>
	<div id="elementor-header" class="main-menu-wrapper">
		<?php 
			if (class_exists("\\Elementor\\Plugin")) {
                echo photography_get_elementor_content($photography_header_content_default);
            }
		?>
	</div>
<?php
	}
	
	//Check if sticky menu
	$photography_fixed_menu = get_theme_mod('photography_fixed_menu', true);
	
	//Check if disable sticky menu on this page specifically
	if(is_page())
	{
		$page_hide_sticky_header = get_post_meta($current_page_id, 'page_hide_sticky_header', true);
	
		if(!empty($page_hide_sticky_header))
		{
			$photography_fixed_menu = false;
		}
	}
	
	if(!empty($photography_fixed_menu))
	{
		//Check if using normal or transparent header
		if(is_page() OR is_single())
		{
			$photography_header_content_default = get_post_meta($post->ID, 'page_sticky_header', true);
		
			if(empty($photography_header_content_default))
			{
				$photography_header_content_default = get_theme_mod('photography_sticky_header_content_default');
			}
		}
		else
		{
			$photography_header_content_default = get_theme_mod('photography_sticky_header_content_default');
		}
		
		//Add Polylang plugin support
		if (function_exists('pll_get_post')) {
			$photography_header_content_default = pll_get_post($photography_header_content_default);
		}
		
		//Add WPML plugin support
		if (function_exists('icl_object_id')) {
			$photography_header_content_default = icl_object_id($photography_header_content_default, 'page', false, ICL_LANGUAGE_CODE);
		}
?>
	<div id="elementor-sticky-header" class="main-menu-wrapper">
		<?php 
			if (class_exists("\\Elementor\\Plugin")) {
                echo photography_get_elementor_content($photography_header_content_default);
            }
		?>
	</div>
<?php
	}
?>