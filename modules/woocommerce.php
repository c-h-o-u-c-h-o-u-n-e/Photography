<?php
// Change page title for Shop Archive page
add_filter( 'wp_title', 'photography_title_for_shop' );
function photography_title_for_shop( $title )
{
  if ( is_shop() ) {
    return esc_html__('Shop', 'photography' );
  }
  return $title;
}

//Change number of products per page
add_filter( 'loop_shop_per_page', 'photography_shop_per_page', 20 );
function photography_shop_per_page()
{
	$tg_shop_items = get_theme_mod('tg_shop_items', 15);
	return $tg_shop_items;
}

// Change number or products per row to 3
add_filter('loop_shop_columns', 'photography_loop_columns');
if (!function_exists('photography_loop_columns')) {
	function photography_loop_columns() {
		$tg_shop_columns = get_theme_mod('tg_shop_columns', 3);
		
		return intval($tg_shop_columns); // 3 products per row
	}
}

/**
 * WooCommerce Extra Feature
 * --------------------------
 *
 * Change number of related products on product page
 * Set your own value for 'posts_per_page'
 *
 */ 
add_filter( 'woocommerce_output_related_products_args', 'photography_related_products_args' );

function photography_related_products_args( $args ) 
{
  	//Check if display related products
	$tg_shop_related_products = get_theme_mod('tg_shop_related_products', 1);
	
	if(!empty($tg_shop_related_products))
	{
		$args['posts_per_page'] = 3; // 4 related products
		$args['columns'] = 3; // arranged in 2 columns
	}
	else
	{
		$args['posts_per_page'] = 0;
	}
	
	return $args;
}

$tg_shop_product_image_swap = get_theme_mod('tg_shop_product_image_swap', 1);

if(!empty($tg_shop_product_image_swap)) {
	add_action( 'woocommerce_before_shop_loop_item_title', 'photography_product_thumbnail_hover', 15 );
	function photography_product_thumbnail_hover() {
		global $product;
		$attr = array();
		
		$product_id = get_the_ID(); // Get the current product ID
		$product_gallery = get_post_meta( $product_id, '_product_image_gallery', true ); // Get the gallery images of the product
		$gallery_images = explode( ',', $product_gallery ); // Convert the gallery images to an array
		
		$first_image_url = '';
		if ( isset( $gallery_images[0] ) && !empty($gallery_images[0]) ) {
			$first_image_id = $gallery_images[0]; // Get the ID of the first image in the gallery
			$first_image_url = wp_get_attachment_image_url( $first_image_id, 'woocommerce_thumbnail' ); // Get the URL of the first image in the gallery
			
			$attr['class'] = 'photography-product-image-one';
		}
		
		echo $product->get_image('woocommerce_thumbnail', $attr);
		
		if(!empty($first_image_url)) {
			echo '<img class="photography-product-image-two" src="' . esc_url($first_image_url) . '"/>';
		}
	}
	
	add_action( 'init', 'photography_remove_product_image_in_loop' );
	function photography_remove_product_image_in_loop() {
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
	}
}
?>