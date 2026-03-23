/**
 * GYM Management - App JavaScript
 */
document.addEventListener('DOMContentLoaded', function () {

    // ── Sidebar Toggle ──
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarClose = document.getElementById('sidebarClose');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            sidebarOverlay?.classList.toggle('active');
        });
    }

    if (sidebarClose) {
        sidebarClose.addEventListener('click', () => {
            sidebar.classList.remove('active');
            sidebarOverlay?.classList.remove('active');
        });
    }

    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', () => {
            sidebar.classList.remove('active');
            sidebarOverlay.classList.remove('active');
        });
    }

    // ── Flash Messages Auto-hide ──
    const flashAlerts = document.querySelectorAll('.flash-alert');
    flashAlerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });

    // ── Active Nav Link ──
    const currentPath = window.location.pathname;
    document.querySelectorAll('.nav-link-item').forEach(link => {
        const href = link.getAttribute('href');
        if (href && currentPath.includes(href.split('/public')[1] || '')) {
            // Skip if it's just '/'
            const path = href.split('/public')[1];
            if (path && path !== '/' && currentPath.includes(path)) {
                document.querySelectorAll('.nav-link-item.active').forEach(a => a.classList.remove('active'));
                link.classList.add('active');
            }
        }
    });

    // ── Confirm Delete ──
    document.querySelectorAll('[data-confirm]').forEach(el => {
        el.addEventListener('click', function (e) {
            if (!confirm(this.dataset.confirm || 'Bạn có chắc chắn muốn xóa?')) {
                e.preventDefault();
            }
        });
    });

    // ── AJAX Helper ──
    window.ajaxRequest = function (url, method = 'GET', data = null) {
        return new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            xhr.open(method, url, true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

            if (data && !(data instanceof FormData)) {
                xhr.setRequestHeader('Content-Type', 'application/json');
                data = JSON.stringify(data);
            }

            xhr.onload = function () {
                if (xhr.status >= 200 && xhr.status < 300) {
                    try {
                        resolve(JSON.parse(xhr.responseText));
                    } catch (e) {
                        resolve(xhr.responseText);
                    }
                } else {
                    reject(xhr.statusText);
                }
            };

            xhr.onerror = () => reject('Network Error');
            xhr.send(data);
        });
    };

    // ── Number Format Helper ──
    window.formatNumber = function (num) {
        return new Intl.NumberFormat('vi-VN').format(num);
    };

    // ── Format Currency ──
    window.formatCurrency = function (amount) {
        return new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        }).format(amount);
    };

    // ── Toast Notification ──
    window.showToast = function (message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `alert alert-${type} flash-alert`;
        toast.style.cssText = 'position:fixed;top:80px;right:24px;z-index:9999;min-width:300px;box-shadow:0 8px 32px rgba(0,0,0,0.3);';
        toast.innerHTML = `
            <i class="bi bi-${type === 'success' ? 'check-circle-fill' : 'exclamation-circle-fill'} me-2"></i>
            ${message}
        `;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(-10px)';
            setTimeout(() => toast.remove(), 500);
        }, 4000);
    };
});
