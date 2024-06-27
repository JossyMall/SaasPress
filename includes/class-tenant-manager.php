<?php
class TenantManager {
    public static function create_tenant($user_id, $tables, $db_details) {
        global $wpdb;
        
        // Ensure tenant DB details are saved
        update_user_meta($user_id, 'tenant_db', $db_details);

        // Duplicate selected tables for the tenant
        foreach ($tables as $table) {
            $tenant_table = self::get_tenant_table_name($user_id, $table, $db_details);
            $wpdb->query("CREATE TABLE $tenant_table LIKE $table");
            $wpdb->query("INSERT INTO $tenant_table SELECT * FROM $table");
        }

        // Save tenant meta
        update_user_meta($user_id, 'is_tenant', '1');
        update_user_meta($user_id, 'tenant_tables', implode(', ', $tables));
    }

    private static function get_tenant_table_name($user_id, $table, $db_details) {
        return $db_details['prefix'] . $user_id . '_' . $table;
    }
}
?>
