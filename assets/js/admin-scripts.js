/* admin-scripts.js */
jQuery(document).ready(function($) {
    $('#non_tenant_user').on('change', function() {
        var userId = $(this).val();
        if (userId) {
            $('#db_tables').show();
        } else {
            $('#db_tables').hide();
        }
    });

    $('#db_tables').hide(); // Initially hide the tables until a user is selected
});
