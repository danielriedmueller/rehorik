document.addEventListener('DOMContentLoaded', () => {
    const status = document.getElementById('status');
    for (let btn of document.getElementsByClassName('rehorik-admin-action-button')) {
        const action = btn.dataset.action;
        if (action) {
            btn.onclick = () => {
                status.innerHTML = 'Pending...';
                jQuery.post(ajaxurl, {
                    'action': action,
                }, function(response) {
                    status.innerHTML = response;
                });
            }
        }
    }
});