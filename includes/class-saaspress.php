<?php
class SaasPress {
    private $tenant_manager;

    public function __construct($tenant_manager) {
        $this->tenant_manager = $tenant_manager;
        add_action('admin_menu', [$this, 'add_admin_pages']);
        add_filter('query', [$this, 'filter_queries']);
    }

    public function add_admin_pages() {
        add_menu_page('SaaS Press', 'SaaS Press', 'manage_options', 'saaspress', [$this, 'saaspress_global_filters_page']);
        add_submenu_page('saaspress', 'Global Filters', 'Global Filters', 'manage_options', 'saaspress-global-filters', [$this, 'saaspress_global_filters_page']);
        add_submenu_page('saaspress', 'Configurations', 'Configurations', 'manage_options', 'saaspress-configurations', [$this, 'saaspress_configurations_page']);
        add_submenu_page('saaspress', 'Tenants', 'Tenants', 'manage_options', 'saaspress-tenants', [$this, 'saaspress_tenants_page']);
        add_submenu_page('saaspress', 'About Us', 'About Us', 'manage_options', 'saaspress-about', [$this, 'saaspress_about_page']);
    }

    public function saaspress_global_filters_page() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            update_option('saaspress_global_filters', $_POST['saaspress_global_filters']);
            update_option('saaspress_databases', $_POST['saaspress_databases']);
            update_option('saaspress_tenant_limit_per_db', $_POST['saaspress_tenant_limit_per_db']);
        }
        include plugin_dir_path(__FILE__) . 'admin/global-filters.php';
    }

    public function saaspress_configurations_page() {
        include plugin_dir_path(__FILE__) . 'admin/configurations.php';
    }

    public function saaspress_tenants_page() {
        include plugin_dir_path(__FILE__) . 'admin/tenants.php';
    }

    public function saaspress_about_page() {
        include plugin_dir_path(__FILE__) . 'admin/about.php';
    }

    public function filter_queries($query) {
        global $wpdb;
        $current_user = wp_get_current_user();
        $tenant_prefix = get_user_meta($current_user->ID, 'saaspress_tenant_prefix', true);
        if ($tenant_prefix) {
            $global_filters = get_option('saaspress_global_filters', []);
            foreach ($global_filters as $table) {
                $query = str_replace($wpdb->prefix . $table, $wpdb->prefix . $tenant_prefix . $table, $query);
            }
        }
        return $query;
    }
}
