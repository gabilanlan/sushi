<?php

        if( !function_exists('noo_shortcode_blog_list') ) {

            function noo_shortcode_blog_list($atts)
            {
                extract(shortcode_atts(array(
                    'icon' => '',
                    'attach' => '',
                    'title' => '',
                    'description' => '',
                    'type_query' => 'cate',
                    'categories' => '',
                    'tags' => '',
                    'include' => '',
                    'orderby' => '',
                    'posts_per_page' => '3',
                ), $atts));
                ob_start();
                ?>
                <div class="inheader-sh-title">
                    <?php if (isset($icon) && !empty($icon)): echo wp_get_attachment_image(esc_attr($icon), '', false, array('class' => 'icon')); endif;?>
                    <?php if (isset($attach) && !empty($attach)): ?>
                        <h4><?php echo esc_html($attach); ?></h4><?php endif; ?>
                    <?php if (isset($title) && !empty($title)): ?>
                        <h2><?php echo esc_html($title); ?></h2><?php endif; ?>
                    <?php if (isset($description) && !empty($description)): ?><p
                        class="ds"><?php echo esc_html($description); ?></p><?php endif; ?>
                </div>
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
                    'post_type' => 'post',
                    'orderby' => $orderby,
                    'order' => $order,
                    'posts_per_page' => $posts_per_page
                );

                if ($type_query == 'cate') {
                    $args['cat'] = $categories;
                }
                if ($type_query == 'tag') {
                    if ($tags != 'all'):
                        $tag_id = explode(',', $tags);
                        $args['tag__in'] = $tag_id;
                    endif;
                }
                if ($type_query == 'post_id') {
                    $posts_var = '';
                    if (isset($include) && !empty($include)) {
                        $posts_var = explode(',', $include);
                    }
                    $args['post__in'] = $posts_var;
                }
                $query = new WP_Query($args);
                if( $query->have_posts() ):
                    echo '<ul class="noo-blog-list">';
                        while( $query->have_posts() ):
                            $query->the_post(); ?>
                            <li>
                                <span class="cat"> <?php echo get_the_category_list('/') ?></span>
                                <h3><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
                                <span class="meta">
                                    <?php echo get_the_date(); ?>
                                     <?php echo esc_html__('By','noo') ?>
                                    <a href="<?php esc_url( get_author_posts_url( get_the_author_meta('ID') ) ) ?>"><?php echo get_the_author(); ?></a>
                                </span>
                            </li>
                        <?php endwhile;
                    echo '</ul>';
                endif; wp_reset_postdata();
                $blog_list = ob_get_contents();
                ob_end_clean();
                return $blog_list;
            }
            add_shortcode('noo_blog_list','noo_shortcode_blog_list');
        }