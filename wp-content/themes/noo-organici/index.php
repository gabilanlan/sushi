<?php
/**
 * The main template file
 *
 */

get_header();

?>

<div id="primary" class="content-area">
    <main id="main" class="site-main noo-container">
        <div class="noo-row">
            <div class="<?php noo_organici_main_class(); ?>">
                <?php if ( have_posts() ) : ?>

                    <?php
                    $is_masonry = is_home() ? ( 'masonry' == get_theme_mod( 'noo_blog_style', 'list') ) : false;
                    if( $is_masonry ) : 
                        wp_enqueue_script( 'vendor-carouFredSel' );
                        wp_enqueue_script('vendor-isotope');

                        $columns = get_theme_mod( 'noo_blog_masonry_column', 3 );
                        $class_columns = 'noo-md-4 noo-sm-6';
                        if( $columns == 4 ){
                            $class_columns = 'noo-md-3 noo-sm-6';
                        }elseif( $columns == 2 ){
                            $class_columns = 'noo-md-6 noo-sm-6';
                        }
                    ?>
                        <div class="masonry noo-blog">
                            <div class="noo-row masonry-container">
                                <?php
                                // Start the loop.
                                while ( have_posts() ) : the_post();
                                    $format = get_post_format( get_the_ID() );
                                    $class_format = ' format-' . $format; ?>

                                    <div class="loadmore-item masonry-item <?php echo esc_attr($class_columns) . esc_attr($class_format); ?>">
                                        <?php 
                                        /*
                                         * Include the Masonry template for the content.
                                         */
                                        get_template_part( 'content', 'masonry' );
                                        ?>

                                    </div>
                                <?php endwhile; ?>
                            </div>

                            <?php global $wp_query;
                            if( 1 < $wp_query->max_num_pages ) : ?>
                                <div class="loadmore-action">
                                    <a href="#" class="btn-loadmore btn-primary" title="<?php _e('Load More','noo-organici')?>"><?php _e('Load More','noo-organici')?></a>
                                    <div class="noo-loader loadmore-loading"><span></span><span></span><span></span><span></span><span></span></div>
                                </div>
                                <?php noo_organici_pagination_normal()?>
                            <?php endif;?>

                        </div>

                    <?php else : ?>
                        <?php
                        // Start the loop.
                        while ( have_posts() ) : the_post();
                            /*
                             * Include the Post-Format-specific template for the content.
                             * If you want to override this in a child theme, then include a file
                             * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                             */
                            get_template_part( 'content', get_post_format() );

                            // End the loop.
                        endwhile;

                        noo_organici_pagination_normal();

                    endif;

                // If no content, include the "No posts found" template.
                else :
                    get_template_part( 'content', 'none' );
                endif;
                ?>
            </div>
            <?php get_sidebar(); ?>
        </div>


    </main><!-- .site-main -->
</div><!-- .content-area -->

<?php get_footer(); ?>
