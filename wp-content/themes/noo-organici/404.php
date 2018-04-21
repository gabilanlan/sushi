<?php get_header(); ?>

<div class="container-wrap" id="error-404">
	
	<div class="noo-container main-content">
		
		<div class="content-404">
            <p><?php esc_html_e('The page you are looking for does not exist. ','noo-organici'); ?></p>
            <h1><?php echo esc_html__( '404 error', 'noo-organici'); ?></h1>
            <a class="button-404" href="<?php echo esc_url(home_url('/')); ?>"><?php echo esc_html__('return to home page','noo-organici'); ?></a>
        </div>
		
	</div><!--/container-->

</div>
<?php get_footer(); ?>