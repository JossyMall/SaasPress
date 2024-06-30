<div class="wrap">
    <h1>Configurations</h1>
    <form method="post" action="options.php">
        <?php settings_fields('saaspress-configurations'); ?>
        <?php do_settings_sections('saaspress-configurations'); ?>
        <h2>Make User a Tenant</h2>
        <div style="max-height: 300px; overflow-y: auto;">
            <?php
            $users = get_users(['role__in' => ['subscriber', 'contributor', 'author', 'editor', 'administrator']]);
            foreach ($users as $user) {
                if (!get_user_meta($user->ID, 'is_tenant', true)) {
                    ?>
                    <label>
                        <input type="checkbox" name="saaspress_make_tenants[]" value="<?php echo $user->ID; ?>" />
                        <?php echo $user->display_name; ?> (<?php echo $user->user_email; ?>)
                    </label><br>
                <?php } ?>
            <?php } ?>
        </div>
        <?php submit_button('Make Tenant'); ?>
    </form>
</div>
