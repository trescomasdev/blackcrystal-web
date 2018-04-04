<?php /* Template Name: Home */ ?>
<?php get_header()?>
	<div class="main-container col1-layout woocommerce">
		<div class="container">
			<div class="row">
				<div class="span12">
					<div class="main">
						<div class="col-main">
							<div class="padding-s">
								<div class="std">
									<?php $actually = new WP_Query(array('p' => get_option('page_actuality'), 'post_type' => 'any'))?>
									<?php if ($actually->have_posts()): $actually->the_post()?>
										<?php if (get_the_content() != ""):?>
											<div class="container">
												<div class="col-md-12 actually">
													<div class="page-title category-title">
														<h1 class="subtitle"><?php the_title()?></h1>
													</div>
													<div class="entry-content">
														<?php the_content() ?>
													</div>
												</div>
											</div>
										<?php endif;?>
									<?php endif;?>
									<?php echo do_shortcode('[rev_slider alias="homeslider"]')?>
								</div>
								<div class="page-title category-title">
									<h1 class="subtitle"><?php _e('Featured Products', 'blackcrystal')?></h1>
								</div>
								<?php echo do_shortcode('[featured_products per_page="12" columns="4"]');?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php get_footer()?>
