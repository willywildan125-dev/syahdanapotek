<!-- Toast Notification System -->
<div id="toastContainer" style="position:fixed;top:24px;right:24px;z-index:9999;display:flex;flex-direction:column;gap:12px;pointer-events:none;"></div>
<style>
@keyframes toastSlideIn {
    from { transform: translateX(120%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}
@keyframes toastSlideOut {
    from { transform: translateX(0); opacity: 1; }
    to { transform: translateX(120%); opacity: 0; }
}
.toast-item {
    pointer-events: auto;
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 320px;
    max-width: 420px;
    padding: 16px 20px;
    border-radius: 14px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.12), 0 2px 8px rgba(0,0,0,0.06);
    animation: toastSlideIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.15);
    cursor: pointer;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.toast-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 40px rgba(0,0,0,0.16), 0 4px 12px rgba(0,0,0,0.08);
}
.toast-item.toast-exit {
    animation: toastSlideOut 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
.toast-success {
    background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
    border-color: #6ee7b7;
    color: #065f46;
}
.toast-error {
    background: linear-gradient(135deg, #fef2f2 0%, #fecaca 100%);
    border-color: #fca5a5;
    color: #991b1b;
}
.toast-warning {
    background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
    border-color: #fcd34d;
    color: #92400e;
}
.toast-info {
    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
    border-color: #93c5fd;
    color: #1e40af;
}
.toast-icon {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.toast-success .toast-icon { background: #10b981; color: white; }
.toast-error .toast-icon { background: #ef4444; color: white; }
.toast-warning .toast-icon { background: #f59e0b; color: white; }
.toast-info .toast-icon { background: #3b82f6; color: white; }
.toast-progress {
    position: absolute;
    bottom: 0;
    left: 16px;
    right: 16px;
    height: 3px;
    border-radius: 3px;
    overflow: hidden;
    background: rgba(0,0,0,0.06);
}
.toast-progress-bar {
    height: 100%;
    border-radius: 3px;
    animation: toastProgress linear forwards;
}
.toast-success .toast-progress-bar { background: #10b981; }
.toast-error .toast-progress-bar { background: #ef4444; }
.toast-warning .toast-progress-bar { background: #f59e0b; }
.toast-info .toast-progress-bar { background: #3b82f6; }
@keyframes toastProgress {
    from { width: 100%; }
    to { width: 0%; }
}
</style>
<script>
function showToast(message, type = 'info', duration = 3500) {
    const container = document.getElementById('toastContainer');
    const toast = document.createElement('div');
    toast.className = `toast-item toast-${type}`;
    toast.style.position = 'relative';
    
    const icons = {
        success: '<svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>',
        error: '<svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>',
        warning: '<svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>',
        info: '<svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
    };
    
    toast.innerHTML = `
        <div class="toast-icon">${icons[type] || icons.info}</div>
        <div style="flex:1;">
            <div style="font-weight:600;font-size:14px;line-height:1.4;">${message}</div>
        </div>
        <div class="toast-progress"><div class="toast-progress-bar" style="animation-duration:${duration}ms;"></div></div>
    `;
    
    toast.addEventListener('click', () => dismissToast(toast));
    container.appendChild(toast);
    
    setTimeout(() => dismissToast(toast), duration);
}

function dismissToast(toast) {
    if (toast.classList.contains('toast-exit')) return;
    toast.classList.add('toast-exit');
    setTimeout(() => toast.remove(), 300);
}
</script>
