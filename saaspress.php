<?php
/**
 * Plugin Name: SaaSPress
 * Description: A plugin to create a multi-tenant setup within WordPress, allowing for isolated environments per user.
 * Version: 1.0.0
 * Author: Angel Cee
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once plugin_dir_path(__FILE__) . 'includes/class-saaspress.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-saaspress-tenant-manager.php';

function saaspress_init() {
    $tenant_manager = new SaasPress_Tenant_Manager();
    $saaspress = new SaasPress($tenant_manager);
}

add_action('plugins_loaded', 'saaspress_init');
