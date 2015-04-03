<?php
// Define Theme Options Variables
$themename = "Sidewinder";
$showsidebar = "true";

//config
$showsidebaroption = 1;
$showhomewidgetoption = 0;
$showblogoption = 1;
$showheadermenu = 0;
$showbackgroundmenu = 0;

if ( $is_iphone )
	$imageheight = 300;
else
	$imageheight = get_option( 'large_size_h' );
$cimageheight = $imageheight - 40;

// Set image sizes upon theme activation
function gpp_base_child_setup() {
	// updating thumbnail and image sizes
	update_option( 'thumbnail_size_w', 150, true );
	update_option( 'thumbnail_size_h', 150, true );
	update_option( 'medium_size_w', 620, true );
	update_option( 'medium_size_h', '', true );
	update_option( 'large_size_w', '', true );
	update_option( 'large_size_h', 500, true );
	// unregister top-menu
	unregister_nav_menu( 'top-menu' );
	// Header option removed
	remove_theme_support( 'custom-header' );
}

add_action( 'init', 'gpp_base_child_setup' );

//changing the descriptions of sidebar and widgets
add_filter( 'sidebar_desc', 'gpp_base_sidebar_desc_sw' );
function gpp_base_sidebar_desc_sw(){ return "Check to show a sidebar on blog posts and pages."; }
add_filter( 'instructions_desc', 'gpp_base_instructions_desc_sw' );
function gpp_base_instructions_desc_sw(){ return "This theme uses Widgets.<br /><br />"; }

// load jquery and core slider functionality
if ( !is_admin() ) add_action( 'wp_enqueue_scripts', 'load_js_sw' );
function load_js_sw( ) {
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-ui-core' );
	wp_enqueue_script( 'jquery-ui-slider' );

	wp_enqueue_script( 'jquerytouch', get_bloginfo( 'stylesheet_directory' ) . '/library/js/jquery.ui.touch-punch.js', array( 'jquery', 'jquery-ui-slider' ) );
	if ( has_nav_menu( 'main-menu' ) ) {
		wp_enqueue_script( 'swmobilenav', get_bloginfo( 'stylesheet_directory' ) . '/library/js/jquery.mobilenav.js', array( 'jquery' ) );
	}
}
/*-----------------------------------------------------------------------------------*/
/* REMOVE BASE DEFAULTS TO OVERIDE */
/*-----------------------------------------------------------------------------------*/


add_action( 'wp_head', 'remove_gpp_base_actions' );
function remove_gpp_base_actions() {
 	require_once ( STYLESHEETPATH . '/library/inc/core-js.php' );
 	remove_action( 'gpp_base_index_loop_hook', 'gpp_base_index_loop' );
	remove_action( 'gpp_base_archive_loop_hook', 'gpp_base_archive_loop' );
	remove_action( 'gpp_base_author_loop_hook', 'gpp_base_author_loop' );

 	global $theme_options;

	// grab categories from theme options removing the trailing comma, else removes undefined variable
	$catarray = $theme_options['gpp_base_blog_cat'];

	if( !is_page_template( 'page-blog.php' ) && !in_category( $catarray ) ) {
		remove_action( 'gpp_base_above_title_hook', 'gpp_base_below_title' );
		add_action( 'gpp_base_below_content_hook', 'gpp_base_sw_below_content' );
 	}
	// Wrap Blog Page, Blog Posts and Attachments in .textcontent
	if( is_page_template( 'page-blog.php' ) || (is_single() && in_category( $catarray ) && !is_home()) || is_attachment() || is_search() || is_page() || in_category($catarray) && !is_home() ) {
		echo "<script type='text/javascript'>jQuery(document).ready(function(){ ";
		echo "jQuery('#main').wrapAll('<div class=\"textcontent\" />')";
		echo "});</script>";
	} else {
		// remove default WP gallery code and add custom gallery
		remove_shortcode( 'gallery', 'gallery_shortcode' );
		add_shortcode( 'gallery', 'sw_gallery_shortcode' );

		remove_action( 'gpp_base_sidebar_hook', 'gpp_base_sidebar' );
		remove_action( 'gpp_base_check_sidebar_hook', 'gpp_base_check_sidebar' );
		add_action( 'gpp_base_check_sidebar_hook', 'gpp_base_no_sidebar' );

		echo "<script type='text/javascript'>jQuery(document).ready(function(){ ";
		echo "if(jQuery('#mainindex').length){
				jQuery('#mainindex').nextAll().wrapAll('<div class=\"textcontent\"></div>');
				Array.prototype.reverse.call(jQuery('.slider-navigation').prevAll()).wrapAll('<div class=\"textcontent\"></div>');
				//jQuery('.entry-content').children().nextUntil('.slider-navigation').wrapAll('<div class=\"textcontent\"></div>');
			} else {
				jQuery('.entry-content').wrapInner('<div class=\"textcontent\" />');
			} ";
		echo "});</script>";
	}
	if( is_home() ) {
		remove_action( 'gpp_base_sidebar_hook', 'gpp_base_sidebar' );
		remove_action( 'gpp_base_check_sidebar_hook', 'gpp_base_check_sidebar' );
		add_action( 'gpp_base_check_sidebar_hook', 'gpp_base_no_sidebar' );
	}

	// Make Blog category archive use the default archive loop from Base
	if( in_category( $catarray ) || is_tag() ) {
		remove_action( 'gpp_base_archive_loop_hook', 'gpp_base_index_loop_sw' );
		add_action( 'gpp_base_archive_loop_hook', 'gpp_base_archive_loop' );
	}
}

