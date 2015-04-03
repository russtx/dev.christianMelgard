<?php

/*-----------------------------------------------------------------------------------*/
/* FOOTER */
/*-----------------------------------------------------------------------------------*/

add_action( 'gpp_base_footer_hook', 'gpp_base_footer_widget' );

function gpp_base_footer_widget(){
	$widgets = array( '1', '2', '3', '4' );
	$cnt = 0;
	foreach ( $widgets as $i ) {
		if ( is_active_sidebar( 'footer-widget-' . $i ) ) {
			$cnt++;
		}
	}
	if( $cnt != 0 ) {
	?>
	<div id="footer-widgets">
		<?php
		foreach ( $widgets as $i ) {
			if ( is_active_sidebar( 'footer-widget-'.$i ) ) {   ?>
			<aside class="widget-<?php echo $cnt; ?>" id="widget-<?php echo $i; ?>">
				<?php dynamic_sidebar( 'footer-widget-'.$i ); ?>
			</aside>
		<?php
			}
		}
		?>
    </div>
<?php
	}
}


/*-----------------------------------------------------------------------------------*/
/* FOOTER - CREDITS */
/*-----------------------------------------------------------------------------------*/

function gpp_base_footer_credits() {
	global $theme_options;
?>
	<div id="below_footer">
		<p><?php printf( __( 'All content &copy; %1$s by %2$s.', 'gpp_base_lang' ), date( 'Y' ), __( get_bloginfo( 'name' ) ) ); ?>
		<?php
			$theme = wp_get_theme();
			$theme_name = $theme['Name'];
			$theme_url = $theme->{'Author URI'} . '/themes/' . strtolower( str_replace( " ", "-", $theme['Name'] ) );
			$url = $theme->{'Author URI'};
		  printf( __( '<a href="%1$s" title="%2$s WordPress theme">%2$s WordPress Theme</a> by <a href="%3$s" title="Graph Paper Press">Graph Paper Press</a>', 'gpp_base_lang' ), $theme_url, $theme_name, $url ); ?>
		 </p>
	</div>
<?php }
add_action( 'gpp_base_footer_credits_hook', 'gpp_base_footer_credits' );

?>