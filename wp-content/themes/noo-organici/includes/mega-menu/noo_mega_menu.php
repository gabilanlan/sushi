<?php

/*
 * Noo Mega Menu
 */

class Noo_Organici_Mega_Menu
{

    function __construct()
    {

        //	add menu fields
        add_action('wp_nav_menu_item_custom_fields', array($this, 'custom_fields'), 5, 4);

        // -- Load enqueue script Noo Mega Menu
        add_action('admin_enqueue_scripts', array($this, 'noo_mega_menu_enqueue_script_admin'));
        add_action('wp_enqueue_scripts', array($this, 'noo_mega_menu_enqueue_script'));

        // -- Edit menu walker
        add_filter('wp_edit_nav_menu_walker', array($this, 'noo_mega_menu_edit_walker'), 10, 2);

        // -- Setup nav menu item custom fields
        add_filter('wp_setup_nav_menu_item', array($this, 'noo_mega_menu_set_item'));

        // -- Save info custom fields nav menu item
        add_action('wp_update_nav_menu_item', array($this, 'noo_mega_menu_save_fields'), 10, 3);

    }

    /**
     * Edit walker detail
     * @access public
     * @since  1.0
     * @name noo_mega_menu_edit_walker
     */
    public function noo_mega_menu_edit_walker($walker, $menu_id)
    {

        return 'Noo_Organici_Walker_Edit';

    }

