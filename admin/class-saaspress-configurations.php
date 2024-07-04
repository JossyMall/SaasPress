<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class SaasPress_Configurations {

    public function __construct() {
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    public function page_init() {
        add_settings_section(
            'saaspress_configurations_section',
            'Configurations',
            array( $this, 'print_section_info' ),
            'saaspress-configurations'
        );

        add_settings_field(
            'databases',
            'Database List',
            array( $this, 'databases_callback' ),
            'saaspress-configurations',
            'saaspress_configurations_section'
        );

        add_settings_field(
            'tenant_limit_per_db',
            'Tenant Limit per Database',
            array( $this, 'tenant_limit_callback' ),
            'saaspress-configurations',
            'saaspress_configurations_section'
        );
    }

    public function print_section_info() {
        print 'Enter your settings below:';
    }

    public function databases_callback() {
        printf(
            '<textarea id="databases" name="saaspress_databases" rows="10" cols="50">%s</textarea>',
            esc_textarea( get_option( 'saaspress_databases' ) )
        );
    }

    public function tenant_limit_callback() {
        printf(
            '<input type="number" id="tenant_limit_per_db" name="saaspress_tenant_limit_per_db" value="%s" />',
            esc_attr( get_option( 'saaspress_tenant_limit_per_db' ) )
        );
    }
}

if ( is_admin() ) {
    new SaasPress_Configurations();
}

?>

<div class="wrap">
    <h1>Configurations</h1>
    <form method="post" action="options.php">
        <?php
        settings_fields( 'saaspress-settings-group' );
        do_settings_sections( 'saaspress-configurations' );
        submit_button();
        ?>
    </form>

    <h2>Make Tenants</h2>
    <form id="make-tenant-form">
        <select id="user-select" name="user-select[]" multiple>
            <?php
            $users = get_users( array( 'meta_key' => 'is_tenant', 'meta_value' => '0' ) );
            foreach ( $users as $user ) {
                echo '<option value="' . esc_attr( $user->ID ) . '">' . esc_html( $user->display_name ) . '</option>';
            }
            ?>
        </select>
        <br>
        <h3>Select Tables to Duplicate for Tenants:</h3>
        <div id="tables-list">
            <?php
            global $wpdb;
            $tables = $wpdb->get_results( "SHOW TABLES LIKE '{$wpdb->prefix}%'", ARRAY_N );
            foreach ( $tables as $table ) {
                $table_name = $table[0];
                if ( strpos( $table_name, 'tenant_' ) === false ) {
                    echo '<input type="checkbox" name="tables[]" value="' . esc_attr( $table_name ) . '"> ' . esc_html( $table_name ) . '<br>';
                }
            }
            ?>
        </div>
        <button type="button" id="make-tenant-button" class="button button-primary">Make Tenant</button>
    </form>
</div>

<script>
document.getElementById('make-tenant-button').addEventListener('click', function() {
    const userSelect = document.getElementById('user-select');
    const selectedUsers = Array.from(userSelect.selectedOptions).map(option => option.value);
    const selectedTables = Array.from(document.querySelectorAll('input[name="tables[]"]:checked')).map(input => input.value);

    if (selectedUsers.length === 0 || selectedTables.length === 0) {
        alert('Please select at least one user and one table.');
        return;
    }

    const data = {
        action: 'make_tenant',
        users: selectedUsers,
        tables: selectedTables,
        nonce: '<?php echo wp_create_nonce( "make_tenant_nonce" ); ?>'
    };

    jQuery.post(ajaxurl, data, function(response) {
        alert(response.data);
        location.reload();
    });
});
</script>
