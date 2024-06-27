<?php
function saaspress_config_page() {
    global $wpdb;

    if (isset($_POST['test_db_connection'])) {
        $db_host = sanitize_text_field($_POST['db_host']);
        $db_name = sanitize_text_field($_POST['db_name']);
        $db_user = sanitize_text_field($_POST['db_user']);
        $db_pass = sanitize_text_field($_POST['db_pass']);
        $test_conn = new wpdb($db_user, $db_pass, $db_name, $db_host);

        if ($test_conn->db_connect()) {
            $connection_message = 'Database connected, all looks good!';
        } else {
            $connection_message = 'Database connection failed. Please check the details.';
        }
    }

    echo '<div class="wrap"><h1>Configurations</h1>';
    if (isset($connection_message)) {
        echo '<p>' . esc_html($connection_message) . '</p>';
    }

    echo '<form method="post" action="">';
    echo '<h2>Database Settings</h2>';
    echo '<table class="form-table">';
    echo '<tr><th scope="row"><label for="db_host">Database Host</label></th><td><input name="db_host" type="text" id="db_host" value="" class="regular-text"></td></tr>';
    echo '<tr><th scope="row"><label for="db_name">Database Name</label></th><td><input name="db_name" type="text" id="db_name" value="" class="regular-text"></td></tr>';
    echo '<tr><th scope="row"><label for="db_user">Database User</label></th><td><input name="db_user" type="text" id="db_user" value="" class="regular-text"></td></tr>';
    echo '<tr><th scope="row"><label for="db_pass">Database Password</label></th><td><input name="db_pass" type="password" id="db_pass" value="" class="regular-text"></td></tr>';
    echo '</table>';
    echo '<p><input type="submit" name="test_db_connection" class="button button-primary" value="Test Database Connection"></p>';
    echo '</form>';

    echo '<h2>Tenant DB</h2>';
    echo '<table class="wp-list-table widefat fixed striped">';
    echo '<thead><tr><th>User</th><th>User ID</th><th>Tenant DB Details</th></tr></thead>';
    echo '<tbody>';
    $tenants = get_users(array('meta_key' => 'is_tenant', 'meta_value' => '1'));
    foreach ($tenants as $tenant) {
        $tenant_db = get_user_meta($tenant->ID, 'tenant_db', true) ?: 'Default';
        echo '<tr>';
        echo '<td>' . esc_html($tenant->display_name) . '</td>';
        echo '<td>' . esc_html($tenant->ID) . '</td>';
        echo '<td>' . esc_html($tenant_db) . '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';

    echo '<h2>Make Tenants</h2>';
    echo '<form method="post" action="">';
    echo '<div style="overflow-y: scroll; height: 200px; border: 1px solid #ccc; padding: 10px;">';
    $users = get_users(array('meta_key' => 'is_tenant', 'meta_value' => '0'));
    foreach ($users as $user) {
        echo '<div><input type="radio" name="non_tenant_user" value="' . esc_attr($user->ID) . '"> ' . esc_html($user->display_name) . '</div>';
    }
    echo '</div>';
    echo '<div id="db_tables">';
    foreach ($wpdb->get_results("SHOW TABLES", ARRAY_N) as $table) {
        echo '<label><input type="checkbox" name="tables[]" value="' . esc_attr($table[0]) . '"> ' . esc_html($table[0]) . '</label><br>';
    }
    echo '</div>';
    echo '<p><input type="submit" name="make_tenant" class="button button-primary" value="Make Tenant"></p>';
    echo '</form></div>';
}
?>
