jQuery(document).ready(function($) {
    // Handle the selection and making users tenants
    $('#saaspress-make-tenants-form').on('submit', function(e) {
        e.preventDefault();
        
        var selectedUsers = [];
        $('input[name="saaspress_make_tenants[]"]:checked').each(function() {
            selectedUsers.push($(this).val());
        });

        if (selectedUsers.length > 0) {
            var data = {
                action: 'saaspress_make_tenants',
                users: selectedUsers,
                security: saaspress_admin.nonce
            };

            $.post(ajaxurl, data, function(response) {
                if (response.success) {
                    alert('Selected users have been made tenants.');
                    location.reload();
                } else {
                    alert('Error: ' + response.data.message);
                }
            });
        } else {
            alert('Please select at least one user to make a tenant.');
        }
    });

    // Handle the global filters form submission
    $('#saaspress-global-filters-form').on('submit', function(e) {
        e.preventDefault();

        var selectedTables = [];
        $('input[name="saaspress_global_filters[]"]:checked').each(function() {
            selectedTables.push($(this).val());
        });

        var data = {
            action: 'saaspress_save_global_filters',
            tables: selectedTables,
            security: saaspress_admin.nonce
        };

        $.post(ajaxurl, data, function(response) {
            if (response.success) {
                alert('Global filters saved successfully.');
                location.reload();
            } else {
                alert('Error: ' + response.data.message);
            }
        });
    });

    // Handle the database connection test
    $('#saaspress-test-db-connection').on('click', function(e) {
        e.preventDefault();

        var data = {
            action: 'saaspress_test_db_connection',
            db_host: $('#saaspress_db_host').val(),
            db_user: $('#saaspress_db_user').val(),
            db_password: $('#saaspress_db_password').val(),
            db_name: $('#saaspress_db_name').val(),
            security: saaspress_admin.nonce
        };

        $.post(ajaxurl, data, function(response) {
            if (response.success) {
                alert('Database connected, all looks good!');
            } else {
                alert('Error: ' + response.data.message);
            }
        });
    });
});
