<?php
function saaspress_tenants_page() {
    echo '<div class="wrap"><h1>Tenants</h1>';
    echo '<table class="wp-list-table widefat fixed striped">';
    echo '<thead><tr><th>User</th><th>User ID</th><th>Is Tenant</th><th>Email</th><th>Tenant Tables</th><th>Tenant DB Details</th></tr></thead>';
    echo '<tbody>';
    $users = get_users();
    foreach ($users as $user) {
        $is_tenant = get_user_meta($user->ID, 'is_tenant', true) == '1' ? 'Yes' : 'No';
        $is_tenant_color = $is_tenant == 'Yes' ? 'green' : 'red';
        $tenant_tables = get_user_meta($user->ID, 'tenant_tables', true) ?: '';
        $tenant_db = get_user_meta($user->ID, 'tenant_db', true) ?: 'Default';
        echo '<tr>';
        echo '<td>' . esc_html($user->display_name) . '</td>';
        echo '<td>' . esc_html($user->ID) . '</td>';
        echo '<td style="color: ' . $is_tenant_color . ';">' . $is_tenant . '</td>';
        echo '<td>' . esc_html($user->user_email) . '</td>';
        echo '<td>' . esc_html($tenant_tables) . '</td>';
        echo '<td>' . esc_html($tenant_db) . '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table></div>';
}
?>
