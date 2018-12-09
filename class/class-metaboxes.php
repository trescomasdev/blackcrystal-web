<?php
	if(!class_exists('METABOXES')) {

		class METABOXES {

			public function __construct(){
				add_action( 'add_meta_boxes_page', array(&$this, 'select_product_metabox' ));
				add_action( 'save_post', array(&$this, 'product_select_save' ));					
				add_action( 'wp_ajax_products_select_get_products', array(&$this, 'products_select_get_products' ));
			}

			function select_product_metabox() {
			    global $post;
			    if ( 'landing.php' == get_post_meta( $post->ID, '_wp_page_template', true ) ) {
					add_meta_box(
	                 'product_meta', // $id
	                 __('Kapcsolódó termékek', 'blackcrystal'), // $title
	                 array(&$this, 'display_product_information'), // $callback
	                 'page', // $page
	                 'normal', // $context
	                 'high'); // $priority
				    }
			}

			function display_product_information(){
				require_once(dirname(dirname(__FILE__)) . '/metaboxes/select-product.php');
			}

			function product_select_save( $post_id ) {

			    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			    return;

			    if ( !wp_verify_nonce( $_POST['product-select-nonce'], 'product-select') )
			    return;

			    if ( 'page' == $_POST['post_type'] ) {
			        if ( !current_user_can( 'edit_page', $post_id ) )
			        return;
			    } else {
			        if ( !current_user_can( 'edit_post', $post_id ) )
			        return;
			    }

			    $cat = (int) $_POST['product-cat-select'];
			    $prod =  serialize($_POST['product-select']);

			    update_post_meta( $post_id, 'product-cat-select', $cat );
			    update_post_meta( $post_id, 'product-select', $prod );
			}

			function products_select_get_products() {
				$args = array(
				    'post_type' => 'product',
				    's' => $_GET['q'],
				    'posts_per_page' => 20,
				    'offset' => $_GET['offset'],
				    'post_status' => 'publish',
				    'orderby'     => 'title',
				    'order'       => 'ASC'
				);

				$wp_query = new WP_Query($args);

				if ($wp_query->have_posts()):
					while ($wp_query->have_posts()): $wp_query->the_post();
						$data[] = array('id' => get_the_ID(), 'text' => get_the_title());
					endwhile;
				else:
					$data[] = array('id' => '0', 'text' => 'No Products Found');
				endif;

				// return the result in json
				echo json_encode($data);

				die();

			}
		}
	}

	if (class_exists('METABOXES')){
		$METABOXES = new METABOXES();
	}
