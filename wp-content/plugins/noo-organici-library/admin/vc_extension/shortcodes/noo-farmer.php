<?php

    if( !function_exists('noo_shortcode_farmer') ){
        function noo_shortcode_farmer($atts){
            extract(shortcode_atts(array(
                'title'          =>  '',
                'description'    =>  '',
                'style'          =>  'grid',
                'cat'            =>  '',
                'columns'        =>  '3',
                'orderby'        =>  'latest',
                'posts_per_page' =>  3
            ),$atts));
            ob_start();
            wp_enqueue_script('noo-carousel');
            ?>
            <?php if( $title != '' || $description !='' ): ?>
                <div class="noo-sh-title noo-farmer-title">
                    <?php if( isset($title) && !empty($title) ) ?><h2><?php echo esc_html($title);  ?></h2>
                    <?php if( isset($description) && !empty($description) ): ?><p><?php echo esc_html($description); ?></p><?php endif; ?>
                </div>
            <?php endif; ?>
            <?php
            $socail  = array('facebook','twitter','google','linkedin','flickr','pinterest','instagram','tumblr');
            $class_columns = 'noo-md-4 noo-sm-6';
            if( $columns == 4 ){
                $class_columns = 'noo-md-3 noo-sm-6';
            }elseif( $columns == 2 ){
                $class_columns = 'noo-md-6 noo-sm-6';
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
                'post_type'         =>  'farmer',
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
                    'taxonomy'  =>  'farmer_category',
                    'field'     =>  'term_id',
                    'terms'     =>   $new_cat
                );
            }
            $class_slider = uniqid('noo-slider-');
            $query = new WP_Query( $args );
            if( $query->have_posts() ):
                if( $style == "slider" ){
                    echo '<div class="noo-row noo-farmer-slider '.esc_attr($class_slider).'">';
                } else {
                    echo '<div class="noo-row">';
                }
                while( $query->have_posts() ):
                    $query->the_post();
                    $image = noo_organici_get_post_meta(get_the_ID(),'_noo_wp_farmer_image','');
                    $name = noo_organici_get_post_meta(get_the_ID(),'_noo_wp_farmer_name','');
                    ?>
                    <div class="<?php if( $style == 'grid') echo esc_attr($class_columns); ?>">
                        <div class="noo-farmer">
                            <?php if( isset($image) && !empty($image) ){ ?>
                            <div class="noo-farmer-thumbnail">
                                <?php echo wp_get_attachment_image($image,'full'); ?>
                                <span class="first"></span>
                                <span class="second"></span>
                            </div>
                            <?php } ?>
                            <div class="noo-farmer-content">
                                <h4><?php echo esc_html($name); ?></h4>
                                <?php the_content(); ?>
                                <span class="social">
                                    <?php for( $i=0; $i < count( $socail ); $i++ ): ?>
                                        <?php
                                            $social_key = '_noo_wp_farmer_'.$socail[$i];
                                            $social_url = noo_organici_get_post_meta(get_the_ID(),$social_key,'');
                                            if( isset($social_url) && !empty($social_url) ): ?>
                                                <a href="<?php echo esc_url($social_url); ?>" class="fa fa-<?php echo esc_attr($socail[$i]); ?>"></a>
                                            <?php endif; ?>
                                    <?php endfor; ?>
                                </span>
                            </div>
                        </div><!--end .noo-farmer-->
                    </div>
                    <?php
                endwhile;
                echo '</div>';
            endif; wp_reset_postdata();
            if( $style == 'slider' ):
                ?>
                <script>
                jQuery(document).ready(function(){
                    jQuery('.<?php echo esc_attr($class_slider) ?>').owlCarousel({
                        items : <?php echo esc_attr($columns); ?>,
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
                        pagination: true,
                        navigation : true,
                        navigationText : ["", ""],
                    });
                });
                </script>
                <?php
            endif;
            $farmer = ob_get_contents();
            ob_end_clean();
            return $farmer;
        }
        add_shortcode('noo_farmer','noo_shortcode_farmer');
    }