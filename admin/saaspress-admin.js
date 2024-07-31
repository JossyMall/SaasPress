jQuery(document).ready(function($) {
    $('#saaspress-make-tenant').on('submit', function(e) {
        e.preventDefault();

        var selectedUsers = $('#saaspress-user-select').val();
        if (selectedUsers.length === 0) {
            alert('Please select at least one user.');
            return;
        }

        var data = {
            action: 'saaspress_make_tenant',
            users: selectedUsers,
            security: saaspress_make_tenant_nonce
        };

        $.post(ajaxurl, data, function(response) {
            if (response.success) {
                alert('Selected users have been made tenants.');
                location.reload();
            } else {
                alert('Failed to make selected users tenants.');
            }
        });
    });
});
