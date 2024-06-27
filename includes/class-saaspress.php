<?php
class SaaasPress {
    private $tenant_manager;

    public function __construct($tenant_manager) {
        $this->tenant_manager = $tenant_manager;

        add_action('init', [$this, 'apply_global_filters']);
        add_action('user_register', [$this, 'make_new_user_tenant']);
    }

    public function apply_global_filters() {
        $global_filters = get_option('saaspress_global_filters', array());
        $this->tenant_manager->apply_filters($global_filters);
    }

    public function make_new_user_tenant($user_id) {
        $global_filters = get_option('saaspress_global_filters', array());
        $db_details = get_option('saaspress_default_db_details', array());
        $this->tenant_manager->make_tenant($user_id, $global_filters, $db_details['db_host'], $db_details['db_name'], $db_details['db_user'], $db_details['db_pass']);
    }
}
?>
