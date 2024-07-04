<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class SaasPress_Tenants {

    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_menu_page' ) );
    }

    public function add_menu_page() {
        add_submenu_page(
            'saaspress',
            'Tenants',
            'Tenants',
            'manage_options',
            'saaspress-tenants',
            array( $this, 'display_tenants_page' )
        );
    }

    public function display_tenants_page() {
        ?>
        <div class="wrap">
            <h1>Tenants</h1>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>User ID</th>
                        <th>Is Tenant</th>
                        <th>Email</th>
                        <th>Tenant Tables</th>
                        <th>Tenant Database Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $users = get_users();
                    foreach ( $users as $user ) {
                        $is_tenant = get_user_meta( $user->ID, 'is_tenant', true ) == '1';
                        $tenant_prefix = get_user_meta( $user->ID, 'tenant_prefix', true );
                        $tenant_db = get_user_meta( $user->ID, 'tenant_db_name', true );

                        $tables = $is_tenant ? implode( ', ', $this->get_tenant_tables( $tenant_prefix ) ) : '';
                        ?>
                        <tr>
                            <td><?php echo esc_html( $user->display_name ); ?></td>
                            <td><?php echo esc_html( $user->ID ); ?></td>
                            <td style="color: <?php echo $is_tenant ? 'green' : 'red'; ?>;">
                                <?php echo $is_tenant ? 'Yes' : 'No'; ?>
                            </td>
                            <td><?php echo esc_html( $user->user_email ); ?></td>
                            <td><?php echo esc_html( $tables ); ?></td>
                            <td><?php echo esc_html( $tenant_db ); ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php
    }

    private function get_tenant_tables( $prefix ) {
        global $wpdb;
        return $wpdb->get_col( "SHOW TABLES LIKE '{$prefix}%'" );
    }
}

if ( is_admin() ) {
    new SaasPress_Tenants();
}
