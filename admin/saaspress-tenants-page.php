<?php
function saaspress_tenants_page() {
    global $wpdb;

    $users = get_users();
    echo '<div class="wrap"><h1>Tenants</h1>';
    echo '<table class="wp-list-table widefat fixed striped">';
    echo '<thead><tr><th>User</th><th>User ID</th><th>Is Tenant</th><th>Email</th><th>Tenant Tables</th><th>Tenant DB Prefix</th></tr></thead>';
    echo '<tbody>';
    foreach ($users as $user) {
        $is_tenant = get_user_meta($user->ID, 'is_tenant', true) ? 'Yes' : 'No';
        $is_tenant_color = $is_tenant == 'Yes' ? 'green' : 'red';
        $tenant_tables = get_user_meta($user->ID, 'tenant_tables', true) ?: '';
        $tenant_prefix = get_user_meta($user->ID, 'tenant_prefix', true) ?: '';

        echo '<tr>';
        echo '<td>' . esc_html($user->display_name) . '</td>';
        echo '<td>' . esc_html($user->ID) . '</td>';
        echo '<td style="color:' . $is_tenant_color . ';">' . esc_html($is_tenant) . '</td>';
        echo '<td>' . esc_html($user->user_email) . '</td>';
        echo '<td>' . esc_html($tenant_tables) . '</td>';
        echo '<td>' . esc_html($tenant_prefix) . '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table></div>';
}
?>
