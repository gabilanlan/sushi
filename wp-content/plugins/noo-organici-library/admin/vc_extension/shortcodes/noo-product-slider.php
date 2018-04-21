<?php

if( !function_exists('noo_shortcode_product_slider') ){

    function noo_shortcode_product_slider($atts){
        extract(shortcode_atts(array(
            'title'          =>  '',
            'description'    =>  '',
            'cat'            =>  '',
            'style'          =>  'one',
            'orderby'        =>  'latest',
            'posts_per_page' =>  8,
            'filter_all_icon' =>  ''
        ),$atts));
        ob_start();
        wp_enqueue_script('noo-carousel');

        $class= '';
        if( $style == 'two' ){
            $class= 'product-style2';
        }

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
        $args = array(
            'post_type'         =>  'product',
            'orderby'           =>   $orderby,
            'order'             =>   $order,
            'posts_per_page'    =>   $posts_per_page
        );
        if( isset($cat) && $cat != 'all' && !empty($cat) ){
            $new_id = explode(',',$cat);
            $new_cat = array();

            foreach($new_id as $id){
                $new_cat[] = intval($id);
            }
            $new_cat_id    = '';
            if( $new_id[0] == 'all' ){
                $new_cat_id = $new_cat;
            }
        }

        ?>
        <div class="noo-product-slider-wrap woocommerce <?php echo esc_attr($class) ?>">
            <?php if( $title != '' || $description !='' ): ?>
            <div class="noo-sh-title">
                <?php if( isset($title) && !empty($title) ) ?><h2><?php echo esc_html($title);  ?></h2>
                <?php if( isset($description) && !empty($description) ): ?><p><?php echo esc_html($description); ?></p><?php endif; ?>
            </div>
        <?php endif; ?>
            <div class="noo-product-filter">
                <ul class="noo-header-filter noo-header-slider">
                    <?php

                    if( (isset($new_id[0]) && $new_id[0] == 'all') || (isset($cat) && $cat == 'all')): ?>
                    <li>
                        <span  data-option-id="<?php echo esc_attr($cat); ?>" data-option-limit="<?php echo esc_attr($posts_per_page); ?>" class="selected">
                        <?php if (isset($filter_all_icon) && !empty($filter_all_icon)): ?>
                            <img width="30" height="26" src="<?php echo esc_url(wp_get_attachment_image_url($filter_all_icon, 'full')); ?>" alt="<?php echo esc_html__('All products','noo') ?>" />
                        <?php else: ?>
                            <img width="30" height="26" src="<?php echo esc_url(NOO_PLUGIN_ASSETS_URI.'/images/organicfood.png'); ?>" alt="<?php echo esc_html__('All products','noo') ?>" />
                        <?php endif; ?>
                            <span><?php echo esc_html__('All products','noo') ?></span>
                        </span>
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
                        foreach( $categories as $key => $cats ):
                            $select='';

                            if( isset($new_id[0]) && $new_id[0] != 'all' && $key==0 ) {
                                $select = 'selected';
                                $new_cat_id = $cats->term_id;
                            }

                            ?>
                            <li>
                                <span data-option-id="<?php echo esc_attr($cats->term_id); ?>" data-option-limit="<?php echo esc_attr($posts_per_page); ?>" class="<?php echo esc_attr($select); ?>">
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
                                </span>
                            </li>
                        <?php endforeach;
                    endif;
                    ?>

                </ul>
            </div>
            <div class="noo-container-fluid">
               <div class="noo-row noo-product-slider products product-grid">
                   <div class="noo-slider">
                        <?php
                            if( isset($new_cat_id) ){
                                $args['tax_query'][] = array(
                                    'taxonomy'  =>  'product_cat',
                                    'field'     =>  'term_id',
                                    'terms'     =>   $new_cat_id
                                );
                            }

                            $query = new WP_Query($args) ;
                            if( $query->have_posts() ):
                               while( $query->have_posts() ): $query->the_post();
                                   ?>
                                   <?php wc_get_template_part( 'content', 'product' ); ?>
                               <?php   endwhile;
                            endif; wp_reset_postdata();
                       ?>
                   </div><!--end .noo-product-slider-->
               </div>
           </div>
        </div>
        <script>
            jQuery(document).ready(function(){

                <?php  if( $style == 'two' ){ ?>

                jQuery('.product-style2 .add_to_wishlist, .product-style2 .yith-wcwl-wishlistexistsbrowse a, .product-style2 .yith-wcwl-wishlistaddedbrowse a').each(function () {
                    var $text = jQuery(this).text();
                    jQuery(this).empty();
                    jQuery(this).append('<span>'+$text+'</span>');
                });
                
                <?php } ?>

                jQuery('.noo-slider').owlCarousel({
                    items : 4,
                    itemsDesktop : [1199,4],
                    itemsDesktopSmall : [991,2],
                    itemsTablet: [768, 2],
                    itemsMobile : [479, 1],
                    slideSpeed:500,
                    paginationSpeed:800,
                    rewindSpeed:1000,
                    autoHeight: false,
                    addClassActive: true,
                    autoPlay: false,
                    loop:true,
                    pagination: true
                });

                //jquery ajax
                jQuery('.noo-header-slider li > span').live('click',function(event){
                    event.preventDefault();
                    var $parent = jQuery(this).closest('.noo-product-slider-wrap');
                    var $height = $parent.find('.noo-product-slider').height();
                    $parent.find('.noo-product-slider').css('min-height', $height + 'px');
                    $parent.find('.noo-header-slider span').removeClass('selected');
                    jQuery(this).addClass('selected');
                    $parent.find('.noo-product-slider').addClass('eff');
                    var $cat_id = jQuery(this).attr('data-option-id');
                    var $limit = jQuery(this).attr('data-option-limit');
                    jQuery.ajax({
                        url: '<?php echo esc_url(admin_url('admin-ajax.php')); ?>',
                        type: 'POST',
                        data: ({
                            action: 'noo_organici_product_slider',
                            catid: $cat_id,
                            limit: $limit
                        }),
                        success: function(data){
                            if(data){
                                jQuery('.noo-product-slider').removeClass('eff');

                                jQuery('.noo-product-slider').html(data);
                                jQuery('.noo-slider').owlCarousel({
                                    items : 4,
                                    itemsDesktop : [1199,4],
                                    itemsDesktopSmall : [991,2],
                                    itemsTablet: [768, 2],
                                    itemsMobile : [479, 1],
                                    slideSpeed:500,
                                    paginationSpeed:800,
                                    rewindSpeed:1000,
                                    autoHeight: false,
                                    addClassActive: true,
                                    autoPlay: false,
                                    loop:true,
                                    pagination: true
                                });
                                jQuery('.noo-product-slider').css('min-height','inherit');
                            }
                        }
                    })
                });
            });
        </script>
        <?php
        $grid = ob_get_contents();
        ob_end_clean();
        return $grid;
    }
    add_shortcode('noo_product_slider','noo_shortcode_product_slider');

}