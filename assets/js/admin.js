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
                    if (response.success) {
                        status.innerHTML = 'Done!';

                        if (response.data) {
                            if (response.data.refresh) {
                                location.reload();
                            }
                        }
                    } else {
                        status.innerHTML = 'Error: ' + response.data;
                    }
                });
            }
        }
    }
});
