<?php 
	add_action('wp_ajax_gdlr_get_single_port', 'gdlr_single_portfolio_ajax');	
	add_action('wp_ajax_nopriv_gdlr_get_single_port', 'gdlr_single_portfolio_ajax');	
	function gdlr_single_portfolio_ajax(){
		global $gdlr_post_option, $wp_query, $gdlr_is_ajax;
		if( $_POST['port_id'] ){
			$wp_query->is_single = 1; $gdlr_is_ajax = 1;
			
			$args = array('post_type'=>'portfolio');
			$args['p'] = $_POST['port_id'];
			$args['posts_per_page '] = 1;
			
			$query = new WP_Query( $args ); 
			while( $query->have_posts() ){ $query->the_post();
				$gdlr_post_option = gdlr_decode_preventslashes(get_post_meta(get_the_ID(), 'post-option', true));
				$gdlr_post_option = json_decode($gdlr_post_option, true);
				
				echo '<div class="gdlr-single-portfolio single-portfolio">';
				echo '<h1 class="gdlr-single-lightbox-title">' . get_the_title() . '</h1>';
				gdlr_single_portfolio_template();
				echo '</div>';
			}
			wp_reset_postdata();
			die();
		}
	}


	function gdlr_single_portfolio_template(){
?>	
<div class="gdlr-content">

	<?php 
		global $gdlr_sidebar, $theme_option, $gdlr_post_option, $gdlr_is_ajax;
		
		if( empty($gdlr_post_option['sidebar']) || $gdlr_post_option['sidebar'] == 'default-sidebar' ){
			$gdlr_sidebar = array(
				'type'=>$theme_option['post-sidebar-template'],
				'left-sidebar'=>$theme_option['post-sidebar-left'], 
				'right-sidebar'=>$theme_option['post-sidebar-right']
			); 
		}else{
			$gdlr_sidebar = array(
				'type'=>$gdlr_post_option['sidebar'],
				'left-sidebar'=>$gdlr_post_option['left-sidebar'], 
				'right-sidebar'=>$gdlr_post_option['right-sidebar']
			); 				
		}
		$gdlr_sidebar = gdlr_get_sidebar_class($gdlr_sidebar);
	?>
	<div class="with-sidebar-wrapper">
		<div class="with-sidebar-container container gdlr-class-<?php echo $gdlr_sidebar['type']; ?>">
			<div class="with-sidebar-left <?php echo $gdlr_sidebar['outer']; ?> columns">
				<div class="with-sidebar-content <?php echo $gdlr_sidebar['center']; ?> columns">
					<div class="gdlr-item gdlr-portfolio-<?php echo $theme_option['portfolio-page-style']; ?> gdlr-item-start-content">
						<div id="portfolio-<?php the_ID(); ?>" <?php post_class(); ?>>
							<?php 
								$thumbnail = gdlr_get_portfolio_thumbnail($gdlr_post_option, $theme_option['portfolio-thumbnail-size']);
								if(!empty($thumbnail)){
									echo '<div class="gdlr-portfolio-thumbnail ' . gdlr_get_portfolio_thumbnail_class($gdlr_post_option) . '">';
									echo $thumbnail;
									echo '</div>';
								}
							?>
							<div class="gdlr-portfolio-content">
								<div class="gdlr-portfolio-info">
									<h4 class="head"><?php echo __('Project Info', 'gdlr-portfolio'); ?></h4>
									
									<nav class="gdlr-single-nav">
										<?php 
											if( !$gdlr_is_ajax ){
												previous_post_link('<div class="previous-nav">%link</div>', '<i class="icon-angle-left"></i>');
												next_post_link('<div class="next-nav">%link</div>', '<i class="icon-angle-right"></i>'); 
											}else{
												$prev_post = get_adjacent_post(false, '', true);
												if( !empty($prev_post) ){
													echo '<div class="previous-nav"><a href="#" data-lightbox="' . $prev_post->ID . '">';
													echo '<i class="icon-angle-left"></i>';
													echo '</a></div>';
												}
												
												$next_post = get_adjacent_post(false, '', false);
												if( !empty($next_post) ){
													echo '<div class="next-nav"><a href="#" data-lightbox="' . $next_post->ID . '">';
													echo '<i class="icon-angle-right"></i>';
													echo '</a></div>';
												}
											}
										?>
										<div class="clear"></div>
									</nav><!-- .nav-single -->		
									
									<div class="content">
									<?php 
										echo gdlr_get_portfolio_info(array('clients', 'skills', 'website', 'tag'), $gdlr_post_option, false); 
										gdlr_get_social_shares();
									?>							
									</div>
								</div>								
								<div class="gdlr-portfolio-description">
									<h4 class="head"><?php echo __('Project Description', 'gdlr-portfolio'); ?></h4>
									<div class="content">
									<?php 
										the_content(); 
										wp_link_pages( array( 
											'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'gdlr-portfolio' ) . '</span>', 
											'after' => '</div>', 
											'link_before' => '<span>', 
											'link_after' => '</span>' ));
									?>
									</div>
								</div>			
								<div class="clear"></div>
							</div>	
						</div><!-- #portfolio -->
						<?php //  ?>
						
						<div class="clear"></div>
						<?php 
							// print portfolio comment
							if( $theme_option['portfolio-comment'] == 'enable' ){
								comments_template( '', true ); 
							} 							
						?>		
					</div>
					
					<?php
						// print related portfolio
						if( !$gdlr_is_ajax && is_single() && $theme_option['portfolio-related'] == 'enable' ){	
							global $gdlr_related_section; $gdlr_related_section = true;
						
							$args = array('post_type' => 'portfolio', 'suppress_filters' => false);
							$args['posts_per_page'] = (empty($theme_option['related-portfolio-num-fetch']))? '3': $theme_option['related-portfolio-num-fetch'];
							$args['post__not_in'] = array(get_the_ID());
							
							$portfolio_term = get_the_terms(get_the_ID(), 'portfolio_tag');
							$portfolio_tags = array();
							if( !empty($portfolio_term) ){
								foreach( $portfolio_term as $term ){
									$portfolio_tags[] = $term->term_id;
								}
								$args['tax_query'] = array(array('terms'=>$portfolio_tags, 'taxonomy'=>'portfolio_tag', 'field'=>'id'));
							} 
							$query = new WP_Query( $args );

							if( !empty($query) ){
								echo '<div class="gdlr-related-portfolio portfolio-item-holder">';
								echo '<h4 class="head">' . __('Related Projects', 'gdlr-portfolio') . '</h4>';
								if( $theme_option['related-portfolio-style'] == 'classic-portfolio' ){
									echo gdlr_get_classic_portfolio($query, $theme_option['related-portfolio-size'], 
										$theme_option['related-portfolio-thumbnail-size'], 'fitRows' );
								}else{
									echo gdlr_get_modern_portfolio($query, $theme_option['related-portfolio-size'], 
										$theme_option['related-portfolio-thumbnail-size'], 'fitRows' );								
								}
								echo '<div class="clear"></div>';
								echo '</div>'; 
							}
							$gdlr_related_section = false;
						}					
					?>
				</div>
				<?php get_sidebar('left'); ?>
				<div class="clear"></div>
			</div>
			<?php get_sidebar('right'); ?>
			<div class="clear"></div>
		</div>				
	</div>				

</div><!-- gdlr-content -->
<?php	
	}
?>