/*
* changed entry-meta hook position from above title to below content
*/

function gpp_base_sw_below_content() {
	echo '<span class="entry-meta">';
		gpp_base_posted_on_hook(); gpp_base_post_author_hook();
	echo '</span>';
}

//add_action( 'gpp_base_below_content_hook', 'gpp_base_sw_below_content' );

/*-----------------------------------------------------------------------------------*/
/* MAKE CONTENT SPAN FULL WIDTH */
/*-----------------------------------------------------------------------------------*/

function gpp_base_no_sidebar() {
	echo "nosidebar";
}

/*-----------------------------------------------------------------------------------*/
/* OVERIDE BASE DEFAULTS WITH NEW FUNCTIONS */
/*-----------------------------------------------------------------------------------*/
add_action( 'gpp_base_index_loop_hook', 'gpp_base_index_loop_sw' );
add_action( 'gpp_base_archive_loop_hook', 'gpp_base_index_loop_sw' );
add_action( 'gpp_base_author_loop_hook', 'gpp_base_index_loop_sw' );



/*-----------------------------------------------------------------------------------*/
/* CONTENT - INDEX LOOP */
/*-----------------------------------------------------------------------------------*/

function gpp_base_index_loop_sw() {
	global $theme_options, $post, $paged, $max_pages, $wp_query, $category, $author, $taxarray, $tag, $cat, $monthnum, $day, $year, $is_iphone, $is_chrome, $cimageheight, $imageheight;
	$arcyear = "";
	$arcmonth = "";
	$arcday = "";
	$postid = "";
	$showallimages = 0;

	// Somehow the wordpress global variables $day, $monthnum, $year are not coming since 3.3, hence we are defining them below.

	$day = get_the_time('j' );
	$monthnum = get_the_time('n' );
	$year = get_the_time('Y' );

	// grab categories from theme options removing the trailing comma
	if( "" != $theme_options['gpp_base_homepage_cats'] ){
		$blogcat = "";
		foreach( $theme_options['gpp_base_homepage_cats'] as $catid ) {
					$blogcat .= get_cat_ID( $catid ) . ",";
				}
		$category = rtrim( $blogcat, "," );
	}
	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	if( ( isset( $theme_options['gpp_base_homepage_design'] ) && $theme_options['gpp_base_homepage_design'] == 'galleries' ) && is_home() ) { //all galleries in homepage with single image
		$post_type = "galleries";
		$category = "";
		if( isset( $theme_options[ 'gpp_base_homepage_colls' ] ) && $theme_options[ 'gpp_base_homepage_colls' ] != "" ) {
			$blogcoll = array();
			foreach( $theme_options['gpp_base_homepage_colls'] as $termid ) {
				$collid = get_term_by( 'slug', $termid, 'collections' );
					$blogcoll[] = $collid->term_id;
				}
			$collections = $blogcoll;
			$taxarray = array(
							array(
								'taxonomy' => "collections",
								'field' => 'id',
								'terms' => $collections
							)
						) ;
		}else{
			$taxarray = "";
		}

	} elseif( ( isset( $theme_options['gpp_base_homepage_design'] ) && $theme_options['gpp_base_homepage_design'] == 'single' ) && is_home() ) { //single gallery in homepage with images
		remove_action( 'gpp_base_navigation_hook', 'gpp_base_navigation', 2 ); //remove navigation in single gallery view
		$args=array(
			  'name' => $theme_options['gpp_base_homepage_gallery'],
			  'post_type' => 'galleries',
			  'post_status' => 'publish',
			  'showposts' => 1
			);
		$my_posts = get_posts( $args );
		$postid = $my_posts[0]->ID;
		$showallimages = 1;
		$post->ID = $postid; // added to overwrite $post->ID to take the single gallery post ID.
		$queried_post = get_post( $postid );
		$content = $queried_post->post_content;
		$content = apply_filters( 'the_content', $content );
		$content = str_replace( ']]>', ']]&gt;', $content );
		echo $content;

	}else{
		$post_type = get_post_type();

	}

	// grab category for archive pages, excluding taxonomy archives
	if( is_archive() ) {
		$category = $cat;
		$taxarray = "";
	}

	if( is_author() ) {
		$category = "";
		$taxarray = "";
		$post_type = "any";
	}

	if( is_tag() ) {
		$category = "";
		$taxarray = "";
	}
	if( is_year() ) {
		$category = "";
		$taxarray = "";
		$arcyear = $year;
		$arcmonth = "";
		$arcday = "";
		$post_type = "any";
	}
	if( is_month() ) {
		$category = "";
		$taxarray = "";
		$arcyear = $year;
		$arcmonth = $monthnum;
		$arcday = "";
		$post_type = "any";
	}
	if( is_day() ) {
		$category = "";
		$taxarray="";
		$arcyear = $year;
		$arcmonth = $monthnum;
		$arcday = $day;
		$post_type = "any";
	}

	// if we are viewing a custom taxonomy for galleries, don't get category
	if( is_tax() ) {
		$category = "";
		$tax = $wp_query->get_queried_object();
		$taxname = $tax->taxonomy;
		$tax = $tax->slug;
		$taxarray = array(
							array(
								'taxonomy' => $taxname,
								'field' => 'slug',
								'terms' => $tax
							)
						) ;
	}

	if( $showallimages == 0 ) {
		$args = array(
			'paged' => $paged,
			'meta_key' => '_thumbnail_id',
			'cat' => $category,
			'tag'=> $tag,
			'author' => $author,
			'year' => $arcyear,
			'monthnum' => $arcmonth,
			'day' => $arcday,
			'post_type' => $post_type,
			'tax_query' =>$taxarray
		);

		$temp = $wp_query;
		$wp_query = null;
		$wp_query = new WP_Query();
		$wp_query->query( $args );
		$max_pages = intval( $wp_query->max_num_pages ); // used for index/archive navigation

		$width = 0;
		while ( $wp_query->have_posts() ) : $wp_query->the_post();
			$do_not_duplicate = $post->ID;
			 if( has_post_thumbnail() ) {
				$id = get_post_thumbnail_id( $post->ID );
				if ( $is_iphone )
					$image = wp_get_attachment_image_src( $id, 'mobile' );
				else
					$image = wp_get_attachment_image_src( $id, 'large' );
				$size = $image[1];
				$width = $width + $size;
			}

		endwhile;
		rewind_posts();

		//$imageheight = get_option( 'large_size_h');
		?>

		<div class="slider-navigation">
			<a class="leftnav" style="height:<?php echo $cimageheight; ?>px"></a>
			<a class="rightnav" style="height:<?php echo $cimageheight; ?>px"></a>
		</div>

		<div id="mainholder">
			<div id="holder" style="width:<?php echo ($width); ?>px;height:<?php echo $imageheight; ?>px">
			  <?php
				// show large rows of images
				while ( $wp_query->have_posts() ) : $wp_query->the_post();
					$do_not_duplicate = $post->ID;
					if( has_post_thumbnail() ) { ?>
						<div class="singleitem"<?php //post_class('singleitem'); ?>>
						<?php
							if ( $is_iphone )
								the_post_thumbnail( 'mobile' );
							else
								the_post_thumbnail( 'large' );
						?>
							<a class="imglink" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</div>
					<?php } ?>
				<?php
				endwhile;
				rewind_posts();
				?>
			 </div><!-- #holder -->
		</div><!-- #mainholder -->

		<div id="mainindex">
			<div id="imagediv">
			  <span class="start"></span>
			  <?php
			  //show thumbnails
			  while ( $wp_query->have_posts() ) : $wp_query->the_post();
					$do_not_duplicate = $post->ID;
					if( has_post_thumbnail() ) {
						the_post_thumbnail( 'thumbnail-50' );
					}
					endwhile; $wp_query = null; $wp_query = $temp; ?>
				<span class="end"></span>
			</div><!-- #imagediv -->
			<div id="index"></div>
		</div><!-- #mainindex -->

	<?php
	}/******  end if($showallimages==0) *****/
}

