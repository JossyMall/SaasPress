<?php
function saaspress_config_page() {
    global $wpdb;

    // Handle database connection testing
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

    // Save settings
    if (isset($_POST['save_settings'])) {
        $db_host = sanitize_text_field($_POST['db_host']);
        $db_name = sanitize_text_field($_POST['db_name']);
        $db_user = sanitize_text_field($_POST['db_user']);
        $db_pass = sanitize_text_field($_POST['db_pass']);
        $db_details = array(
            'host' => $db_host,
            'name' => $db_name,
            'user' => $db_user,
            'pass' => $db_pass
        );
        update_option('saaspress_db_details', $db_details);

        $tenants_per_db = intval($_POST['tenants_per_db']);
        update_option('saaspress_tenants_per_db', $tenants_per_db);
    }

    // Handle making a user a tenant
    if (isset($_POST['make_tenant']) && !empty($_POST['non_tenant_user']) && !empty($_POST['tables'])) {
        $user_id = intval($_POST['non_tenant_user']);
        $tables = array_map('sanitize_text_field', $_POST['tables']);

        // Set user as tenant
        update_user_meta($user_id, 'is_tenant', '1');

        // Duplicate tables for the tenant
        $prefix = 'tenant_' . $user_id . '_';
        foreach ($tables as $table) {
            $new_table = $prefix . $table;
            $wpdb->query("CREATE TABLE $new_table LIKE $table");
            $wpdb->query("INSERT $new_table SELECT * FROM $table");
        }

        // Save tenant tables to user meta
        update_user_meta($user_id, 'tenant_tables', $tables);
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

    echo '<h2>Tenants per Database</h2>';
    echo '<input type="number" name="tenants_per_db" value="' . esc_attr(get_option('saaspress_tenants_per_db', 1)) . '">';
    echo '<p><input type="submit" name="save_settings" class="button button-primary" value="Save Settings"></p>';
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
        echo '<td>' . esc_html(json_encode($tenant_db)) . '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';

    echo '<h2>Make Tenants</h2>';
    echo '<form method="post" action="">';
    echo '<div style="overflow-y: scroll; height: 200px; border: 1px solid #ccc; padding: 10px;">';

    $users = get_users(array(
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => 'is_tenant',
                'compare' => 'NOT EXISTS',
            ),
            array(
                'key' => 'is_tenant',
                'value' => '0',
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'is_tenant',
                'value' => 'false',
                'compare' => 'LIKE'
            )
        )
    ));

    if (empty($users)) {
        echo '<p>No non-tenant users found.</p>';
    } else {
        foreach ($users as $user) {
            echo '<div><input type="radio" name="non_tenant_user" value="' . esc_attr($user->ID) . '"> ' . esc_html($user->display_name) . '</div>';
        }
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
