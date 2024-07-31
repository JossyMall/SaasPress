<?php

if (!defined('ABSPATH')) {
    exit;
}

class SaasPress_Settings {
    public static function init() {
        add_action('admin_init', [__CLASS__, 'admin_init']);
    }

    public static function admin_init() {
        register_setting('saaspress-settings', 'saaspress_global_filters');
        register_setting('saaspress-settings', 'saaspress_database_settings');

        add_settings_section(
            'saaspress_global_filters_section',
            __('Global Filters', 'saaspress'),
            null,
            'saaspress-settings'
        );

        add_settings_section(
            'saaspress_database_settings_section',
            __('Database Settings', 'saaspress'),
            null,
            'saaspress-settings'
        );

        add_settings_field(
            'saaspress_global_filters',
            __('Select Tables to Duplicate', 'saaspress'),
            [__CLASS__, 'global_filters_callback'],
            'saaspress-settings',
            'saaspress_global_filters_section'
        );

        add_settings_field(
            'saaspress_database_settings',
            __('Database Credentials', 'saaspress'),
            [__CLASS__, 'database_settings_callback'],
            'saaspress-settings',
            'saaspress_database_settings_section'
        );
    }

    public static function global_filters_callback() {
        global $wpdb;
        $tables = $wpdb->get_results("SHOW TABLES LIKE '{$wpdb->prefix}%'", ARRAY_N);
        $selected_tables = get_option('saaspress_global_filters', []);
        ?>
        <table class="form-table">
            <?php foreach ($tables as $table) {
                $table_name = $table[0];
                if (strpos($table_name, $wpdb->prefix . 'tenant_') === false) {
                    ?>
                    <tr>
                        <th scope="row"><?php echo $table_name; ?></th>
                        <td>
                            <input type="checkbox" name="saaspress_global_filters[]" value="<?php echo $table_name; ?>" <?php checked(in_array($table_name, $selected_tables)); ?> />
                        </td>
                    </tr>
                    <?php
                }
            } ?>
        </table>
        <?php
    }

    public static function database_settings_callback() {
        $databases = get_option('saaspress_database_settings', []);
        ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row"><?php _e('Database Details', 'saaspress'); ?></th>
                <td>
                    <textarea name="saaspress_database_settings" rows="10" cols="50"><?php echo esc_textarea(json_encode($databases)); ?></textarea>
                    <p class="description"><?php _e('Enter database details in JSON format.', 'saaspress'); ?></p>
                </td>
            </tr>
        </table>
        <?php
    }

    public static function render_page() {
        ?>
        <div class="wrap">
            <h1><?php _e('SaasPress Settings', 'saaspress'); ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('saaspress-settings');
                do_settings_sections('saaspress-settings');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }
}

SaasPress_Settings::init();
