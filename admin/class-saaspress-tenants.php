<?php

function saaspress_tenants_page() {
    $users = get_users();
    ?>
    <div class="wrap">
        <h1>Tenants</h1>
        <table class="widefat fixed" cellspacing="0">
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
                <?php foreach ($users as $user) :
                    $user_id = $user->ID;
                    $is_tenant = get_user_meta($user_id, 'is_tenant', true);
                    $tenant_tables = get_user_meta($user_id, 'tenant_tables', true);
                    $tenant_db_details = get_user_meta($user_id, 'tenant_db_details', true);
                ?>
                    <tr>
                        <td><?php echo esc_html($user->user_login); ?></td>
                        <td><?php echo esc_html($user_id); ?></td>
                        <td>
                            <?php if ($is_tenant) : ?>
                                <span style="color:green;">Yes</span>
                            <?php else : ?>
                                <span style="color:red;">No</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo esc_html($user->user_email); ?></td>
                        <td><textarea readonly><?php echo esc_textarea($tenant_tables); ?></textarea></td>
                        <td><textarea readonly><?php echo esc_textarea($tenant_db_details); ?></textarea></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
}
?>
