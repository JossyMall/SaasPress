<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class SaasPress_Admin {

    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
        add_action( 'admin_init', array( $this, 'register_settings' ) );
    }

    public function add_admin_menu() {
        add_menu_page(
            'SaasPress',
            'SaasPress',
            'manage_options',
            'saaspress',
            array( $this, 'create_settings_page' ),
            '',
            110
        );

        add_submenu_page(
            'saaspress',
            'About SaasPress',
            'About Us',
            'manage_options',
            'saaspress-about',
            array( $this, 'create_about_page' )
        );

        add_submenu_page(
            'saaspress',
            'Tenants',
            'Tenants',
            'manage_options',
            'saaspress-tenants',
            array( $this, 'create_tenants_page' )
        );

        add_submenu_page(
            'saaspress',
            'Configurations',
            'Configurations',
            'manage_options',
            'saaspress-configurations',
            array( $this, 'create_configurations_page' )
        );
    }

    public function register_settings() {
        register_setting( 'saaspress-settings-group', 'saaspress_global_filters' );
        register_setting( 'saaspress-settings-group', 'saaspress_databases' );
        register_setting( 'saaspress-settings-group', 'saaspress_tenant_limit_per_db' );
    }

    public function create_settings_page() {
        include_once plugin_dir_path( __FILE__ ) . 'class-saaspress-settings.php';
    }

    public function create_about_page() {
        include_once plugin_dir_path( __FILE__ ) . 'class-saaspress-about.php';
    }

    public function create_tenants_page() {
        include_once plugin_dir_path( __FILE__ ) . 'class-saaspress-tenants.php';
    }

    public function create_configurations_page() {
        include_once plugin_dir_path( __FILE__ ) . 'class-saaspress-configurations.php';
    }
}

new SaasPress_Admin();
