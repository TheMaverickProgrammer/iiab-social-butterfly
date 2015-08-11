<?php
/**
 * @package IIAB Social Butterfly
 */
/*
Plugin Name: IIAB Social Butterfly
Plugin URI: 
Description: A sidebar that floats gently on your page and displays popular social networking buttons. Styling and urls configurable under Appearance >> Site Options.
Author: Image In A Box
Author URI: 
License: GPLv2 or later
Text Domain: 
*/

require_once('admin-interface.php');
require_once('admin-functions.php');

add_action( 'wp_head', 'safely_add_social_icon_style' );

/**
 * Add stylesheet to the page
 */
function safely_add_social_icon_style() {
	wp_enqueue_style( 'SocialButterflyStylesheet', plugins_url('socialfloater.css', __FILE__) );
}
	
function add_social_icons_sidebar() {
	
    $pinterest = get_option( 'imageinabox_pinterest' );
	$youtube = get_option( 'imageinabox_youtube' );
	$facebook = get_option( 'imageinabox_facebook' );
	$instagram = get_option( 'imageinabox_instagram' );
	$twitter = get_option( 'imageinabox_twitter' );
	$googleplus = get_option( 'imageinabox_googleplus' );
	
	$socialOutput = "
			<ul class=\"iiabSocial\">
				";
    if( !empty( $youtube ) )
		$socialOutput .= "<li><a title=\"Subscribe to our YouTube Channel\" class=\"youIcon\" onclick=\" window.open(this.href); ga('send', 'event', 'Header Social', 'Clicked', 'YouTube'); return false;\" href=\"$youtube\">YouTube</a></li>";
	if( !empty( $facebook ) )
		$socialOutput .= "<li><a title=\"Become our friend on Facebook\" class=\"fbIcon\" onclick=\" window.open(this.href); ga('send', 'event', 'Header Social', 'Clicked', 'Facebook'); return false;\" href=\"$facebook\">Facebook</a></li>";
	if( !empty( $instagram ) )
		$socialOutput .= "<li><a title=\"Follow us on Instagram\" class=\"InIcon\" onclick=\" window.open(this.href); ga('send', 'event', 'Header Social', 'Clicked', 'Instagram'); return false;\" href=\"$instagram\">Instagram</a></li>";
	if( !empty( $twitter ) )
		$socialOutput .= "<li><a title=\"Follow " . get_bloginfo( 'name' ) . " Tweets, Tweets!\" class=\"twIcon\" onclick=\" window.open(this.href); ga('send', 'event', 'Header Social', 'Clicked', 'Twitter'); return false;\" href=\"$twitter\">Twitter</a></li>";
	if( !empty( $googleplus ) )
		$socialOutput .= "<li><a title=\"Follow us today\" class=\"googleIcon\" onclick=\" window.open(this.href); ga('send', 'event', 'Header Social', 'Clicked', 'Google Plus'); return false;\" href=\"$googleplus\">Google Plus</a></li>";
    if( !empty( $pinterest) )
        $socialOutput .= "<li><a title=\"Follow us on Pinterest\" class=\"pIcon\" onclick=\" window.open(this.href); ga('send', 'event', 'Header Social', 'Clicked', 'Pinterest'); return false;\" href=\"$pinterest\">Pinterest</a></li>";
    $socialOutput .= "	</ul>
	";
	
	echo $socialOutput;
}

add_action( 'wp_footer', 'add_social_icons_sidebar', 20 );

function add_icons_sidebar_filter($content){
	$content = iiab_social_icons().$content;
	
	return $content;
}

add_action('init','of_options');

