<?php

function base_widgets_init() {
	global $showhomewidgetoption, $showsidebarwidgetoption;
	if( $showhomewidgetoption ) {
		register_sidebar(array(
			'name' => 'Home',
			'id' => 'home',
			'before_title' => '<h3 class="sub"><span>',
			'after_title' => '</span></h3>'
		));	
	}
	if( $showsidebarwidgetoption ) {
	register_sidebar(array(
		'name' => 'Sidebar',
		'id' => 'sidebar',
		'before_widget' => '<aside class="widget">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>'
	));
	}
 
    $widgets = array( '1', '2', '3', '4' );
	foreach ( $widgets as $i ) {	
		register_sidebar(array(
			'name' => 'Footer Widget '.$i,
			'id' => 'footer-widget-'.$i,
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '<h3 class="widget-title"><span>',
			'after_title' => '</span></h3>'
		));
    } 		

}
add_action( 'widgets_init', 'base_widgets_init' );