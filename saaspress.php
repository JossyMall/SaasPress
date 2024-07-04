<?php
/**
 * Plugin Name: SaasPress
 * Description: A multi-tenant management plugin for WordPress.
 * Version: 0.1.0
 * Author: Angel Cee
 * Text Domain: saaspress
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Includes
require_once plugin_dir_path( __FILE__ ) . 'includes/class-saaspress.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-saaspress-tenant-manager.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-saaspress-db.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-saaspress-utils.php';

// Activation and deactivation hooks
register_activation_hook( __FILE__, 'saaspress_activate' );
register_deactivation_hook( __FILE__, 'saaspress_deactivate' );

function saaspress_activate() {
    // Activation code here
}

function saaspress_deactivate() {
    // Deactivation code here
}

// Initialize the plugin
add_action( 'plugins_loaded', 'saaspress_init' );

function saaspress_init() {
    $tenant_manager = new SaasPress_Tenant_Manager();
    $saaspress = new SaasPress( $tenant_manager );

    if ( is_admin() ) {
        require_once plugin_dir_path( __FILE__ ) . 'admin/class-saaspress-admin.php';
        $admin = new SaasPress_Admin();
    }
}
