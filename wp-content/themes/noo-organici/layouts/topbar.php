<?php
    $phone = noo_organici_get_option('noo_header_top_phone');
    $email = noo_organici_get_option('noo_header_top_email');
    $header_style         = noo_organici_get_option('noo_header_nav_style','header1');
    $header_page = noo_organici_get_post_meta(get_the_ID(),'_noo_wp_page_header_style');
    $navbar_meta_social = get_theme_mod('noo_header_nav_widget', '');
    if( is_page() ) {
        if( !empty( $header_page ) && $header_page != 'header' ){
            $header_style = $header_page;
        }
    }
?>
<div class="noo-topbar">
    <div class="noo-container">
        <ul>
            <?php if( isset($phone) && !empty($phone) && $header_style != 'header5'): ?>
                <li>
                    <span><i class="fa fa-phone"></i></span>
                    <a href="tel:<?php echo str_replace(' ', '', esc_attr($phone)) ?>"><?php echo esc_html($phone) ?></a>
                </li>
            <?php endif; ?>
            <?php if( isset($email) && !empty($email) ): ?>
                <li>
                    <span><i class="fa fa-envelope"></i></span>
                    <a href="mailto:<?php echo esc_attr($email) ?>"><?php echo esc_html($email) ?></a>
                </li>
            <?php endif; ?>
        </ul>
        <ul>
            <?php
            if (noo_organici_get_option('noo_header_nav_top_icon_user', false) == true) :
                if (is_user_logged_in()):
                    ?>
                    <li>

                        <span><i class="fa fa-user"></i></span>
                        <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>">
                            <?php echo esc_html__('My Account', 'noo-organici'); ?>
                        </a>
                    </li>
                    <li>

                        <span><i class="fa fa-sign-out"></i></span>
                        <a href="<?php echo wp_logout_url(home_url()); ?>"><?php echo esc_html__('Log Out', 'noo-organici'); ?></a>
                    </li>
                <?php else: ?>
                    <li>
                        <span><i class="fa fa-sign-in"></i></span>
                        <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>">
                            <?php echo esc_html__('Log In / Sign Up', 'noo-organici'); ?>
                        </a>
                    </li>
                <?php endif;
            endif; ?>
            <?php if ( noo_organici_get_option('noo_header_nav_top_icon_wishlist', false) == true ) : ?>
            <li>
                <span><i class="fa fa-heart-o"></i></span>
                <a href="<?php echo esc_url(get_page_link( get_option('yith_wcwl_wishlist_page_id') )); ?>"><?php echo esc_html__('Wishlist', 'noo-organici'); ?></a>
            </li>
            <?php endif; ?>

            <?php if ( noo_organici_get_option('noo_header_nav_icon_social', false) == true && $navbar_meta_social != 'select_widget') : ?>
            <li>
                <?php dynamic_sidebar( $navbar_meta_social ); ?>
            </li>
            <?php endif; ?>           


            <?php
            if(defined('WOOCOMMERCE_VERSION') && noo_organici_get_option('noo_header_nav_top_icon_cart',false)):
                global $woocommerce;
            ?>
                <?php echo noo_organici_minicart(false, true); ?>
            <?php endif; ?>
            <?php 
            if( $header_style != 'header1' ) :
                if ( noo_organici_get_option('noo_header_nav_top_icon_search', false) == true ) : 
            ?>
            <li>
                <a href="#" class="fa fa-search noo-search" id="noo-search"></a>
            </li>
            <?php 
                endif;
            endif;
            ?>
        </ul>
    </div>
</div>