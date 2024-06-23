<?php
/**
 * Plugin Name: SaaSPress
 * Plugin URI: https://tabs101.com
 * Description: A multi-tenant WordPress plugin for SaaS applications.
 * Version: 1.0.0
 * Author: Angel Cee
 * Author URI: https://tabs101.com
 * License: GPL2
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Include necessary files
require_once plugin_dir_path(__FILE__) . 'includes/class-tenant-manager.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-saaspress.php';
require_once plugin_dir_path(__FILE__) . 'admin/class-saaspress-settings.php';

function saaspress_init() {
    $tenant_manager = new TenantManager();
    $saaspress = new SaasPress($tenant_manager);

    // Initialize tenant environment on user login
    add_action('wp_login', function($user_login, $user) use ($tenant_manager) {
        $tenant_manager->switch_to_tenant($user->ID);
    }, 10, 2);

    // Switch to default environment on user logout
    add_action('wp_logout', function() use ($tenant_manager) {
        $tenant_manager->switch_to_default();
    });

    // Create tenant environment on user registration
    add_action('user_register', function($user_id) use ($tenant_manager) {
        $tenant_manager->create_tenant($user_id);
    });
}
add_action('plugins_loaded', 'saaspress_init');

// Register settings page
add_action('admin_menu', 'saaspress_register_settings_page');
add_action('admin_init', 'saaspress_register_settings');
?>
