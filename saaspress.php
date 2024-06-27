<?php
/*
Plugin Name: SaaSPress
Description: Multi-tenant WordPress plugin with deep role management and content isolation.
Version: 1.1
Author: Angel Cee
Author URI: https://tabs101.com
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Includes
require_once plugin_dir_path( __FILE__ ) . 'includes/class-tenant-manager.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-saaspress.php';

// Enqueue admin styles and scripts
function saaspress_enqueue_admin_assets() {
    wp_enqueue_style( 'saaspress-admin-styles', plugin_dir_url( __FILE__ ) . 'assets/css/admin-styles.css' );
    wp_enqueue_script( 'saaspress-admin-scripts', plugin_dir_url( __FILE__ ) . 'assets/js/admin-scripts.js', array('jquery'), null, true );
}
add_action( 'admin_enqueue_scripts', 'saaspress_enqueue_admin_assets' );

// Register admin menus and pages
require_once plugin_dir_path( __FILE__ ) . 'admin/saaspress-admin-menu.php';

// Initialize the main plugin class
$tenant_manager = new TenantManager();
$saaspress = new SaaasPress($tenant_manager);
