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

        $this->tenants[$tenant_id] = [
            'prefix' => $tenant_prefix,
            'content' => [],
            'plugins' => [],
            'roles' => [],
            'settings' => [],
        ];

        // Create tenant tables
        $this->create_tenant_tables($tenant_prefix);

        return $tenant_id;
    }

    public function get_tenant_prefix($user_id) {
        $tenant_id = 'tenant_' . $user_id;
        return isset($this->tenants[$tenant_id]) ? $this->tenants[$tenant_id]['prefix'] : $this->default_prefix;
    }

    private function create_tenant_tables($prefix) {
        global $wpdb;
        $tables = [
            'posts',
            'postmeta',
            'terms',
            'term_taxonomy',
            'term_relationships',
            'options',
        ];

        foreach ($tables as $table) {
            $wpdb->query("CREATE TABLE IF NOT EXISTS {$prefix}{$table} LIKE {$this->default_prefix}{$table}");
        }
    }

    public function switch_to_tenant($user_id) {
        global $wpdb;
        $wpdb->prefix = $this->get_tenant_prefix($user_id);
    }

    public function switch_to_default() {
        global $wpdb;
        $wpdb->prefix = $this->default_prefix;
    }
}
?>
