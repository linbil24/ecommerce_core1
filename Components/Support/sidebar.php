<!-- Sidebar / Navigation -->
<aside id="sidebar" class="sidebar">
    <div class="logo-container">
        <div class="logo-flex">
            <img src="../image/logo.png?v=3.5" alt="Logo" class="logo-img"
                style="height: 2.5rem; width: auto; margin-right: 0.5rem;">
            <span class="logo-text">IMARKETPH | SUPPORT </span>
        </div>
    </div>

    <nav class="nav-menu">
        <a href="#" class="nav-item active-nav" onclick="showModule('dashboard', this)">
            <i data-lucide="layout-dashboard" class="w-5 h-5 mr-3"></i>
            Support Dashboard
        </a>

        <a href="#" class="nav-item" onclick="showModule('customers', this)">
            <i data-lucide="users" class="w-5 h-5 mr-3"></i>
            Customer Directory
        </a>
        
        <div class="group">
            <a href="#" class="nav-item"
                onclick="toggleSubMenu(this, 'support-submenu'); showSubModule('support', 'tickets');">
                <i data-lucide="message-square" class="w-5 h-5 mr-3"></i>
                Customer Support Center
                <span id="chatNotificationBadge" class="notification-badge"
                    style="display: none; background: #ef4444; color: white; font-size: 10px; font-weight: 700; padding: 2px 6px; border-radius: 10px; margin-left: 8px; min-width: 18px; text-align: center;"></span>
                <i data-lucide="chevron-right"
                    class="w-4 h-4 ml-auto transition-transform duration-200 chevron-icon"></i>
            </a>
            <div id="support-submenu" class="submenu hidden">
                <a href="#" onclick="showSubModule('support', 'tickets'); event.preventDefault();">Support Tickets</a>
                <a href="#" onclick="showSubModule('support', 'chat'); event.preventDefault();">
                    Store Chat Messages
                    <span id="chatSubNotificationBadge" class="notification-badge"
                        style="display: none; background: #ef4444; color: white; font-size: 9px; font-weight: 700; padding: 2px 5px; border-radius: 8px; margin-left: 6px; min-width: 16px; text-align: center;"></span>
                </a>
            </div>
        </div>

        <a href="#" class="nav-item" onclick="showModule('alerts', this)">
            <i data-lucide="alert-triangle" class="w-5 h-5 mr-3"></i>
            Global Notifications
        </a>

        <a href="../Admin/dashboard.php" class="nav-item">
            <i data-lucide="external-link" class="w-5 h-5 mr-3"></i>
            Back to Admin Portal
        </a>
    </nav>

    <div class="sidebar-footer" style="padding: 1.5rem; font-size: 0.75rem; border-top: 1px solid rgba(255,255,255,0.05); color: rgba(255,255,255,0.4);">
        <p>iMARKET Support Portal v1.0</p>
    </div>
</aside>
