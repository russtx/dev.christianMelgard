<?php
/**
 * The template for displaying page content in the showcase.php page template
 *
 * @package Base
 * @since Base 2.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'intro' ); ?>>
	<header class="entry-header">
		<h2 class="entry-title"><?php the_title(); ?></h2>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'gpp_base_lang' ) . '</span>', 'after' => '</div>' ) ); ?>
		<?php edit_post_link( __( 'Edit', 'gpp_base_lang' ), '<span class="edit-link">', '</span>' ); ?>
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->
