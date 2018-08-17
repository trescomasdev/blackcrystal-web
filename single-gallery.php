<?php get_header()?>
	<div class="main-container col2-right-layout">
		<div class="container">
			<div class="row">
				<div class="span12">
					<div class="main">
						<div class="breadcrumbs">
							<?php if ( function_exists('yoast_breadcrumb') )
{yoast_breadcrumb('<p id="breadcrumbs">','</p>');} ?>
						</div>
						<div class="row">
							<div class="col-main span9">
								<div class="padding-s">
									<?php if (have_posts()): the_post();?>
										<div class="page-title"><h2><?php the_title()?></h2></div>
										<div class="entry-content">
											<?php the_content();?>
										</div>
									<?php endif;?>
								</div>
							</div>
							<?php get_sidebar()?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
    <!-- jQuery version must be >= 1.8.0; -->
    <script src="<?php bloginfo('template_url')?>/js/lightgallery.min.js"></script>

    <!-- A jQuery plugin that adds cross-browser mouse wheel support. (Optional) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"></script>

    <!-- lightgallery plugins -->
    <script src="<?php bloginfo('template_url')?>/js/lg-thumbnail.js"></script>
    <script src="<?php bloginfo('template_url')?>/js/lg-fullscreen.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $("#lightgallery").lightGallery();
    });
</script>
<?php get_footer()?>
