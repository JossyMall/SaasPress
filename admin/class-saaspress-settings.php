<?php

// Register the settings page
function saaspress_register_settings_page() {
    add_menu_page(
        'SaaSPress Settings',
        'SaaSPress',
        'manage_options',
        'saaspress-settings',
        'saaspress_settings_page',
        'dashicons-admin-generic'
    );
}

// Display the settings page
function saaspress_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('saaspress_settings');
            do_settings_sections('saaspress-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Register settings and add fields
function saaspress_register_settings() {
    register_setting('saaspress_settings', 'saaspress_tables');

    add_settings_section(
        'saaspress_main_section',
        'Main Settings',
        'saaspress_main_section_callback',
        'saaspress-settings'
    );

    add_settings_field(
        'saaspress_tables',
        'Database Tables',
        'saaspress_tables_field_callback',
        'saaspress-settings',
        'saaspress_main_section'
    );
}

function saaspress_main_section_callback() {
    echo '<p>Add the database tables to be filtered for each tenant.</p>';
}

function saaspress_tables_field_callback() {
    $tables = get_option('saaspress_tables');
    echo '<textarea name="saaspress_tables" rows="10" cols="50" class="large-text code">' . esc_textarea($tables) . '</textarea>';
    echo '<p class="description">Enter each table name on a new line.</p>';
}

add_action('admin_init', 'saaspress_register_settings');
?>
