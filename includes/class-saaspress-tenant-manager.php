<?php

if (!defined('ABSPATH')) {
    exit;
}

class SaasPress_Tenant_Manager {
    private $wpdb;
    private $default_db;

    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->default_db = DB_NAME;

        add_action('user_register', [$this, 'make_new_user_tenant']);
    }

    public function make_user_tenant($user_id) {
        $prefix = $this->generate_unique_prefix();
        $tenant_data = [
            'user_id' => $user_id,
            'prefix' => $prefix,
            'database' => $this->assign_database()
        ];

        $this->create_tenant_tables($tenant_data);
        $this->save_tenant_data($tenant_data);
    }

    private function generate_unique_prefix() {
        do {
            $prefix = 'tenant_' . wp_generate_password(8, false) . '_';
        } while ($this->prefix_exists($prefix));
        return $prefix;
    }

    private function prefix_exists($prefix) {
        $query = $this->wpdb->prepare("SHOW TABLES LIKE %s", $prefix . '%');
        return $this->wpdb->get_var($query) !== null;
    }

    private function assign_database() {
        $databases = get_option('saaspress_database_settings', []);
        foreach ($databases as $database) {
            if ($this->get_tenant_count($database['database']) < $database['max_tenants']) {
                return $database['database'];
            }
        }
        return $this->default_db; // Fallback to the default database
    }

    private function get_tenant_count($database) {
        $tenants = get_option('saaspress_tenants', []);
        $count = 0;
        foreach ($tenants as $tenant) {
            if ($tenant['database'] === $database) {
                $count++;
            }
        }
        return $count;
    }

    private function create_tenant_tables($tenant_data) {
        SaasPress_DB::switch_to_database($tenant_data['database']);
        $tables_to_duplicate = get_option('saaspress_global_filters', []);
        foreach ($tables_to_duplicate as $table) {
            $this->duplicate_table($table, $tenant_data['prefix']);
        }
        SaasPress_DB::switch_to_database($this->default_db); // Switch back to default DB
    }

    private function duplicate_table($table, $prefix) {
        global $wpdb;
        $new_table = $prefix . $table;
        $query = "CREATE TABLE $new_table LIKE $wpdb->prefix$table";
        $wpdb->query($query);
    }

    private function save_tenant_data($tenant_data) {
        $tenants = get_option('saaspress_tenants', []);
        $tenants[] = $tenant_data;
        update_option('saaspress_tenants', $tenants);
    }

    public function make_new_user_tenant($user_id) {
        $this->make_user_ttenant($user_id);
    }
}
