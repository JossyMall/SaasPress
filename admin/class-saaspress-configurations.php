<?php

function saaspress_configurations_page() {
    if (isset($_POST['saaspress_save_settings'])) {
        update_option('saaspress_default_db', sanitize_text_field($_POST['default_db']));
        update_option('saaspress_additional_dbs', sanitize_textarea_field($_POST['additional_dbs']));
    }

    $default_db = get_option('saaspress_default_db', '');
    $additional_dbs = get_option('saaspress_additional_dbs', '');
    ?>
    <div class="wrap">
        <h1>Configurations</h1>
        <form method="post">
            <h2>Tenant DB</h2>
            <p>Current Tenant Databases:</p>
            <textarea name="additional_dbs" rows="10" cols="50"><?php echo esc_textarea($additional_dbs); ?></textarea>
            <p>Enter each database detail on a new line in the format: db_name;db_user;db_password;db_host</p>
            <h2>Default Database</h2>
            <input type="text" name="default_db" value="<?php echo esc_attr($default_db); ?>" />
            <p>Enter the default database details in the format: db_name;db_user;db_password;db_host</p>
            <input type="submit" name="saaspress_save_settings" value="Save Settings" class="button-primary" />
        </form>

        <h2>Make Tenants</h2>
        <form method="post">
            <select name="non_tenant_user">
                <?php
                $non_tenants = get_users(array('meta_key' => 'is_tenant', 'meta_value' => ''));
                foreach ($non_tenants as $user) :
                ?>
                    <option value="<?php echo esc_attr($user->ID); ?>"><?php echo esc_html($user->user_login); ?></option>
                <?php endforeach; ?>
            </select>
            <h3>Tables to Duplicate</h3>
            <?php
            global $wpdb;
            $tables = $wpdb->get_col("SHOW TABLES");
            foreach ($tables as $table) :
            ?>
                <input type="checkbox" name="tenant_tables[]" value="<?php echo esc_attr($table); ?>"><?php echo esc_html($table); ?><br>
            <?php endforeach; ?>
            <input type="submit" name="saaspress_make_tenant" value="Make Tenant" class="button-primary" />
        </form>
    </div>
    <?php

    if (isset($_POST['saaspress_make_tenant'])) {
        $user_id = intval($_POST['non_tenant_user']);
        $tables = array_map('sanitize_text_field', $_POST['tenant_tables']);
        $tenant_manager = new TenantManager();
        $tenant_manager->create_tenant($user_id);

        foreach ($tables as $table) {
            $tenant_manager->duplicate_table_for_tenant($user_id, $table);
        }
    }
}
?>
