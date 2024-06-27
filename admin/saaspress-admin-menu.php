<?php
function saaspress_register_admin_pages() {
    add_menu_page('SaaSPress', 'SaaSPress', 'manage_options', 'saaspress', 'saaspress_about_page', 'dashicons-admin-multisite');
    add_submenu_page('saaspress', 'About Us', 'About Us', 'manage_options', 'saaspress-about', 'saaspress_about_page');
    add_submenu_page('saaspress', 'Tenants', 'Tenants', 'manage_options', 'saaspress-tenants', 'saaspress_tenants_page');
    add_submenu_page('saaspress', 'Configurations', 'Configurations', 'manage_options', 'saaspress-config', 'saaspress_config_page');
    add_submenu_page('saaspress', 'Global Filters', 'Global Filters', 'manage_options', 'saaspress-global-filters', 'saaspress_global_filters_page');
}
add_action('admin_menu', 'saaspress_register_admin_pages');

function saaspress_about_page() {
    echo '<div class="wrap"><h1>About SaaSPress</h1><p>This plugin allows for a multi-tenant setup within WordPress, providing unique content and isolated environments for each user.</p></div>';
}

require_once plugin_dir_path( __FILE__ ) . 'saaspress-tenants-page.php';
require_once plugin_dir_path( __FILE__ ) . 'saaspress-config-page.php';
require_once plugin_dir_path( __FILE__ ) . 'saaspress-global-filters.php';
