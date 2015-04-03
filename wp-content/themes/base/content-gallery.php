<?php
/**
 * The template for displaying posts in the Gallery Post Format on index and archive pages
 *
 * Learn more: http://codex.wordpress.org/Post_Formats
 *
 * @package Base
 * @since Base 2.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h3 class="entry-format"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'gpp_base_lang' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php _e( 'Gallery', 'gpp_base_lang' ); ?></a></h3>
		<?php gpp_base_above_title_hook(); ?>
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'gpp_base_lang' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
	</header>

	<div class="entry-content">

	<?php if ( is_search() ) : // Only display Excerpts for search pages ?>
			<?php the_excerpt(); ?>
		<?php else : ?>

			<?php if ( post_password_required() ) : ?>
				<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'gpp_base_lang' ) ); ?>

			<?php else : ?>
				<?php
					$post_subtitrare = get_post( $post->ID );
					$content = $post_subtitrare->post_content;
					$pattern = get_shortcode_regex();
					preg_match( "/$pattern/s", $content, $match );
					if( isset( $match[2] ) && ( "gallery" == $match[2] ) ) {
						$atts = shortcode_parse_atts( $match[3] );
						$images = isset( $atts['ids'] ) ? explode( ',', $atts['ids'] ) : get_children( 'post_type=attachment&post_mime_type=image&post_parent=' . $post->ID .'&order=ASC&orderby=menu_order ID' );
					}

					if ( isset( $images ) && $images != "" ) :
						$total_images = count( $images );
						$image = array_shift( $images );
						if( has_post_thumbnail() ) {
							$image_img_tag = get_the_post_thumbnail();
						} else {
							$_post = get_post( $image );
							$image_img_tag = wp_get_attachment_image( $_post->ID, 'thumbnail' );
						}
				?>

				<figure class="gallery-thumb">
					<a href="<?php the_permalink(); ?>"><?php echo $image_img_tag; ?></a>
				</figure><!-- .gallery-thumb -->

				<p><em><?php printf( _n( 'This gallery contains <a %1$s>%2$s photo</a>.', 'This gallery contains <a %1$s>%2$s photos</a>.', $total_images, 'gpp_base_lang' ),
						'href="' . esc_url( get_permalink() ) . '" title="' . sprintf( esc_attr__( 'Permalink to %s', 'gpp_base_lang' ), the_title_attribute( 'echo=0' ) ) . '" rel="bookmark"',
						number_format_i18n( $total_images )
					); ?></em></p>
			<?php endif; ?>
			<?php the_excerpt(); ?>
		<?php endif; ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'gpp_base_lang' ) . '</span>', 'after' => '</div>' ) ); ?>
	<?php endif; ?>
		</div><!-- .entry-content -->

	<?php gpp_base_meta(); //call meta data ?>

</article><!-- #post-<?php the_ID(); ?> -->
