<?php

    if( !function_exists('noo_shortcode_client') ){

        function noo_shortcode_client($atts){
            extract(shortcode_atts(array(
                'icon'          =>      '',
                'attach'        =>      '',
                'title'         =>      '',
                'description'   =>      '',
                'columns'       =>  '3',
                'clients'       =>  ''
            ),$atts));
            ob_start();
            if( empty($clients) ) return false;
            $new_clients = vc_param_group_parse_atts( $clients );
            ?>
            <div class="inheader-sh-title">
                <?php if(isset( $icon ) && !empty( $icon )): echo wp_get_attachment_image( esc_attr($icon),'',false,array('class'=>'icon') ); endif;?>
                <?php if( isset($attach) && !empty($attach) ): ?><h4><?php echo esc_html($attach); ?></h4><?php endif; ?>
                <?php if( isset($title) && !empty($title) ): ?><h2><?php echo esc_html($title); ?></h2><?php endif; ?>
                <?php if( isset($description) && !empty($description) ): ?><p class="ds"><?php echo esc_html($description); ?></p><?php endif; ?>
            </div>
            <div class="noo-clients-wrap">
                <ul class="noo-clients noo-clients-<?php echo esc_attr($columns); ?>">
                    <?php
                        if(isset($new_clients) && !empty($new_clients) && is_array($new_clients)){
                            foreach( $new_clients as $client_attr ){ ?>
                                <li>
                                    <a href="<?php if(isset($client_attr['link']) && !empty($client_attr['link'])): echo esc_url($client_attr['link']); endif; ?>" target="_blank">
                                        <?php if( isset($client_attr['image']) && !empty($client_attr['image']) ): echo wp_get_attachment_image( esc_attr($client_attr['image']),'full' ); endif; ?>
                                    </a>
                                </li>
                            <?php }
                        }
                    ?>
                </ul>
            </div>
            <?php
            $client = ob_get_contents();
            ob_end_clean();
            return $client;
        }
        add_shortcode('noo_clients','noo_shortcode_client');

    }