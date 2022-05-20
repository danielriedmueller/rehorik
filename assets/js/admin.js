document.addEventListener('DOMContentLoaded', () => {
    const status = document.getElementById('status');
    const button = document.getElementById('create-sigil-attributes-button');
    button.onclick = () => {
        status.innerHTML = 'Pending...';
        jQuery.post(ajaxurl, {
            'action': 'create_sigil_attributes',
        }, function(response) {
            status.innerHTML = response;
        });
    }
});