<?php
/* *
 * Register taxonomy and meta field in woocommerce
 * @since 0.0
 */

if( !class_exists('Noo_Boxed') ){
    class Noo_Boxed{

        public function __construct(){
            add_action('init',array($this,'noo_register_taxonomy_boxed'));
            add_action('admin_enqueue_scripts',array($this,'noo_register_admin_assets'));

            add_action('product_boxed_add_form_fields',array($this,'noo_create_meta_field'),100,2);
            add_action('product_boxed_edit_form_fields',array($this,'noo_edit_meta_field'),100,2);

            add_action( 'edited_product_boxed', array($this,'noo_save_taxonomy_custom_meta_boxed'), 10, 2 );
            add_action( 'create_product_boxed', array($this,'noo_save_taxonomy_custom_meta_boxed'), 10, 2 );

            //Display Fields for product
            add_action( 'woocommerce_product_write_panel_tabs', array($this,'noo_add_custom_admin_product_tab') );
            add_action( 'woocommerce_product_data_panels',     array( $this, 'noo_product_write_panel_box' ) );

            // Save Fields
            add_action( 'woocommerce_process_product_meta', array($this,'noo_add_custom_box_contents_fields_save') );

            //auto ajax
            add_action('wp_ajax_noo_search_ajax_products',array($this,'noo_search_ajax_products'));
        }


        /* *
         * Register js and css
         * @uses wp_register_style
         * @uses wp_register_script
         */
        public function noo_register_admin_assets(){
            wp_register_style('noo-boxed-css', NOO_PLUGIN_ASSETS_URI.'/css/noo-box.css');
            wp_register_script('noo-boxed-script', NOO_PLUGIN_ASSETS_URI.'/js/boxed.js',array(),null,true);
        }

        /* *
         * autocomplate ajax product
         */
        public function noo_search_ajax_products(){
            $title = $_POST['title'];
            $current_id = '';

            if( isset($_POST['current_id']) && !empty($_POST['current_id']) ){
                $current_id = $_POST['current_id'];
            }
            if( !isset($title) && empty($title)) exit;

            global $wpdb;
            if( $current_id != '' ):
            $sql = "SELECT id, post_title, guid FROM $wpdb->posts  WHERE post_title LIKE '%$title%' AND ID NOT IN ($current_id)  AND post_status ='publish' AND post_type = 'product' LIMIT 10";
            else:
                $sql = "SELECT id, post_title, guid FROM $wpdb->posts  WHERE post_title LIKE '%$title%' AND post_status ='publish' AND post_type = 'product' LIMIT 10";
            endif;
            $query = $wpdb->get_results( $sql, OBJECT );
            if( isset($query) && !empty($query) ):
                echo '<ul class="noo-returs-boxed">';
                foreach($query as $value):
                    ?>
                    <li  class="noo-return-item" data-id="<?php echo esc_html($value->id) ?>"><?php echo esc_html($value->post_title); ?><span>x</span></li>
                <?php
                endforeach;
                echo '</ul>';
            endif;
            exit;
        }

        /**
         * Register taxonomy with name boxed.
         * @return taxonomy boxed
         */
        public function noo_register_taxonomy_boxed(){
            $labels = array(
                'name'              =>  esc_html__('Boxes','noo'),
                'singular'          =>  esc_html__('Boxes','noo'),
                'Search_items'      =>  esc_html__('Search Boxes','noo'),
                'add_new_item'      =>  esc_html__( 'Add New Boxes', 'noo' ),
            );

            $args   = array(
                'labels'        =>  $labels,
                'hierarchical'          => true,
                'show_ui'               => true,
                'show_admin_column'     => true,
                'query_var'             => true,
            );

            register_taxonomy('product_boxed','product',$args);


        }

        /* *
         * Create meta field for taxonomy boxed
         * @return field product, image
         */
        public function noo_create_meta_field(){

            // using js an css

            wp_enqueue_media();

            wp_enqueue_style('noo-boxed-css');
            wp_enqueue_style( 'wp-color-picker' );
            wp_enqueue_script( 'wp-color-picker' );
            wp_enqueue_script('noo-boxed-script');

            ?>

            <div class="form-field term-boxed-product-wrap">
                <label><?php esc_html_e('Boxed\'s product','noo') ?></label>
                <div class="noo-form-boxed">
                    <div class="noo_autocomplete-wrap">
                        <ul class="noo_autocomplete">
                        </ul>
                        <input class="noo_auto_complete_param" type="text" placeholder="Click here and start typing..." value="" autocomplete="off">
                        <img class="box-loading" src="<?php echo esc_url(NOO_PLUGIN_ASSETS_URI.'/images/spinner.gif') ?>" alt="loading">
                    </div>
                    <div class="noo_get_auto_product"></div>
                    <input class="boxed_product_id" name="boxed_product_id" type="hidden" value="" autocomplete="off">
                    <input class="boxed_product_id_sort" name="term_meta[boxed_id_sort]" type="hidden" value="" autocomplete="off">
                </div>
                <p><?php echo esc_html__('Please enter 3 or more characters','noo'); ?></p>
            </div>
            <div class="form-field">
                <label for="term_meta-category_color"><?php esc_html_e( 'Color title', 'noo' ); ?></label>
                <input type="text"  name="term_meta[box_color]" class="term_meta-heading_box_color" id="term_meta-box_color" value="" />
            </div>
            <div class="form-field">
                <label for="term_meta-thumbnail_id"><?php esc_html_e( 'Thumbnail', 'noo' ); ?></label>
                <input type="hidden" name="term_meta[thumbnail_id]" id="term_meta-thumbnail_id" value="" />
                <input type="button" class="button" name="term_meta-thumbnail_button_upload_id" id="term_meta-thumbnail_button_upload_id" value="<?php esc_html_e( 'Upload/Add Image', 'noo' ); ?>" />
                <input type="button" class="button" name="term_meta-thumbnail_button_clear_id" id="term_meta-thumbnail_button_clear_id" value="<?php esc_html_e( 'Clear Image', 'noo' ); ?>" style="display: none;"/>
                <div class="noo-thumb-wrapper">
                    <img src="<?php echo wc_placeholder_img_src(); ?>" />
                </div>
                <p class="description"><?php esc_html_e( 'The image represent this Boxed.', 'noo' ); ?></p>
                <script>
                    jQuery(document).ready(function($) {
                        $('.term_meta-heading_box_color').wpColorPicker();
                        $('#term_meta-thumbnail_button_upload_id').on('click', function(event) {
                            event.preventDefault();
                            var noo_upload_btn   = $(this);

                            // if media frame exists, reopen
                            if(wp_media_frame) {
                                wp_media_frame.open();
                                return;
                            }

                            // create new media frame
                            // I decided to create new frame every time to control the selected images
                            var wp_media_frame = wp.media.frames.wp_media_frame = wp.media({
                                title: "<?php echo esc_html__( 'Select or Upload your Image', 'noo' ); ?>",
                                button: {
                                    text: "<?php echo esc_html__( 'Select', 'noo' ); ?>"
                                },
                                library: { type: 'image' },
                                multiple: false
                            });

                            // when open media frame, add the selected image
                            wp_media_frame.on('open',function() {
                                var selected_id = noo_upload_btn.siblings('#term_meta-thumbnail_id').val();
                                if (!selected_id)
                                    return;
                                var selection = wp_media_frame.state().get('selection');
                                var attachment = wp.media.attachment(selected_id);
                                attachment.fetch();
                                selection.add( attachment ? [ attachment ] : [] );
                            });

                            // when image selected, run callback
                            wp_media_frame.on('select', function(){
                                var attachment = wp_media_frame.state().get('selection').first().toJSON();
                                noo_upload_btn.siblings('#term_meta-thumbnail_id').val(attachment.id);

                                noo_thumb_wraper = noo_upload_btn.siblings('.noo-thumb-wrapper');
                                noo_thumb_wraper.html('');
                                noo_thumb_wraper.append('<img src="' + attachment.url + '" alt="" />');

                                noo_upload_btn.attr('value', '<?php echo esc_html__( 'Change Image', 'noo' ); ?>');
                                $('#term_meta-thumbnail_button_clear_id').css('display', 'inline-block');
                            });

                            // open media frame
                            wp_media_frame.open();
                        });

                        $('#term_meta-thumbnail_button_clear_id').on('click', function(event) {
                            var noo_clear_btn = $(this);
                            noo_clear_btn.hide();
                            $('#term_meta-thumbnail_button_upload_id').attr('value', '<?php echo esc_html__( 'Upload/Add Image', 'noo' ); ?>');
                            noo_clear_btn.siblings('#term_meta-thumbnail_id').val('');
                            noo_clear_btn.siblings('.noo-thumb-wrapper').html('');
                        });

                        $('.noo_auto_complete_param').keyup(function(){
                            var $_value = jQuery(this).val();
                            var $current_id  = jQuery('.boxed_product_id').val();
                            if( $_value.length >= 3 ){
                                jQuery('.box-loading').addClass('noo_show');
                                jQuery.ajax({
                                    url: '<?php echo esc_url(admin_url('admin-ajax.php')); ?>',
                                    type: 'post',
                                    data: ({
                                        action: 'noo_search_ajax_products',
                                        title: $_value,
                                        current_id: $current_id
                                    }),
                                    success: function(data){
                                        if(data){
                                            jQuery('.box-loading').removeClass('noo_show');
                                            jQuery('.noo_get_auto_product').html(data);

                                        }else{
                                            jQuery('.box-loading').removeClass('noo_show');
                                        }
                                    }
                                });
                            }else{
                                jQuery('.box-loading').removeClass('noo_show');
                                jQuery('.noo-returs-boxed').remove();
                            }
                        });
                        $('.noo-returs-boxed li').live('click',function(){

                            var $value = $(this).clone();

                            $('.noo_autocomplete').append($value);

                            get_all_id();

                        });

                        $('.noo_autocomplete').on('click','.noo-return-item span',function(){
                           $(this).parent().remove();
                            get_all_id();
                           
                        });
                        $('body').click(function(){
                            $('.noo-returs-boxed').remove();
                        });

                        $('.noo_autocomplete').sortable({
                            placeholder: "ui-state-highlight",
                            forcePlaceholderSize: true,
                            item: '.noo-return-item',
                            update: function(){
                                get_all_id();
                            }
                        });
                    });

                    function get_all_id(){
                        var $all_value = [];
                        jQuery('.noo_autocomplete .noo-return-item').each(function(){
                            var $id = jQuery(this).data('id');
                            $all_value.push($id);
                        });
                        jQuery('.boxed_product_id').val($all_value.toString());
                        jQuery('.boxed_product_id_sort').val($all_value.toString());
                    }
                </script>
            </div>


            <?php
        }

        /* *
         * edit meta field for taxonomy boxed
         * @param $term_id
         */
        public function noo_edit_meta_field($term){
            // using js an css

            wp_enqueue_media();
            wp_enqueue_style('noo-boxed-css');
            wp_enqueue_style( 'wp-color-picker' );
            wp_enqueue_script( 'wp-color-picker' );

            wp_enqueue_script('noo-boxed-script');

            $args = array(
                'post_type' =>  'product',
                'posts_per_page'    =>  -1,
                'tax_query'         =>  array(
                   array(
                       'taxonomy'      =>  'product_boxed',
                       'field'         =>  'slug',
                       'terms'         =>  $term->slug
                   )
                )
            );

            $new_query = new WP_Query( $args );

            $all_product	= noo_organici_get_term_meta( $term->term_id, 'boxed_id_sort', '' );
            $all_id = '';
            if( isset($all_product) && !empty($all_product)){
                $all_id = explode(',',$all_product);

            }
            ?>

            <tr class="form-field">
                <th scope="row" valign="top"><label for="boxed_product_id"><?php esc_html_e('Boxed\'s product','noo') ?></label></th>
                <td>
                    <div class="noo-form-boxed">
                        <div class="noo_autocomplete-wrap">
                            <ul class="noo_autocomplete">
                                <?php if( isset($all_id) && !empty($all_id) ): ?>
                                    <?php foreach($all_id as $id): ?>
                                        <li  class="noo-return-item" data-id="<?php echo esc_html($id); ?>"><?php echo esc_html(get_the_title($id)); ?><span>x</span></li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <?php
                                        $other_id = array();
                                        if( $new_query->have_posts() ):
                                            while( $new_query->have_posts() ):
                                                $new_query->the_post();
                                                $other_id[] = get_the_ID();
                                                ?>
                                                <li  class="noo-return-item" data-id="<?php echo esc_html(get_the_ID()); ?>"><?php echo the_title(); ?><span>x</span></li>
                                                <?php
                                            endwhile;
                                        endif; wp_reset_postdata();
                                    ?>
                                <?php endif; ?>
                            </ul>
                            <input class="noo_auto_complete_param" type="text" placeholder="Click here and start typing..." value="" autocomplete="off">
                            <img class="box-loading" src="<?php echo esc_url(NOO_PLUGIN_ASSETS_URI.'/images/spinner.gif') ?>" alt="loading">
                        </div>
                        <div class="noo_get_auto_product"></div>
                        <?php
                        $get_product_hidden = '';
                        if( !empty($all_product) ):
                            $get_product_hidden = $all_product;
                        elseif( !empty($other_id) ):
                            $get_product_hidden = implode(',',$other_id);
                        endif;
                        ?>
                        <input class="boxed_product_id" name="boxed_product_id" type="hidden" value="<?php if( !empty($get_product_hidden) ): echo esc_html($get_product_hidden);  endif; ?>" autocomplete="off">
                        <input class="boxed_product_id_sort" name="term_meta[boxed_id_sort]" type="hidden" value="<?php if( !empty($get_product_hidden) ): echo esc_html($get_product_hidden);  endif; ?>" autocomplete="off">
                    </div>
                    <p><?php echo esc_html__('Please enter 3 or more characters','noo'); ?></p>
                </td>
            </tr>
            <tr class="form-field">
                <th scope="row" valign="top"><label for="term_meta-box_color"><?php esc_html_e( 'Color title', 'noo' ); ?></label></th>
                <td>
                    <?php
                    $color_pk	= noo_organici_get_term_meta( $term->term_id, 'box_color', '' );
                    ?>
                    <input type="text"  class="term_meta-heading_box_color" name="term_meta[box_color]" id="term_meta-box_color" value="<?php echo esc_html($color_pk); ?>" />
                </td>
            </tr>
            <tr class="form-field" >
                <th scope="row" valign="top"><label for="term_meta-thumbnail_id"><?php esc_html_e( 'Thumbnail', 'noo' ); ?></label></th>
                <td>
                    <?php
                    $output		= '';
                    $btn_text	= '';
                    $image_id	= noo_organici_get_term_meta( $term->term_id, 'thumbnail_id', '' );

                    if( !empty( $image_id ) ) {
                        $output		= wp_get_attachment_thumb_url( $image_id );
                        $btn_text	= esc_html__( 'Change Image', 'noo' );
                    } else {
                        $output = wc_placeholder_img_src();
                        $btn_text	= esc_html__( 'Upload/Add Image', 'noo' );
                    }
                    ?>
                    <input type="hidden" name="term_meta[thumbnail_id]" id="term_meta-thumbnail_id" value="<?php echo esc_attr($image_id); ?>" />
                    <input type="button" class="button" name="term_meta-thumbnail_button_upload_id" id="term_meta-thumbnail_button_upload_id" value="<?php echo esc_attr($btn_text); ?>" />
                    <input type="button" class="button" name="term_meta-thumbnail_button_clear_id" id="term_meta-thumbnail_button_clear_id" value="<?php esc_html_e( 'Clear Image', 'noo' ); ?>" <?php echo ( $image_id ) ? '' : 'style="display: none;"' ?> />
                    <div class="noo-thumb-wrapper"><?php echo !empty( $output ) ? '<img src="' . $output . '" />' : ''; ?></div>
                    <p class="description"><?php esc_html_e( 'The image represent this boxed.', 'noo' ); ?></p>
                    <script>
                        jQuery(document).ready(function($) {
                            $('.term_meta-heading_box_color').wpColorPicker();
                            $('#term_meta-thumbnail_button_upload_id').on('click', function(event) {
                                event.preventDefault();
                                var noo_upload_btn   = $(this);

                                // if media frame exists, reopen
                                if(wp_media_frame) {
                                    wp_media_frame.open();
                                    return;
                                }

                                // create new media frame
                                // I decided to create new frame every time to control the selected images
                                var wp_media_frame = wp.media.frames.wp_media_frame = wp.media({
                                    title: "<?php echo esc_html__( 'Select or Upload your Image', 'noo' ); ?>",
                                    button: {
                                        text: "<?php echo esc_html__( 'Select', 'noo' ); ?>"
                                    },
                                    library: { type: 'image' },
                                    multiple: false
                                });

                                // when open media frame, add the selected image
                                wp_media_frame.on('open',function() {
                                    var selected_id = noo_upload_btn.siblings('#term_meta-thumbnail_id').val();
                                    if (!selected_id)
                                        return;
                                    var selection = wp_media_frame.state().get('selection');
                                    var attachment = wp.media.attachment(selected_id);
                                    attachment.fetch();
                                    selection.add( attachment ? [ attachment ] : [] );
                                });

                                // when image selected, run callback
                                wp_media_frame.on('select', function(){
                                    var attachment = wp_media_frame.state().get('selection').first().toJSON();
                                    noo_upload_btn.siblings('#term_meta-thumbnail_id').val(attachment.id);

                                    noo_thumb_wraper = noo_upload_btn.siblings('.noo-thumb-wrapper');
                                    noo_thumb_wraper.html('');
                                    noo_thumb_wraper.append('<img src="' + attachment.url + '" alt="" />');

                                    noo_upload_btn.attr('value', '<?php echo __( 'Change Image', 'noo' ); ?>');
                                    $('#term_meta-thumbnail_button_clear_id').css('display', 'inline-block');
                                });

                                // open media frame
                                wp_media_frame.open();
                            });

                            $('#term_meta-thumbnail_button_clear_id').on('click', function(event) {
                                var noo_clear_btn = $(this);
                                noo_clear_btn.hide();
                                $('#term_meta-thumbnail_button_upload_id').attr('value', '<?php echo esc_html__( 'Select Image', 'noo' ); ?>');
                                noo_clear_btn.siblings('#term_meta-thumbnail_id').val('');
                                noo_clear_btn.siblings('.noo-thumb-wrapper').html('');
                            });

                            $('.noo_auto_complete_param').keyup(function(){
                                var $_value = jQuery(this).val();
                                var $current_id  = jQuery('.boxed_product_id').val();

                                if( $_value.length >= 3 ){
                                    jQuery('.box-loading').addClass('noo_show');
                                    jQuery.ajax({
                                        url: '<?php echo esc_url(admin_url('admin-ajax.php')); ?>',
                                        type: 'post',
                                        data: ({
                                            action: 'noo_search_ajax_products',
                                            title: $_value,
                                            current_id: $current_id
                                        }),
                                        success: function(data){
                                            if(data){
                                                jQuery('.box-loading').removeClass('noo_show');
                                                jQuery('.noo_get_auto_product').html(data);

                                            }else{
                                                jQuery('.box-loading').removeClass('noo_show');
                                            }
                                        }
                                    });
                                }else{
                                    jQuery('.box-loading').removeClass('noo_show');
                                    jQuery('.noo-returs-boxed').remove();
                                }
                            });
                            $('.noo-returs-boxed li').live('click',function(){

                                var $value = $(this).clone();

                                $('.noo_autocomplete').append($value);

                                get_all_id();

                            });

                            $('.noo_autocomplete').on('click','.noo-return-item span',function(){
                                $(this).parent().remove();
                                get_all_id();

                            });
                            $('body').click(function(){
                                $('.noo-returs-boxed').remove();
                            });

                            $('.noo_autocomplete').sortable({
                                placeholder: "ui-state-highlight",
                                forcePlaceholderSize: true,
                                item: '.noo-return-item',
                                update: function(){
                                    get_all_id();
                                }
                            });
                        });
                        function get_all_id(){
                            var $all_value = [];
                            jQuery('.noo_autocomplete .noo-return-item').each(function(){
                                var $id = jQuery(this).data('id');
                                $all_value.push($id);
                            });
                            jQuery('.boxed_product_id').val($all_value.toString());
                            jQuery('.boxed_product_id_sort').val($all_value.toString());
                        }
                    </script>
                </td>
            </tr>
        <?php
        }


        /* *
        * save meta field for taxonomy boxed
        * @param $term_id
        */
        public function noo_save_taxonomy_custom_meta_boxed( $term_id ) {


            if ( isset( $_POST['term_meta'] ) ) {
                $t_id = $term_id;
                $term_meta = get_option( "taxonomy_{$t_id}" );
                $cat_keys = array_keys( $_POST['term_meta'] );
                foreach ( $cat_keys as $key ) {
                    if ( isset ( $_POST['term_meta'][$key] ) ) {
                        $term_meta[$key] = $_POST['term_meta'][$key];
                    }
                }

                // Save the option array.
                update_option( "taxonomy_{$t_id}", $term_meta );
            }

            if ( isset( $_POST['boxed_product_id'] ) && !empty( $_POST['boxed_product_id'] ) ) {
                $new_products2 = $_POST['boxed_product_id'];

                $new_products = explode(',',$new_products2);

                if (!defined('DOING_AJAX') || !DOING_AJAX) {
                    // Not in AJAX --> editing not creating

                    if( $term_id ) {
                        global $wpdb;
                        // Get all current products in boxed
                        $current_products = (array) $wpdb->get_col( $wpdb->prepare( "
							SELECT $wpdb->posts.ID
							FROM $wpdb->term_relationships, $wpdb->posts
							WHERE $wpdb->posts.ID = $wpdb->term_relationships.object_id AND post_status = 'publish' AND post_type = 'product' AND term_taxonomy_id = %d", $term_id ) );

                        foreach ($current_products as $product_ID) {
                            $key = array_search( $product_ID, $new_products );
                            if( $key === false ) {
                                wp_remove_object_terms( $product_ID, $term_id, 'product_boxed');
                            } else {
                                unset($new_products[$key]);
                            }
                        }
                    }
                }

                foreach ($new_products as $product_ID) {
                    wp_set_object_terms( $product_ID, $term_id, 'product_boxed' );
                }
            }
        }

        /* *
         * Register new tab boxed content for product
         */
        public function noo_add_custom_admin_product_tab() {
        ?>
            <li class="noo_box_contents"><a href="#noo_box_contents"><?php esc_html_e('Box Contens', 'noo'); ?></a></li>

        <?php
        }

        /* *
         * Create field for product
         */
        function noo_product_write_panel_box(){

            wp_enqueue_style('noo-boxed-css');
            wp_enqueue_script('noo-boxed-script');
            global $post;
            $post_id = $post->ID;
            $box_contents  = get_post_meta($post_id,'noo_box_contents',true);

            ?>
            <div id="noo_box_contents" class="panel woocommerce_options_panel">
                <?php
                    woocommerce_wp_text_input(
                      array(
                          'id'           =>  '_noo_box_title',
                          'label'        =>  esc_html__('Box title','noo'),
                          'placeholder'  =>  esc_html__('Box small','noo')
                      )
                    );
                ?>
                <div class="box_contents_wrap">
                    <?php if( isset($box_contents) && !empty($box_contents) ): ?>
                        <?php foreach($box_contents as $content):
                                $thumb_url  = wc_placeholder_img_src();
                                $thumb_id   = '';
                                $title_item = '';
                                $value_item = '';
                                if( isset( $content['noo_thumbnail_id'] ) && $content['noo_thumbnail_id'] !='' ){
                                    $thumb_url = wp_get_attachment_thumb_url($content['noo_thumbnail_id']);
                                    $thumb_id  = $content['noo_thumbnail_id'];
                                }
                                if( isset( $content['noo_box_title_item'] ) && $content['noo_box_title_item'] !='' ){
                                    $title_item = $content['noo_box_title_item'];
                                }
                                if( isset( $content['noo_box_value'] ) && $content['noo_box_value'] !='' ){
                                    $value_item = $content['noo_box_value'];
                                }
                            ?>
                            <div class="noo_box_attribute noo_closed">
                                <h3 class="noo_sort">
                                    <span class="noo_remove_row noo_delete"><?php echo esc_html__('Remove','noo'); ?></span>
                                    <span class="noo_handlediv noo_handlediv_closed" title="Click to toggle"></span>
                                    <span class="noo_attribute_name"><?php echo esc_html($title_item); ?></span>
                                </h3>
                                <div class="noo_box_attribute_item">
                                    <table cellpadding="0" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td class="noobox-image">
                                                    <div class="box-admin-set-image">
                                                        <img alt="<?php echo esc_html__('set image box item') ?>" title="<?php echo esc_html__('set image box item') ?>" data-url="<?php echo wc_placeholder_img_src(); ?>" class="box-admin-img" src="<?php echo esc_url($thumb_url); ?>" />
                                                        <a href="#" class="noo-set-image <?php if( !empty($thumb_id) ): echo 'noo_am_hide';  endif;?>"><?php echo esc_html__('Set image','noo') ?></a>
                                                    </div>
                                                    <a href="#" class="noo-remove-image <?php if( !empty($thumb_id) ): echo 'noo_am_show';  endif;?>"><?php echo esc_html__('Remove image','noo') ?></a>
                                                    <input type="hidden" name="noobox_item_thumbnail_id[]" class="noobox_item_thumbnail_id" value="<?php echo esc_html($thumb_id); ?>" />
                                                </td>
                                                <td class="noobox-title">
                                                    <label><?php echo esc_html__('Title ','noo') ?></label>
                                                    <input title="text" class="noo_box_title_item" name="noo_box_title_item[]" value="<?php echo esc_html($title_item); ?>" placeholder="<?php echo esc_html__('Title','noo'); ?>">
                                                </td>
                                                <td class="noobox-value">
                                                    <label><?php echo esc_html__('Value:','noo'); ?></label>
                                                    <input title="text" name="noo_box_value[]" value="<?php echo esc_html($value_item); ?>" placeholder="<?php echo esc_html__('value','noo'); ?>">
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div><!--End .noo_box_attribute-->
                        <?php endforeach; ?>
                    <?php else: ?>

                        <div class="noo_box_attribute noo_closed">
                            <h3 class="sort">
                                <span class="noo_remove_row noo_delete"><?php echo esc_html__('Remove','noo'); ?></span>
                                <span class="noo_handlediv noo_handlediv_closed" title="Click to toggle"></span>
                                <span class="noo_attribute_name"></span>
                            </h3>
                            <div class="noo_box_attribute_item">
                                <table cellpadding="0" cellspacing="0">
                                    <tbody>
                                    <tr>
                                        <td class="noobox-image">
                                            <div class="box-admin-set-image">
                                                <img alt="<?php echo esc_html__('set image box item') ?>" title="<?php echo esc_html__('set image box item') ?>" data-url="<?php echo wc_placeholder_img_src(); ?>" class="box-admin-img" src="<?php echo wc_placeholder_img_src(); ?>" />
                                                <a href="#" class="noo-set-image"><?php echo esc_html__('Set image','noo') ?></a>
                                            </div>
                                            <a href="#" class="noo-remove-image"><?php echo esc_html__('Remove image','noo') ?></a>
                                            <input type="hidden" name="noobox_item_thumbnail_id[]" class="noobox_item_thumbnail_id" value="" />
                                        </td>
                                        <td class="noobox-title">
                                            <label><?php echo esc_html__('Title','noo') ?></label>
                                            <input  title="text" class="noo_box_title_item" name="noo_box_title_item[]" value="" placeholder="<?php echo esc_html__('Title','noo'); ?>">
                                        </td>
                                        <td class="noobox-value">
                                            <label><?php echo esc_html__('Value:','noo'); ?></label>
                                            <input title="text" name="noo_box_value[]" value="" placeholder="<?php echo esc_html__('value','noo'); ?>">
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div><!--End .noo_box_attribute-->

                     <?php endif; ?>
                </div><!--End .box_contens_wrap-->
                <p class="noo-box-action">
                    <span class="button noo_new_box_item button-primary"><?php echo esc_html__('New box item'); ?></span>
                </p>
            </div><!--end #noo_box_contens-->
            <script type="text/javascript">
                jQuery(document).ready(function() {
                    jQuery('.box_contents_wrap').on('click', '.box-admin-set-image', function(event) {
                        event.preventDefault();

                        var noo_upload_btn   = jQuery(this);
                        // if media frame exists, reopen
                        if(wp_media_frame) {
                            wp_media_frame.open();
                            return;
                        }

                        // create new media frame
                        // I decided to create new frame every time to control the selected images
                        var wp_media_frame = wp.media.frames.wp_media_frame = wp.media({
                            title: "<?php echo esc_html__( 'Select or Upload your Image', 'noo' ); ?>",
                            button: {
                                text: "<?php echo esc_html__( 'Select', 'noo' ); ?>"
                            },
                            library: { type: 'image' },
                            multiple: false
                        });



                        // when image selected, run callback
                        wp_media_frame.on('select', function(){
                            var attachment = wp_media_frame.state().get('selection').first().toJSON();
                            noo_upload_btn.parent().find('.noobox_item_thumbnail_id').val(attachment.id);
                            noo_upload_btn.parent().find('.box-admin-img').attr('src',attachment.url);
                            noo_upload_btn.parent().find('.noo-set-image').addClass('noo_am_hide');
                            noo_upload_btn.parent().find('.noo-remove-image').addClass('noo_am_show');

                        });

                        // open media frame
                        wp_media_frame.open();
                    });

                    jQuery('.box_contents_wrap').on('click', '.noo-remove-image', function(event){
                        event.preventDefault();
                        jQuery(this).addClass('noo_am_hide');
                        var $control = jQuery(this).parent();
                        $control.find('.noobox_item_thumbnail_id').val('');
                        $control.find('.box-admin-img').attr('src','<?php echo wc_placeholder_img_src(); ?>');
                        $control.find('.noo-set-image').removeClass('noo_am_hide').addClass('noo_am_show');
                    });
                });
            </script>
        <?php
        }


        /* *
         * Save field
         * @param $post_id
         */
        function noo_add_custom_box_contents_fields_save($post_id){
            $box_title             = $_POST['_noo_box_title'];
            $noo_thumbnail_id      = isset( $_POST['noobox_item_thumbnail_id'] ) ? $_POST['noobox_item_thumbnail_id'] : array();
            $noo_box_title_item    = isset( $_POST['noo_box_title_item'] ) ? $_POST['noo_box_title_item'] : array();
            $noo_box_value         = isset( $_POST['noo_box_value'] ) ? $_POST['noo_box_value'] : array();

            if( isset( $box_title ) && !empty( $box_title ) ){
                update_post_meta( $post_id, '_noo_box_title', sanitize_text_field($box_title) );
            }
            $box_item = array();
            $count_item = count($noo_box_title_item);

            for( $i=0; $i< $count_item; $i++ ){
                if( !empty($noo_box_title_item[$i]) ):
                    $key = 'noo_box_item_'.$post_id.'_'.wp_rand(1,10000);
                    $box_item[$key]   = array(
                        'noo_thumbnail_id'    => sanitize_text_field($noo_thumbnail_id[$i]),
                        'noo_box_title_item'  => sanitize_text_field($noo_box_title_item[$i]),
                        'noo_box_value'       => sanitize_text_field($noo_box_value[$i]),
                    );
                endif;
            }
            if( isset($box_item) && !empty($box_item) ){
              //  update_post_meta( $post_id, '_visibility', 'hidden' );
            }
            update_post_meta( $post_id, 'noo_box_contents', $box_item );



        }
    }
    new Noo_Boxed();
}