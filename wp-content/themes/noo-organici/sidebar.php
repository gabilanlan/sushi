
<?php
$sidebar = noo_organici_get_sidebar_id();

if( ! empty( $sidebar ) ) :
?>
<div class="<?php noo_organici_sidebar_class(); ?>">
	<div class="noo-sidebar-wrap">
		<?php // Dynamic Sidebar
		if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( $sidebar ) ) : ?>
			<!-- Sidebar fallback content -->

		<?php endif; // End Dynamic Sidebar sidebar-main ?>
	</div>
</div>
<?php endif; // End sidebar ?> 
