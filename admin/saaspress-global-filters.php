<?php
function saaspress_global_filters_page() {
    global $wpdb;

    if (isset($_POST['save_global_filters'])) {
        $global_filters = isset($_POST['global_filters']) ? array_map('sanitize_text_field', $_POST['global_filters']) : array();
        update_option('saaspress_global_filters', $global_filters);
        
        $db_details = isset($_POST['db_details']) ? sanitize_text_field($_POST['db_details']) : '';
        update_option('saaspress_db_details', $db_details);
        
        $tenants_per_db = isset($_POST['tenants_per_db']) ? intval($_POST['tenants_per_db']) : 1;
        update_option('saaspress_tenants_per_db', $tenants_per_db);
    }

    $global_filters = get_option('saaspress_global_filters', array());
    $db_details = get_option('saaspress_db_details', '');
    $tenants_per_db = get_option('saaspress_tenants_per_db', 1);

    echo '<div class="wrap"><h1>Global Filters</h1>';
    echo '<form method="post" action="">';
    echo '<table class="wp-list-table widefat fixed striped">';
    echo '<thead><tr><th>Table</th><th>Apply Filter</th></tr></thead>';
    echo '<tbody>';
    foreach ($wpdb->get_results("SHOW TABLES", ARRAY_N) as $table) {
        $checked = in_array($table[0], $global_filters) ? 'checked' : '';
        echo '<tr>';
        echo '<td>' . esc_html($table[0]) . '</td>';
        echo '<td><input type="checkbox" name="global_filters[]" value="' . esc_attr($table[0]) . '" ' . $checked . '></td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';

    echo '<h2>Database Details</h2>';
    echo '<textarea name="db_details" rows="5" cols="50">' . esc_textarea($db_details) . '</textarea>';
    echo '<p>Enter database details in JSON format: [{"db_host": "", "db_name": "", "db_user": "", "db_pass": "", "prefix": ""}, ...]</p>';

    echo '<h2>Tenants per Database</h2>';
    echo '<input type="number" name="tenants_per_db" value="' . esc_attr($tenants_per_db) . '">';
    
    echo '<p><input type="submit" name="save_global_filters" class="button button-primary" value="Save Global Filters"></p>';
    echo '</form>';
    echo '<p><span style="color: red;">Note: It is not advisable to duplicate the wp-options table for tenants.</span></p>';
    echo '</div>';
}
?>
