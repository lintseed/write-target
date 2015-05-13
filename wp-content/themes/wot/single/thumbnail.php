<?php 
	if( !is_single() ){ 
		global $gdlr_post_settings; 
	}else{
		global $gdlr_post_settings, $theme_option, $gdlr_post_option;
	}
	$gdlr_post_settings['content'] = get_the_content();
	
	if ( has_post_thumbnail() && ! post_password_required() ){ ?>
		<div class="gdlr-blog-thumbnail">
			<?php 
				$rating = '';
				if( is_single() ){
					$rating = !empty($gdlr_post_option['rating'])? $gdlr_post_option['rating']: '';
					echo gdlr_get_image(get_post_thumbnail_id(), $theme_option['post-thumbnail-size'], true);	
				}else{
					$temp_option = json_decode(get_post_meta(get_the_ID(), 'post-option', true), true);
					$rating = !empty($temp_option['rating'])? $temp_option['rating']: '';
					echo '<a href="' . get_permalink() . '"> ';
					echo gdlr_get_image(get_post_thumbnail_id(), $gdlr_post_settings['thumbnail-size']);
					echo '</a>';
					
					if( is_sticky() ){
						echo '<div class="gdlr-sticky-banner">';
						echo '<i class="icon-bullhorn" ></i>';
						echo __('Sticky Post', 'gdlr_translate');
						echo '</div>';
					}
				}

				if( !empty($rating) ){
					echo '<div class="gdlr-post-rating">' . $rating . '</div>';
				}
			?>
		</div>
<?php 
	} 
?>	