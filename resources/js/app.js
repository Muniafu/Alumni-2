import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// ✅ Initialize Echo for real-time notifications (if available)
if (typeof Echo !== 'undefined') {
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: process.env.MIX_PUSHER_APP_KEY,
        cluster: process.env.MIX_PUSHER_APP_CLUSTER,
        encrypted: true,
        forceTLS: true,
        wsHost: window.location.hostname,
        wsPort: 6001,
        wssPort: 6001,
        disableStats: true,
        enabledTransports: ['ws', 'wss']
    });
}

document.addEventListener('DOMContentLoaded', function () {
    // ✅ Single notification mark-as-read
    document.addEventListener('click', function (e) {
        const item = e.target.closest('.notification-item, .mark-as-read');
        if (!item) return;

        e.preventDefault();

        const id = item.dataset.id;
        const url = item.getAttribute('href');

        if (id) {
            fetch(`/notifications/mark-as-read/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            }).then(() => {
                // Remove item from dropdown if exists
                if (item.classList.contains('notification-item')) {
                    item.remove();
                }

                // Update unread badge
                const badge = document.getElementById('unread-count') || document.querySelector('.notification-count');
                if (badge) {
                    let n = parseInt(badge.textContent) - 1;
                    if (n <= 0) {
                        badge.remove();
                    } else {
                        badge.textContent = n;
                    }
                }

                // Redirect if notification had a URL
                if (url && url !== '#') {
                    window.location.href = url;
                }
            });
        }
    });

    // ✅ Mark all notifications as read
    document.getElementById('mark-all-read')?.addEventListener('click', function () {
        fetch('/notifications/mark-all-read', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        }).then(r => r.json()).then(() => {
            // Clear dropdown
            const list = document.getElementById('notifications-list');
            if (list) {
                list.innerHTML = '<div class="px-4 py-3 text-center text-sm text-gray-500">No new notifications</div>';
            }

            // Remove badge
            const badge = document.getElementById('unread-count') || document.querySelector('.notification-count');
            if (badge) badge.remove();
        });
    });

    // ✅ Real-time notifications (via Echo + Pusher)
    const userId = document.querySelector('meta[name="user-id"]')?.getAttribute('content');
    if (userId && window.Echo) {
        window.Echo.private(`App.Models.User.${userId}`)
            .notification((notification) => {
                // Play notification sound
                const audio = document.getElementById('notificationSound');
                if (audio) {
                    audio.currentTime = 0;
                    audio.play().catch(e => console.log('Audio play failed:', e));
                }

                // Update unread badge
                const badge = document.getElementById('unread-count') || document.querySelector('.notification-count');
                if (badge) {
                    badge.textContent = (parseInt(badge.textContent) || 0) + 1;
                    badge.classList.remove('hidden');
                } else {
                    const bell = document.querySelector('button .fa-bell');
                    if (bell) {
                        bell.insertAdjacentHTML(
                            'afterend',
                            `<span id="unread-count" class="absolute top-0 right-0 w-5 h-5 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full text-xs text-white flex items-center justify-center">1</span>`
                        );
                    }
                }

                // Add new notification to dropdown
                const list = document.getElementById('notifications-list') || document.querySelector('[x-show="openNotifications"] .max-h-64');
                if (list) {
                    const newNotification = `
                        <a href="${notification.url || '#'}"
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 notification-item mark-as-read"
                           data-id="${notification.id}">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 pt-0.5">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <strong>${notification.title || notification.student_name || 'Notification'}</strong>
                                    <p class="text-sm font-medium text-gray-900">${notification.message}</p>
                                    <p class="text-xs text-gray-500">Just now</p>
                                </div>
                            </div>
                        </a>
                    `;
                    list.insertAdjacentHTML('afterbegin', newNotification);
                }

                // Show toast popup
                showToastNotification(notification.message, notification.url);
            });
    }

    // ✅ Message Handling: Select2 for recipients
    if (document.querySelector('#recipients')) {
        $('#recipients').select2({
            placeholder: "Select recipients",
            allowClear: true,
            width: '100%'
        });
    }
});

// ✅ Toast Notification
function showToastNotification(message, url = '#') {
    const toast = document.createElement('div');
    toast.className = 'fixed bottom-4 right-4 bg-white shadow-lg rounded-lg p-4 max-w-xs z-50 border-l-4 border-blue-500 transform transition-all duration-300 translate-x-0 opacity-100';
    toast.innerHTML = `
        <div class="flex items-start">
            <div class="flex-shrink-0 pt-0.5">
                <svg class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-900">${message}</p>
            </div>
        </div>
    `;

    document.body.appendChild(toast);

    // Auto-remove after 5s
    setTimeout(() => {
        toast.classList.add('translate-x-full', 'opacity-0');
        setTimeout(() => toast.remove(), 300);
    }, 5000);

    // Click to visit URL
    toast.addEventListener('click', () => {
        if (url && url !== '#') {
            window.location.href = url;
        }
    });
}
