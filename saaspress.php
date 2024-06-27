<?php
/*
Plugin Name: SaaSPress
Plugin URI: http://example.com/saaspress
Description: A plugin for multi-tenant setup within WordPress.
Version: 1.0.0
Author: Angel Cee
Author URI: http://example.com
License: GPL2
*/

// Include core files
require_once plugin_dir_path(__FILE__) . 'includes/class-saaspress.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-tenant-manager.php';

// Initialize the plugin
SaaSPress::init();
?>
