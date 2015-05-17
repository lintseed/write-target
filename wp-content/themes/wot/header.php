<!DOCTYPE html>
<!--[if IE 7]><html class="ie ie7 ltie8 ltie9" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8]><html class="ie ie8 ltie9" <?php language_attributes(); ?>><![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />
	<title><?php bloginfo('name'); ?>  <?php wp_title(); ?></title>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	
	<?php 
		global $theme_option, $gdlr_post_option;
		if( !empty($gdlr_post_option) ){ $gdlr_post_option = json_decode($gdlr_post_option, true); }
		
		wp_head(); 
	?>
</head>

<body <?php body_class(); ?>>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
 
  ga('create', 'UA-59003131-1', 'auto');
  ga('send', 'pageview');
 
</script>
<?php
	$body_wrapper = '';
	if($theme_option['enable-boxed-style'] == 'boxed-style'){
		$body_wrapper  = 'gdlr-boxed-style';
		if( !empty($theme_option['boxed-background-image']) && is_numeric($theme_option['boxed-background-image']) ){
			$alt_text = get_post_meta($theme_option['boxed-background-image'] , '_wp_attachment_image_alt', true);	
			$image_src = wp_get_attachment_image_src($theme_option['boxed-background-image'], 'full');
			echo '<img class="gdlr-full-boxed-background" src="' . $image_src[0] . '" alt="' . $alt_text . '" />';
		}else if( !empty($theme_option['boxed-background-image']) ){
			echo '<img class="gdlr-full-boxed-background" src="' . $theme_option['boxed-background-image'] . '" />';
		}
	}
	$body_wrapper .= ($theme_option['enable-float-menu'] != 'disable')? ' float-menu': '';
?>
<div class="body-wrapper <?php echo $body_wrapper; ?>" data-home="<?php echo home_url(); ?>" >
	<?php 
		// page style
		if( empty($gdlr_post_option) || empty($gdlr_post_option['page-style']) ||
			  $gdlr_post_option['page-style'] == 'normal' || 
			  $gdlr_post_option['page-style'] == 'no-footer'){ 
			  
		$header_class  = 'gdlr-header-' . $theme_option['header-style'];
	?>
	<header class="gdlr-header-wrapper <?php echo $header_class; ?>">

		<!-- top navigation -->
		<?php if( empty($theme_option['enable-top-bar']) || $theme_option['enable-top-bar'] == 'enable' ){ ?>
		<div class="top-navigation-wrapper">
			<div class="top-navigation-container container">
				<div class="top-navigation-left">
					<div class="top-social-wrapper">
						<?php gdlr_print_header_social(); ?>
					</div>
				</div>
				<div class="top-navigation-right">
					<div class="top-navigation-right-text">
						<?php 
							if( !empty($theme_option['top-bar-right-text']) ) 
								echo gdlr_text_filter($theme_option['top-bar-right-text']); 
						?>
					</div>
					<?php if( empty($theme_option['enable-top-search']) || $theme_option['enable-top-search'] == 'enable' ){ ?>
						<div class="gdlr-nav-search-form-button-wrapper">
							<div class="gdlr-nav-search-form" id="gdlr-nav-search-form">
								<form method="get" action="<?php  echo home_url(); ?>">
									<div class="search-text" id="search-text">
										<input type="text" value="" name="s" id="s" autocomplete="off" data-default="<?php _e("Search..." , "gdlr_translate"); ?>" >
									</div>
									<div class="gdlr-nav-search-form-button" id="gdlr-nav-search-form-button">
										<i class="icon-search"></i>
									</div>
									<div class="clear"></div>
								</form>
							</div>								
							
						</div>
					<?php }	?>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<?php } ?>
		
		<!-- logo -->
		<?php if( empty($theme_option['header-style']) || $theme_option['header-style'] != 'style-1' ){ ?>
		<div class="gdlr-header-substitute">
			<div class="gdlr-header-inner">
				<div class="gdlr-header-container container">
					<!-- logo -->
					<div class="gdlr-logo gdlr-align-<?php echo $theme_option['logo-alignment']; ?>">
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
					
					<?php if($theme_option['logo-alignment'] != 'center'){ ?>
					<div class="gdlr-logo-right-text gdlr-align-<?php echo $theme_option['logo-alignment']; ?>">
						<?php echo gdlr_text_filter($theme_option['logo-right-text']); ?>
					</div>
					<div class="clear"></div>
					<?php } ?>
				</div>
			</div>
		</div>
		<?php } ?>
		
		<!-- navigation -->
		<?php 
			if( empty($gdlr_post_option) || empty($gdlr_post_option['navigation-area']) ||
				$gdlr_post_option['navigation-area'] == 'top' ){
				get_template_part( 'header', 'nav' ); 
			}
		?>

		<div class="clear"></div>
		<?php get_template_part( 'header', 'title' ); ?>
	</header>
	<?php } // page style ?>
	<div class="content-wrapper">
