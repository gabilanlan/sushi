<?php

    if( !function_exists('noo_shortcode_product_list') ){

        function noo_shortcode_product_list($atts){
            extract(shortcode_atts(array(
                'title'          =>  '',
                'description'    =>  '',
                'orderby'        =>  'latest',
                'cat'            =>  '',
                'posts_per_page' =>  8,
                'button_name'    => '',
                'button_link'    => '#',
            ),$atts));
            ob_start();
            ?>
            <?php if( $title != '' || $description !='' ): ?>
                <div class="noo-sh-title noo-product-list-title">
                    <?php if( isset($title) && !empty($title) ) ?><h2><?php echo esc_html($title);  ?></h2>
                    <?php if( isset($description) && !empty($description) ): ?><p><?php echo esc_html($description); ?></p><?php endif; ?>
                </div>
            <?php endif; ?>
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
                $args['tax_query'][] = array(
                    'taxonomy'  =>  'product_cat',
                    'field'     =>  'term_id',
                    'terms'     =>   $new_cat
                );
            }
            $query = new WP_Query( $args );

            if( $query->have_posts() ):
                $i = 0;
                while( $query->have_posts() ):
                    $query->the_post(); global $product;
                    $class= 'left';
                    if( $i % 2 !=0 ){
                        $class = 'product-list-right';
                    }
                    $i++;
                    ?>
                <div class="noo-row product-list-item <?php echo esc_attr($class); ?>">
                    <div class="noo-md-6 noo-sm-6 left-content">
                        <h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
                        <div class="list-excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                        <?php if ( $price_html = $product->get_price_html() ) : ?>
                            <span class="price"><?php echo $price_html; ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="noo-md-6 noo-sm-6 right-img">
                        <a href="<?php the_permalink() ?>">
                            <?php the_post_thumbnail('large'); ?>
                            <span><em><?php echo esc_html('Shop now','noo'); ?></em></span>
                        </a>
                    </div>
                </div>
            <?php endwhile;
            endif; wp_reset_postdata();
            ?>
            <?php if( isset( $button_name ) && !empty($button_name) ): ?>
               <p class="text-center">
                   <span class="view_all"><a href="<?php echo esc_url($button_link); ?>"><?php echo esc_html($button_name) ?></a></span>
               </p>
            <?php endif; ?>
            <?php
            $list = ob_get_contents();
            ob_end_clean();
            return $list;
        }
        add_shortcode('noo_product_list','noo_shortcode_product_list');

    }