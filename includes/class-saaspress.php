<?php

if (!defined('ABSPATH')) {
    exit;
}

class SaasPress {
    public static function init() {
        add_action('plugins_loaded', [__CLASS__, 'load_textdomain']);
        add_action('admin_menu', ['SaasPress_Admin', 'init']);
        add_action('wp_ajax_saaspress_make_tenant', ['SaasPress_Tenant_Manager', 'make_tenant']);
    }

    public static function load_textdomain() {
        load_plugin_textdomain('saaspress', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }

    public static function activate() {
        self::create_tables();
    }

    public static function deactivate() {
        // Clean up if necessary
    }

    public static function uninstall() {
        global $wpdb;
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}saaspress_tenants");
    }

    private static function create_tables() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        $table_name = $wpdb->prefix . 'saaspress_tenants';
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            user_id bigint(20) NOT NULL,
            user_login varchar(60) NOT NULL,
            user_email varchar(100) NOT NULL,
            database varchar(100) NOT NULL,
            table_prefix varchar(100) NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}
