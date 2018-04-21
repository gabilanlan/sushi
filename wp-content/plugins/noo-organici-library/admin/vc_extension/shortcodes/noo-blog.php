<?php

/**
 * Shortcode attributes
 * @var $style
 * @var $list_active
 * @var $description
 */

if( !function_exists('noo_shortcode_blog') ){

    function noo_shortcode_blog($atts){
        extract(shortcode_atts(array(
            'style_title'       =>  'one',
            'icon'              =>  '',
            'attach'            =>  '',
            'title'             =>  '',
            'description'       =>  '',
            'type_query'        =>  'cate',
            'categories'        =>  '',
            'tags'              =>  '',
            'include'           =>  '',
            'orderby'           =>  '',
            'posts_per_page'    =>  '',
            'columns'           =>  '2',
            'limit_excerpt'     =>   20,
            'show_loadmore'     =>  ''
        ),$atts));
        ob_start();
        wp_enqueue_script( 'vendor-carouFredSel' );
        wp_enqueue_script('vendor-isotope');
        ?>
        <?php if( $style_title == 'one' ): ?>
            <?php if( $title != '' || $description !='' ): ?>
                <div class="noo-sh-title noo-blog-title">
                    <?php if( isset($title) && !empty($title) ) ?><h2><?php echo esc_html($title);  ?></h2>
                    <?php if( isset($description) && !empty($description) ): ?><p><?php echo esc_html($description); ?></p><?php endif; ?>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="inheader-sh-title blog-sh-title2">
                <?php if(isset( $icon ) && !empty( $icon )): echo wp_get_attachment_image( esc_attr($icon),'',false,array('class'=>'icon') ); endif;?>
                <?php if( isset($title) && !empty($title) ): ?><h2><?php echo esc_html($title); ?></h2><?php endif; ?>
                <?php if( isset($attach) && !empty($attach) ): ?><h4><?php echo esc_html($attach); ?></h4><?php endif; ?>
                <?php if( isset($description) && !empty($description) ): ?><p class="ds"><?php echo esc_html($description); ?></p><?php endif; ?>
            </div>
        <?php endif; ?>
        <?php
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

        if( is_front_page() || is_home()) {
         $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : ( ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1 );
        } else {
         $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
        }

        $args = array(
            'post_type'         =>  'post',
            'orderby'           =>   $orderby,
            'order'             =>   $order,
            'posts_per_page'    =>   $posts_per_page,
            'paged'             =>   $paged,
        );

        if($type_query == 'cate'){
            $args['cat']   =  $categories ;
        }
        if($type_query == 'tag'){
            if($tags != 'all'):
                $tag_id = explode (',' , $tags);
                $args['tag__in'] = $tag_id;
            endif;
        }
        if($type_query == 'post_id'){
            $posts_var = '';
            if ( isset($include) && !empty($include) ){
                $posts_var = explode (',' , $include);
            }
            $args['post__in'] = $posts_var;
        }
        $query = new WP_Query($args);
        if( $query->have_posts() ) :
            echo '<div class="masonry noo-blog">';
                echo '<div class="noo-row masonry-container">';
            while( $query->have_posts() ) : $query->the_post();
                $format = get_post_format( get_the_ID() );
                $class_format = ' format-' . $format;
            ?>
                <div class="loadmore-item masonry-item <?php echo esc_attr($class_columns) . esc_attr($class_format); ?>">
                    <?php include(locate_template("content-masonry.php")); ?>
                </div>
            <?php endwhile;
            echo '</div>';
            
            if( 1 < $query->max_num_pages && 'yes' == $show_loadmore ): ?>
                <div class="loadmore-action">
                    <a href="#" class="btn-loadmore btn-primary" title="<?php echo esc_attr__('Load More','noo')?>"><?php echo esc_html__('Load More','noo')?></a>
                    <div class="noo-loader loadmore-loading"><span></span><span></span><span></span><span></span><span></span></div>
                </div>
                <?php  noo_organici_pagination_normal(array(),$query)?>
            <?php endif;?>
            <?php
        echo '</div> <!-- masonry -->';
        endif; wp_reset_postdata();
        ?>
        
        <?php
        $blog = ob_get_contents();
        ob_end_clean();
        return $blog;
    }
    add_shortcode('noo_blog','noo_shortcode_blog');

}