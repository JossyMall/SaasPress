<?php
class SaasPress_Utils {
    public static function generate_tenant_prefix() {
        return 'tenant_' . wp_generate_password(8, false, false) . '_';
    }

    public static function get_tenant_count_in_db($db_name) {
        global $wpdb;
        return $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $wpdb->usermeta WHERE meta_key = 'tenant_db_name' AND meta_value = %s", $db_name));
    }

    public static function get_available_database() {
        $databases = get_option('saaspress_databases', []);
        $tenant_limit_per_db = get_option('saaspress_tenant_limit_per_db', 10);

        foreach ($databases as $database) {
            $db_info = explode(':', $database);
            $db_name = $db_info[0];

            if (self::get_tenant_count_in_db($db_name) < $tenant_limit_per_db) {
                return $database;
            }
        }

        return null;
    }

    public static function connect_to_db($db_name, $db_user, $db_password, $db_host = 'localhost') {
        $connection = new wpdb($db_user, $db_password, $db_name, $db_host);

        if ($connection->db_connect(false)) {
            return $connection;
        }

        return null;
    }
}

