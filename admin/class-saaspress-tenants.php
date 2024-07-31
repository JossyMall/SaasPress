<?php

if (!defined('ABSPATH')) {
    exit;
}

class SaasPress_Tenants {
    public static function render_page() {
        global $wpdb;
        $tenants = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}saaspress_tenants");

        ?>
        <div class="wrap">
            <h1><?php _e('Tenants', 'saaspress'); ?></h1>
            <table class="wp-list-table widefat fixed striped table-view-list">
                <thead>
                    <tr>
                        <th><?php _e('User ID', 'saaspress'); ?></th>
                        <th><?php _e('User Name', 'saaspress'); ?></th>
                        <th><?php _e('Email', 'saaspress'); ?></th>
                        <th><?php _e('Database', 'saaspress'); ?></th>
                        <th><?php _e('Table Prefix', 'saaspress'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tenants as $tenant) : ?>
                        <tr>
                            <td><?php echo esc_html($tenant->user_id); ?></td>
                            <td><?php echo esc_html($tenant->user_login); ?></td>
                            <td><?php echo esc_html($tenant->user_email); ?></td>
                            <td><?php echo esc_html($tenant->database); ?></td>
                            <td><?php echo esc_html($tenant->table_prefix); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php
    }
}
