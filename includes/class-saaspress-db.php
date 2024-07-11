<?php
class SaasPress_DB {
    public function duplicate_tables($prefix, $tables) {
        global $wpdb;

        foreach ($tables as $table) {
            $table_name = $wpdb->prefix . $table;
            $new_table_name = $prefix . $table;

            // Get the table structure
            $create_table_sql = $wpdb->get_row("SHOW CREATE TABLE $table_name", ARRAY_N)[1];

            // Modify the table name in the SQL
            $create_table_sql = str_replace("CREATE TABLE `$table_name`", "CREATE TABLE `$new_table_name`", $create_table_sql);

            // Create the new table
            $wpdb->query($create_table_sql);
        }
    }
}
?>
