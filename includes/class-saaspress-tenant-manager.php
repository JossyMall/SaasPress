<?php
class SaasPress_Tenant_Manager {
    public function create_tenant($user_id, $tables) {
        global $wpdb;

        $tenant_prefix = $this->generate_tenant_prefix();
        update_user_meta($user_id, 'saaspress_tenant_prefix', $tenant_prefix);

        $databases = get_option('saaspress_databases', []);
        $tenant_limit_per_db = get_option('saaspress_tenant_limit_per_db', 10);
        $tenant_db = $this->get_tenant_db($databases, $tenant_limit_per_db);

        update_user_meta($user_id, 'saaspress_tenant_db', $tenant_db);

        foreach ($tables as $table) {
            $new_table_name = $tenant_prefix . $table;
            $create_table_sql = "CREATE TABLE $tenant_db.$new_table_name LIKE $wpdb->prefix$table";
            $wpdb->query($create_table_sql);
        }
    }

    private function generate_tenant_prefix() {
        return substr(md5(uniqid(rand(), true)), 0, 8) . '_';
    }

    private function get_tenant_db($databases, $tenant_limit_per_db) {
        foreach ($databases as $db) {
            $tenant_count = $this->get_tenant_count_in_db($db);
            if ($tenant_count < $tenant_limit_per_db) {
                return $db;
            }
        }
        return $databases[0];
    }

    private function get_tenant_count_in_db($db) {
        global $wpdb;
        $count_query = $wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->usermeta} WHERE meta_key = 'saaspress_tenant_db' AND meta_value = %s", $db);
        return $wpdb->get_var($count_query);
    }
}

