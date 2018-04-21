<?php
    if( !function_exists('noo_shortcode_product_menu') ){

        function noo_shortcode_product_menu($atts){
            extract(shortcode_atts(array(
                'icon'          =>      '',
                'attach'        =>      '',
                'title'         =>      '',
                'description'   =>      '',
                'cat'            =>  '',
                'orderby'        =>  'latest',
                'posts_per_page' =>  8,
                'background'     =>  ''
            ),$atts));
            ob_start();
            $bk = '';
            if( isset( $background ) && !empty($background) ){
                $bk = wp_get_attachment_image_src( esc_attr($background) ,'full' );
            }
            ?>
            <div class="inheader-sh-title products-sh-title">
                <?php if(isset( $icon ) && !empty( $icon )): echo wp_get_attachment_image( esc_attr($icon),'',false,array('class'=>'icon') ); endif;?>
                <?php if( isset($title) && !empty($title) ): ?><h2><?php echo esc_html($title); ?></h2><?php endif; ?>
                <?php if( isset($attach) && !empty($attach) ): ?><h4><?php echo esc_html($attach); ?></h4><?php endif; ?>
                <?php if( isset($description) && !empty($description) ): ?><p class="ds"><?php echo esc_html($description); ?></p><?php endif; ?>
            </div>
            <div class="noo-products-menu">
                <ul class="filter-menu">
                    <li>
                        <span data-option-id="all" data-option-limit="<?php echo esc_attr($posts_per_page); ?>" class="selected">
                             <?php echo esc_html__('All products','noo') ?>
                        </span>
                    </li>
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
                        foreach( $categories as $cats ): ?>
                            <li>
                                <span data-option-id="<?php echo esc_attr($cats->term_id); ?>" data-option-limit="<?php echo esc_attr($posts_per_page); ?>">
                                    <?php echo esc_html($cats->name); ?>
                                </span>
                            </li>
                        <?php endforeach;
                    endif;
                    ?>
                </ul>
                <div class="noo-product-menu-content" <?php if( isset($bk) && !empty($bk) ): ?> style="background-image: url('<?php echo esc_url($bk[0]) ; ?>')" <?php endif; ?>>
                    <div class="product-menu-bk"></div>
                    <div class="noo-line">
                        <span class="line-one">
                            <span></span>
                            <span></span>
                        </span>
                        <span class="line-two">
                            <span></span>
                            <span></span>
                        </span>
                    </div>
                    <ul class="noo-menu-content">
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
                            'post_status'       =>   array('publish'),
                            'posts_per_page'    =>   $posts_per_page,
                            // 'meta_query'     => array(
                            //     array(
                            //         'key'       => '_visibility',
                            //         'value'     => 'hidden',
                            //         'compare'   => '!=',
                            //     )
                            // )
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

                        $query = new WP_Query($args) ;
                        if( $query->have_posts() ):
                            $i = 1;
                            while( $query->have_posts() ): $query->the_post();
                                global $product;
                                $classes = 'first';
                                if ( 0 == $i % 2 ) {
                                    $classes = 'last';
                                }
                                $i++;
                                ?>
                                <li class="<?php echo esc_attr($classes); ?>">
                                    <div class="menu-thumb">
                                       <a href="<?php the_permalink() ?>"><?php the_post_thumbnail(array(65,65)) ?></a>
                                    </div>
                                    <div class="product-menu-ds">
                                        <div class="product-menu-flex">
                                           <span class="p-menu-title"> <a href="<?php the_permalink() ?>"><?php the_title(); ?></a></span>
                                            <span class="p-menu-border"></span>
                                            <?php if ( $price_html = $product->get_price_html() ) : ?>
                                                <span class="price"><?php echo $price_html; ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <?php the_excerpt(); ?>
                                    </div>
                                </li>
                            <?php   endwhile;
                        endif; wp_reset_postdata();
                        ?>
                    </ul>
                </div>
            </div>
            <script>
                jQuery(document).ready(function(){
                    //jquery ajax
                    jQuery('.filter-menu span').live('click',function(event){
                        event.preventDefault();
                        var $parent = jQuery(this).closest('.noo-products-menu');
                        $parent.find('.filter-menu span').removeClass('selected');
                        jQuery(this).addClass('selected');
                        $parent.find('.noo-menu-content').addClass('eff');
                        $parent.find('.product-menu-bk').addClass('eff');
                        var $cat_id = jQuery(this).attr('data-option-id');
                        var $limit = jQuery(this).attr('data-option-limit');
                        jQuery.ajax({
                            url: '<?php echo esc_url(admin_url('admin-ajax.php')); ?>',
                            type: 'POST',
                            data: ({
                                action: 'noo_organici_product_menu_action',
                                catid: $cat_id,
                                limit: $limit
                            }),
                            success: function(data){
                                if(data){
                                   jQuery('.noo-menu-content').removeClass('eff');
                                    jQuery('.product-menu-bk').removeClass('eff');

                                    jQuery('.noo-menu-content').html(data);

                                }
                            }
                        })
                    });
                });
            </script>
            <?php
            $p_menu = ob_get_contents();
            ob_end_clean();
            return $p_menu;
        }
        add_shortcode('noo_product_menu','noo_shortcode_product_menu');

    }