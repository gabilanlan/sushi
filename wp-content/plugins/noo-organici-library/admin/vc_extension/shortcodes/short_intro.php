<?php

    if( !function_exists('noo_shortcode_short_intro') ){
      function noo_shortcode_short_intro($atts){
            extract(shortcode_atts(array(
                'attach'    =>  '',
                'title'     =>  '',
                'price'     =>  ''
            ),$atts));
          ob_start();
        ?>
        <div class="noo-short-intro">
            <h4><?php echo esc_html($attach); ?></h4>
            <h2><?php echo esc_html($title); ?></h2>
            <div class="price">
                <span><?php echo esc_html__('- Only -','noo'); ?></span>
                <?php echo esc_html($price); ?>
            </div>
        </div>
        <?php

          $intro = ob_get_contents();
          ob_end_clean();
          return $intro;
      }
      add_shortcode('noo_shortintro','noo_shortcode_short_intro');
    }