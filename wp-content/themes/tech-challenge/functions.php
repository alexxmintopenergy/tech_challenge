<?php
/**
 * Functions and definitions
 *
 */

function theme_scripts_and_styles() {

	wp_enqueue_style( 'swiper-style', 'https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css' );
	wp_enqueue_style( 'bootstrap-style', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css' );
	wp_enqueue_style( 'theme-style', get_stylesheet_directory_uri() . '/assets/css/style.css' );

	wp_enqueue_script( 'swiper-script', 'https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js', array( 'jquery' ), null, false );
	wp_enqueue_script( 'bootstrap-script', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'theme-script', get_stylesheet_directory_uri() . '/assets/js/script.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'tabs-script', 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js', array( 'jquery' ), null, true );

}
add_action( 'wp_enqueue_scripts', 'theme_scripts_and_styles' );

if ( ! function_exists( 'theme_setup' ) ) :
	function theme_setup() {
		add_theme_support( 'menus' );
		register_nav_menus(
			array(
				'header-menu' => esc_html__( 'Header Menu' ),
				'footer-menu' => esc_html__( 'Footer Menu' ),
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'theme_setup' );

if ( ! file_exists( get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php' ) ) {
	return new WP_Error( 'class-wp-bootstrap-navwalker-missing', esc_html__( 'It appears the class-wp-bootstrap-navwalker.php file may be missing.', 'wp-bootstrap-navwalker' ) );
} else {

	require_once get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';
}

add_theme_support( 'post-thumbnails' );

add_filter( 'wpcf7_validate_text*', 'custom_text_validation_filter', 20, 2 );

function custom_text_validation_filter( $result, $tag ) {
    $tag = new WPCF7_Shortcode( $tag );

    $name = $tag->name;
    $value = isset( $_POST[$name] ) ? trim( wp_unslash( strtr( (string) $_POST[$name], "\n", " " ) ) ) : '';

    if ( 'your-name' == $name ) { // name of your field
        if (!preg_match('/^[a-zA-Z ]*$/', $value)) {
            $result->invalidate( $tag, "Please use only letters and spaces in this field." );
        }
    }
    return $result;
}
function add_file_types_to_uploads( $file_types ) {

    $new_filetypes        = array();
    $new_filetypes['svg'] = 'image/svg+xml';
    $file_types           = array_merge( $file_types, $new_filetypes );

    return $file_types;
}
add_action( 'upload_mimes', 'add_file_types_to_uploads' );

if ( ! function_exists( 'wp_handle_upload_prefilter' ) ) {
    function cc_mime_types( $mimes ) {
        $mimes['svg'] = 'image/svg+xml';
        return $mimes;
    }
    add_filter( 'upload_mimes', 'cc_mime_types' );

    function fix_svg() {
        echo '<style type="text/css">
          .attachment-266x266, .thumbnail img {
               width: 100% !important;
               height: auto !important;
          }
          </style>';
    }
    add_action( 'admin_head', 'fix_svg' );
}

remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );

