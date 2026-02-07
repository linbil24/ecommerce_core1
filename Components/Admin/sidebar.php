<!-- Sidebar / Navigation -->
<aside id="sidebar" class="sidebar" style="background: #111827; border-right: 1px solid #1f2937;">
    <div class="logo-container" style="border-bottom: 1px solid #1f2937; padding: 2rem 1.5rem;">
        <div class="logo-flex" style="gap: 12px;">
            <div style="background: #2563eb; padding: 8px; border-radius: 12px;">
                <i data-lucide="layout-grid" style="color: white; width: 24px; height: 24px;"></i>
            </div>
            <span class="logo-text" style="color: white; font-weight: 800; font-size: 1.25rem;">IMARKET <span style="color: #60a5fa;">PH</span></span>
        </div>
    </div>

    <nav class="nav-menu" style="padding: 1.5rem 1rem;">
        <!-- General Section -->
        <p style="font-size: 0.7rem; color: #4b5563; text-transform: uppercase; letter-spacing: 0.1em; font-weight: 800; margin: 1.5rem 1rem 1rem 1rem;">Main Menu</p>
        
        <a href="#" class="nav-item active-nav" onclick="showModule('dashboard', this)">
            <i data-lucide="layout-dashboard"></i>
            Dashboard
        </a>

        <!-- Commerce Engine -->
        <div class="group">
            <a href="#" class="nav-item" onclick="toggleSubMenu(this, 'product-submenu'); showSubModule('product', 'products');">
                <i data-lucide="package"></i>
                Product
                <i data-lucide="chevron-right" class="chevron-icon"></i>
            </a>
            <div id="product-submenu" class="submenu hidden">
                <a href="#" onclick="showSubModule('product', 'products'); event.preventDefault();">Product Inventory</a>
                <a href="#" onclick="showSubModule('product', 'sellers'); event.preventDefault();">Sellers & Stores</a>
                <a href="#" onclick="showSubModule('product', 'categories'); event.preventDefault();">Category Management</a>
            </div>
        </div>

        <div class="group">
            <a href="#" class="nav-item" onclick="toggleSubMenu(this, 'order-submenu'); showSubModule('order', 'orders');">
                <i data-lucide="shopping-cart"></i>
                Order & Checkout
                <i data-lucide="chevron-right" class="chevron-icon"></i>
            </a>
            <div id="order-submenu" class="submenu hidden">
                <a href="#" onclick="showSubModule('order', 'orders'); event.preventDefault();">View All Orders</a>
                <a href="#" onclick="showSubModule('order', 'payments'); event.preventDefault();">Transaction Logs</a>
            </div>
        </div>

        <!-- Logistics -->
        <div class="group">
            <a href="#" class="nav-item" onclick="toggleSubMenu(this, 'shipping-submenu'); showSubModule('shipping', 'addresses');">
                <i data-lucide="truck"></i>
                Shipping & Address
                <i data-lucide="chevron-right" class="chevron-icon"></i>
            </a>
            <div id="shipping-submenu" class="submenu hidden">
                <a href="#" onclick="showSubModule('shipping', 'addresses'); event.preventDefault();">Addresses & Validation</a>
                <a href="#" onclick="showSubModule('shipping', 'tracking'); event.preventDefault();">Shipment Tracking</a>
            </div>
        </div>

        <!-- Governance -->
        <div class="group">
            <a href="#" class="nav-item" onclick="toggleSubMenu(this, 'user-submenu'); showSubModule('user', 'profile');">
                <i data-lucide="users"></i>
                User & Roles
                <i data-lucide="chevron-right" class="chevron-icon"></i>
            </a>
            <div id="user-submenu" class="submenu hidden">
                <a href="#" onclick="showSubModule('user', 'profile'); event.preventDefault();">Admin Profile</a>
                <a href="#" onclick="showSubModule('user', 'admins'); event.preventDefault();">Admin Accounts</a>
                <a href="#" onclick="showSubModule('user', 'customers'); event.preventDefault();">Customer List</a>
            </div>
        </div>

        <!-- System & Support -->
        <p style="font-size: 0.7rem; color: #4b5563; text-transform: uppercase; letter-spacing: 0.1em; font-weight: 800; margin: 2rem 1rem 1rem 1rem;">System</p>

        <a href="#" class="nav-item" onclick="showModule('notifications', this)">
            <i data-lucide="alert-triangle"></i>
            Notifications & Alerts
        </a>

        <a href="../CustomerSupport/dashboard.php" class="nav-item">
            <i data-lucide="life-buoy"></i>
            Customer Support Portal
        </a>

        <a href="#" class="nav-item" onclick="showModule('settings', this)" style="background: #1e3a8a; color: white; margin-top: 1rem; padding: 1rem; border-radius: 12px; box-shadow: 0 4px 12px rgba(30, 58, 138, 0.45);">
            <i data-lucide="settings"></i>
            System Settings & Security
        </a>
    </nav>

    <div class="sidebar-footer" style="background: #0f172a; border-top: 1px solid #1f2937; padding: 1.5rem;">
        <p style="margin: 0; color: #64748b; font-weight: 600;">iMARKET Portal v1.0</p>
    </div>
</aside>
