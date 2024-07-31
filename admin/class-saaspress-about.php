<?php

if (!defined('ABSPATH')) {
    exit;
}

class SaasPress_About {
    public static function render_page() {
        ?>
        <div class="wrap">
            <h1><?php _e('About SaasPress', 'saaspress'); ?></h1>
            <p><?php _e('SaasPress is a WordPress plugin designed to provide multi-tenant SaaS functionality.', 'saaspress'); ?></p>
            <p><?php _e('Developed by Angel Cee.', 'saaspress'); ?></p>
            <p><?php _e('For more information, visit ', 'saaspress'); ?><a href="https://tabs101.com/saaspress" target="_blank">https://tabs101.com/saaspress</a></p>
        </div>
        <?php
    }
}

