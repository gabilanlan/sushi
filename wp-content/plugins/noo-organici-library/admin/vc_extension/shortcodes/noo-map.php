<?php
// [Shortcode] Noo Map
// ============================
if (!function_exists('noo_shortcode_map')) {
    function noo_shortcode_map($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'latitude' => '',
            'longitude' => '',
            'icon' => '',
            'height' => '500',
            'title' => '',
            'description' => '',
            'location' => '',
            'email' => '',
            'phone' => '',
            'website' => '',
            'mark_item' => ''
        ), $atts));

        wp_enqueue_script('google-map');
        wp_enqueue_script('google-map-custom');

        if ($icon == '') {
            $image = NOO_ASSETS_URI . '/images/marker-icon.png';
        } else {
            $image = wp_get_attachment_thumb_url($icon);
        }

        $latlonmulti = '';
        if (isset($mark_item) && !empty($mark_item)) {
            $latlon = array();
            $new_mark_item = vc_param_group_parse_atts($mark_item);
            foreach ($new_mark_item as $item) {
                if (isset($item['lat']) && !empty($item['lat']) && isset($item['lon']) && !empty($item['lon'])) {
                    $latlon[] = $item['desc'] . ',' . $item['lat'] . ',' . $item['lon'];
                }
            }
            if (count($latlon) > 0) {
                $latlonmulti = implode('|', $latlon);
            }
        }
        $google_map_api_key = get_theme_mod('noo_google_map_api_key', '');
        ob_start();
        ?>
        <div class="google-map">
            <?php if (!empty($google_map_api_key)): ?>
                <div class="googleMap" data-latlonmulti="<?php echo esc_attr($latlonmulti); ?>"
                     data-icon="<?php echo esc_url($image); ?>" data-lat="<?php echo esc_attr($latitude); ?>"
                     data-lon="<?php echo esc_attr($longitude); ?>" <?php if (isset($height) && !empty($height)): ?> style="height: <?php echo esc_attr($height) . 'px'; ?>" <?php endif; ?>></div>
            <?php else: ?>
                <iframe width="100%" height="<?php echo $height; ?>" frameborder="0" scrolling="no" marginheight="0"
                        marginwidth="0"
                        src="https://maps.google.com/maps?q=<?php echo $latitude; ?>,<?php echo $longitude; ?>&hl=es;z=14&amp;output=embed"></iframe>
            <?php endif; ?>
            <div class="noo-address-info-wrap">
                <div class="noo-container">
                    <div class="address-info">
                        <h3><?php echo esc_attr($title); ?></h3>
                        <p><?php echo noo_organici_html_content_filter($description); ?></p>
                        <ul>
                            <?php if (isset($location) && !empty($location)): ?>
                                <li><i class="fa fa-map-marker"></i><span><?php echo esc_attr($location); ?></span></li>
                            <?php endif; ?>
                            <?php if (isset($email) && !empty($email)): ?>
                                <li><i class="fa fa-envelope"> </i><span><?php echo esc_attr($email); ?></span></li>
                            <?php endif; ?>
                            <?php if (isset($phone) && !empty($phone)): ?>
                                <li><i class="fa fa-phone"> </i><span><?php echo esc_attr($phone); ?></span></li>
                            <?php endif; ?>
                            <?php if (isset($website) && !empty($website)): ?>
                                <li><i class="fa fa-globe"> </i><span><a
                                            href="<?php echo esc_url($website); ?>"><?php echo esc_url($website); ?></a></span>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div> <!-- /.google-map -->

        <?php
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }
}
add_shortcode('noo_map', 'noo_shortcode_map');