    /**
     * custom fields for mega menu
     */
    public function custom_fields($item_id, $item, $depth, $args)
    {
        ?>
        <div class="noo-mega-menu-icon">
        <label
            for="edit-menu-item-megamenu_icon-<?php echo esc_attr($item_id); ?>"><?php esc_html_e('Icon', 'noo-organici'); ?></label>
        <div class="noo-icon">
        <span class="icon">
	            			<i class="fa fa-cogs"></i>
	            		</span>
	            		<span class="select_icon" data-id="<?php echo esc_attr($item_id); ?>">
	            			<i class="fa fa-arrow-down"></i>
	            		</span>
	            		<span class="select_color" data-id="<?php echo esc_attr($item_id); ?>">
	            			<i class="fa fa-magic"></i>
	            		</span>
	            		<span
                            class="<?php echo empty($item->megamenu_icon) ? 'hide ' : ''; ?>display icon-<?php echo esc_attr($item_id); ?>"
                            style="color: <?php echo esc_attr($item->megamenu_icon_color); ?>;<?php echo empty($item->megamenu_icon_size) ? 'font-size: 13px' : "font-size: {$item->megamenu_icon_size}px"; ?>">
	            			<i class="fa <?php echo esc_attr($item->megamenu_icon); ?>"></i>
	            		</span>
        <div class="mega-entry list-entry-<?php echo esc_attr($item_id); ?>"
             data-id="<?php echo esc_attr($item_id); ?>">
	            			<span class="megamenu-search">
	            				<input type="text" class="box-search search-<?php echo esc_attr($item_id); ?>"
                                       placeholder="<?php esc_html_e('Ex: balance-scale', 'noo-organici'); ?>"/>
	            				<i class="fa-search fip-fa fa"></i>
	            			</span>
            <p class="mega-list-icon list-entry-<?php echo esc_attr($item_id); ?>"></p>
        </div>
        <div class="mega-entry box-set color-<?php echo esc_attr($item_id); ?>">

            <div class="size">
                <label
                    for="edit-menu-item-megamenu_icon_size-<?php echo esc_attr($item_id); ?>"><?php esc_html_e('Size', 'noo-organici'); ?></label>
                <input type="number" id="edit-menu-item-megamenu_icon_size-<?php echo esc_attr($item_id); ?>"
                       name="menu-item-megamenu_icon_size[<?php echo esc_attr($item_id); ?>]"
                       value="<?php echo empty($item->megamenu_icon_size) ? '13' : $item->megamenu_icon_size; ?>">
            </div>

            <input type="text" data-id="<?php echo esc_attr($item_id); ?>"
                   id="edit-menu-item-megamenu_icon_color-<?php echo esc_attr($item_id); ?>"
                   name="menu-item-megamenu_icon_color[<?php echo esc_attr($item_id); ?>]"
                   value="<?php echo esc_attr($item->megamenu_icon_color); ?>"
                   class="color-picker-<?php echo esc_attr($item_id); ?>"/>

            <div>
                <label
                    for="edit-menu-item-megamenu_icon_alignment-<?php echo esc_attr($item_id); ?>"><?php esc_html_e('Icon Alignment', 'noo-organici'); ?></label>
                <select class="select_alignment"
                        id="edit-menu-item-megamenu_icon_alignment-<?php echo esc_attr($item_id); ?>"
                        name="menu-item-megamenu_icon_alignment[<?php echo esc_attr($item_id); ?>]">
                    <option
                        value="left"<?php selected($item->megamenu_icon_alignment, 'left'); ?>><?php esc_html_e('Left', 'noo-organici'); ?></option>
                    <option
                        value="right"<?php selected($item->megamenu_icon_alignment, 'right'); ?>><?php esc_html_e('Right', 'noo-organici'); ?></option>
                    <option
                        value="center"<?php selected($item->megamenu_icon_alignment, 'center'); ?>><?php esc_html_e('Center', 'noo-organici'); ?></option>
                </select>
                <div>

                </div>
                <input type="hidden" id="edit-menu-item-megamenu_icon-<?php echo esc_attr($item_id); ?>"
                       data-icon="<?php echo esc_attr($item->megamenu_icon); ?>"
                       value="<?php echo esc_attr($item->megamenu_icon); ?>"
                       name="menu-item-megamenu_icon[<?php echo esc_attr($item_id); ?>]"/>
            </div>
        </div>
        <p class="megamenu-status description description-wide" style="margin-top: 10px;">
            <label for="edit-menu-item-megamenu-<?php echo esc_attr($item_id); ?>">
                <input class="enable_megamenu" data-id="<?php echo esc_attr($item_id); ?>" type="checkbox"
                       id="edit-menu-item-megamenu-<?php echo esc_attr($item_id); ?>" value="megamenu"
                       name="menu-item-megamenu[<?php echo esc_attr($item_id); ?>]"<?php checked($item->megamenu, 'megamenu'); ?> />
                <?php esc_html_e('Enable megamenu', 'noo-organici'); ?>
            </label>
        </p>

        <script type="text/javascript">
            jQuery(document).ready(function ($) {

                if ($('input[name="menu-item-megamenu[<?php echo esc_attr($item_id); ?>]"]:checked').serialize() != '') {
                    $('.enable_megamenu_child-<?php echo esc_attr($item_id); ?>').show();
                } else {
                    $('.enable_megamenu_child-<?php echo esc_attr($item_id); ?>').hide();
                }

            });
        </script>

        <p class="megamenu_columns description description-wide megamenu-child-options enable_megamenu_child-<?php echo esc_attr($item_id); ?>">
            <label for="menu-item-megamenu_columns-<?php echo esc_attr($item->ID); ?>">
                <?php esc_html_e('Megamenu columns', 'noo-organici'); ?>
                <br/>
                <select id="menu-item-megamenu_columns-<?php echo esc_attr($item->ID); ?>"
                        name="menu-item-megamenu_columns[<?php echo esc_attr($item->ID); ?>]"
                        class="widefat code edit-menu-item-custom">
                    <option <?php selected($item->megamenu_col, 'columns-2') ?>
                        value="columns-2"><?php esc_html_e('Two', 'noo-organici') ?></option>
                    <option <?php selected($item->megamenu_col, 'columns-3') ?>
                        value="columns-3"><?php esc_html_e('Three', 'noo-organici') ?></option>
                    <option <?php selected($item->megamenu_col, 'columns-4') ?>
                        value="columns-4"><?php esc_html_e('Four', 'noo-organici') ?></option>
                    <option <?php selected($item->megamenu_col, 'columns-5') ?>
                        value="columns-5"><?php esc_html_e('Five', 'noo-organici') ?></option>
                    <option <?php selected($item->megamenu_col, 'columns-6') ?>
                        value="columns-6"><?php esc_html_e('Six', 'noo-organici') ?></option>
                </select>
            </label>
        </p>

        <p class="noo-mega-menu-heading description description-wide enable_megamenu_child-<?php echo esc_attr($item_id); ?>">
            <label for="edit-menu-item-megamenu_heading-<?php echo esc_attr($item_id); ?>">
                <input type="checkbox" id="edit-menu-item-megamenu_heading-<?php echo esc_attr($item_id); ?>"
                       value="megamenu_heading"
                       name="menu-item-megamenu_heading[<?php echo esc_attr($item_id); ?>]"<?php checked($item->megamenu_heading, 'megamenu_heading'); ?> />
                <?php esc_html_e('Hide Mega menu heading?', 'noo-organici'); ?>
            </label>
        </p>

        <p class="noo-mega-menu-widgetarea description description-wide enable_megamenu_child-<?php echo esc_attr($item_id); ?>">
            <label for="edit-menu-item-megamenu_widgetarea-<?php echo esc_attr($item_id); ?>">
                <?php esc_html_e('Mega Menu Widget Area', 'noo-organici'); ?>
                <select id="edit-menu-item-megamenu_widgetarea-<?php echo esc_attr($item_id); ?>"
                        class="widefat code edit-menu-item-custom"
                        name="menu-item-megamenu_widgetarea[<?php echo esc_attr($item_id); ?>]">
                    <option value="0"><?php esc_html_e('Select Widget Area', 'noo-organici'); ?></option>
                    <?php
                    global $wp_registered_sidebars;
                    if (!empty($wp_registered_sidebars) && is_array($wp_registered_sidebars)):
                        foreach ($wp_registered_sidebars as $sidebar):
                            ?>
                            <option
                                value="<?php echo esc_attr($sidebar['id']); ?>" <?php selected($item->megamenu_widgetarea, $sidebar['id']); ?>><?php echo esc_html($sidebar['name']); ?></option>
                        <?php endforeach; endif; ?>
                </select>
            </label>
        </p>
        <?php
    }

