import './bootstrap';

import Echo from "laravel-echo";
window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true
});

let userId = document.head.querySelector('meta[name="user-id"]').content;

window.Echo.private(`pengaduan.${userId}`)
    .notification((notification) => {
        console.log(notification);
        // Add the notification to the view
        let notificationsWrapper = document.getElementById('notifications');
        let notificationsCountElem = document.getElementById('notifications_count');
        let notificationsCount = parseInt(notificationsCountElem.innerText);

        let newNotificationHtml = `
            <li class="notification">
                <div class="notification-details">
                    <p>${notification.message}</p>
                </div>
            </li>
        `;
        notificationsWrapper.innerHTML = newNotificationHtml + notificationsWrapper.innerHTML;
        notificationsCountElem.innerText = notificationsCount + 1;
    });

