<?php
// [Shortcode] Noo Mailchimp
// ============================
    if( !function_exists('noo_shortcode_mailchimp') ){
        function noo_shortcode_mailchimp($atts){
            extract(shortcode_atts(array(
                'title' =>  '',
                'desc'  =>  ''
            ),$atts));
            ?>
            <div class="noo-sh-mailchimp">
                <div class="row">
                    <div class="noo-md-5 noo-xs-12">
                    <?php
                        if( isset($title) && !empty($title) ): ?><h3 class="noo-mail-title"><?php echo esc_html($title); ?></h3><?php endif;
                        if( isset($desc) && !empty($desc) ): ?><p class="noo-mail-desc"><?php echo esc_html($desc); ?></p><?php endif; ?>
                    </div>
                    <div class="noo-md-7 noo-xs-12">
                     <?php
                     if( function_exists('mc4wp_show_form') ){
                        mc4wp_show_form();
                     }
                    ?>
                    </div>
                </div>
            </div>
            <?php
        }
        add_shortcode('noo_mailchimp','noo_shortcode_mailchimp');
    }