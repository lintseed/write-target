<?php 
	global $theme_option;

	echo '<div class="gdlr-navigation-substitute">';
	echo '<div class="gdlr-navigation-wrapper gdlr-' . $theme_option['header-style'] . '">';
	echo '<div class="gdlr-navigation-container container">';
	
	// logo for style 2
	if( !empty($theme_option['header-style']) && $theme_option['header-style'] == 'style-1' ){ ?>
		<div class="gdlr-logo">
			<?php echo (is_front_page())? '<h1>':''; ?>
			<a href="<?php echo home_url(); ?>" >
				<?php 
					if(empty($theme_option['logo-id'])){ 
						echo gdlr_get_image(GDLR_PATH . '/images/logo.png');
					}else{
						echo gdlr_get_image($theme_option['logo-id']);
					}
				?>						
			</a>
			<?php echo (is_front_page())? '</h1>':''; ?>
			<?php
				// mobile navigation
				if( class_exists('gdlr_dlmenu_walker') && ( empty($theme_option['enable-responsive-mode']) || $theme_option['enable-responsive-mode'] == 'enable' ) ){
					echo '<div class="gdlr-responsive-navigation dl-menuwrapper" id="gdlr-responsive-navigation" >';
					echo '<button class="dl-trigger">Open Menu</button>';
					wp_nav_menu( array(
						'theme_location'=>'main_menu', 
						'container'=> '', 
						'menu_class'=> 'dl-menu gdlr-main-mobile-menu',
						'walker'=> new gdlr_dlmenu_walker() 
					) );						
					echo '</div>';
				}						
			?>			
		</div>
	<?php }  

	
	// navigation
	if( has_nav_menu('main_menu') ){
		if( class_exists('gdlr_menu_walker') ){
			echo '<nav class="gdlr-navigation" id="gdlr-main-navigation" role="navigation">';
			wp_nav_menu( array(
				'theme_location'=>'main_menu', 
				'container'=> '', 
				'menu_class'=> 'sf-menu gdlr-main-menu',
				'walker'=> new gdlr_menu_walker() 
			) );
		}else{
			echo '<nav class="gdlr-navigation" role="navigation">';
			wp_nav_menu( array('theme_location'=>'main_menu') );
		}
		echo '</nav>'; // gdlr-navigation
	}
	
	echo '<div class="clear"></div>';
	echo '</div>'; // gdlr-navigation-container
	echo '</div>'; // gdlr-navigation-wrapper
	echo '</div>'; // gdlr-navigation-substitute	
?>