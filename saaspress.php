<?php
/**
 * Plugin Name: SaasPress
 * Plugin URI: https://tabs101.com/saaspress
 * Description: A SaaS plugin for WordPress with multi-tenant architecture.
 * Version: 1.0.0
 * Author: Angel Cee
 * Text Domain: saaspress
 * Domain Path: /languages
 */

if (!defined('ABSPATH')) {
    exit;
}

define('SAASPRESS_VERSION', '1.0.0');
define('SAASPRESS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('SAASPRESS_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once SAASPRESS_PLUGIN_DIR . 'includes/class-saaspress.php';

register_activation_hook(__FILE__, ['SaasPress', 'activate']);
register_deactivation_hook(__FILE__, ['SaasPress', 'deactivate']);
register_uninstall_hook(__FILE__, 'saaspress_uninstall');

function saaspress_uninstall() {
    SaasPress::uninstall();
}

SaasPress::init();
