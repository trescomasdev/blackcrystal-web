<?php
	if(!class_exists('WIDGETS')) {

		class WIDGETS {

	    public function __construct(){
		    add_action( 'widgets_init', array(&$this, 'sidebar_setup') );
	    }

			public function sidebar_setup() {

				register_sidebar( array(
					'name' => 'Right sidebar',
					'id' => 'right_sidebar',
					'before_widget' 	=> '<div id="%1$s" class="block %2$s">',
					'after_widget' 		=> '</div></div>',
					'before_title'		=> '<div class="block-title"><strong><span>',
					'after_title' 		=> '</span></strong></div><div class="block-content">',
				) );

				register_sidebar( array(
					'name' => 'Footer sidebar',
					'id' => 'footer_sidebar',
					'before_widget' 	=> '<div id="%1$s" class="footer-col %2$s">',
					'after_widget' 		=> '</div></div>',
					'before_title'		=> '<h4>',
					'after_title' 		=> '</h4><div class="footer-col-content">',
				) );
			}
		}
	}

	if (class_exists('WIDGETS')){
		$WIDGETS = new WIDGETS();
	}
?>
