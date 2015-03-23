<?php
	/*	
	*	Goodlayers Master Slider Support File
	*/
	
	if(!function_exists('gdlr_get_masterslider_list')){
		function gdlr_get_masterslider_list(){
			if( !function_exists('get_masterslider_names') ) return;
	
			return get_masterslider_names(true);
		}
	}
	
	add_action('gdlr_print_item_selector', 'gdlr_check_masterslider_item', 10, 2);
	if( !function_exists('gdlr_check_masterslider_item') ){
		function gdlr_check_masterslider_item( $type, $settings = array() ){
			if( !function_exists('get_masterslider') ) return;
		
			$item_id = empty($settings['page-item-id'])? '': ' id="' . $settings['page-item-id'] . '" ';

			global $gdlr_spaces;
			$margin = (!empty($settings['margin-bottom']) && 
				$settings['margin-bottom'] != $gdlr_spaces['bottom-item'])? 'margin-bottom: ' . $settings['margin-bottom'] . ';': '';
			$margin_style = (!empty($margin))? ' style="' . $margin . '" ': '';	
		
			if($type == 'master-slider'){
				echo '<div class="gdlr-master-slider-item gdlr-slider-item gdlr-item" ' . $item_id . $margin_style . ' >';
				echo get_masterslider($settings['id']);
				echo '</div>';
			}
		}
	}	
	
?>