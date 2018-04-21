<?php

    /**
     * This shortocde display product by taxonomy boxed
     * @param $atts
     * @return display boxed
     */

    if( !function_exists('noo_shortcode_boxes') ){

        function noo_shortcode_boxes($atts){
            extract(shortcode_atts(array(
                extract(shortcode_atts(array(
                    'cat'       =>  '',
                    'columns'   =>  '3'
                ),$atts))
            ),$atts));
            ob_start();

            $args = array(
                'type'      =>  'product',
                'taxonomy'  =>  'product_boxed'
            );
            if( isset($cat) && $cat != 'all' && !empty($cat) ){
                $args['include'] = $cat;
            }
            $class_columns = 'noo-md-4 noo-sm-6';
            if( $columns == '4'){
                $class_columns = 'noo-md-3 noo-sm-6';
            }elseif( $columns == '2' ){
                $class_columns = 'noo-md-6 noo-sm-6';
            }

            $boxes = get_categories( $args );

            if( isset($boxes) && !empty($boxes) ){
                echo '<div class="noo-row noo-boxed">';
                    foreach( $boxes as $box ){
                        $box_thumbnail = noo_organici_get_term_meta( $box->term_id, 'thumbnail_id', '' );
                        $box_color     = noo_organici_get_term_meta( $box->term_id, 'box_color', '' );
                        $all_product   = noo_organici_get_term_meta( $box->term_id, 'boxed_id_sort', '' );
                        $product_box   = '';
                        if( isset($all_product) && !empty($all_product) ){
                            $product_box = explode(',',$all_product);
                        }

                        ?>
                            <div class="<?php echo esc_attr($class_columns); ?>">
                                <div class="box-inner">
                                    <div class="box-inner-child">


                                    <?php if( isset($box_thumbnail) && !empty($box_thumbnail) ):
                                        $url_image = wp_get_attachment_image_src(esc_attr($box_thumbnail),'full');
                                        ?>
                                        <div class="box-thumbail">
                                            <a href="<?php if( isset($product_box) && !empty($product_box) ){ echo esc_url(get_permalink($product_box[0])) ; }else{ echo '#'; } ?>">
                                                <img src="<?php echo esc_url($url_image[0]) ?>" alt="<?php echo esc_attr($box->name); ?>">
                                            </a>
                                        </div>
                                    <?php endif; ?>

                                    <div class="box-content">
                                        <h3 <?php if( isset($box_color) && !empty($box_color) ): ?> style="color: <?php echo esc_attr($box_color) ?> <?php endif; ?>"><?php echo esc_html($box->name); ?></h3>
                                        <p><?php echo esc_html($box->description); ?></p>
                                    </div><!--end .box-content-->
                                    <div class="box-inner-product">
                                        <?php
                                            // get product by box
                                            $box_description = '';
                                        ?>
                                        <ul class="product-box-header">
                                            <?php

                                                if( isset($product_box) && !empty($product_box) ){
                                                        foreach($product_box as $product_id):
                                                            $get_product = get_post( $product_id );

                                                            $alias = noo_organici_get_post_meta($product_id,'_noo_box_title');
                                                            $key_id = $product_id.wp_rand(0,100);

                                                            $box_description .='<div class="box-content-tab" id="box_tab_'.esc_attr($key_id).'">';

                                                                $box_description .= '<h4><a href="'.esc_url(get_permalink($product_id)).'">'.esc_html(get_the_title($product_id)).'</a></h4>';
                                                                $box_description .= '<p>'.esc_html($get_product->post_excerpt).'</p>';

                                                            $box_description .= '</div>';  ?>
                                                                <li>
                                                                    <span data-id="#box_tab_<?php echo esc_attr($key_id) ; ?>" data-color="<?php if( isset($box_color) && !empty($box_color) ): echo esc_attr($box_color);  endif; ?>">
                                                                        <?php
                                                                            if ( !wp_is_mobile() ) {
                                                                                if( isset($alias) && !empty($alias) ){
                                                                                    echo '<a href="'.esc_url(get_permalink($product_id)).'">'.esc_html($alias).'</a>';
                                                                                }else{
                                                                                    echo '<a href="'.esc_url(get_permalink($product_id)).'">'.esc_html(get_the_title($product_id)).'</a>';
                                                                                }
                                                                            } else {
                                                                                if( isset($alias) && !empty($alias) ){
                                                                                    echo '<a>'.esc_html($alias).'</a>';
                                                                                }else{
                                                                                    echo '<a>'.esc_html(get_the_title($product_id)).'</a>';
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </span>
                                                                </li>
                                                <?php endforeach;
                                                }
                                            ?>
                                            </ul>
                                            <div class="box-description-tab" <?php if( isset($box_color) && !empty($box_color) ): ?> style="background-color: <?php echo esc_attr($box_color) ?> <?php endif; ?>">
                                                <?php echo $box_description; ?>
                                            </div>
                                        </div><!--end box-inner-product-->
                                    </div><!--end .box-inner-child-->
                                </div><!--end .box_inner-->

                            </div>
                        <?php
                    }
                echo '</div>';

            }
            ?>

            <script>
                jQuery(document).ready(function(){
                    jQuery('.box-inner').each(function(){
                        var first_color = jQuery(this).find('.product-box-header li:first-child span').data('color');
                        jQuery(this).find('.product-box-header li:first-child span').css('background',first_color).addClass('acitve');
                    });

                    jQuery('.product-box-header li span').mousemove(function(){
                        var $parent = jQuery(this).closest('.box-inner');
                        $parent.find('.product-box-header li span').removeAttr('style').removeClass('acitve');
                        var color   = jQuery(this).data('color');
                        var id      = jQuery(this).data('id');
                        jQuery(this).css('background',color).addClass('acitve');
                        $parent.find('.box-content-tab').hide();
                        $parent.find(id).show();
                    });

                });
            </script>

            <?php

            $boxed = ob_get_contents();
            ob_end_clean();
            return $boxed;
        }
        add_shortcode('noo_boxes','noo_shortcode_boxes');

    }