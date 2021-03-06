<?php
add_theme_support( 'woocommerce' );
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);

add_action("woocommerce_archive_description", "giftFeatured", 10, 2);

function giftFeatured(){
	$term = get_queried_object();
	if ($term && $term->taxonomy === "product_tag"){
		echo "<div style='padding: 20px 0'>";
			if (function_exists('z_taxonomy_image_url')) z_taxonomy_image($term->term_id);
			if (function_exists('taxonomy_featured_image')) taxonomy_featured_image($term->term_id);
		echo "<div>";
	}
}

if(!class_exists('wCore')) {

	class wCore{

		static function get_dir($dirname, $all = true,  $location = false){
			$location = ($location == false ? $location = dirname(__FILE__) : $location);
			$dirnames = glob($location . '/'. $dirname .'/*.php');

			foreach ($dirnames as $filename) {
						$adds = explode("/", $filename);
					include $filename;
			}
		}

		static function get_addon($dirname, $folders = true, $location = false){
			$location = ($location == false ? $location = dirname(__FILE__) : $location);
			$dirnames = glob($location . '/'. $dirname .'/*.php');

			if (is_array($dirnames)){
				foreach ($dirnames as $filename) {
							$adds = explode("/", $filename);
						include $filename;
				}
			}


			if ($folders == true){
				$dirnames = glob(dirname(__FILE__) . '/'. $dirname . '/*', GLOB_ONLYDIR);
				foreach ($dirnames as $filename) {
							$adds = explode("/", $filename);
						include $filename . '/' . end($adds) . '.php';
				}
			}
		}

		function logout_url(){
			wp_redirect( home_url() );
			exit();
		}

	} //End wCore Class
}

if(!class_exists('ThemeFramework')) {

	class ThemeFramework{

		public function __construct(){
			add_action( 'init', array(&$this, 'images_setup' ));
			add_action( 'init', array(&$this, 'nav_menus_setup' ));
			add_action('admin_menu', array(&$this, 'create_pages'));
			add_action('admin_init', array(&$this, 'register_settings') );
			add_filter( 'wp_nav_menu_items', array(&$this, 'loginout_menu_link'), 10, 2 );
			add_action( 'pre_get_posts', array(&$this, 'polylang_search_normalize' ));
			add_action( 'pre_get_posts', array(&$this, 'gallery_posts_per_page' ));
			add_action( 'after_setup_theme', array(&$this, 'set_languages' ));
			add_filter( 'logout_url', array(&$this, 'logout_url'), 10, 2 );

			$this->init();
		}

		public function init(){
			if (class_exists("wCore")){
				wCore::get_dir('class', false, dirname(__FILE__));
				wCore::get_dir('post-types', false, dirname(__FILE__));
				wCore::get_dir('widgets', false, dirname(__FILE__));
			}

		}

		function set_languages(){
		    load_theme_textdomain( 'blackcrystal', get_template_directory() . '/languages' );
		}

		public function logout_url($logout_url, $redirect){
			return $logout_url . '&redirect_to=' . home_url();
		}

		public function create_pages(){
			add_menu_page('Téma beállítások', 'Téma beállítások', 'administrator', __FILE__, array(&$this, 'theme_settings_page'),'dashicons-welcome-view-site', 998);
		}

		public function theme_settings_page(){
			include(sprintf("%s/admin-templates/theme-options.php", dirname(__FILE__)));
		}

		public function register_settings(){
			register_setting('theme-options', 'shop_type');
			register_setting('theme-options', 'page_video');
			register_setting('theme-options', 'page_kontakt');
			register_setting('theme-options', 'page_sale');
			register_setting('theme-options', 'page_gift');
			register_setting('theme-options', 'page_actuality');
			register_setting('theme-options', 'page_subtitle');
			register_setting('theme-options', 'page_shipping');
			register_setting('theme-options', 'callback_form');
			register_setting('theme-options', 'writeus_form');
			register_setting('theme-options', 'kh_logo');
			register_setting('theme-options', 'video_form');
			register_setting('theme-options', 'google_analytics');
		}

		public function images_setup(){
			add_theme_support( 'wc-product-gallery-zoom' );
			add_theme_support( 'wc-product-gallery-lightbox' );
			add_theme_support( 'wc-product-gallery-slider' );
			add_theme_support( 'post-thumbnails' );

			//Add image sizes
			add_image_size( 'home-gallery-thumb', 520, 300, true );
			add_image_size( 'gallery-thumb', 290, 220, true );
		}

		public function nav_menus_setup() {
			register_nav_menu( 'top-menu', __( 'Top menu', 'blackcrystal' ) );
			register_nav_menu( 'header-menu', __( 'Header menu', 'blackcrystal' ) );
			register_nav_menu( 'header-nav-menu', __( 'Header nav menu', 'blackcrystal' ) );
		}

		function loginout_menu_link( $items, $args ) {
		   if ($args->theme_location == 'header-menu' && class_exists("WooCommerce")) {
		      if (is_user_logged_in()) {
		         $items .= '<li class=""><a href="'. get_the_permalink(wc_get_page_id('myaccount')) .'">'.__('My Account', 'blackcrystal').'</a></li>';
		         $items .= '<li class=""><a href="'. wp_logout_url(home_url()) .'">'.__('Logout', 'blackcrystal').'</a></li>';
		      } else {
		         $items .= '<li class=""><a href="'. get_the_permalink(wc_get_page_id('myaccount')) .'?action=login">'.__('Log in', 'blackcrystal').'</a></li>';
		         $items .= '<li class=""><a href="'. get_the_permalink(wc_get_page_id('myaccount')) .'">'.__('Register', 'blackcrystal').'</a></li>';
		      }
		   }
		   return $items;
		}

		function polylang_search_normalize( $query ) {
		    if ( $query->is_search()) {
		        $query->query_vars['tax_query'] = array();
		    }
		}

		function gallery_posts_per_page( $query ) {
		   if( !is_admin() && $query->is_main_query() && is_post_type_archive( 'gallery' ) ) {
		        $query->set( 'posts_per_page', '-1' );
		    }
		}

	}
}

$ThemeFramework = new ThemeFramework();


add_action('woocommerce_account_content', 'account_content');

function account_content(){
	if (get_option("shop_type") == "wholesale"){
		echo('
			<span class="show_price_switch_label">Eladási árak megjelenítése? </span>
			<div class="onoffswitch">
			    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" value="'. get_user_meta( get_current_user_id(), '_show_customer_price', true ).'" id="myonoffswitch"'.(get_user_meta( get_current_user_id(), '_show_customer_price', true ) == false ? "" : "checked").'>
			    <label class="onoffswitch-label" for="myonoffswitch">
			        <span class="onoffswitch-inner"></span>
			        <span class="onoffswitch-switch"></span>
			    </label>
			</div>
	    <script type="text/javascript">

	        jQuery(".onoffswitch-checkbox").on("change", function(){
				var ajaxurl = "'. admin_url( 'admin-ajax.php' ).'";
				var val = jQuery(this).val()
				jQuery.post(
				    ajaxurl,
				    {
				        "action": "display_price_action",
				        "data":   val
				    },
				    function(response){
						location.reload();
				    }
				);
	        })

	    </script>
	');
	}
}
