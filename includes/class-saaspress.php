<?php

class SaasPress {
    private $tenant_manager;

    public function __construct($tenant_manager) {
        $this->tenant_manager = $tenant_manager;

        add_filter('query', [$this, 'filter_query']);
        add_action('user_register', [$this, 'auto_make_tenant'], 10, 1);
        add_action('admin_menu', [$this, 'add_admin_menus']);
        add_action('wp_login', [$this, 'apply_tenant_filters'], 10, 2);
    }

    public function filter_query($query) {
        if (is_user_logged_in()) {
            $current_user_id = get_current_user_id();
            $tenant_prefix = $this->tenant_manager->get_tenant_prefix($current_user_id);
            if ($tenant_prefix) {
                $query = str_replace($wpdb->prefix, $tenant_prefix, $query);
            }
        }
        return $query;
    }

    public function auto_make_tenant($user_id) {
        $this->tenant_manager->make_tenant($user_id);
    }

    public function add_admin_menus() {
        add_menu_page('SaaSPress', 'SaaSPress', 'manage_options', 'saaspress', [$this, 'render_about_page'], 'dashicons-admin-network');
        add_submenu_page('saaspress', 'About Us', 'About Us', 'manage_options', 'saaspress', [$this, 'render_about_page']);
        add_submenu_page('saaspress', 'Tenants', 'Tenants', 'manage_options', 'saaspress-tenants', [$this, 'render_tenants_page']);
        add_submenu_page('saaspress', 'Global Filters', 'Global Filters', 'manage_options', 'saaspress-global-filters', [$this, 'render_global_filters_page']);
        add_submenu_page('saaspress', 'Configurations', 'Configurations', 'manage_options', 'saaspress-configurations', [$this, 'render_configurations_page']);
    }

    public function render_about_page() {
        require_once plugin_dir_path(__FILE__) . '../admin/class-saaspress-about.php';
    }

    public function render_tenants_page() {
        require_once plugin_dir_path(__FILE__) . '../admin/class-saaspress-tenants.php';
    }

    public function render_global_filters_page() {
        require_once plugin_dir_path(__FILE__) . '../admin/class-saaspress-global-filters.php';
    }

    public function render_configurations_page() {
        require_once plugin_dir_path(__FILE__) . '../admin/class-saaspress-configurations.php';
    }

    public function apply_tenant_filters($user_login, $user) {
        $tenant_prefix = $this->tenant_manager->get_tenant_prefix($user->ID);
        if ($tenant_prefix) {
            add_filter('query', function($query) use ($tenant_prefix) {
                return str_replace($wpdb->prefix, $tenant_prefix, $query);
            });
        }
    }
}
