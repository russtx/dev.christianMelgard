<?php

/*-----------------------------------------------------------------------------------*/
/* HEADER.PHP - HEAD profile */
/*-----------------------------------------------------------------------------------*/

function gpp_base_head_profile() {
    $content = '<head profile="http://gmpg.org/xfn/11">' . "\n";
    echo apply_filters( 'gpp_base_head_profile', $content );
} // end gpp_base_head_profile

/*-----------------------------------------------------------------------------------*/
/* HEADER.PHP - BROWSER DETECTION */
/*-----------------------------------------------------------------------------------*/

function gpp_base_browser_class( $classes ) {
	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
		if ( $is_lynx ) $classes[] = 'browser-lynx';
		elseif( $is_gecko ) $classes[] = 'browser-gecko';
		elseif( $is_opera ) $classes[] = 'browser-opera';
		elseif( $is_NS4 ) $classes[] = 'browser-ns4';
		elseif( $is_safari ) $classes[] = 'browser-safari';
		elseif( $is_chrome ) $classes[] = 'browser-chrome';
		elseif( $is_IE ) $classes[] = 'browser-ie';
		else $classes[] = '';
		if ( $is_iphone ) $classes[] = 'browser-iphone';
	return $classes;
}
add_filter( 'body_class', 'gpp_base_browser_class' );


/*-----------------------------------------------------------------------------------*/
/* HEADER.PHP - LOGO */
/*-----------------------------------------------------------------------------------*/

function gpp_base_site_logo() {
	global $theme_options;
?>
	<h1 class="logo site-title">
		<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
			<?php if( "" != $theme_options[ 'logo' ] && isset($theme_options[ 'logo' ] )) : ?>
				<img class="sitetitle" src="<?php echo esc_url( $theme_options[ 'logo' ] ); ?>" alt="<?php bloginfo( 'name' ); ?>" id="logo-image-home" />
			<?php else : ?>
					<?php bloginfo( 'name' ); ?>
			<?php endif; ?>
		</a>
	</h1>
<?php }
add_action( 'gpp_base_header_hook', 'gpp_base_site_logo', 1 );


/*-----------------------------------------------------------------------------------*/
/* HEADER.PHP - DESCRIPTION */
/*-----------------------------------------------------------------------------------*/

function gpp_base_site_description() { ?>
	<h2 class="description site-description"><?php bloginfo( 'description' ); ?></h2>
<?php }
add_action( 'gpp_base_header_hook', 'gpp_base_site_description', 3 );


/*-----------------------------------------------------------------------------------*/
/* HEADER.PHP - HEADER IMAGES */
/*-----------------------------------------------------------------------------------*/

function gpp_base_header_image() {
	global $showheadermenu, $post;
		// Check if this is a post or page, if it has a thumbnail, and if it's a big one

	if( $showheadermenu ) { //if headerimage functionality is on
		if ( is_singular() &&
				has_post_thumbnail( $post->ID ) &&
				( /* $src, $width, $height */ $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), array( '940', '200' ) ) ) &&
				$image[ 1 ] >= HEADER_IMAGE_WIDTH ) :
			// Houston, we have a new header image!
			echo get_the_post_thumbnail( $post->ID, '940x200' );
		elseif ( get_header_image() ) : ?>
			<img src="<?php header_image(); ?>" width="<?php echo HEADER_IMAGE_WIDTH; ?>" height="<?php echo HEADER_IMAGE_HEIGHT; ?>" alt="<?php bloginfo( 'name' ); ?>" class="headerimg" />
	<?php endif;
	}
}


/*-----------------------------------------------------------------------------------*/
/* HEADER.PHP - NAVIGATION */
/*-----------------------------------------------------------------------------------*/

// Make Menu Support compatible with earlier WP versions
function gpp_base_nav() {
	if ( function_exists( 'wp_nav_menu' ) )
		wp_nav_menu( 'sort_column=menu_order&theme_location=main-menu&container_class=menu clearfix&fallback_cb=' );
	else
		gpp_base_nav_fallback();
}
add_action( 'gpp_base_nav_hook', 'gpp_base_nav' );

// Make Menu Support compatible with earlier WP versions
function gpp_base_topnav() {
	if ( function_exists( 'wp_nav_menu' ) )
		wp_nav_menu( 'sort_column=menu_order&theme_location=top-menu&container_class=topmenu clearfix&fallback_cb=' );
}
add_action( 'gpp_base_topnav_hook', 'gpp_base_topnav' );

// Create our GPP Fallback Menu
function gpp_base_nav_fallback() {
    echo '<ul class="menu"><li><a href="' . site_url() . '/wp-admin/nav-menus.php">Create Menu</a></li></ul>';
}