<?php
class SaasPress_Tenants {
    public function __construct() {
        add_action('admin_menu', array($this, 'register_tenants_page'));
    }

    public function register_tenants_page() {
        add_submenu_page(
            'saaspress',
            'Tenants',
            'Tenants',
            'manage_options',
            'saaspress-tenants',
            array($this, 'display_tenants_page')
        );
    }

    public function display_tenants_page() {
        $users = get_users();
        $user_ids = wp_list_pluck($users, 'ID');
        $user_meta = $this->get_user_meta_multi($user_ids);

        echo '<div class="wrap">';
        echo '<h1>Tenants</h1>';
        echo '<table class="wp-list-table widefat fixed striped">';
        echo '<thead><tr><th>User</th><th>Is Tenant</th><th>Tenant Prefix</th><th>Tenant Database</th></tr></thead>';
        echo '<tbody>';

        foreach ($users as $user) {
            $is_tenant = isset($user_meta[$user->ID]['is_tenant']) && $user_meta[$user->ID]['is_tenant'] == '1';
            $tenant_prefix = isset($user_meta[$user->ID]['tenant_prefix']) ? $user_meta[$user->ID]['tenant_prefix'] : '';
            $tenant_db = isset($user_meta[$user->ID]['tenant_db_name']) ? $user_meta[$user->ID]['tenant_db_name'] : '';

            echo '<tr>';
            echo '<td>' . esc_html($user->display_name) . '</td>';
            echo '<td>' . ($is_tenant ? 'Yes' : 'No') . '</td>';
            echo '<td>' . esc_html($tenant_prefix) . '</td>';
            echo '<td>' . esc_html($tenant_db) . '</td>';
            echo '</tr>';
        }

        echo '</tbody></table>';
        echo '</div>';
    }

    private function get_user_meta_multi($user_ids) {
        global $wpdb;
        $user_ids = implode(',', array_map('intval', $user_ids));
        $meta = $wpdb->get_results("SELECT user_id, meta_key, meta_value FROM {$wpdb->usermeta} WHERE user_id IN ($user_ids)", ARRAY_A);
        $result = array();
        foreach ($meta as $m) {
            $result[$m['user_id']][$m['meta_key']] = $m['meta_value'];
        }
        return $result;
    }
}
?>
