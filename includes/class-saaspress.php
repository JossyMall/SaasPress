<?php
class SaaSPress {
    public static function init() {
        // Register hooks
        add_action('admin_menu', array(__CLASS__, 'register_admin_pages'));
    }

    public static function register_admin_pages() {
        add_menu_page('SaaSPress', 'SaaSPress', 'manage_options', 'saaspress', array(__CLASS__, 'about_page'), 'dashicons-admin-multisite');
        add_submenu_page('saaspress', 'About Us', 'About Us', 'manage_options', 'saaspress-about', array(__CLASS__, 'about_page'));
        add_submenu_page('saaspress', 'Tenants', 'Tenants', 'manage_options', 'saaspress-tenants', array(__CLASS__, 'tenants_page'));
        add_submenu_page('saaspress', 'Configurations', 'Configurations', 'manage_options', 'saaspress-config', array(__CLASS__, 'config_page'));
        add_submenu_page('saaspress', 'Global Filters', 'Global Filters', 'manage_options', 'saaspress-global-filters', array(__CLASS__, 'global_filters_page'));
    }

    public static function about_page() {
        echo '<div class="wrap"><h1>About SaaSPress</h1><p>This plugin allows for a multi-tenant setup within WordPress, providing unique content and isolated environments for each user.</p></div>';
    }

    public static function tenants_page() {
        require_once plugin_dir_path(__FILE__) . '../admin/saaspress-tenants-page.php';
        saaspress_tenants_page();
    }

    public static function config_page() {
        require_once plugin_dir_path(__FILE__) . '../admin/saaspress-config-page.php';
        saaspress_config_page();
    }

    public static function global_filters_page() {
        require_once plugin_dir_path(__FILE__) . '../admin/saaspress-global-filters.php';
        saaspress_global_filters_page();
    }
}
?>
