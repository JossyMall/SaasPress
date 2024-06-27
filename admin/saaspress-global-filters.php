<?php
function saaspress_global_filters_page() {
    global $wpdb;

    if (isset($_POST['save_global_filters'])) {
        $global_filters = isset($_POST['global_filters']) ? array_map('sanitize_text_field', $_POST['global_filters']) : array();
        update_option('saaspress_global_filters', $global_filters);
    }

    $global_filters = get_option('saaspress_global_filters', array());

    echo '<div class="wrap"><h1>Global Filters</h1>';
    echo '<form method="post" action="">';
    echo '<table class="wp-list-table widefat fixed striped">';
    echo '<thead><tr><th>Database Table</th><th>Apply Filter</th></tr></thead>';
    echo '<tbody>';
    foreach ($wpdb->tables() as $table) {
        $checked = in_array($table, $global_filters) ? 'checked' : '';
        $warning = ($table == $wpdb->prefix . 'options') ? 'style="color:red;"' : '';
        $note = ($table == $wpdb->prefix . 'options') ? '<span style="color:red;">(Not advisable to duplicate)</span>' : '';

        echo '<tr>';
        echo '<td ' . $warning . '>' . esc_html($table) . ' ' . $note . '</td>';
        echo '<td><input type="checkbox" name="global_filters[]" value="' . esc_attr($table) . '" ' . $checked . '></td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    echo '<p><input type="submit" name="save_global_filters" class="button button-primary" value="Save Global Filters"></p>';
    echo '</form></div>';
}
?>
