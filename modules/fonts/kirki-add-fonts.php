<?php

/*
 * Add Typekit Fonts
 * */

class kirkiAddFonts {
    private $data = [];
    
    public function __set($name, $value) {
        $this->data[$name] = $value;
    }
    
    public function __get($name) {
        return $this->data[$name] ?? null;
    }
    
    public function __construct() {
    
        $theme_info = wp_get_theme();
        $this->theme_version = $theme_info[ 'Version' ];
    
        $this->custom_fonts = get_theme_mod( 'tg_custom_fonts' );
    
        if ( ! empty( $this->custom_fonts ) ){
            add_action( 'wp_enqueue_scripts', array( $this, 'load_custom_fonts' ) );
        }
        add_filter( 'kirki/fonts/google_fonts', array( $this, 'add_custom_fonts' ) );
    }
    
    public function load_custom_fonts() {
        $custom_css = '';
        
        /*if ( ! empty( $this->custom_fonts ) ) 
        {
            foreach( $this->custom_fonts as $key=>$custom_font ){
	            if (filter_var($custom_font[ 'font_url' ], FILTER_VALIDATE_URL) === FALSE) {
				    $custom_font[ 'font_url' ] = wp_get_attachment_url($custom_font[ 'font_url' ]);
				}
				
				if (!isset($custom_font[ 'font_style' ]) OR empty($custom_font[ 'font_style' ]))
				{
					$custom_font[ 'font_style' ] = 'normal';
				}
	            
	            $custom_css.='
                	@font-face {
	                	font-family: "'.$custom_font[ 'font_name' ].'";
	                	src: url('.esc_url($custom_font[ 'font_url' ]).') format("woff");
	                	font-weight: '.$custom_font[ 'font_weight' ].';
						font-style: '.$custom_font[ 'font_style' ].';
	                }
                ';
            }
        }*/
        
        global $tg_google_fonts;
        $tg_custom_fonts = get_theme_mod('tg_custom_fonts');
        $added_font = array();
        
        if (!empty($tg_google_fonts) && is_array($tg_google_fonts) && !empty($tg_custom_fonts)) {
            foreach( $tg_google_fonts as $key=>$custom_font ){
                
                //Check if font is installed
                $font_name = get_theme_mod($custom_font);
                $search_items = array('font_name'=>$font_name); 
                $selected_font = search_array_by_key_value($tg_custom_fonts, $search_items);
                
                if(!empty($selected_font) && !in_array($font_name, $added_font) && isset($selected_font[0])) {
                    $custom_css.='
                        @font-face {
                            font-family: "'.$selected_font[0][ 'font_name' ].'";
                            src: url('.esc_url($selected_font[0][ 'font_url' ]).') format("woff");
                            font-weight: '.$selected_font[0][ 'font_weight' ].';
                            font-style: '.$selected_font[0][ 'font_style' ].';
                        }
                    ';
                    
                    $added_font[] = $font_name;
                }
            }
        }
        
        wp_add_inline_style( 'screen', $custom_css );
    }

    public function add_custom_fonts( $google_fonts ){
        $my_custom_fonts = array();
        if ( ! empty( $this->custom_fonts ) ) {
            foreach( $this->custom_fonts as $key=>$custom_font )
            {
                $my_custom_fonts[ $custom_font[ 'font_name' ] ] = array(
                    'label' => $custom_font[ 'font_name' ],
                    'category' => 'sans-serif'
                );
            }
        }
        //var_dump($my_custom_fonts); die;
        return array_merge_recursive( $my_custom_fonts, $google_fonts );
    }
}

new kirkiAddFonts;