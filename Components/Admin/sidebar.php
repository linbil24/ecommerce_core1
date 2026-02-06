<!-- Sidebar / Navigation -->
<aside id="sidebar" class="sidebar">
    <div class="logo-container">
        <div class="logo-flex">
            <img src="../image/logo.png?v=3.5" alt="Logo" class="logo-img"
                style="height: 2.5rem; width: auto; margin-right: 0.5rem;">
            <span class="logo-text">IMARKETPH | ADMIN </span>
        </div>
    </div>

    <nav class="nav-menu">
        <a href="#" class="nav-item active-nav" onclick="showModule('dashboard', this)">
            <i data-lucide="layout-dashboard" class="w-5 h-5 mr-3"></i>
            Dashboard
        </a>
        <div class="group">
            <a href="#" class="nav-item"
                onclick="toggleSubMenu(this, 'product-submenu'); showSubModule('product', 'products');">
                <i data-lucide="package" class="w-5 h-5 mr-3"></i>
                Product
                <i data-lucide="chevron-right"
                    class="w-4 h-4 ml-auto transition-transform duration-200 chevron-icon"></i>
            </a>
            <div id="product-submenu" class="submenu hidden">
                <a href="#" onclick="showSubModule('product', 'products'); event.preventDefault();">Product Inventory</a>
                <a href="#" onclick="showSubModule('product', 'sellers'); event.preventDefault();">Sellers & Stores</a>
                <a href="#" onclick="showSubModule('product', 'categories'); event.preventDefault();">Category
                    Management</a>
            </div>
        </div>

        <div class="group">
            <a href="#" class="nav-item"
                onclick="toggleSubMenu(this, 'order-submenu'); showSubModule('order', 'orders');">
                <i data-lucide="shopping-cart" class="w-5 h-5 mr-3"></i>
                Order & Checkout
                <i data-lucide="chevron-right"
                    class="w-4 h-4 ml-auto transition-transform duration-200 chevron-icon"></i>
            </a>
            <div id="order-submenu" class="submenu hidden">
                <a href="#" onclick="showSubModule('order', 'orders'); event.preventDefault();">View All Orders</a>
                <a href="#" onclick="showSubModule('order', 'payments'); event.preventDefault();">Transaction
                    Logs</a>
            </div>
        </div>

        <div class="group">
            <a href="#" class="nav-item"
                onclick="toggleSubMenu(this, 'shipping-submenu'); showSubModule('shipping', 'addresses');">
                <i data-lucide="truck" class="w-5 h-5 mr-3"></i>
                Shipping & Address
                <i data-lucide="chevron-right"
                    class="w-4 h-4 ml-auto transition-transform duration-200 chevron-icon"></i>
            </a>
            <div id="shipping-submenu" class="submenu hidden">
                <a href="#" onclick="showSubModule('shipping', 'addresses'); event.preventDefault();">Addresses &
                    Validation</a>
                <a href="#" onclick="showSubModule('shipping', 'tracking'); event.preventDefault();">Shipment
                    Tracking</a>
            </div>
        </div>

        <div class="group">
            <a href="#" class="nav-item"
                onclick="toggleSubMenu(this, 'user-submenu'); showSubModule('user', 'profile');">
                <i data-lucide="users" class="w-5 h-5 mr-3"></i>
                User & Roles
                <i data-lucide="chevron-right"
                    class="w-4 h-4 ml-auto transition-transform duration-200 chevron-icon"></i>
            </a>
            <div id="user-submenu" class="submenu hidden">
                <a href="#" onclick="showSubModule('user', 'profile'); event.preventDefault();">Admin Profile</a>
                <a href="#" onclick="showSubModule('user', 'admins'); event.preventDefault();">Admin Accounts</a>
                <a href="#" onclick="showSubModule('user', 'customers'); event.preventDefault();">Customer List</a>
            </div>
        </div>

        <a href="#" class="nav-item" onclick="showModule('notifications', this)">
            <i data-lucide="alert-triangle" class="w-5 h-5 mr-3"></i>
            Notifications & Alerts
        </a>

        <a href="../CustomerSupport/dashboard.php" class="nav-item">
            <i data-lucide="life-buoy" class="w-5 h-5 mr-3"></i>
            Customer Support Portal
        </a>

        <a href="#" class="nav-item" onclick="showModule('settings', this)">
            <i data-lucide="settings" class="w-5 h-5 mr-3"></i>
            System Settings & Security
        </a>
    </nav>

    <div class="sidebar-footer">
        <p>iMARKET Admin Portal v1.0</p>
    </div>
</aside>