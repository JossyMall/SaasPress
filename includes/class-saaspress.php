<?php
class SaasPress {
    public function init() {
        // Load admin functionality.
        if (is_admin()) {
            require_once SAASPRESS_PLUGIN_DIR . 'admin/class-saaspress-admin.php';
            $admin = new SaasPress_Admin();
            $admin->init();
        }
    }

    public static function activate() {
        global $wpdb;
        
        // Create tenants table.
        $table_name = $wpdb->prefix . 'tenants';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            user_id bigint(20) NOT NULL,
            tenant_prefix varchar(255) DEFAULT '' NOT NULL,
            db_exclusions text NOT NULL,
            is_tenant boolean DEFAULT 0 NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    public static function deactivate() {
        // Placeholder for potential deactivation tasks.
    }
}
