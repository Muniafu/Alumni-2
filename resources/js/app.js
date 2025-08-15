import './bootstrap';

import Alpine from 'alpinejs';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;
window.Alpine = Alpine;

Alpine.start();

// Initialize Echo for real-time notifications
if (typeof Echo !== 'undefined') {
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: process.env.MIX_PUSHER_APP_KEY,
        cluster: process.env.MIX_PUSHER_APP_CLUSTER,
        encrypted: true,
        forceTLS: true
    });
}

// Notification handling
document.addEventListener('DOMContentLoaded', function() {
    // Mark notification as read when clicked
    document.addEventListener('click', function(e) {
        if (e.target.closest('.mark-as-read')) {
            e.preventDefault();

            const notificationId = e.target.closest('.mark-as-read').getAttribute('data-id');
            const url = e.target.closest('.mark-as-read').getAttribute('href');

            if (notificationId) {
                fetch(`/notifications/mark-as-read/${notificationId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                }).then(() => {
                    // Update notification count
                    const countElement = document.querySelector('.notification-count');
                    if (countElement) {
                        const currentCount = parseInt(countElement.textContent) || 0;
                        if (currentCount > 1) {
                            countElement.textContent = currentCount - 1;
                        } else {
                            countElement.classList.add('hidden');
                        }
                    }

                    // Redirect to the notification URL
                    if (url && url !== '#') {
                        window.location.href = url;
                    }
                });
            }
        }
    });

    // Real-time notifications
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

                // Update notification count
                const countElement = document.querySelector('.notification-count');
                if (countElement) {
                    const currentCount = parseInt(countElement.textContent) || 0;
                    countElement.textContent = currentCount + 1;
                    countElement.classList.remove('hidden');
                }

                // Add to notifications dropdown
                const dropdown = document.querySelector('[x-show="openNotifications"]');
                if (dropdown) {
                    const notificationsList = dropdown.querySelector('.max-h-64');
                    if (notificationsList) {
                        const newNotification = `
                            <a href="${notification.url || '#'}"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 mark-as-read"
                               data-id="${notification.id}">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 pt-0.5">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">${notification.message}</p>
                                        <p class="text-xs text-gray-500">Just now</p>
                                    </div>
                                </div>
                            </a>
                        `;
                        notificationsList.insertAdjacentHTML('afterbegin', newNotification);
                    }
                }

                // Show toast notification
                showToastNotification(notification.message, notification.url);
            });
    }
});

// Message Handling
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Select2 for recipient selection
    if (document.querySelector('#recipients')) {
        $('#recipients').select2({
            placeholder: "Select recipients",
            allowClear: true,
            width: '100%'
        });
    }
});

// Show toast notification
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

    // Auto-remove after 5 seconds
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