    /**
     * Enqueue script for Noo Mega Menu
     * @access public
     * @since  1.0
     * @name noo_mega_menu_enqueue_script
     */
    public function noo_mega_menu_enqueue_script_admin($hook)
    {

        if ($hook != 'nav-menus.php') {
            return;
        }

        // Enqueue style for Mega Menu admin
        wp_register_style('noo-megamenu-admin', get_template_directory_uri() . '/includes/admin_assets/css/noo-megamenu-admin.css', array(), NULL, NULL);
        wp_enqueue_style('noo-megamenu-admin');

        wp_register_script('noo-megamenu-admin-js', get_template_directory_uri() . '/includes/admin_assets/js/min/noo-megamenu-admin.min.js', array('wp-color-picker'), false, true);
        wp_enqueue_script('noo-megamenu-admin-js');

        wp_register_style('noo-megamenu-awesome', get_template_directory_uri() . '/assets/vendor/fontawesome/css/font-awesome.min.css', array(), NULL, NULL);
        wp_enqueue_style('noo-megamenu-awesome');

    }

    public function noo_mega_menu_enqueue_script()
    {

        wp_register_style('noo-megamenu', get_template_directory_uri() . '/includes/admin_assets/css/noo-megamenu.css', array(), NULL, NULL);
        wp_enqueue_style('noo-megamenu');


        wp_register_script('noo-megamenu-js', get_template_directory_uri() . '/includes/admin_assets/js/min/noo-megamenu.min.js');
        wp_enqueue_script('noo-megamenu-js');

    }

