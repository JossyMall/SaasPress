<?php
/**
 * Uninstall SaasPress
 *
 * Deletes all plugin data upon uninstall.
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit; // Exit if accessed directly.
}

// Cleanup options
delete_option( 'saaspress_global_filters' );
delete_option( 'saaspress_databases' );
delete_option( 'saaspress_tenant_limit_per_db' );

// Cleanup user meta
global $wpdb;
$wpdb->query( "DELETE FROM $wpdb->usermeta WHERE meta_key = 'is_tenant'" );
$wpdb->query( "DELETE FROM $wpdb->usermeta WHERE meta_key = 'tenant_prefix'" );
$wpdb->query( "DELETE FROM $wpdb->usermeta WHERE meta_key = 'tenant_db_name'" );

