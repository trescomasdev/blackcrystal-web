<?php 
	if(!class_exists('WIDGETS')) {

	    class WIDGETS {
	    
		    public function __construct(){	
			    add_action( 'widgets_init', array(&$this, 'widgets_init' ));	
			    add_action( 'widgets_init', array(&$this, 'sidebar_setup') );		    
		    }
		    
			function widgets_init() {
				unregister_widget("WP_Widget_Pages");       	 	// Pages Widget
				unregister_widget("WP_Widget_Calendar");    	 	// Calendar Widget
				//unregister_widget("WP_Widget_Archives");    	 	// Archives Widget
				unregister_widget("WP_Widget_Links");     		 	// Links Widget
				unregister_widget("WP_Widget_Meta");     	 	 	// Meta Widget
				unregister_widget("WP_Widget_Search");   	 	 	// Search Widget
				unregister_widget("WP_Widget_Categories");      	// Categories Widget
				unregister_widget("WP_Widget_Recent_Posts");    	// Recent Posts Widget
				unregister_widget("WP_Widget_Recent_Comments"); 	// Recent Comments Widget
				unregister_widget("WP_Widget_RSS");    				// RSS Widget
				unregister_widget("WP_Widget_Tag_Cloud");	        // Tag Cloud Widget
				unregister_widget("SiteOrigin_Panels_Widgets_PostLoop");	        // Tag Cloud Widget
				unregister_widget("SiteOrigin_Panels_Widgets_PostContent");	        // Tag Cloud Widget

							
				if (class_exists("WebcreativesHeadlineWidget")) register_widget("WebcreativesHeadlineWidget");	      
				if (class_exists("WebcreativesContactWidget")) register_widget("WebcreativesContactWidget");	      
				if (class_exists("WebcreativesLoginWidget")) register_widget("WebcreativesLoginWidget");	   
				//if (class_exists("WebcreativesTag_Cloud")) register_widget("WebcreativesTag_Cloud");	      
				if (class_exists("WebcreativesPostLoopWidget")) register_widget("WebcreativesPostLoopWidget");
				if (class_exists("WebcreativesCustomPostWidget")) register_widget("WebcreativesCustomPostWidget");
				if (class_exists("WebcreatviesChainsWidget")) register_widget("WebcreatviesChainsWidget");	     
			
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