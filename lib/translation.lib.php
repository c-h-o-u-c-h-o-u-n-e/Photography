<?php
function photography_theme_load() {
	load_theme_textdomain( 'photography', get_template_directory().'/languages' );
}
add_action( 'init', 'photography_theme_load' );
?>