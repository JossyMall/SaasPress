<div class="wrap">
    <h1>Tenants</h1>
    <table class="widefat fixed" cellspacing="0">
        <thead>
            <tr>
                <th class="manage-column column-columnname">User</th>
                <th class="manage-column column-columnname">User ID</th>
                <th class="manage-column column-columnname">Is Tenant</th>
                <th class="manage-column column-columnname">Email</th>
                <th class="manage-column column-columnname">Tenant Tables</th>
                <th class="manage-column column-columnname">Tenant Database</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $users = get_users();
            foreach ($users as $user) {
                $is_tenant = get_user_meta($user->ID, 'is_tenant', true);
                $tenant_prefix = get_user_meta($user->ID, 'tenant_prefix', true);
                $tenant_db = $this->tenant_manager->get_tenant_db_details($user->ID);
                ?>
                <tr>
                    <td><?php echo $user->display_name; ?></td>
                    <td><?php echo $user->ID; ?></td>
                    <td><?php echo $is_tenant ? '<span style="color:green;">Yes</span>' : '<span style="color:red;">No</span>'; ?></td>
                    <td><?php echo $user->user_email; ?></td>
                    <td><?php echo $tenant_prefix ? str_replace($wpdb->prefix, '', $tenant_prefix) : ''; ?></td>
                    <td><?php echo $tenant_db; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
