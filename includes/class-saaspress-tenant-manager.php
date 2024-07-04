<?php
class SaasPress_Tenant_Manager {
    public function is_tenant($user_id) {
        return get_user_meta($user_id, 'is_tenant', true) === 'yes';
    }

    public function get_tenant_prefix($user_id) {
        return get_user_meta($user_id, 'tenant_prefix', true);
    }

    public function get_global_filtered_tables() {
        return get_option('saaspress_global_filters', []);
    }

    public function add_tenant($user_id, $tables) {
        if ($this->is_tenant($user_id)) {
            return;
        }

        global $wpdb;
        $tenant_prefix = 'tenant_' . wp_generate_password(8, false, false) . '_';
        update_user_meta($user_id, 'is_tenant', 'yes');
        update_user_meta($user_id, 'tenant_prefix', $tenant_prefix);

        $databases = get_option('saaspress_databases', []);
        $tenant_limit_per_db = get_option('saaspress_tenant_limit_per_db', 10);

        foreach ($databases as $database) {
            $db_info = explode(':', $database);
            $db_name = $db_info[0];
            $db_user = $db_info[1];
            $db_password = $db_info[2];
            $db_host = isset($db_info[3]) ? $db_info[3] : 'localhost';

            $tenant_count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $wpdb->users WHERE meta_key = 'tenant_db_name' AND meta_value = %s", $db_name));
            if ($tenant_count < $tenant_limit_per_db) {
                update_user_meta($user_id, 'tenant_db_name', $db_name);
                break;
            }
        }

        $tenant_db_name = get_user_meta($user_id, 'tenant_db_name', true);

        foreach ($tables as $table) {
            $wpdb->query("CREATE TABLE $tenant_db_name.$tenant_prefix$table LIKE $wpdb->prefix$table");
        }
    }
}
