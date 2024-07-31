<?php

if (!defined('ABSPATH')) {
    exit;
}

class SaasPress_Configurations {
    public static function render_page() {
        ?>
        <div class="wrap">
            <h1><?php _e('Configurations', 'saaspress'); ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('saaspress-configurations');
                do_settings_sections('saaspress-configurations');
                submit_button();
                ?>
            </form>
            <h2><?php _e('Make User a Tenant', 'saaspress'); ?></h2>
            <form id="saaspress-make-tenant" method="post">
                <?php wp_nonce_field('saaspress_make_tenant', 'saaspress_make_tenant_nonce'); ?>
                <select id="saaspress-user-select" name="saaspress_user_select[]" multiple>
                    <?php
                    $users = get_users();
                    foreach ($users as $user) {
                        echo '<option value="' . esc_attr($user->ID) . '">' . esc_html($user->display_name) . ' (' . esc_html($user->user_email) . ')</option>';
                    }
                    ?>
                </select>
                <button type="submit" class="button button-primary"><?php _e('Make Tenant', 'saaspress'); ?></button>
            </form>
        </div>
        <?php
    }
}
