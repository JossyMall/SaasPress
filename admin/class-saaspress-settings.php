<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class SaasPress_Settings {

    public function __construct() {
        add_action( 'admin_init', array( $this, 'register_settings' ) );
    }

    public function register_settings() {
        register_setting( 'saaspress-settings-group', 'saaspress_global_filters' );

        add_settings_section(
            'saaspress_settings_section',
            'Global Filters',
            array( $this, 'print_section_info' ),
            'saaspress-settings'
        );

        add_settings_field(
            'global_filters',
            'Select Tables for Global Filters',
            array( $this, 'global_filters_callback' ),
            'saaspress-settings',
            'saaspress_settings_section'
        );
    }

    public function print_section_info() {
        print 'Select the tables to be included in global filters:';
    }

    public function global_filters_callback() {
        global $wpdb;
        $tables = $wpdb->get_results( "SHOW TABLES LIKE '{$wpdb->prefix}%'", ARRAY_N );
        $selected_tables = get_option( 'saaspress_global_filters', array() );

        foreach ( $tables as $table ) {
            $table_name = $table[0];
            if ( strpos( $table_name, 'tenant_' ) === false ) {
                printf(
                    '<input type="checkbox" name="saaspress_global_filters[]" value="%s" %s /> %s<br>',
                    esc_attr( $table_name ),
                    in_array( $table_name, $selected_tables ) ? 'checked="checked"' : '',
                    esc_html( $table_name )
                );
            }
        }
    }
}

if ( is_admin() ) {
    new SaasPress_Settings();
}

?>

<div class="wrap">
    <h1>Global Filters</h1>
    <form method="post" action="options.php">
        <?php
        settings_fields( 'saaspress-settings-group' );
        do_settings_sections( 'saaspress-settings' );
        submit_button();
        ?>
    </form>
</div>
