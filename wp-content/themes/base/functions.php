<?php

// Theme Data Constants
if ( function_exists('wp_get_theme') ) {
	$theme_data = wp_get_theme();
	define('GPP_THEME_AUTHOR_URI', $theme_data->{'Author URI'});
}
define('GPP_THEME_NAME', $theme_data['Name']);
define('GPP_THEME_AUTHOR', $theme_data['Author']);
define('GPP_THEME_HOMEPAGE', $theme_data['URI']);
define('GPP_THEME_VERSION', trim($theme_data['Version']));
define('GPP_THEME_DESC', trim($theme_data['Description']));

/* enqueue style */
function base_style(){
	wp_enqueue_style( 'style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'base_style' );

// Available css themes
if( ! isset( $css ) ) {
	$css = array(
            "default" => array(
                "name" => "default",
                "title" => __( "Light", "gpp" )
            ),
            "dark" => array(
                "name" => "dark",
                "title" => __( "Dark", "gpp" )
            )
        );
}

/**
 * Theme options
 */
if( file_exists( get_template_directory() . '/options/options.php' ) )
	require( get_template_directory() . '/options/options.php' );
if( file_exists( get_template_directory() . '/options/options.php' ) && file_exists( get_template_directory() . '/theme-options.php' ) )
	require( get_template_directory() . '/theme-options.php' );

	
	
// Load Theme Options
//$theme_options = get_option( 'gpp_base_options' );
$theme_options = get_option( gpp_get_current_theme_id() . '_options');
$appsdirectorys = array();
$appspatharray = array();
$appsarray = array();



if ( ! isset( $showheadermenu ) ) $showheadermenu = 1;
if ( ! isset( $showbackgroundmenu ) ) $showbackgroundmenu = 1;
if ( ! isset( $content_width ) ) $content_width = 850;

// Theme Options Setups
if ( ! isset( $showblogoption ) ) { $showblogoption = 1; }
if ( ! isset( $showhomewidgetoption ) ) { $showhomewidgetoption = 1; }
if ( ! isset( $showsidebarwidgetoption ) ) { $showsidebarwidgetoption = 1; }
add_action( 'after_setup_theme', 'gpp_base_setup' );

if ( ! function_exists( 'gpp_base_setup' ) ):

	function gpp_base_setup() {
		global $showheadermenu;
		// Define paths
		$extensions_path = TEMPLATEPATH . '/library/extensions/';
		$functions_path = TEMPLATEPATH . '/library/functions/';
		$includes_path = TEMPLATEPATH . '/library/includes/';
		$options_path = TEMPLATEPATH . '/library/options/';

		// Load Hooks
		require_once ( $extensions_path . 'hooks.php' );

		// Header extensions
		require_once ( $extensions_path . 'header-extensions.php' );

		// Content extensions
		require_once ( $extensions_path . 'content-extensions.php' );

		// Footer extensions
		require_once ( $extensions_path . 'footer-extensions.php' );

		// Style extensions
		require_once ( $extensions_path . 'style-extensions.php' );

		// Load Javascript
		require_once ( $includes_path . 'theme-js.php' );

		// Widgets
		require_once ( $includes_path . 'widgets.php' );

		// PhotoShelter
		require_once ( $includes_path . 'photoshelter.php' );

		//Internationalization
		load_theme_textdomain( "gpp_base_lang", TEMPLATEPATH . '/library/lang' );

		$locale = get_locale();
		$locale_file = TEMPLATEPATH . "/languages/$locale.php";
		if ( is_readable( $locale_file ) )
			require_once( $locale_file );

		// This theme styles the visual editor with editor-style.css to match the theme style.
		add_editor_style();

		// Add default posts and comments RSS feed links to <head>.
		add_theme_support( 'automatic-feed-links' );

		// This theme uses wp_nav_menu() in two location.
		register_nav_menu( 'main-menu', __( 'Main Menu', 'gpp_base_lang' ) );
		register_nav_menu( 'top-menu', __( 'Top Menu', 'gpp_base_lang' ) );


		// Add support for a variety of post formats
		add_theme_support( 'post-formats', array( 'aside', 'link', 'chat', 'status', 'quote', 'image', 'gallery', 'audio', 'video' ) );

		// Add support for custom backgrounds
		if ( function_exists( 'wp_get_theme' ) ) {
			add_theme_support( 'custom-background' );
		} else {
			add_custom_background();
		}

		// This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images
		add_theme_support( 'post-thumbnails' );

		// The next four constants set how Twenty Eleven supports custom headers.

		// Add Custom Header
		define( 'HEADER_TEXTCOLOR', '' );
		define( 'HEADER_IMAGE', '%s/images/headers/arrow.jpg' ); // %s is the template dir uri
		// The height and width of your custom header. You can hook into the theme's own filters to change these values.
		// Add a filter to gpp_base_header_image_width and gpp_base_header_image_height to change these values.
		define( 'HEADER_IMAGE_WIDTH', apply_filters( 'gpp_base_header_image_width', 940 ) );
		define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'gpp_base_header_image_height', 200 ) );
		define( 'NO_HEADER_TEXT', true );

		// We'll be using post thumbnails for custom header images on posts and pages.
		// We want them to be the size of the header image that we just defined
		// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
		set_post_thumbnail_size( HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true );

		set_post_thumbnail_size( 200, 150, true );
		add_image_size( '940x200', 940, 200, true );

		// Set image sizes upon theme activation
		update_option('thumbnail_size_w', 200);
		update_option('thumbnail_size_h', 150);
		update_option('medium_size_w', 620);
		update_option('large_size_w', 940);

		// Add a way for the custom header to be styled in the admin panel that controls
		// custom headers. See gpp_base_lang_admin_header_style(), below.
		if( $showheadermenu ) {
			if ( function_exists('wp_get_theme') ) {
				add_theme_support( 'custom-header', array( 'random-default' => true ) );
			} else {
				add_custom_image_header( '', 'gpp_base_admin_header_style' );
			}

		}

		// ... and thus ends the changeable header business.

		// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
		register_default_headers( array(
				'bottles' => array(
					'url' => '%s/images/headers/bottles.jpg',
					'thumbnail_url' => '%s/images/headers/bottles-thumbnail.jpg',
					/* translators: header image description */
					'description' => __( 'Bottles', 'gpp_base_lang' )
				),
				'brush' => array(
					'url' => '%s/images/headers/brush.jpg',
					'thumbnail_url' => '%s/images/headers/brush-thumbnail.jpg',
					/* translators: header image description */
					'description' => __( 'Brush', 'gpp_base_lang' )
				),
				'clouds' => array(
					'url' => '%s/images/headers/clouds.jpg',
					'thumbnail_url' => '%s/images/headers/clouds-thumbnail.jpg',
					/* translators: header image description */
					'description' => __( 'Clouds', 'gpp_base_lang' )
				),
				'arrow' => array(
					'url' => '%s/images/headers/arrow.jpg',
					'thumbnail_url' => '%s/images/headers/arrow-thumbnail.jpg',
					/* translators: header image description */
					'description' => __( 'Arrow', 'gpp_base_lang' )
				),
				'surf' => array(
					'url' => '%s/images/headers/surf.jpg',
					'thumbnail_url' => '%s/images/headers/surf-thumbnail.jpg',
					/* translators: header image description */
					'description' => __( 'Surf', 'gpp_base_lang' )
				),
				'wood' => array(
					'url' => '%s/images/headers/wood.jpg',
					'thumbnail_url' => '%s/images/headers/wood-thumbnail.jpg',
					/* translators: header image description */
					'description' => __( 'Wood', 'gpp_base_lang' )
				)
			)
		);

		// Remove default widgets registered by WordPress
		add_action( 'plugins_loaded', 'gpp_base_remove_action' );
		add_action( 'init', 'gpp_base_do_widgets_init', 1 );
		function gpp_base_do_widgets_init() { do_action( 'widgets_init' ); }
		function gpp_base_remove_action() { remove_action( 'init', 'wp_widgets_init', 1 ); }	

	} // gpp_base_setup

