<?php
require_once get_template_directory() . "/modules/class-tgm-plugin-activation.php";
add_action( 'tgmpa_register', 'photography_require_plugins' );

function photography_require_plugins() {
 
    $plugins = array(
	    array(
	        'name'               => 'Photography Theme Custom Post Type',
	        'slug'               => 'photography-custom-post',
	        'source'             => 'https://themegoods-assets.b-cdn.net/photography-custom-post/photography-custom-post-v5.3.1.zip',
	        'required'           => true, 
	        'version'            => '5.3.1',
	    ),
		array(
			'name'               => 'Photography Theme Elements for Elementor',
			'slug'               => 'photography-elementor',
			'source'             => 'https://themegoods-assets.b-cdn.net/photography-elementor/photography-elementor-v1.4.zip',
			'required'           => true, 
			'version'            => '1.4',
		),
		array(
			'name'      		 => 'Elementor Page Builder',
			'slug'      		 => 'elementor',
			'required'  		 => true, 
		),
	    array(
	        'name'               => 'One Click Demo Import',
	        'slug'      		 => 'one-click-demo-import',
	        'required'           => true, 
	    ),
	    array(
			'name'               => 'Revolution Slider',
			'slug'               => 'revslider',
			'source'             => 'https://themegoods-assets.b-cdn.net/revslider/revslider-v6.7.34.zip',
			'required'           => false, 
			'version'            => '6.7.34',
		),
		array(
			'name'               => 'Appointment Booking',
			'slug'      		 => 'motopress-appointment',
			'source'             => 'https://themegoods-assets.b-cdn.net/motopress-appointment/motopress-appointment-v2.3.0.zip',
			'required'           => true, 
			'version'            => '2.3.0',
		),
		array(
			'name'               => 'Appointment Booking Checkout Fields',
			'slug'      		 => 'mpa-checkout-fields',
			'source'             => 'https://themegoods-assets.b-cdn.net/mpa-checkout-fields/mpa-checkout-fields-v1.1.1.zip',
			'required'           => false, 
			'version'            => '1.1.1',
		),
		array(
			'name'               => 'Appointment Booking PDF Invoices',
			'slug'      		 => 'mpa-invoices',
			'source'             => 'https://themegoods-assets.b-cdn.net/mpa-invoices/mpa-invoices-v1.0.1.zip',
			'required'           => false, 
			'version'            => '1.0.1',
		),
		array(
			'name'               => 'Appointment Booking WooCommerce Payments',
			'slug'      		 => 'mpa-woocommerce',
			'source'             => 'https://themegoods-assets.b-cdn.net/mpa-woocommerce/mpa-woocommerce-v1.2.0.zip',
			'required'           => true, 
			'version'            => '1.2.0',
		),
		array(
			'name'               => 'Google Analytics for Appointment Booking',
			'slug'      		 => 'mpa-google-analytics',
			'source'             => 'https://themegoods-assets.b-cdn.net/mpa-google-analytics/mpa-google-analytics-v1.0.1.zip',
			'required'           => true, 
			'version'            => '1.0.1',
		),
		array(
			'name'               => 'Appointment Booking Twilio SMS',
			'slug'      		 => 'mpa-twilio-sms',
			'source'             => 'https://themegoods-assets.b-cdn.net/mpa-twilio-sms/mpa-twilio-sms-v1.0.0.zip',
			'required'           => true, 
			'version'            => '1.0.0',
		),
		array(
			'name'               => 'Square Payments for Appointment Booking',
			'slug'      		 => 'mpa-square-payments',
			'source'             => 'https://themegoods-assets.b-cdn.net/mpa-square-payments/mpa-square-payments-v1.0.1.zip',
			'required'           => true, 
			'version'            => '1.0.1',
		),
	    array(
			'name'               => 'Envato Market',
			'slug'               => 'envato-market',
			'source'             => 'https://themegoods-assets.b-cdn.net/envato-market/envato-market-v2.0.12.zip',
			'required'           => true, 
			'version'            => '2.0.12',
		),
	    array(
	        'name'      => 'Multiple Post Thumbnails',
	        'slug'      => 'multiple-post-thumbnails',
	        'required'  => true, 
	    ),
	    array(
	        'name'      => 'MailChimp for WordPress',
	        'slug'      => 'mailchimp-for-wp',
	        'required'  => false, 
	    ),
		array(
			'name'      => 'Custom Fonts',
			'slug'      => 'custom-fonts',
			'required'  => true, 
		),
		array(
			'name'      => 'Contact Form 7',
			'slug'      => 'contact-form-7',
			'required'  => true, 
		),
	    array(
	        'name'      => 'WooCommerce',
	        'slug'      => 'woocommerce',
	        'required'  => false, 
	    ),
	    /*array(
	        'name'      => 'Meks Easy Photo Feed Widget',
	        'slug'      => 'meks-easy-instagram-widget',
	        'required'  => false, 
	    ),*/
		array(
			'name'      => 'Before After Image Comparison Slider for Elementor',
			'slug'      => 'before-after-image-comparison-slider-for-elementor',
			'required'  => false, 
		),
		array(
			'name'      => 'Extended Google Map for Elementor',
			'slug'      => 'extended-google-map-for-elementor',
			'required'  => false, 
			'source'    => 'https://themegoods-assets.b-cdn.net/extended-google-map-for-elementor/extended-google-map-for-elementor-v1.2.5.zip',
			'version'   => '1.2.5',
		),
	);
	
	$config = array(
		'domain'	=> 'photography',
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'install-required-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'is_automatic' => true,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
        'strings'          => array(
	        'page_title'                      => esc_html__('Install Required Plugins', 'photography' ),
	        'menu_title'                      => esc_html__('Install Plugins', 'photography' ),
	        'installing'                      => esc_html__('Installing Plugin: %s', 'photography' ),
	        'oops'                            => esc_html__('Something went wrong with the plugin API.', 'photography' ),
	        'return'                          => esc_html__('Return to Required Plugins Installer', 'photography' ),
	        'plugin_activated'                => esc_html__('Plugin activated successfully.', 'photography' ),
	        'complete'                        => esc_html__('All plugins installed and activated successfully. %s', 'photography' ),
	        'nag_type'                        => 'update-nag'
	    )
    );
 
    tgmpa( $plugins, $config );
 
}
?>