<!-- Notification Bell & Dropdown -->
<style>
    .notif-bell-wrapper {
        position: relative;
    }
    .notif-badge {
        position: absolute;
        top: -4px;
        right: -4px;
        min-width: 18px;
        height: 18px;
        padding: 0 5px;
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        font-size: 10px;
        font-weight: 700;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 6px rgba(239,68,68,0.4);
        animation: notifPulse 2s ease-in-out infinite;
        line-height: 1;
    }
    @keyframes notifPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.15); }
    }
    .notif-panel {
        position: fixed;
        top: 0;
        right: -420px;
        width: 400px;
        height: 100vh;
        background: white;
        border-left: 1px solid #e5e7eb;
        box-shadow: -8px 0 30px rgba(0,0,0,0.08);
        z-index: 9998;
        transition: right 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        flex-direction: column;
    }
    .notif-panel.open {
        right: 0;
    }
    .notif-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.2);
        backdrop-filter: blur(2px);
        z-index: 9997;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
    }
    .notif-overlay.open {
        opacity: 1;
        pointer-events: auto;
    }
    .notif-panel-header {
        padding: 20px 24px;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-shrink: 0;
    }
    .notif-panel-body {
        flex: 1;
        overflow-y: auto;
        padding: 16px;
    }
    .notif-section-title {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 8px 8px 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .notif-card {
        padding: 14px 16px;
        border-radius: 12px;
        margin-bottom: 8px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
        cursor: default;
    }
    .notif-card:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    }
    .notif-card-expired {
        background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
        border: 1px solid #fecaca;
    }
    .notif-card-expiring {
        background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
        border: 1px solid #fde68a;
    }
    .notif-card-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .notif-card-expired .notif-card-icon {
        background: #ef4444;
        color: white;
    }
    .notif-card-expiring .notif-card-icon {
        background: #f59e0b;
        color: white;
    }
    .notif-card-title {
        font-weight: 600;
        font-size: 13px;
        color: #1f2937;
        margin-bottom: 4px;
    }
    .notif-card-meta {
        font-size: 12px;
        color: #6b7280;
        display: flex;
        flex-wrap: wrap;
        gap: 6px 14px;
    }
    .notif-card-meta span {
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .notif-empty {
        text-align: center;
        padding: 48px 24px;
        color: #9ca3af;
    }
    .notif-empty svg {
        margin: 0 auto 16px;
    }
    .notif-tab-bar {
        display: flex;
        gap: 4px;
        padding: 0 16px;
        border-bottom: 1px solid #f3f4f6;
        flex-shrink: 0;
    }
    .notif-tab {
        padding: 10px 16px;
        font-size: 13px;
        font-weight: 600;
        color: #9ca3af;
        border-bottom: 2px solid transparent;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .notif-tab:hover {
        color: #6b7280;
    }
    .notif-tab.active {
        color: #1f2937;
        border-bottom-color: #3b82f6;
    }
    .notif-tab .tab-count {
        background: #f3f4f6;
        padding: 1px 7px;
        border-radius: 10px;
        font-size: 11px;
        font-weight: 700;
    }
    .notif-tab.active .tab-count {
        background: #dbeafe;
        color: #1d4ed8;
    }
    .notif-bell-btn {
        position: relative;
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
        background: transparent;
    }
    .notif-bell-btn:hover {
        background: #f3f4f6;
    }
    .notif-bell-btn.has-alerts {
        background: #fef2f2;
    }
    .notif-bell-btn.has-alerts:hover {
        background: #fee2e2;
    }
    .notif-bell-btn.has-alerts svg {
        color: #ef4444;
        animation: bellShake 3s ease-in-out infinite;
    }
    @keyframes bellShake {
        0%, 90%, 100% { transform: rotate(0deg); }
        92% { transform: rotate(8deg); }
        94% { transform: rotate(-8deg); }
        96% { transform: rotate(5deg); }
        98% { transform: rotate(-3deg); }
    }
</style>

<div class="notif-overlay" id="notifOverlay" onclick="toggleNotifPanel()"></div>
<div class="notif-panel" id="notifPanel">
    <div class="notif-panel-header">
        <div>
            <h3 style="font-size:16px;font-weight:700;color:#1f2937;margin:0;">Notifikasi Kadaluwarsa</h3>
            <p style="font-size:12px;color:#9ca3af;margin:4px 0 0;" id="notifSubtitle">Memuat...</p>
        </div>
        <button onclick="toggleNotifPanel()" style="width:32px;height:32px;border-radius:8px;border:none;background:#f3f4f6;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:background 0.2s;" onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">
            <svg width="16" height="16" fill="none" stroke="#6b7280" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
    <div class="notif-tab-bar">
        <div class="notif-tab active" data-tab="all" onclick="switchNotifTab('all')">
            Semua <span class="tab-count" id="tabCountAll">0</span>
        </div>
        <div class="notif-tab" data-tab="expired" onclick="switchNotifTab('expired')">
            Kadaluwarsa <span class="tab-count" id="tabCountExpired">0</span>
        </div>
        <div class="notif-tab" data-tab="expiring" onclick="switchNotifTab('expiring')">
            Segera <span class="tab-count" id="tabCountExpiring">0</span>
        </div>
    </div>
    <div class="notif-panel-body" id="notifPanelBody">
        <div class="notif-empty">
            <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p style="font-weight:600;font-size:14px;margin-bottom:4px;">Semua obat aman</p>
            <p style="font-size:12px;">Tidak ada obat yang kadaluwarsa atau mendekati kadaluwarsa.</p>
        </div>
    </div>
</div>

<script>
let notifData = null;
let currentNotifTab = 'all';

function toggleNotifPanel() {
    const panel = document.getElementById('notifPanel');
    const overlay = document.getElementById('notifOverlay');
    const isOpen = panel.classList.contains('open');
    
    if (!isOpen) {
        panel.classList.add('open');
        overlay.classList.add('open');
        if (!notifData) fetchNotifData();
    } else {
        panel.classList.remove('open');
        overlay.classList.remove('open');
    }
}

function switchNotifTab(tab) {
    currentNotifTab = tab;
    document.querySelectorAll('.notif-tab').forEach(t => {
        t.classList.toggle('active', t.getAttribute('data-tab') === tab);
    });
    renderNotifCards();
}

function fetchNotifData() {
    fetch('../Backend/get_kadaluwarsa.php')
        .then(r => r.json())
        .then(data => {
            notifData = data;
            document.getElementById('tabCountAll').textContent = data.total_alerts;
            document.getElementById('tabCountExpired').textContent = data.total_expired;
            document.getElementById('tabCountExpiring').textContent = data.total_expiring_soon;
            
            // Update badge
            const badge = document.getElementById('notifBadge');
            const bellBtn = document.getElementById('notifBellBtn');
            if (data.total_alerts > 0) {
                badge.textContent = data.total_alerts > 99 ? '99+' : data.total_alerts;
                badge.style.display = 'flex';
                bellBtn.classList.add('has-alerts');
            } else {
                badge.style.display = 'none';
                bellBtn.classList.remove('has-alerts');
            }
            
            document.getElementById('notifSubtitle').textContent = 
                data.total_alerts > 0 
                    ? `${data.total_alerts} obat perlu perhatian`
                    : 'Semua obat dalam kondisi aman';
            
            renderNotifCards();
        })
        .catch(err => {
            console.error('Error fetching notifications:', err);
            document.getElementById('notifPanelBody').innerHTML = `
                <div class="notif-empty">
                    <svg width="48" height="48" fill="none" stroke="#ef4444" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <p style="font-weight:600;font-size:14px;margin-bottom:4px;color:#991b1b;">Gagal memuat data</p>
                    <p style="font-size:12px;">Silakan coba lagi nanti.</p>
                </div>
            `;
        });
}

function renderNotifCards() {
    if (!notifData) return;
    
    const body = document.getElementById('notifPanelBody');
    let items = [];
    
    if (currentNotifTab === 'all' || currentNotifTab === 'expired') {
        items = items.concat(notifData.expired.map(i => ({...i, _type: 'expired'})));
    }
    if (currentNotifTab === 'all' || currentNotifTab === 'expiring') {
        items = items.concat(notifData.expiring_soon.map(i => ({...i, _type: 'expiring'})));
    }
    
    if (items.length === 0) {
        const label = currentNotifTab === 'expired' ? 'kadaluwarsa' : 
                      currentNotifTab === 'expiring' ? 'mendekati kadaluwarsa' : 'perlu perhatian';
        body.innerHTML = `
            <div class="notif-empty">
                <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p style="font-weight:600;font-size:14px;margin-bottom:4px;">Aman!</p>
                <p style="font-size:12px;">Tidak ada obat yang ${label}.</p>
            </div>
        `;
        return;
    }
    
    let html = '';
    
    // Expired section
    const expiredItems = items.filter(i => i._type === 'expired');
    const expiringItems = items.filter(i => i._type === 'expiring');
    
    if (expiredItems.length > 0) {
        html += `<div class="notif-section-title" style="color:#dc2626;">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            Sudah Kadaluwarsa (${expiredItems.length})
        </div>`;
        expiredItems.forEach(item => {
            const days = Math.abs(item.sisa_hari);
            html += buildNotifCard(item, 'expired', `${days} hari lalu`);
        });
    }
    
    if (expiringItems.length > 0) {
        html += `<div class="notif-section-title" style="color:#d97706;margin-top:${expiredItems.length > 0 ? '12px' : '0'};">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Segera Kadaluwarsa (${expiringItems.length})
        </div>`;
        expiringItems.forEach(item => {
            const label = item.sisa_hari === 0 ? 'Hari ini' : `${item.sisa_hari} hari lagi`;
            html += buildNotifCard(item, 'expiring', label);
        });
    }
    
    body.innerHTML = html;
}

function buildNotifCard(item, type, daysLabel) {
    const iconSvg = type === 'expired' 
        ? '<svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>'
        : '<svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
    
    const expDate = new Date(item.kadaluwarsa).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
    
    return `
        <div class="notif-card notif-card-${type}">
            <div class="notif-card-icon">${iconSvg}</div>
            <div style="flex:1;min-width:0;">
                <div class="notif-card-title">${escapeHtml(item.nama_obat)}</div>
                <div class="notif-card-meta">
                    <span>
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        ${expDate}
                    </span>
                    <span>
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        ${daysLabel}
                    </span>
                    <span>
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        Stok: ${item.total_stock} ${escapeHtml(item.satuan)}
                    </span>
                </div>
            </div>
        </div>
    `;
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Auto-fetch notification data on page load for badge count
document.addEventListener('DOMContentLoaded', function() {
    fetch('../Backend/get_kadaluwarsa.php')
        .then(r => r.json())
        .then(data => {
            notifData = data;
            const badge = document.getElementById('notifBadge');
            const bellBtn = document.getElementById('notifBellBtn');
            
            if (data.total_alerts > 0) {
                badge.textContent = data.total_alerts > 99 ? '99+' : data.total_alerts;
                badge.style.display = 'flex';
                bellBtn.classList.add('has-alerts');
            } else {
                badge.style.display = 'none';
                bellBtn.classList.remove('has-alerts');
            }
            
            // Show toast for expired items on page load
            if (data.total_expired > 0) {
                setTimeout(() => {
                    if (typeof showToast === 'function') {
                        showToast(`⚠️ ${data.total_expired} obat sudah kadaluwarsa! Segera periksa dan tarik dari peredaran.`, 'error', 6000);
                    }
                }, 500);
            }
            if (data.total_expiring_soon > 0) {
                setTimeout(() => {
                    if (typeof showToast === 'function') {
                        showToast(`📋 ${data.total_expiring_soon} obat akan kadaluwarsa dalam 30 hari.`, 'warning', 5000);
                    }
                }, data.total_expired > 0 ? 1500 : 500);
            }
        })
        .catch(err => console.error('Notif fetch error:', err));
});
</script>
