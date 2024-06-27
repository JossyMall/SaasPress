<?php

// Register the admin menu pages
function saaspress_register_admin_pages() {
    add_menu_page(
        'SaaSPress',
        'SaaSPress',
        'manage_options',
        'saaspress',
        null,
        'dashicons-admin-generic'
    );

    add_submenu_page(
        'saaspress',
        'About Us',
        'About Us',
        'manage_options',
        'saaspress-about',
        'saaspress_about_page'
    );

    add_submenu_page(
        'saaspress',
        'Tenants',
        'Tenants',
        'manage_options',
        'saaspress-tenants',
        'saaspress_tenants_page'
    );

    add_submenu_page(
        'saaspress',
        'Configurations',
        'Configurations',
        'manage_options',
        'saaspress-configurations',
        'saaspress_configurations_page'
    );
}
?>
