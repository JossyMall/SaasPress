<?php

class TenantManager {
    private $tenants;
    private $default_prefix;

    public function __construct() {
        global $wpdb;
        $this->tenants = [];
        $this->default_prefix = $wpdb->prefix;
    }

    public function create_tenant($user_id) {
        $tenant_id = 'tenant_' . $user_id;
        $tenant_prefix = $tenant_id . '_';

        $this->tenants[$user_id] = $tenant_prefix;
        update_user_meta($user_id, 'is_tenant', true);
        update_user_meta($user_id, 'tenant_prefix', $tenant_prefix);

        // Add any additional initialization for the tenant here
    }

    public function duplicate_table_for_tenant($user_id, $table) {
        global $wpdb;
        $tenant_prefix = get_user_meta($user_id, 'tenant_prefix', true);
        $tenant_table = $tenant_prefix . $table;

        $wpdb->query("CREATE TABLE $tenant_table LIKE $table");
        $wpdb->query("INSERT $tenant_table SELECT * FROM $table");
    }

    public function switch_to_tenant($user_id) {
        global $wpdb;
        $tenant_prefix = get_user_meta($user_id, 'tenant_prefix', true);

        if ($tenant_prefix) {
            $wpdb->set_prefix($tenant_prefix);
        }
    }

    public function switch_to_default() {
        global $wpdb;
        $wpdb->set_prefix($this->default_prefix);
    }
}
?>
