<div class="wrap">
    <h1>Global Filters</h1>
    <form method="post" action="options.php">
        <?php settings_fields('saaspress-global-filters'); ?>
        <?php do_settings_sections('saaspress-global-filters'); ?>
        <table class="form-table">
            <?php
            global $wpdb;
            $tables = $wpdb->get_results("SHOW TABLES LIKE '{$wpdb->prefix}%'", ARRAY_N);
            foreach ($tables as $table) {
                $table_name = $table[0];
                if (strpos($table_name, 'tenant_') === false) {
                    ?>
                    <tr>
                        <th scope="row"><?php echo $table_name; ?></th>
                        <td><input type="checkbox" name="saaspress_global_filters[]" value="<?php echo $table_name; ?>" <?php checked(in_array($table_name, get_option('saaspress_global_filters', []))); ?> /></td>
                    </tr>
                <?php } ?>
            <?php } ?>
        </table>
        <?php submit_button(); ?>
    </form>
</div>
