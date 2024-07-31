<?php

if (!defined('ABSPATH')) {
    exit;
}

class SaasPress_Admin {
    public static function init() {
        add_action('admin_menu', [__CLASS__, 'admin_menu']);
        add_action('admin_enqueue_scripts', [__CLASS__, 'enqueue_scripts']);
    }

    public static function admin_menu() {
        add_menu_page(
            __('SaasPress', 'saaspress'),
            __('SaasPress', 'saaspress'),
            'manage_options',
            'saaspress',
            [__CLASS__, 'render_settings_page']
        );

        add_submenu_page(
            'saaspress',
            __('Configurations', 'saaspress'),
            __('Configurations', 'saaspress'),
            'manage_options',
            'saaspress-configurations',
            [__CLASS__, 'render_configurations_page']
        );

        add_submenu_page(
            'saaspress',
            __('Tenants', 'saaspress'),
            __('Tenants', 'saaspress'),
            'manage_options',
            'saaspress-tenants',
            [__CLASS__, 'render_tenants_page']
        );

        add_submenu_page(
            'saaspress',
            __('About Us', 'saaspress'),
            __('About Us', 'saaspress'),
            'manage_options',
            'saaspress-about',
            [__CLASS__, 'render_about_page']
        );
    }

    public static function enqueue_scripts($hook) {
        if (strpos($hook, 'saaspress') !== false) {
            wp_enqueue_style('saaspress-admin', SAASPRESS_PLUGIN_URL . 'admin/saaspress-admin.css', [], SAASPRESS_VERSION);
            wp_enqueue_script('saaspress-admin', SAASPRESS_PLUGIN_URL . 'admin/saaspress-admin.js', ['jquery'], SAASPRESS_VERSION, true);
        }
    }

    public static function render_settings_page() {
        require_once SAASPRESS_PLUGIN_DIR . 'admin/class-saaspress-settings.php';
        SaasPress_Settings::render_page();
    }

    public static function render_configurations_page() {
        require_once SAASPRESS_PLUGIN_DIR . 'admin/class-saaspress-configurations.php';
        SaasPress_Configurations::render_page();
    }

    public static function render_tenants_page() {
        require_once SAASPRESS_PLUGIN_DIR . 'admin/class-saaspress-tenants.php';
        SaasPress_Tenants::render_page();
    }

    public static function render_about_page() {
        require_once SAASPRESS_PLUGIN_DIR . 'admin/class-saaspress-about.php';
        SaasPress_About::render_page();
    }
}
