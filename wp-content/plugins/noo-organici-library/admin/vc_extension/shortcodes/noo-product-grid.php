<?php
/* *
 * This shortcode display product by style grid
 */

if( !function_exists('noo_shortcode_product_grid') ){
    function noo_shortcode_product_grid($atts){
        extract(shortcode_atts(array(
            'icon'            =>  '',
            'title'           =>  '',
            'description'     =>  '',
            'cat'             =>  '',
            'style'           =>  'one',
            'columns'         =>  '4',
            'orderby'         =>  'latest',
            'withcat'        =>  'all',
            'posts_per_page'  =>  8,
            'showall'         =>  true,
            'filter_all_icon' =>  ''
        ),$atts));
        ob_start();
        wp_enqueue_script('vendor-imagesloaded');
        wp_enqueue_script('isotope');
        wp_enqueue_script('portfolio');
        $class= 'product-style';
        $class_js = uniqid("product_");
        if( $style == 'two' ){
            $class= 'product-style2';
        }
        $porduct_layout = noo_organici_get_option('noo_shop_display_style','fitRows');
        ?>
        <div class="noo-product-grid-wrap woocommerce <?php echo esc_attr($class).' '.esc_attr( $class_js )  ; ?>">
            <?php if( $title != '' || $description !='' ): ?>
            <div class="noo-sh-title">
                <?php if( isset($icon) && !empty($icon) ): echo wp_get_attachment_image($icon,'full'); endif; ?>
                <?php if( isset($title) && !empty($title) ) ?><h2><?php echo esc_html($title);  ?></h2>
                <?php if( isset($description) && !empty($description) ): ?><p><?php echo esc_html($description); ?></p><?php endif; ?>
            </div>
            <?php endif; ?>
            <div class="noo-product-filter masonry-filters">
                <ul class="noo-header-filter" data-option-key="filter">

                    <?php if( $showall == true ): ?>
                        <li>
                            <a data-option-value="*" href="#all" class="selected">
                                <?php if (isset($filter_all_icon) && !empty($filter_all_icon)): ?>
                                    <img width="30" height="26" src="<?php echo esc_url(wp_get_attachment_image_url($filter_all_icon, 'full')); ?>" alt="<?php echo esc_html__('All products','noo') ?>" />
                                <?php else: ?>
                                    <img width="30" height="26"
                                         src="<?php echo esc_url(NOO_PLUGIN_ASSETS_URI . '/images/organicfood.png'); ?>"
                                         alt="<?php echo esc_html__('All products','noo') ?>" />
                                <?php endif; ?>
                                <span><?php echo esc_html__('All products','noo') ?></span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php
                        $args_cat = array(
                            'type'      =>  'product',
                            'taxonomy'  =>  'product_cat'
                        );
                        if( isset($cat) && $cat != 'all' && !empty($cat) ){
                            $args_cat['include'] = $cat;
                        }
                        $categories = get_categories( $args_cat );
                        if( isset($categories) && !empty( $categories ) ):
                            foreach( $categories as $key => $cats ): ?>
                                <li>
                                    <a <?php if($key == 0 && !$showall) echo 'class="selected"' ?> data-option-value=".<?php echo esc_attr($cats->slug); ?>" href="#<?php echo esc_attr($cats->slug); ?>">
                                      <?php
                                      if (class_exists( 'WC_API' )) {

                                          $thumbnail_id = get_woocommerce_term_meta( $cats->term_id, 'thumbnail_id', true );
                                          $image = wp_get_attachment_url( $thumbnail_id );
                                          if ( $image ) {
                                              echo '<img width="30" height="26" src="' . esc_url($image) . '" alt="'.esc_attr($cats->name).'" />';
                                          }
                                          
                                      }
                                      ?>
                                        <span><?php echo esc_html($cats->name); ?></span>
                                    </a>
                                </li>
                            <?php endforeach;
                        endif;
                    ?>

                <!-- </ul> -->
            </div>
            <div class="noo-product-grid products noo-row product-grid noo-grid-<?php echo esc_attr($columns); ?>" data-layout = "<?php echo esc_attr($porduct_layout);?>">
                <?php
                $order = 'DESC';
                switch ($orderby) {
                    case 'latest':
                        $orderby = 'date';
                        break;

                    case 'oldest':
                        $orderby = 'date';
                        $order = 'ASC';
                        break;

                    case 'alphabet':
                        $orderby = 'title';
                        $order = 'ASC';
                        break;

                    case 'ralphabet':
                        $orderby = 'title';
                        break;

                    default:
                        $orderby = 'date';
                        break;
                }

                $new_cat = array();
                if( isset($cat) && $cat != 'all' && !empty($cat) ){

                    $new_id = explode(',',$cat);
                    foreach($new_id as $id){
                        $new_cat[] = intval($id);
                    }                    
                    $args_cat['include'] = $cat;

                } else {

                    foreach ($categories as $value) {
                        $new_cat[]= $value->term_id;
                    }

                }

                if( $withcat == 'all' ) {
                    $query = noo_organici_product_cat($order, $orderby, $posts_per_page, $new_cat);
                    if( $query->have_posts() ):
                        while( $query->have_posts() ): $query->the_post();

                            wc_get_template_part( 'content', 'product' );

                        endwhile;
                    endif; wp_reset_postdata();
                } else {
                    foreach ($new_cat as $value) {
                        $query = noo_organici_product_cat($order, $orderby, $posts_per_page, $value);
                        if( $query->have_posts() ):
                            while( $query->have_posts() ): $query->the_post();

                                wc_get_template_part( 'content', 'product' );

                            endwhile;
                        endif; wp_reset_postdata();
                    }
                }

                ?>
            </div>
        </div>
        <script>
            jQuery(document).ready(function($){

                "use strict";

                // noo_masonry2();

                // Init masonry isotope
                noo_masonry();
                var $container = jQuery('.<?php echo esc_attr( $class_js ) ?> .noo-product-grid');
                var $filter = jQuery('.<?php echo esc_attr( $class_js ) ?> .masonry-filters a');
                var options = {},
                    key = jQuery('.<?php echo esc_attr( $class_js ) ?> .masonry-filters a.selected').closest('ul').attr('data-option-key'),
                    value = jQuery('.<?php echo esc_attr( $class_js ) ?> .masonry-filters a.selected').attr('data-option-value');
                value = value === 'false' ? false : value;

                options[key] = value;
                $container.isotope(options);

                $filter.click(function(e){
                    e.stopPropagation();
                    e.preventDefault();
                    var $this = jQuery(this);
                    // don't proceed if already selected
                    if ($this.hasClass('selected')) {
                        return false;
                    }
                    var filters = $this.closest('ul');
                    filters.find('.selected').removeClass('selected');
                    $this.addClass('selected');

                    var options = {},
                        key = filters.attr('data-option-key'),
                        value = $this.attr('data-option-value');

                    value = value === 'false' ? false : value;
                    options[key] = value;

                    $container.isotope(options);

                });

            });
        </script>
        
        <?php  if( $style == 'two' ){ ?>
        <script>
            jQuery(document).ready(function () {
                jQuery('.product-style2 .add_to_wishlist, .product-style2 .yith-wcwl-wishlistexistsbrowse a, .product-style2 .yith-wcwl-wishlistaddedbrowse a').each(function () {
                    var $text = jQuery(this).text();
                    jQuery(this).empty();
                    jQuery(this).append('<span>'+$text+'</span>');
                });


            });
        </script>
        <?php } ?>
        <?php
        $grid = ob_get_contents();
        ob_end_clean();
        return $grid;
    }
    add_shortcode('noo_product_grid','noo_shortcode_product_grid');
}