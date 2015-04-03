<?php
/**
 WooCommerce Page
 */
get_header(); ?>

<div id="primary">
	<div id="content" role="main" class="<?php gpp_base_check_sidebar_hook(); ?>">

		<?php woocommerce_content(); ?>

		<?php gpp_base_comments(); ?>

	</div>
</div>

<?php gpp_base_sidebar_hook(); ?>

<?php get_footer(); ?>