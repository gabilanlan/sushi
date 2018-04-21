<?php
    if( !function_exists('noo_shortcode_farmer_slider') ){
        function noo_shortcode_farmer_slider($atts){
            extract(shortcode_atts(array(
                'title'            =>  '',
                'description'      =>  '',
                'cat'              =>  '',
                'columns'          =>  '3',
                'orderby'          =>  'latest',
                'posts_per_page'   =>  3,
                'background_thumb' =>  '',
            ),$atts));
            ob_start();
            wp_enqueue_script('noo-carousel');
            $socail  = array('facebook','twitter','google','linkedin','flickr','pinterest','instagram','tumblr');
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
                $query = new WP_Query( $args );

            ?>
            <?php if( $title != '' || $description !='' ): ?>
                <div class="noo-sh-title noo-farmer-title noo-farmer-title-slider">
                    <?php if( isset($title) && !empty($title) ) ?><h2><?php echo esc_html($title);  ?></h2>
                    <?php if( isset($description) && !empty($description) ): ?><?php echo wpb_js_remove_wpautop($description, true); ?><?php endif; ?>
                </div>
            <?php endif; ?>
            <div class="noo_testimonial_wrap noo_farmer_wrap">
                <?php
                $html = '';
                ?>
                <div class="noo-testimonial-sync1">
                    <?php if( $query->have_posts() ): ?>
                        <?php  while( $query->have_posts() ): $query->the_post();
                            $url      = get_post_meta(get_the_ID(),'_noo_wp_farmer_image', true);
                            $name     = get_post_meta(get_the_ID(),'_noo_wp_farmer_name', true);
                            if( isset($background_thumb) && !empty($background_thumb)  ){
                                $thumb = wp_get_attachment_image_src($background_thumb,'full');
                            }
                            $html .='<div class="item">';
                                $html .=' <div class="testimonial-name">';
                                     if( isset($name) && !empty($name) ):
                                         $html .='<h4 class="noo_testimonial_name">'.esc_html($name).'</h4>';
                                     endif;
                                $html .='</div>';
                                $html .='<div class="testimonial-content">';
                                    $html .='<span class="social">';
                                    for( $i=0; $i < count( $socail ); $i++ ):
                                        $social_key = '_noo_wp_farmer_'.$socail[$i];
                                        $social_url = noo_organici_get_post_meta(get_the_ID(),$social_key,'');
                                        if( isset($social_url) && !empty($social_url) ): 
                                            $html .='<a href="'.esc_url($social_url).'" class="fa fa-'.esc_attr($socail[$i]).'"></a>';
                                        endif; 
                                    endfor;
                                    $html .='</span>';
                                $html .='</div>';
                            $html .='</div>';
                            ?>
                            <div class="item">
                                <?php if( isset($url) && !empty($url) ): ?>
                                    <div class="background_image" <?php if( isset($thumb) && !empty($thumb) ):  ?>style="background-image: url('<?php echo esc_url($thumb[0]); ?>') !important;" <?php endif; ?>>
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
            </div>
            <script>
                jQuery(document).ready(function(){
                        var sync1 = jQuery(".noo-testimonial-sync2");
                        var sync2 = jQuery(".noo-testimonial-sync1");

                        sync1.owlCarousel({
                            singleItem : true,
                            slideSpeed : 1000,
                            navigation: true,
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
                     
                    sync2.owlCarousel({
                            items : 3,
                            itemsDesktop      : [1199,3],
                            itemsDesktopSmall     : [979,2],
                            itemsTablet       : [768,2],
                            itemsMobile       : [479,2],
                            pagination:false,
                            responsiveRefreshRate : 100,
                            afterInit : function(el){
                                el.find(".owl-item").eq(1).click();
                            }
                        });

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
                });

            </script>
            <?php

            $testimonial = ob_get_contents();
            ob_end_clean();
            return $testimonial;
        }
        add_shortcode('noo_farmer_slider','noo_shortcode_farmer_slider');
    }