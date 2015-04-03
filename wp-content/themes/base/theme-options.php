<?php
/**
 * Define the Tabs appearing on the Theme Options page
 * Tabs contains sections
 * Options are assigned to both Tabs and Sections
 * See README.md for a full list of option types
 */
global $css;
$general_settings_tab = array(
    "name" => "general_tab",
    "title" => __( "General", "gpp" ),
    "sections" => array(
        "general_section_1" => array(
            "name" => "general_section_1",
            "title" => __( "General", "gpp" ),
            "description" => __( "", "gpp" )
        )
    )
);
gpp_register_theme_option_tab( $general_settings_tab );

$color_settings_tab = array(
    "name" => "colors_tab",
    "title" => __( "Colors", "gpp" ),
    "sections" => array(
        "colors_section_1" => array(
            "name" => "colors_section_1",
            "title" => __( "Colors", "gpp" ),
            "description" => __( "", "gpp" )
        )
    )
);

gpp_register_theme_option_tab( $color_settings_tab );

 /**
 * The following example shows you how to register theme options and assign them to tabs and sections:
*/

$options = array(
    'logo' => array(
        "tab" => "general_tab",
        "name" => "logo",
        "title" => "Logo",
        "description" => __( "Upload a logo for your theme, or specify the image address of your online logo. (http://yoursite.com/logo.png).  Logos should be in transparent PNG format and be 60px in max height and 350px in max width.  If you don't upload a logo, your site name will appear in unstyled html text.", "gpp" ),
        "section" => "general_section_1",
        "since" => "1.0",
        "id" => "general_section_1",
        "type" => "image",
        "default" => ""
    ),
    'favicon' => array(
        "tab" => "general_tab",
        "name" => "favicon",
        "title" => "Favicon",
        "description" => __( "Upload a 16px x 16px Png/Gif image that will represent your website's favicon.", "gpp" ),
        "section" => "general_section_1",
        "since" => "1.0",
        "id" => "general_section_1",
        "type" => "image",
        "default" => ""
    ),
    'font' => array(
        "tab" => "general_tab",
        "name" => "font",
        "title" => "Headline Font",
        "description" => __( '<a href="' . get_option('siteurl') . '/wp-admin/admin-ajax.php?action=fonts&font=header&height=600&width=640" class="thickbox">Preview and choose a font</a>', "gpp" ),
        "section" => "general_section_1",
        "since" => "1.0",
        "id" => "general_section_1",
        "type" => "select",
        "default" => "Allan:400,700",
        "valid_options" => gpp_font_array()
    ),
    'font_alt' => array(
        "tab" => "general_tab",
        "name" => "font_alt",
        "title" => "Body Font",
        "description" => __( '<a href="' . get_option('siteurl') . '/wp-admin/admin-ajax.php?action=fonts&font=body&height=600&width=640" class="thickbox">Preview and choose a font</a>', "gpp" ),
        "section" => "general_section_1",
        "since" => "1.0",
        "id" => "general_section_1",
        "type" => "select",
        "default" => "Allan:400,700",
        "valid_options" => gpp_font_array()
    ),
		
	
	'gpp_base_blog_cat' => array(
        "tab" => "general_tab",
        "name" => "gpp_base_blog_cat",
        "title" => "Blog Category",
        "description" => __( 'Choose categories to be displayed in the Blog template page. You will want to create a Page called "Blog" and assign it to the "Blog" Page Template in the Page Attributes area.', "gpp" ),
        "section" => "general_section_1",
        "since" => "1.0",
        "id" => "general_section_1",
        "type" => "checkbox",
		"default" => array("uncategorized"),
		"valid_options" => gpp_get_taxonomy_list()
    ),
	'color' => array(
        "tab" => "colors_tab",
        "name" => "color",
        "title" => "Color",
        "description" => __( "Select your desired theme color scheme", "gpp" ),
        "section" => "colors_section_1",
        "since" => "1.0",
        "id" => "colors_section_1",
        "type" => "select",
        "default" => "default",
        "valid_options" => $css
    ),	
	"css" => array(
        "tab" => "colors_tab",
        "name" => "css",
        "title" => "Custom CSS",
        "description" => __( "Add some custom CSS to your theme.", "gpp" ),
        "section" => "colors_section_1",
        "since" => "1.0",
        "id" => "colors_section_1",
        "type" => "textarea",
        "sanitize" => "html",
        "default" => ""
    )
);
gpp_register_theme_options( $options );

	

child_theme_options();
?>