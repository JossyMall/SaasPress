<?php
class SaasPress {
    private $tenant_manager;

    public function __construct($tenant_manager) {
        $this->tenant_manager = $tenant_manager;

        add_filter('query', [$this, 'filter_query']);
    }

    public function filter_query($query) {
        global $wpdb;
        $current_user = wp_get_current_user();

        if ($this->tenant_manager->is_tenant($current_user->ID)) {
            $tenant_prefix = $this->tenant_manager->get_tenant_prefix($current_user->ID);

            $tables = $this->tenant_manager->get_global_filtered_tables();
            foreach ($tables as $table) {
                $base_table = $wpdb->prefix . $table;
                $tenant_table = $tenant_prefix . $table;
                $query = str_replace($base_table, $tenant_table, $query);
            }
        }

        return $query;
    }
}
