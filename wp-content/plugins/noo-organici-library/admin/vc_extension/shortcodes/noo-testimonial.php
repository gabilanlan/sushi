<?php
    if( !function_exists('noo_shortcode_testimonial') ){
        function noo_shortcode_testimonial($atts){
            extract(shortcode_atts(array(
                'style'             =>  'one',
                'categories'        =>  '',
                'background_thumb'  =>  '',
                'autoplay'          =>  'true',
                'orderby'           =>  'latest',
                'posts_per_page'    =>  '10',
                'line'              =>  'hide',
                'image_left'        =>  '',
                'image_right'       =>  ''
            ),$atts));
            ob_start();
            wp_enqueue_script('noo-carousel');
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
                    'post_type' =>  'testimonial',
                    'orderby'           =>   $orderby,
                    'order'             =>   $order,
                    'posts_per_page'    =>   $posts_per_page,
                );

                if( $categories != 'all' && !empty($categories)){
                    $args['tax_query'][]  = array(
                        'taxonomy'  =>  'testimonial_category',
                        'field'     =>  'term_id',
                        'terms'     =>   array($categories)
                    );
                }
                $query = new WP_Query( $args );
                $count = $query->post_count;

            ?>
            <div class="noo_testimonial_wrap">
                <?php
                    if( isset($image_left) && !empty($image_left) ){
                        echo wp_get_attachment_image($image_left,'full',false, array('class'=>'image_left'));
                    }
                    if( isset($image_right) && !empty($image_right) ){
                        echo wp_get_attachment_image($image_right,'full',false, array('class'=>'image_right'));
                    }
                ?>
                <?php if( $line == 'show' ): ?>
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
                <?php endif; ?>
                <?php if( $style == 'one' ): ?>
                <ul class="noo_testimonial">
                    <?php if( $query->have_posts() ): ?>
                        <?php  while( $query->have_posts() ): $query->the_post();
                            $url      = get_post_meta(get_the_ID(),'_noo_wp_testimonial_image', true);
                            $name     = get_post_meta(get_the_ID(),'_noo_wp_testimonial_name', true);
                            $position = get_post_meta(get_the_ID(),'_noo_wp_testimonial_position', true);
                            if( isset($background_thumb) && !empty($background_thumb)  ){
                                $thumb = wp_get_attachment_image_src($background_thumb,'full');
                            }

                            ?>
                            <li>
                                <div class="testimonial_wrap">
                                    <div class="testimonial-header">
                                        <?php if( isset($url) && !empty($url) ): ?>
                                            <div class="background_image" <?php if( isset($thumb) && !empty($thumb) ):  ?>style="background-image: url('<?php echo esc_url($thumb[0]); ?>')" <?php endif; ?>>
                                                <img width="120" height="120" class="noo_testimonial_avatar" src="<?php echo wp_get_attachment_url(esc_attr($url)); ?>" alt="<?php echo esc_attr($name); ?>" />
                                            </div>
                                        <?php endif; ?>
                                        <div class="testimonial-name">
                                            <?php if( isset($name) && !empty($name) ): ?>
                                                <h4 class="noo_testimonial_name"><?php echo esc_html($name); ?></h4>
                                            <?php endif; ?>
                                            <?php if( isset($position) && !empty($position) ): ?>
                                                <span class="noo_testimonial_position">( <?php echo esc_html($position); ?> )</span>
                                            <?php endif; ?>

                                        </div>
                                    </div>
                                    <div class="testimonial-content">
                                        <div>
                                            <i class="fa fa-quote-left"></i>
                                            <?php the_content(); ?>
                                            <i class="fa fa-quote-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php endwhile; ?>
                    <?php endif; wp_reset_postdata(); ?>
                </ul>
                <?php elseif($style == 'two') :
                    $html = '';
                    ?>
                    <div class="noo-testimonial-sync1">
                        <?php if( $query->have_posts() ): ?>
                            <?php  while( $query->have_posts() ): $query->the_post();
                                $url      = get_post_meta(get_the_ID(),'_noo_wp_testimonial_image', true);
                                $name     = get_post_meta(get_the_ID(),'_noo_wp_testimonial_name', true);
                                $position = get_post_meta(get_the_ID(),'_noo_wp_testimonial_position', true);
                                if( isset($background_thumb) && !empty($background_thumb)  ){
                                    $thumb = wp_get_attachment_image_src($background_thumb,'full');
                                }
                                $html .='<div class="item">';
                                    $html .='<div class="testimonial-content">';
                                        $html .='<div>';
                                            $html .= '<i class="fa fa-quote-left"></i>';
                                            $html .= get_the_content();
                                            $html .= '<i class="fa fa-quote-right"></i>';
                                        $html .= '</div>';
                                    $html .='</div>';
                                    $html .=' <div class="testimonial-name">';
                                         if( isset($name) && !empty($name) ):
                                             $html .='<h4 class="noo_testimonial_name">'.esc_html($name).'</h4>';
                                         endif;
                                         if( isset($position) && !empty($position) ):
                                             $html .='<span class="noo_testimonial_position">( '.esc_html($position).' )</span>';
                                         endif;
                                    $html .='</div>';
                                $html .='</div>';
                                ?>
                                <div class="item">
                                    <?php if( isset($url) && !empty($url) ): ?>
                                        <div class="background_image" <?php if( isset($thumb) && !empty($thumb) ):  ?>style="background-image: url('<?php echo esc_url($thumb[0]); ?>')" <?php endif; ?>>
                                            <img class="noo_testimonial_avatar" src="<?php echo wp_get_attachment_url(esc_attr($url)); ?>" alt="<?php echo esc_attr($name); ?>" />
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; wp_reset_postdata(); ?>
                    </div>
                    <div class="noo-testimonial-sync2">
                        <?php echo ($html); ?>
                    </div>

                <?php else:
                    $html = '';
                    ?>
                    <div class="noo-testimonial-sync2 testimonial-three">
                        <?php if( $query->have_posts() ): ?>
                            <?php  while( $query->have_posts() ): $query->the_post();
                                $url      = get_post_meta(get_the_ID(),'_noo_wp_testimonial_image', true);
                                $name     = get_post_meta(get_the_ID(),'_noo_wp_testimonial_name', true);
                                $position = get_post_meta(get_the_ID(),'_noo_wp_testimonial_position', true);
                                if( isset($background_thumb) && !empty($background_thumb)  ){
                                    $thumb = wp_get_attachment_image_src($background_thumb,'full');
                                }
                                ?>
                                <div class="item">
                                    <div class="testimonial-content">
                                        <h3 class="testi-title"><?php  the_title(); ?></h3>
                                        <div>
                                            <i class="fa fa-quote-left"></i>
                                            <?php the_content(); ?>
                                            <i class="fa fa-quote-right"></i>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $html .='<div class="item">';
                                    if( isset($url) && !empty($url) ):
                                        if( isset($thumb[0]) && !empty($thumb[0]) ) {
                                            $html .= '<div class="background_image" style="background-image: url(' . esc_url($thumb[0]) . ')">';
                                        }else{
                                            $html .= '<div class="background_image">';
                                        }
                                                    $html .='<img class="noo_testimonial_avatar" src="'. wp_get_attachment_url(esc_attr($url)) .'" alt="'. esc_attr($name) .'" />';
                                            $html .='</div>';
                                    endif;
                                        $html .= '<div class="testimonial-name">';
                                            if( isset($name) && !empty($name) ):
                                                $html .='<h4 class="noo_testimonial_name">'.esc_html($name).'</h4>';
                                            endif;
                                            if( isset($position) && !empty($position) ):
                                                $html .='<span class="noo_testimonial_position">( '.esc_html($position).' )</span>';
                                            endif;
                                        $html .='</div>';
                                $html .='</div>';
                                ?>

                            <?php endwhile; ?>
                        <?php endif; wp_reset_postdata();?>
                    </div>

                    <div class="noo-testimonial-sync1 testimonial-three">
                        <?php echo ($html); ?>
                    </div>
                <?php endif; ?>
            </div>
            <script>
                jQuery(document).ready(function(){
                    <?php if( $style == 'one' ){ ?>
                        jQuery('.noo_testimonial').each(function(){
                            jQuery(this).owlCarousel({
                                items : 1,
                                itemsDesktop : [1199,1],
                                itemsDesktopSmall : [979,1],
                                itemsTablet: [768, 1],
                                slideSpeed:500,
                                paginationSpeed:800,
                                rewindSpeed:1000,
                                autoHeight: false,
                                addClassActive: true,
                                autoPlay: <?php echo esc_attr($autoplay); ?>,
                                loop:true,
                                pagination: true,
                                afterInit : function(el){
                                    el.find(".owl-item").eq(1).addClass("synced");
                                }
                            });
                        });
                    <?php }else{ ?>
                        var sync1 = jQuery(".noo-testimonial-sync2");
                        var sync2 = jQuery(".noo-testimonial-sync1");

                        sync1.owlCarousel({
                            singleItem : true,
                            slideSpeed : 1000,
                            navigation: false,
                            pagination:false,
                            afterAction : syncPosition,
                            responsiveRefreshRate : 200
                        });

                        function syncPosition(el){
                            var current = this.currentItem;
                            jQuery(".noo-testimonial-sync1")
                                .find(".owl-item")
                                .removeClass("synced")
                                .eq(current)
                                .addClass("synced")
                            if(jQuery(".noo-testimonial-sync1").data("owlCarousel") !== undefined){
                                center(current)
                            }
                        }

                        jQuery(".noo-testimonial-sync1").on("click", ".owl-item", function(e){
                            e.preventDefault();
                            var number = jQuery(this).data("owlItem");
                            sync1.trigger("owl.goTo",number);
                        });
                        <?php
                        $items = ( $count < 3 ) ? $count : 3;
                        ?>
                        sync2.owlCarousel({
                            items : <?php echo $items; ?>,
                            itemsDesktop      : [1199,<?php echo $items; ?>],
                            itemsDesktopSmall     : [979,<?php echo $items; ?>],
                            itemsTablet       : [768,<?php echo $items; ?>],
                            itemsMobile       : [479,<?php echo $items; ?>],
                            pagination:false,
                            responsiveRefreshRate : 100,
                            afterInit : function(el){
                                el.find(".owl-item").eq(1).click();
                            }
                        });
                        <?php if($items == 1): ?>
                        jQuery(".noo-testimonial-sync1")
                        .find(".owl-item")
                        .addClass("synced");
                        <?php endif; ?>

                        function center(number){
                            var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
                            var num = number;
                            var found = false;
                            for(var i in sync2visible){
                                if(num === sync2visible[i]){
                                    var found = true;
                                }
                            }

                            if(found===false){
                                if(num>sync2visible[sync2visible.length-1]){
                                    sync2.trigger("owl.goTo", num - sync2visible.length+2)
                                }else{
                                    if(num - 1 === -1){
                                        num = 0;
                                    }
                                    sync2.trigger("owl.goTo", num);
                                }
                            } else if(num === sync2visible[sync2visible.length-1]){
                                sync2.trigger("owl.goTo", sync2visible[1])
                            } else if(num === sync2visible[0]){
                                sync2.trigger("owl.goTo", num-1)
                            }

                        }
                    <?php } ?>
                });

            </script>
            <?php

            $testimonial = ob_get_contents();
            ob_end_clean();
            return $testimonial;
        }
        add_shortcode('noo_testimonial','noo_shortcode_testimonial');
    }