<?php 
	get_header(); 
	
	while( have_posts() ){ the_post();
		gdlr_single_portfolio_template();
	}
	
	get_footer(); 
?>