<div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notificationModalLabel">Notifikasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul id="notificationList" class="list-group">
                        <!-- Notifikasi akan ditambahkan di sini -->
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM fully loaded and parsed');

        // Load notifications from localStorage on page load
        loadNotifications();

        var notificationButton = document.getElementById('notificationButton');
        notificationButton.addEventListener('click', function() {
            // Show notifications in modal
            showNotificationsInModal();

            var notificationModal = new bootstrap.Modal(document.getElementById('notificationModal'), {
                keyboard: false
            });
            notificationModal.show();
        });

        // Event listener for when the modal is fully shown
        $('#notificationModal').on('shown.bs.modal', function () {
            // Mark notifications as read when modal is fully shown
            markNotificationsAsRead();
        });

        // Event listener for when the modal is fully hidden
        $('#notificationModal').on('hidden.bs.modal', function () {
            // Clear notification list when modal is fully hidden
            clearNotificationList();
        });

        // Pusher setup and notification handling
        Pusher.logToConsole = true;

        var pusher = new Pusher('6a260fa3e4660736f2dc', {
            cluster: 'ap1'
        });

        var channel = pusher.subscribe('SIKADU');
        channel.bind('pengaduan-baru', function(data) {
            console.log('New notification received:', data);
            addNotification(data.pengaduan);
        });
    });

    // Function to load notifications from local storage
    function loadNotifications() {
        var notifications = JSON.parse(localStorage.getItem('notifications')) || [];
        var notificationCount = document.getElementById('notificationCount');

        // Count unread notifications
        var unreadNotifications = notifications.filter(function(notification) {
            return !notification.read;
        });

        notificationCount.innerText = unreadNotifications.length;
    }

    // Function to show notifications in modal
    function showNotificationsInModal() {
        var notifications = JSON.parse(localStorage.getItem('notifications')) || [];
        var notificationList = document.getElementById('notificationList');

        // Clear existing notifications
        notificationList.innerHTML = '';

        // Add notifications to the modal
        notifications.forEach(function(notification) {
            var newNotification = document.createElement('li');
            newNotification.classList.add('list-group-item');
            newNotification.innerHTML = '<strong>' + notification.message + '</strong><br>' + notification.permasalahan + '</strong><br>' + notification.tgl_pengaduan;
            notificationList.appendChild(newNotification);
        });
    }

    // Function to mark notifications as read
    function markNotificationsAsRead() {
        var notifications = JSON.parse(localStorage.getItem('notifications')) || [];

        // Mark all notifications as read
        notifications.forEach(function(notification) {
            notification.read = true;
        });

        // Save updated notifications to local storage
        localStorage.setItem('notifications', JSON.stringify(notifications));

        // Update notification count
        loadNotifications();
    }

    // Function to clear notification list when modal is fully hidden
    function clearNotificationList() {
        var notificationList = document.getElementById('notificationList');
        notificationList.innerHTML = '';
    }

    // Function to add a new notification
    function addNotification(data) {
        var notifications = JSON.parse(localStorage.getItem('notifications')) || [];
        var notificationCount = document.getElementById('notificationCount');

        // Add new notification to the array
        notifications.unshift(data);

        // Save updated notifications to local storage
        localStorage.setItem('notifications', JSON.stringify(notifications));

        // Update notification count and list
        notificationCount.innerText = notifications.length;

        // Optionally show a toast or alert for new notification
        // Example: toastr.success('New notification received!');
    }
</script>