import './bootstrap';
import Alpine from 'alpinejs';

// Initialize Alpine.js
window.Alpine = Alpine;
Alpine.start();

// Notification handling
document.addEventListener('DOMContentLoaded', () => {
    const notificationContainer = document.getElementById('notification-container');
    
    if (notificationContainer) {
        notificationContainer.addEventListener('click', function (event) {
            if (event.target.matches('.mark-as-read')) {
                const button = event.target;
                const notificationId = button.dataset.id;
                const notificationDiv = button.closest('.alert');
                
                button.disabled = true;

                axios.post(`/notifications/${notificationId}/read`, {
                    _token: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                })
                .then(response => {
                    if (response.data.success) {
                        notificationDiv.style.transition = 'opacity 0.3s ease';
                        notificationDiv.style.opacity = '0';
                        
                        setTimeout(() => {
                            notificationDiv.remove();
                            
                            if (!notificationContainer.querySelector('.alert')) {
                                notificationContainer.innerHTML = '<p class="text-center text-gray-500 text-sm py-4">No new notifications</p>';
                            }
                        }, 300);
                    } else {
                        button.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Notification update failed:', error);
                    button.disabled = false;
                });
            }
        });
    }

    // Initialize dropdowns separately
    const dropdownToggles = document.querySelectorAll('[x-data]');
    dropdownToggles.forEach(toggle => {
        
        if (toggle.__x) return;
        
        toggle.addEventListener('click', (e) => {
            e.stopPropagation();
            const menu = toggle.querySelector('.dropdown-menu') || toggle.nextElementSibling;
            if (menu && menu.classList.contains('dropdown-menu')) {
                const isVisible = menu.style.display === 'block';
                menu.style.display = isVisible ? 'none' : 'block';
            }
        });
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', (e) => {
        if (!e.target.closest('[x-data]')) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.style.display = 'none';
            });
        }
    });
});

// Chart.js initialization
if (typeof Chart !== 'undefined') {
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('sales-chart')?.getContext('2d');
        if (ctx && window.chartLabels && window.salesData) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: window.chartLabels,
                    datasets: [{
                        label: 'Daily Sales',
                        data: window.salesData,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1
                    }]
                }
            });
        }
    });
}