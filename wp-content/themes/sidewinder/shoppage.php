<?php
/*
 * Template Name: Shop Page
 * Description: Custom Shop page for different background 
 * Author: Russ Berge
 */
get_header(); ?>

<div class="shopPage" id="primary">
	<div id="content" role="main" class="<?php gpp_base_check_sidebar_hook(); ?>">

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<?php gpp_base_page_hook(); ?>

		<?php endwhile; endif; ?>

		<?php gpp_base_comments(); ?>

	</div>
</div>

<?php gpp_base_sidebar_hook(); ?>

<?php get_footer(); ?>