endif;

/**
* support for child theme options
*/
function child_theme_options() {
    do_action( 'child_theme_options' );
}


// Add Custom Header CSS to Admin
function gpp_base_admin_header_style() {
	$header_height = HEADER_IMAGE_HEIGHT;
	$header_width = HEADER_IMAGE_WIDTH;
    ?><style type="text/css">
        #headimg {
            width: <?php echo $header_width; ?>px !important;
            height: <?php echo $header_height; ?>px !important;
            padding: 3em 0 2em 2em;
            background-repeat: no-repeat;
        }
    </style><?php
}

remove_action( 'wp_head', 'wp_generator' );


// Redirect to Instructions page after the theme is activated.
if ( is_admin() && isset( $_GET[ 'activated' ] ) && $pagenow ==  "themes.php" ) {
  header( 'Location:' . site_url(). '/wp-admin/themes.php?page=gpp-settings' );
}

// Comment Loop
if ( ! function_exists( 'gpp_base_comment' ) ) :

function gpp_base_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
		<div class="comment-author vcard">
			<?php echo get_avatar( $comment, 40 ); ?>
			<?php printf( __( '%s <span class="says">says:</span>', 'gpp_base_lang' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
		</div><!-- .comment-author .vcard -->
		<?php if ( $comment->comment_approved == '0' ) : ?>
				<em><?php _e( 'Your comment is awaiting moderation.', 'gpp_base_lang' ); ?></em>
				<br />
		<?php endif; ?>

		<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
			<?php
				/* translators: 1: date, 2: time */
				printf( __( '%1$s at %2$s', 'gpp_base_lang' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', 'gpp_base_lang' ), ' ' );
			?>
		</div><!-- .comment-meta .commentmetadata -->

		<div class="comment-body"><?php comment_text(); ?></div>

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div><!-- .reply -->
	</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'gpp_base_lang' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'gpp_base_lang' ), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;

// Integrate old settings into new
function gpp_preserve_base_old_settings(){
	$new = array();
	$old = get_option( 'gpp_base_options');

	$new_value = array();

	foreach ($old as $key => $value) {
		if( $key == 'gpp_base_logo' ){
			$new_value['logo'] = $value;
		}
		if( $key == 'gpp_base_custom_favicon' ){
			$new_value['favicon'] = $value;
		}
		if( $key == 'gpp_base_alt_css' ){
			$val = explode( ".", $value );
			$new_value['color'] = $val[0];
		}
		if( $key == 'gpp_base_custom_css' ){
			$new_value['css'] = $value;
		}
		if( $key == 'gpp_base_blog_cat' ){
			$val = explode( ",", $value );
			$cats = array();
			foreach ( $val as $key => $value ) {
				if( "" != $value ) {
					$cat_array = get_category( $value, 'ARRAY_A' );
					$cats[] .= $cat_array['slug'];
				}
			}
			$new_value['gpp_base_blog_cat'] = $cats;
		}
	}

	$new = array_merge( $new, $new_value );
	update_option( gpp_get_current_theme_id() . '_options', $new );
}

//First check it make sure this function has not been done
if ( get_option( 'base_settings_integrated') != "yes") {
	add_action( 'init', 'gpp_preserve_base_old_settings', 20 );
	//now that function has been run, set option so it wont run again
	update_option( 'base_settings_integrated', 'yes' );
}

?>