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
        nonce: saaspressAdmin.nonce
    };

    jQuery.post(saaspressAdmin.ajaxurl, data, function(response) {
        alert(response.data);
        location.reload();
    });
});