/*-----------------------------------------------------------------------------------*/
/* CONTENT - GALLERY SHORTCODE */
/*-----------------------------------------------------------------------------------*/


//replace default gallery shortcode by image slider if not blog category
function sw_gallery_shortcode( $attr ) {
   global $post, $is_iphone, $is_chrome,$cimageheight;
   // to show the custom taxonomies in single page of the custom post-type galleries
	if( get_post_type( $post->ID ) == "galleries" ) {
		remove_action( 'gpp_base_single_meta_hook', 'gpp_base_single_meta' );
		add_action( 'gpp_base_single_meta_hook', 'gpp_base_single_gallery_meta' );
	}

	$post = get_post();

	static $instance = 0;
	$instance++;

	if ( ! empty( $attr['ids'] ) ) {
		// 'ids' is explicitly ordered, unless you specify otherwise.
		if ( empty( $attr['orderby'] ) )
			$attr['orderby'] = 'post__in';
		$attr['include'] = $attr['ids'];
	}

	// Allow plugins/themes to override the default gallery template.
	$output = apply_filters( 'post_gallery', '', $attr );
	if ( $output != '' )
		return $output;

	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}

	extract(shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'columns'    => 3,
		'size'       => 'thumbnail-50',
		'include'    => '',
		'exclude'    => ''
	), $attr));

	$id = intval($id);
	if ( 'RAND' == $order )
		$orderby = 'none';

	if ( !empty( $include ) ) {
		$_attachments = get_posts( array( 'include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( !empty( $exclude ) ) {
		$attachments = get_children( array( 'post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );
	} else {
		$attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );
	}

	if ( empty( $attachments ) )
		return '';

	$width = "";
	foreach ( $attachments as $id => $attachment ) {
		if ( $is_iphone )
			$image = wp_get_attachment_image_src( $id, 'mobile' );
		else
			$image = wp_get_attachment_image_src( $id, 'large' );
		$size = $image[1];
		$width = $width + $size;
	}
 ?>
 <?php
	//$imageheight = get_option( 'large_size_h');
 $swshortcode = '<div class="slider-navigation">
	<a class="leftnav" style="height:'. $cimageheight.'px"></a><a class="rightnav" style="height:'.$cimageheight.'px"></a>
</div>

<div id="mainholder">
	<div id="holder" style="width:'.$width.'px;height:'.$cimageheight.'px">';

				foreach ( $attachments as $id => $attachment ) {
					if ( $is_iphone )
						$image = wp_get_attachment_image_src( $id,'mobile' );
					else
						$image = wp_get_attachment_image_src( $id,'large' );
						$alt_text = get_post_meta( $id, '_wp_attachment_image_alt', true );
						$link_url = get_post_meta( $id, '_wp_attachment_url', true ); // link url of the attachment added **currently wordpress 3.1.2 has a bug with this feature.**
						$download_buy_url = get_post_meta( $id, '_download_buy_url', true );
						$swshortcode .= '<div class="singleitem">
							<img src="' . $image[0] . '" width="' . $image[1] . '" height="' . $image[2] . '" alt="' . $alt_text . '" />';
						if( !empty( $attachment->post_excerpt ) && !empty( $attachment->post_title ) ) {
						$swshortcode .= '<div class="imglink show"></div>
						<div class="postlink"><div class="imgexcerpt"><h6>' . $attachment->post_title . '</h6>' . $attachment->post_excerpt . '</div></div>
					'; }
					if( $download_buy_url != "" ) {
					$swshortcode .= '<div class="linkurl show"><a href="' . $download_buy_url . '">Link</a></div>
					'; }

				$swshortcode .='</div>';
			}
$swshortcode .= '</div>
</div>
<div id="mainindex">
	<div id="imagediv">
		<span class="start"></span>';
		foreach ( $attachments as $id => $attachment ) {
			$image = wp_get_attachment_image_src( $id,'thumbnail-50' );
			$alt_text = get_post_meta( $id, '_wp_attachment_image_alt', true );
			$swshortcode .= '<img src="' . $image[0] . '" width="' . $image[1] . '" height="' . $image[2] . '" alt="' . $alt_text . '" />';
		}
		$swshortcode .='<span class="end"></span>
	</div>
	<div id="index"></div>
</div>
';

return $swshortcode;

}

/*-----------------------------------------------------------------------------------*/
/* Register new post type */
/*-----------------------------------------------------------------------------------*/

add_action( 'init', 'gpp_base_sw_gallery_create_type' );

function gpp_base_sw_gallery_create_type() {

	$sslug = __( 'Gallery', 'gpp_base_lang' );
	$slug = __( 'Galleries', 'gpp_base_lang' );

	$sslugl = strtolower( $sslug ); // single name lowercase
	$slugl = strtolower( $slug ); // plural name lowercase

	register_post_type('galleries',
		array(
			'labels' => array(
				'name'						=> $slug,
				'singular_name' 			=> $sslug,
				'add_new'					=> __( 'Add ' . $sslug . '' ),
				'add_new_item'				=> __( 'Add ' . $sslug . '' ),
				'new_item'					=> __( 'Add ' . $sslug . '' ),
				'view_item'					=> __( 'View ' . $slug . '' ),
				'search_items' 				=> __( 'Search ' . $slug . '' ),
				'edit_item' 				=> __( 'Edit ' . $sslug . '' ),
				'all_items'					=> __( 'All ' . $slug . '' ),
				'not_found'					=> __( 'No ' . $slug . ' found' ),
				'not_found_in_trash'		=> __( 'No ' . $slug . ' found in Trash' )
			),
			'taxonomies'	=> array('collections', 'gallery_tags'),
			'public' => true,
			'show_ui' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'rewrite' => array( 'slug' => '' . $sslugl . '', 'with_front' => false ),
			'query_var' => true,
			'supports' => array( 'title', 'revisions', 'thumbnail', 'author', 'editor', 'comments' ),
			'menu_position' => 5,
			'menu_icon' => get_bloginfo( 'stylesheet_directory' ) . '/images/icon.jpg',
			'has_archive' => '' . $slugl . ''
		)
	);
}


/*-----------------------------------------------------------------------------------*/
/* Register taxonomy for new post type */
/*-----------------------------------------------------------------------------------*/

add_action( 'init', 'gpp_base_sw_gallery_taxonomy', 0 );

function gpp_base_sw_gallery_taxonomy() {
	// Add new taxonomy, make it hierarchical (like categories)
  $labels = array(
    'name' => _x( 'Collections', 'taxonomy general name' ),
    'singular_name' => _x( 'Collection', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Collections' ),
    'all_items' => __( 'All Collections' ),
    'parent_item' => __( 'Parent Collection' ),
    'parent_item_colon' => __( 'Parent Collection:' ),
    'edit_item' => __( 'Edit Collection' ),
    'update_item' => __( 'Update Collection' ),
    'add_new_item' => __( 'Add New Collection' ),
    'new_item_name' => __( 'New Collection Name' ),
    'menu_name' => __( 'Collections' )
  );
	register_taxonomy( 'collections', 'galleries', array(
				'hierarchical' => true,
				'labels' => $labels,
				'query_var' => true,
				'rewrite' => array( 'slug' => 'collection' )
	));
}

add_action( 'init', 'gpp_base_sw_gallery_tags', 1 );

function gpp_base_sw_gallery_tags() {
	register_taxonomy( 'gallery_tags', 'galleries', array(
				'hierarchical' => false,
				'update_count_callback' => '_update_post_term_count',
				'label' => __('Gallery Tags'),
				'query_var' => true,
				'rewrite' => true
	)) ;

}

// ADDS EXTRA INFO TO ADMIN MENU FOR GALLERY POST TYPE
add_filter( 'manage_edit-galleries_columns', 'add_new_galleries_columns' );
function add_new_galleries_columns( $galleries_columns ) {
	$new_columns['cb'] = '<input type="checkbox" />';
	$new_columns['title'] = _x( 'Title', 'column name' );
	$new_columns['author'] = __( 'Author' );
	$new_columns['gcategories'] = __( 'Collections' );
	$new_columns['gtags'] = __( 'Gallery Tags' );
	$new_columns['date'] = _x( 'Date', 'column name' );
	return $new_columns;
}

// Add to admin_init function
add_action( 'manage_galleries_posts_custom_column', 'manage_galleries_columns', 10, 3 );
function manage_galleries_columns( $column_name, $id ) {
global $post;
	switch ( $column_name ) {
		case 'gcategories':
			// Get the collections
			$gcats = "";

			$collections = get_the_terms( $post->ID, 'collections' );
			if( $collections != "" ) {
				foreach( $collections as $collection ) {
					$gcats .= " <a href=edit.php?post_type=galleries&collections=" . $collection->slug . ">" . $collection->name . "</a>,";
				}
			}
			echo substr( $gcats, 0, -1 );
			break;
		case 'gtags':
			// Get the collections
			$gtags = "";
			$gallery_tags = get_the_terms( $post->ID, 'gallery_tags' );
			if( $gallery_tags != "" ) {
				foreach( $gallery_tags as $gallery_tag ) {
					$gtags .= " <a href=edit.php?post_type=galleries&gallery_tags=" . $gallery_tag->slug . ">" . $gallery_tag->name . "</a>,";
				}
			}
			echo substr( $gtags, 0, -1 );
			break;
		default:
			break;
	} // end switch
}

// overwrite the default meta function with this for the custom post-type galleries
function gpp_base_single_gallery_meta() {
	global $post;
	$collections_list = get_the_term_list( $post->ID, 'collections', '', ', ', '' );
	$tags_list = get_the_term_list( $post->ID, 'gallery_tags', '', ', ', '' );

	echo '<div class="entry-utility">';
		_e( 'Posted in ', 'gpp_base_lang' );  echo $collections_list; _e( ' and tagged with ', 'gpp_base_lang' );  echo $tags_list; echo ". ";
		 printf( __( '<a href="%1$s" title="%2$s feed">%2$s</a> feed. ', 'gpp_base_lang' ), get_post_comments_feed_link(), __( 'RSS 2.0', 'gpp_base_lang' ) );
		 edit_post_link( __( 'Edit this entry', 'gpp_base_lang' ), '', '.' );
	echo '</div>';
}

// turn off the comments in the gallery post types by default.
function default_comments_off( $data ) {
    if( $data['post_type'] == 'galleries' && $data['post_status'] == 'auto-draft' ) {
        $data['comment_status'] = 0;
    }
    return $data;
}
add_filter( 'wp_insert_post_data', 'default_comments_off' );


/*
get the gallery posts.
*/
$args = array( 'post_type'=>'galleries', 'numberposts'=>-1, 'order'=>'DESC', 'orderby'=>'ID' );
$mygalleries = get_posts($args);
$galleries = array();

foreach( $mygalleries as $post ) :	setup_postdata($post);
		if ( stripos( $post->post_content, '[gallery' ) !== false ){
			$galleries[ $post->post_name ]['name'] = $post->post_name;
		$galleries[ $post->post_name ] ['title'] = get_the_title();
		}
endforeach;

/*
Sidewinder options
*/

function base_child_options() {
	global $galleries;
	$misc_tab = array(
		"name" => "misc_tab",
		"title" => __( "Homepage Design", "gpp" ),
		"sections" => array(
			"misc_section_1" => array(
				"name" => "misc_section_1",
				"title" => __( "Homepage Design", "gpp" ),
				"description" => __( "", "gpp" )
			)
		)
	);

	gpp_register_theme_option_tab( $misc_tab );


	$terms = array();
	global $wpdb;
	$collectionids=$wpdb->get_results( "SELECT term_id FROM $wpdb->term_taxonomy WHERE taxonomy='collections'" );
	foreach($collectionids as $collectionid){
		$collsname=$wpdb->get_row( "SELECT * FROM $wpdb->terms WHERE term_id='" . $collectionid->term_id . "'", 'ARRAY_A' );
		$terms[ $collsname['slug'] ]['name'] = $collsname['slug'];
		$terms[ $collsname['slug'] ] ['title'] = $collsname['name'];
	}

	$options = array(
		'gpp_base_separation_distance' => array(
			"tab" => "misc_tab",
			"name" => "gpp_base_separation_distance",
			"title" => "Image Separation",
			"description" => __( 'Set the separation distance in pixels between images in the slider.', "gpp" ),
			"section" => "misc_section_1",
			"since" => "1.0",
			"id" => "misc_section_1",
			"type" => "select",
			"default" => "12",
			"valid_options" => array(
				"0" => array(
					"name" => "0",
					"title" => __( "0", "gpp" )
				),
				"1" => array(
					"name" => "1",
					"title" => __( "1", "gpp" )
				),
				"5" => array(
					"name" => "5",
					"title" => __( "5", "gpp" )
				),
				"10" => array(
					"name" => "10",
					"title" => __( "10", "gpp" )
				)
			)
		),


		'gpp_base_homepage_design' => array(
			"tab" => "misc_tab",
			"name" => "gpp_base_homepage_design",
			"title" => "Homepage design",
			"description" => __( "The homepage slideshow can display your Latest Posts, Latest Galleries or a single gallery.  The Posts and Galleries options display all posts that have both a Post Thumbnail and a gallery inserted into the post.", "gpp" ),
			"section" => "misc_section_1",
			"since" => "1.0",
			"id" => "misc_section_1",
			"type" => "select",
			"default" => "",
			"valid_options" => array(
				"posts" => array(
					"name" => "posts",
					"title" => __( "Latest Posts", "gpp" )
				),
				"galleries" => array(
					"name" => "galleries",
					"title" => __( "Latest Galleries", "gpp" )
				),
				"single" => array(
					"name" => "single",
					"title" => __( "Single Gallery", "gpp" )
				)
			)
		),

		'gpp_base_homepage_cats' => array(
			"tab" => "misc_tab",
			"name" => "gpp_base_homepage_cats",
			"title" => "Post Categories",
			"description" => __( 'Select categories you want to show', "gpp" ),
			"section" => "misc_section_1",
			"since" => "1.0",
			"id" => "misc_section_1",
			"type" => "checkbox",
			"default" => "",
			"valid_options" => gpp_get_taxonomy_list()
		),

		'gpp_base_homepage_colls' => array(
			"tab" => "misc_tab",
			"name" => "gpp_base_homepage_colls",
			"title" => "Gallery Collections",
			"description" => __( 'Select collections you want to show', "gpp" ),
			"section" => "misc_section_1",
			"since" => "1.0",
			"id" => "misc_section_1",
			"type" => "checkbox",
			"default" => "",
			"valid_options" => $terms
		),
		'gpp_base_homepage_gallery' => array(
			"tab" => "misc_tab",
			"name" => "gpp_base_homepage_gallery",
			"title" => "Single Gallery",
			"description" => __( 'Select a gallery you want to show on homepage', "gpp" ),
			"section" => "misc_section_1",
			"since" => "1.0",
			"id" => "misc_section_1",
			"type" => "select",
			"default" => "",
			"valid_options" => $galleries
		)
	);

	gpp_register_theme_options( $options );
}
add_filter('child_theme_options', 'base_child_options');

/**
 * Flush your rewrite rules for custom post type and taxonomies added in theme
 * @package Sidewinder
 * @since Sidewinder 2.1
 * @author Thad Allender
 */
function sidewinder_flush_rewrite_rules() {
    global $pagenow, $wp_rewrite;

    if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) )
        $wp_rewrite->flush_rules();
}

add_action( 'load-themes.php', 'sidewinder_flush_rewrite_rules' );


// Integrate old settings into new
function gpp_preserve_sidewinder_old_settings(){
	$new = array();
	$old = get_option( 'gpp_base_options');

	$new_value = array();

	foreach ($old as $key => $value) {
		if( $key == 'gpp_base_logo' ){
			$new_value['logo'] = $value;
		}
		if( $key == 'gpp_base_custom_favicon' ){
			$new_value['favicon'] = $value;
		}
		if( $key == 'gpp_base_alt_css' ){
			$val = explode( ".", $value );
			$new_value['color'] = $val[0];
		}
		if( $key == 'gpp_base_custom_css' ){
			$new_value['css'] = $value;
		}
		if( $key == 'gpp_base_blog_cat' ){
			$val = explode( ",", $value );
			$cats = array();
			foreach ( $val as $key => $value ) {
				if( "" != $value ) {
					$cat_array = get_category( $value, 'ARRAY_A' );
					$cats[] .= $cat_array['slug'];
				}
			}
			$new_value['gpp_base_blog_cat'] = $cats;
		}
		//Sidewinder
		if( $key == 'gpp_base_separation_distance' ){
			$new_value['gpp_base_separation_distance'] = $value;
		}
		if( $key == 'gpp_base_homepage_design' ){
			$new_value['gpp_base_homepage_design'] = $value;
		}
		if( $key == 'gpp_base_homepage_cats' ){
			$val = explode( ",", $value );
			$cats = array();
			foreach ( $val as $key => $value ) {
				if( "" != $value ) {
					$cat_array = get_category( $value, 'ARRAY_A' );
					$cats[] .= $cat_array['slug'];
				}
			}
			$new_value['gpp_base_homepage_cats'] = $cats;
		}
		if( $key == 'gpp_base_homepage_colls' ){
			$val = explode( ",", $value );
			$cats = array();
			foreach ( $val as $key => $value ) {
				if( "" != $value ) {
					$cat_array = get_term( $value, 'collections', 'ARRAY_A' );
					$cats[] .= $cat_array['slug'];
				}
			}
			$new_value['gpp_base_homepage_colls'] = $cats;
		}
		if( $key == 'gpp_base_homepage_gallery' ){
			$val = get_post( $value, 'ARRAY_A' );
			$new_value['gpp_base_homepage_gallery'] = $val['post_name'];
		}
		//Sidewinder
	}

	$new = array_merge( $new, $new_value );
	update_option( gpp_get_current_theme_id() . '_options', $new );
}

//First check it make sure this function has not been done
if ( get_option( 'sidewinder_settings_integrated') != "yes") {
	add_action( 'init', 'gpp_preserve_sidewinder_old_settings', 20 );
	//now that function has been run, set option so it wont run again
	update_option( 'sidewinder_settings_integrated', 'yes' );
}

/* ==============================================================================
 *  Added to customize theme to build a custom Woo Commerce Theme 
 * ===========================================================================+== */
add_theme_support( 'custom-background' );

$args = array(
	'default-color' => 'ffffff',
	'default-image' => '%1$s/images/background.jpg',
);
add_theme_support( 'custom-background', $args );