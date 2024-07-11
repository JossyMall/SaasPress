<?php
class SaasPress_Settings {
    public function __construct() {
        add_action('admin_init', array($this, 'register_settings'));
    }

    public function register_settings() {
        register_setting('saaspress-global-filters', 'saaspress_global_filters');
```php
        add_settings_section('saaspress_global_filters_section', 'Global Filters', null, 'saaspress-global-filters');
        add_settings_field('saaspress_global_filters', 'Select Tables to Duplicate for Tenants', array($this, 'global_filters_callback'), 'saaspress-global-filters', 'saaspress_global_filters_section');
    }

    public function global_filters_callback() {
        global $wpdb;
        $tables = $wpdb->get_results("SHOW TABLES LIKE '{$wpdb->prefix}%'", ARRAY_N);
        $selected_tables = get_option('saaspress_global_filters', array());

        foreach ($tables as $table) {
            $table_name = $table[0];
            if (strpos($table_name, $wpdb->prefix) === 0 && strpos($table_name, 'tenant_') === false) {
                printf(
                    '<input type="checkbox" name="saaspress_global_filters[]" value="%s" %s /> %s<br>',
                    esc_attr($table_name),
                    in_array($table_name, $selected_tables) ? 'checked="checked"' : '',
                    esc_html($table_name)
                );
            }
        }
    }

    public function display_page() {
        echo '<div class="wrap">';
        echo '<h1>Global Filters</h1>';
        echo '<form method="post" action="options.php">';
        settings_fields('saaspress-global-filters');
        do_settings_sections('saaspress-global-filters');
        submit_button();
        echo '</form>';
        echo '</div>';
    }

    public function display_global_filters_page() {
        $this->display_page();
    }
}
?>
