<?php
$customizer_show = noo_organici_get_option('noo_page_heading', true);
$hidden = ( NOO_WOOCOMMERCE_EXIST && is_shop() ) ? noo_organici_get_post_meta(get_option( 'woocommerce_shop_page_id' ) , '_hidden_heading_image', 0) : noo_organici_get_post_meta(get_the_ID(), '_hidden_heading_image', 0);
if ($customizer_show):
    if (empty($hidden) or $hidden == 0):
        if ( !is_front_page() && !is_404() ):
            $heading = noo_organici_new_heading();

            if (!empty($heading['img']) && $heading['img']):
                $style = 'style="background-image: url(' . esc_url($heading['img']) . ')"';
            else:
                $style = '';
            endif;

            if (empty($heading['title'])) {
                $heading['title'] = '';
            }

            ?>
            <section class="noo-page-heading" <?php echo $style; ?>>
                <div class="noo-container">
                    <div class="noo-heading-content">
                        <h1 class="page-title"><?php echo esc_html($heading['title']); ?></h1>
                        <?php if (function_exists('bcn_display') && !is_search()): ?>
                            <div class="noo-page-breadcrumb">
                                <?php bcn_display(); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div><!-- /.container-boxed -->
            </section>
            <?php
        endif;
    endif;
endif;
?>