    /**
     * Update custom fields columns
     * @access    public
     * @since    1.0
     */
    public function noo_mega_menu_save_fields($menu_id, $menu_item_db_id, $args)
    {
        // print_r($_REQUEST); die;
        // -- Process Enable megamenu
        if (isset($_REQUEST['menu-item-megamenu'][$menu_item_db_id]) && $_REQUEST['menu-item-megamenu'][$menu_item_db_id] !== ''):

            $megamenu_value = $_REQUEST['menu-item-megamenu'][$menu_item_db_id];
            update_post_meta($menu_item_db_id, '_menu_item_megamenu', $megamenu_value);

        else :

            delete_post_meta($menu_item_db_id, '_menu_item_megamenu');

        endif;

        // -- Process megamenu columns
        if (isset($_REQUEST['menu-item-megamenu_columns']) && is_array($_REQUEST['menu-item-megamenu_columns'])) :

            $megamenu_col_value = $_REQUEST['menu-item-megamenu_columns'][$menu_item_db_id];
            update_post_meta($menu_item_db_id, '_menu_item_megamenu_col', $megamenu_col_value);

        else :

            delete_post_meta($menu_item_db_id, '_menu_item_megamenu_col');

        endif;

        // -- Process Hide Mega menu heading
        if (isset($_REQUEST['menu-item-megamenu_heading']) && is_array($_REQUEST['menu-item-megamenu_heading'])) :

            $megamenu_heading_value = @$_REQUEST['menu-item-megamenu_heading'][$menu_item_db_id];
            update_post_meta($menu_item_db_id, '_menu_item_megamenu_heading', $megamenu_heading_value);

        else :

            delete_post_meta($menu_item_db_id, '_menu_item_megamenu_heading');

        endif;

        // -- Process Hide Mega menu icon
        if (isset($_REQUEST['menu-item-megamenu_icon']) && is_array($_REQUEST['menu-item-megamenu_icon'])) :

            $megamenu_icon_value = @$_REQUEST['menu-item-megamenu_icon'][$menu_item_db_id];
            update_post_meta($menu_item_db_id, '_menu_item_megamenu_icon', $megamenu_icon_value);

        else :

            delete_post_meta($menu_item_db_id, '_menu_item_megamenu_icon');

        endif;

        // -- Process Hide Mega menu icon color
        if (isset($_REQUEST['menu-item-megamenu_icon_color']) && is_array($_REQUEST['menu-item-megamenu_icon_color'])) :

            $megamenu_icon_color_value = @$_REQUEST['menu-item-megamenu_icon_color'][$menu_item_db_id];
            update_post_meta($menu_item_db_id, '_menu_item_megamenu_icon_color', $megamenu_icon_color_value);

        else :

            delete_post_meta($menu_item_db_id, '_menu_item_megamenu_icon_color');

        endif;

        // -- Process Hide Mega menu icon size
        if (isset($_REQUEST['menu-item-megamenu_icon_size']) && is_array($_REQUEST['menu-item-megamenu_icon_size'])) :

            $megamenu_icon_size_value = @$_REQUEST['menu-item-megamenu_icon_size'][$menu_item_db_id];
            update_post_meta($menu_item_db_id, '_menu_item_megamenu_icon_size', $megamenu_icon_size_value);

        else :

            delete_post_meta($menu_item_db_id, '_menu_item_megamenu_icon_color');

        endif;

        // -- Process Hide Mega menu icon alignment
        if (isset($_REQUEST['menu-item-megamenu_icon_alignment']) && is_array($_REQUEST['menu-item-megamenu_icon_alignment'])) :

            $megamenu_icon_alignment_value = @$_REQUEST['menu-item-megamenu_icon_alignment'][$menu_item_db_id];
            update_post_meta($menu_item_db_id, '_menu_item_megamenu_icon_alignment', $megamenu_icon_alignment_value);

        else :

            delete_post_meta($menu_item_db_id, '_menu_item_megamenu_icon_alignment');

        endif;

        // -- Process Mega Menu Widget Area
        if (isset($_REQUEST['menu-item-megamenu_widgetarea']) && is_array($_REQUEST['menu-item-megamenu_widgetarea'])) :

            $megamenu_widgetarea_value = $_REQUEST['menu-item-megamenu_widgetarea'][$menu_item_db_id];
            update_post_meta($menu_item_db_id, '_menu_item_megamenu_widgetarea', $megamenu_widgetarea_value);

        else :

            delete_post_meta($menu_item_db_id, '_menu_item_megamenu_widgetarea');

        endif;

    }

    /**
     * Add custom fields to $item nav object
     * in order to be used in custom Walker
     *
     * @access      public
     * @since       1.0
     */
    public function noo_mega_menu_set_item($menu_item)
    {
        // -- set item mega menu
        $menu_item->megamenu = get_post_meta($menu_item->ID, '_menu_item_megamenu', true);

        // -- set item columns
        $menu_item->megamenu_col = get_post_meta($menu_item->ID, '_menu_item_megamenu_col', true);

        // -- set item hedding
        $menu_item->megamenu_heading = get_post_meta($menu_item->ID, '_menu_item_megamenu_heading', true);

        // -- set item icon
        $menu_item->megamenu_icon = get_post_meta($menu_item->ID, '_menu_item_megamenu_icon', true);

        // -- set item icon color
        $menu_item->megamenu_icon_color = get_post_meta($menu_item->ID, '_menu_item_megamenu_icon_color', true);

        // -- set item icon size
        $menu_item->megamenu_icon_size = get_post_meta($menu_item->ID, '_menu_item_megamenu_icon_size', true);

        // -- set item icon alignment
        $menu_item->megamenu_icon_alignment = get_post_meta($menu_item->ID, '_menu_item_megamenu_icon_alignment', true);


        // -- set item widget
        $menu_item->megamenu_widgetarea = get_post_meta($menu_item->ID, '_menu_item_megamenu_widgetarea', true);

        return $menu_item;

    }

}

new Noo_Organici_Mega_Menu();

function noo_organici_notice_set_menu()
{

    echo '<ul class="navbar-nav nav"><li><a href="' . esc_url(admin_url('nav-menus.php')) . '">' . esc_html__('No menu assigned!', 'noo-organici') . '</a></li></ul>';

}

get_template_part('includes/mega-menu/noo-edit-walker');
get_template_part('includes/mega-menu/noo-custom-walker');