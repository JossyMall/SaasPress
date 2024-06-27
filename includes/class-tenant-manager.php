<?php
class TenantManager {
    public function make_tenant($user_id, $tables, $db_host, $db_name, $db_user, $db_pass) {
        global $wpdb;

        // Generate a unique prefix for the tenant
        $tenant_prefix = 'tenant_' . $user_id . '_' . wp_generate_password(6, false);

        // Update user meta
        update_user_meta($user_id, 'is_tenant', true);
        update_user_meta($user_id, 'tenant_tables', implode(',', $tables));
        update_user_meta($user_id, 'tenant_prefix', $tenant_prefix);

        // Duplicate tables
        $tenant_db = new wpdb($db_user, $db_pass, $db_name, $db_host);
        foreach ($tables as $table) {
            $new_table = $tenant_prefix . '_' . $table;
            $tenant_db->query("CREATE TABLE $new_table LIKE $table");
            $tenant_db->query("INSERT $new_table SELECT * FROM $table");
        }
    }

    public function apply_filters($global_filters) {
        global $wpdb;

        foreach ($global_filters as $table) {
            $tenant_prefix = get_user_meta(get_current_user_id(), 'tenant_prefix', true);
            if ($tenant_prefix) {
                add_filter($table, function($original_table) use ($tenant_prefix, $table) {
                    global $wpdb;
                    return $tenant_prefix . '_' . $table;
                });
            }
        }
    }
}
?>
