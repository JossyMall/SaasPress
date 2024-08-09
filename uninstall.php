<?php
// Exit if accessed directly.
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Clean up database and options.
global $wpdb;

// Remove all tenant-specific tables.
$prefixes = $wpdb->get_col("SELECT DISTINCT tenant_prefix FROM {$wpdb->prefix}tenants WHERE tenant_prefix IS NOT NULL");

foreach ($prefixes as $prefix) {
    $tables = $wpdb->get_col("SHOW TABLES LIKE '{$prefix}%'");
    foreach ($tables as $table) {
        $wpdb->query("DROP TABLE IF EXISTS $table");
    }
}

// Remove tenant data.
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}tenants");