if (!function_exists('of_options')) {
	function of_options() {
		
		//Theme Shortname
		$shortname = "imageinabox";
		
		
		//Populate the options array
		global $tt_options;
		$tt_options = get_option('of_options');
		
		
		//Access the WordPress Pages via an Array
		$tt_pages = array();
		$tt_pages_obj = get_pages('sort_column=post_parent,menu_order');    
		foreach ($tt_pages_obj as $tt_page) {
			$tt_pages[$tt_page->ID] = $tt_page->post_name;
		}
		$tt_pages_tmp = array_unshift($tt_pages, "Select a page:"); 
		
		
		//Access the WordPress Categories via an Array
		$tt_categories = array();  
		$tt_categories_obj = get_categories('hide_empty=0');
		foreach ($tt_categories_obj as $tt_cat) {
			$tt_categories[$tt_cat->cat_ID] = $tt_cat->cat_name;
		}
		$categories_tmp = array_unshift($tt_categories, "Select a category:");
		
		
		//Sample Array for demo purposes
		$sample_array = array("1","2","3","4","5");
		
		
		//Sample Advanced Array - The actual value differs from what the user sees
		$sample_advanced_array = array("image" => "The Image","post" => "The Post"); 
		
		
		//Folder Paths for "type" => "images"
		$sampleurl =  SOCIALFLOATER_PLUGIN_DIR . '/_inc/admin/images/sample-layouts/';
		
		
		/*-----------------------------------------------------------------------------------*/
		/* Create The Custom Site Options Panel
		/*-----------------------------------------------------------------------------------*/
		$options = array(); // do not delete this line - sky will fall
		
		
		
		
		/* Option Page 1 - All Options */	
		$options[] = array( "name" => __('Social Options','iiab'),
					"type" => "heading");
					
					
		$options[] = array( "name" => __('Attention','iiab'),
					"desc" => "",
					"id" => $shortname."_sample_callout",
					"std" => "Changing this information below will change the data on the live site.",
					"type" => "info");
					
		$options[] = array( "name" => __('Pinterest URL', 'iiab'),
                    "desc" => "Full Pinterest URL.",
                    "id" => $shortname."_pinterest",
                    "std" => "",
                    "type" => "text");
		$options[] = array( "name" => __('YouTube Channel URL','iiab'),
					"desc" => "Full YouTube Channel URL.",
					"id" => $shortname."_youtube",
					"std" => "",
					"type" => "text");
		$options[] = array( "name" => __('Facebook URL','iiab'),
					"desc" => "Full Facebook URL.",
					"id" => $shortname."_facebook",
					"std" => "",
					"type" => "text");
		$options[] = array( "name" => __('Instagram URL','iiab'),
					"desc" => "Full Instagram URL.",
					"id" => $shortname."_instagram",
					"std" => "",
					"type" => "text");
		$options[] = array( "name" => __('Twitter URL','iiab'),
					"desc" => "Full Twitter URL.",
					"id" => $shortname."_twitter",
					"std" => "",
					"type" => "text");
		$options[] = array( "name" => __('Google Plus URL','iiab'),
					"desc" => "Full Google Plus URL",
					"id" => $shortname."_googleplus",
					"std" => "",
					"type" => "text");
		
		/*
		Option Page 2 - Sample Page
		$options[] = array( "name" => __('Sample Page','iiab'),
					"type" => "heading");
					
		
		$options[] = array( "name" => __('Website Logo','iiab'),
					"desc" => __('Upload a custom logo for your Website.','iiab'),
					"id" => $shortname."_sitelogo",
					"std" => "",
					"type" => "upload");
					
					
		$options[] = array( "name" => __('Favicon','iiab'),
					"desc" => __('Upload a 16px x 16px image that will represent your website\'s favicon.<br /><br /><em>To ensure cross-browser compatibility, we recommend converting the favicon into .ico format before uploading. (<a href="http://www.favicon.cc/">www.favicon.cc</a>)</em>','iiab'),
					"id" => $shortname."_favicon",
					"std" => "",
					"type" => "upload");
					
											   
		$options[] = array( "name" => __('Tracking Code','iiab'),
					"desc" => __('Paste Google Analytics (or other) tracking code here.','iiab'),
					"id" => $shortname."_google_analytics",
					"std" => "",
					"type" => "textarea");
		
						
		*/			
		
		
		update_option('of_template',$options); 					  
		update_option('of_themename',$shortname);   
		update_option('of_shortname',$shortname);
	
	}
}
?>