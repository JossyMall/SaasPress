<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; //```php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class SaasPress_About {

    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_menu_page' ) );
    }

    public function add_menu_page() {
        add_submenu_page(
            'saaspress',
            'About SaasPress',
            'About Us',
            'manage_options',
            'saaspress-about',
            array( $this, 'display_about_page' )
        );
    }

    public function display_about_page() {
        ?>
        <div class="wrap">
            <h1>About SaasPress</h1>
            <p>SaasPress is a multi-tenant management plugin for WordPress. It allows you to manage multiple tenants within a single WordPress installation, providing each tenant with their own set of tables and data.</p>
            <p>Version: 1.0.0</p>
            <p>Author: Angel Cee</p>
        </div>
        <?php
    }
}

if ( is_admin() ) {
    new SaasPress_About();
}
