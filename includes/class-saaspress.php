<?php

class SaasPress {
    private $tenant_manager;

    public function __construct($tenant_manager) {
        $this->tenant_manager = $tenant_manager;

        $this->add_dynamic_filters();
    }

    private function add_dynamic_filters() {
        $tables = get_option('saaspress_tables');
        if ($tables) {
            $tables = array_map('trim', explode("\n", $tables));
            foreach ($tables as $table) {
                add_filter("{$table}_table", function($table) {
                    global $wpdb;
                    return $wpdb->prefix . $table;
                });
            }
        }
    }
}
?>
