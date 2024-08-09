<?php
/**
 * Plugin Name: SaasPress
 * Plugin URI: https://tabs101.com/saaspress
 * Description: A WordPress plugin to manage multi-tenant architecture with isolated tenant data.
 * Version: 1.0.0
 * Author: Angel Cee
 * License: GPLv2 or later
 * Text Domain: saaspress
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin directory.
define('SAASPRESS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('SAASPRESS_PLUGIN_URL', plugin_dir_url(__FILE__));

// Load necessary files.
require_once SAASPRESS_PLUGIN_DIR . 'includes/class-saaspress.php';
require_once SAASPRESS_PLUGIN_DIR . 'includes/class-saaspress-tenant-manager.php';
require_once SAASPRESS_PLUGIN_DIR . 'includes/class-saaspress-db.php';
require_once SAASPRESS_PLUGIN_DIR . 'includes/class-saaspress-utils.php';

// Initialize the plugin.
function saaspress_init() {
    $saaspress = new SaasPress();
    $saaspress->init();
}
add_action('plugins_loaded', 'saaspress_init');

// Activation and deactivation hooks.
function saaspress_activate() {
    SaasPress::activate();
}
register_activation_hook(__FILE__, 'saaspress_activate');

function saaspress_deactivate() {
    SaasPress::deactivate();
}
register_deactivation_hook(__FILE__, 'saaspress_deactivate');
