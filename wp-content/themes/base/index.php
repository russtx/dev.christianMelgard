<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Base
 * @since Base 2.0
 */
if ( function_exists( 'get_header' ) ) {
    get_header();
} else {
    header("Location: http://" . $_SERVER['HTTP_HOST'] . "");
    exit;
} ?>

<?php gpp_base_home_widgets_hook(); // pull homepage widgets ?>

<?php gpp_base_apps_hook(); // pull apps such as slideshow, slider ?>

<?php gpp_base_loop_hook(); // determines output of post display ?>

<?php gpp_base_sidebar_hook(); ?>
<!--ThemebotFooterFinderTop-->
<?php get_footer(); ?>
<!--ThemebotFooterFinderBottom-->