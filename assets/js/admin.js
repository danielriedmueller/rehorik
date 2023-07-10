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
                        let message = '';

                        if (response.data) {
                            if (response.data.message) {
                                message = response.data.message;
                            }

                            if (response.data.refresh) {
                                location.reload();
                            }
                        }

                        status.innerHTML = message + ' Done!';
                    } else {
                        status.innerHTML = 'Error: ' + response.data;
                    }
                });
            }
        }
    }
});
