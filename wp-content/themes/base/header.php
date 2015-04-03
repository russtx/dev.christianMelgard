<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package Base
 * @since Base 2.0
 */
?><!DOCTYPE html>

<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->


<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="initial-scale=1.0, width=device-width" />

<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged, $theme_options;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'base' ), max( $paged, $page ) );

	?></title>
<?php if ( isset( $theme_options['favicon'] ) && '' != $theme_options['favicon'] ) : ?>
	<link rel="shortcut icon" href="<?php echo esc_url( $theme_options['favicon'] ); ?>" />
<?php endif; ?>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />


<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/library/js/html5.js" type="text/javascript"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/library/js/css3-mediaqueries.js"></script>
<![endif]-->

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

	<!-- BeginHeader -->
	<div id="page" class="hfeed">
	<?php gpp_base_above_header_hook(); ?>

	<header id="branding" class="cf" role="banner">
		<hgroup>
			<?php gpp_base_header_hook(); ?>
		</hgroup>
		<nav id="topaccess" role="navigation">
				<?php gpp_base_topnav_hook(); ?>
		</nav>
		<?php gpp_base_header_image(); ?>
		<nav id="access" role="navigation">
			<?php gpp_base_nav_hook(); ?>
		</nav>
	</header>
	<!-- EndHeader -->

	<?php gpp_base_below_header_hook(); ?>

	<div id="main">