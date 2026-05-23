import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

window.Echo.private('App.Models.User.' + window.userId)
    .notification((notification) => {
        toastr.success(notification.msg);

        let alert_found = $('#alertsDropdown .badge-counter').length;
        let notify_count = $('#alertsDropdown .badge-counter').data('count');

        if (alert_found) {
            if (notify_count < 5) {
                $('#alertsDropdown .badge-counter').removeClass('d-none');
                $('#alertsDropdown .badge-counter').data('count', notify_count + 1);
                $('#alertsDropdown .badge-counter').text(notify_count + 1);
            }
        }
    });
