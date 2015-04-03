<?php
/**
 * The Sidebar containing the main widget area.
 *
 * @package Base
 * @since Base 1.3
 */
?>
<?php gpp_base_above_sidebar_hook(); ?>
<?php if ( is_active_sidebar( 'sidebar' ) ) { ?>
	<div id="secondary" class="widget-area" role="complementary">
		<?php  dynamic_sidebar( 'sidebar' ); ?>
	</div><!-- #secondary -->
<?php } ?>
<?php gpp_base_below_sidebar_hook(); ?>

