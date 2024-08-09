<?php
class SaasPress_Tenant_Manager {
    public function activate_tenancy($user_id, $prefix, $exclusions) {
        global $wpdb;
        
        // Check for missing configurations.
        if (empty($prefix)) {
            return new WP_Error('missing_prefix', 'Tenant prefix is required.');
        }

        // Get all tables to duplicate.
        $tables = $wpdb->get_results("SHOW TABLES", ARRAY_N);
        $tables = array_map(function($table) { return $table[0]; }, $tables);
        
        // Exclude specified tables.
        $exclusions_array = explode(',', $exclusions);
        $tables_to_duplicate = array_filter($tables, function($table) use ($exclusions_array, $wpdb) {
            return !in_array(str_replace($wpdb->prefix, '', $table), $exclusions_array);
        });

        // Duplicate tables with new prefix.
        foreach ($tables_to_duplicate as $table) {
            $new_table_name = $prefix . str_replace($wpdb->prefix, '', $table);
            $wpdb->query("CREATE TABLE $new_table_name LIKE $table");
        }

        // Update tenant status in the database.
        $wpdb->insert(
            $wpdb->prefix . 'tenants',
            [
                'user_id' => $user_id,
                'tenant_prefix' => $prefix,
                'db_exclusions' => $exclusions,
                'is_tenant' => true,
            ]
        );
    }

    public function revoke_tenancy($user_id) {
        global $wpdb;

        // Get tenant prefix.
        $prefix = $wpdb->get_var($wpdb->prepare(
            "SELECT tenant_prefix FROM {$wpdb->prefix}tenants WHERE user_id = %d", 
            $user_id
        ));

        // Drop tenant-specific tables.
        $tables = $wpdb->get_col("SHOW TABLES LIKE '{$prefix}%'");
        foreach ($tables as $table) {
            $wpdb->query("DROP TABLE IF EXISTS $table");
        }

        // Update tenant status in the database.
        $wpdb->delete(
            $wpdb->prefix . 'tenants',
            ['user_id' => $user_id]
        );
    }
}
