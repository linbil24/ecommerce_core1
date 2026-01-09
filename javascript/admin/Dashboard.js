// --- UTILITY FUNCTIONS ---
function setPageTitle(title) {
    // Update the large title in the content area
    const contentHeader = document.querySelector('#content-container .page-header');
    if (contentHeader) {
        contentHeader.innerText = title;
    }
    // Update the invisible title used in the header bar for alignment
    document.getElementById('page-title').innerText = title;
}

function setActiveNav(element) {
    // Reset all nav items
    document.querySelectorAll('.nav-menu a').forEach(item => {
        item.classList.remove('active-nav');
        // Also reset rotation on chevron icons
        const icon = item.querySelector('.chevron-icon');
        if (icon) {
            icon.classList.remove('rotate-90');
        }
    });
    // Set the main element to active
    element.classList.add('active-nav');
}

function toggleSubMenu(element, submenuId) {
    const submenu = document.getElementById(submenuId);
    const icon = element.querySelector('.chevron-icon');

    submenu.classList.toggle('hidden');
    icon.classList.toggle('rotate-90');

    event.preventDefault();
}

// Custom Modal Implementation (Replaces alert/confirm)
function showCustomActionModal(title, message, confirmText = 'OK', actionCallback = null) {
    const backdrop = document.getElementById('custom-modal-backdrop');
    const modalContainer = document.getElementById('modal-container');

    // Simple markup for bolding **text**
    const safeMessage = message
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/\*\*(.*?)\*\*/g, '<b>$1</b>');

    modalContainer.innerHTML = `
                <h3 id="modal-title" class="modal-title" style="font-size: 1.25rem; font-weight: 700; color: #1f2937;">${title}</h3>
                <p id="modal-message" class="modal-message" style="font-size: 1rem; color: var(--color-gray-500); margin-bottom: 1.5rem;">${safeMessage}</p>
                <div class="modal-actions" style="display: flex; justify-content: flex-end; column-gap: 0.75rem;">
                    <button id="modal-cancel" class="btn-base btn-secondary hidden">Cancel</button>
                    <button id="modal-confirm" class="btn-base btn-primary">${confirmText}</button>
                </div>
            `;

    const confirmBtn = document.getElementById('modal-confirm');
    const cancelBtn = document.getElementById('modal-cancel');

    if (actionCallback) {
        cancelBtn.classList.remove('hidden');
        cancelBtn.onclick = () => backdrop.classList.add('hidden');
        confirmBtn.onclick = () => {
            actionCallback();
            backdrop.classList.add('hidden');
        };
    } else {
        cancelBtn.classList.add('hidden');
        confirmBtn.onclick = () => backdrop.classList.add('hidden');
    }

    backdrop.classList.remove('hidden');
}

// --- MAIN CONTENT FUNCTIONS (MODULES - ENHANCED) ---

// Helper function for KPI Card HTML
function createKPICard(title, value, iconName, kpiClass) {
    return `
                <div class="kpi-card ${kpiClass}">
                    <div class="card-content" style="display: flex; align-items: center; justify-content: space-between;">
                        <div style="flex: 1;">
                            <p class="card-title" style="font-size: 0.875rem; font-weight: 600; color: var(--color-gray-500); margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">${title}</p>
                            <h2 class="card-value" style="font-size: 2rem; font-weight: 800; line-height: 1.2; margin: 0;">${value}</h2>
                        </div>
                        <div class="card-icon" style="padding: 1rem; border-radius: 1rem; width: 4.5rem; height: 4.5rem; display: flex; align-items: center; justify-content: center; transition: transform 0.3s;">
                            <i data-lucide="${iconName}" style="width: 2rem; height: 2rem;"></i>
                        </div>
                    </div>
                </div>
            `;
}

// 4. Dashboard & Analytics
function renderDashboard() {
    setPageTitle('Dashboard & Analytics');
    const content = document.getElementById('content-container');

    content.innerHTML = '';
    lucide.createIcons();
}

// 1. Product & Storefront Management
function renderProductModule(submodule) {
    setPageTitle('Product & Storefront Management');
    const content = document.getElementById('content-container');
    let moduleTitle = 'Product & Storefront Management';
    let submoduleContent = '';

    const getProductStatusBadge = (stock) => {
        if (stock >= 50) return 'active';
        if (stock >= 10 && stock < 50) return 'low-stock';
        if (stock < 10) return 'critical-stock';
        return 'inactive';
    };

    const productRows = productsData.map((p, index) => {
        const statusClass = p.status === 'Active' ? 'active' : (p.status === 'Low Stock' ? 'low-stock' : (p.status === 'Critical Stock' ? 'critical-stock' : 'inactive'));
        return `
                <tr style="transition: all 0.2s; border-bottom: 1px solid #f3f4f6;" 
                    onmouseover="this.style.backgroundColor='#f9fafb'; this.style.transform='scale(1.01)';" 
                    onmouseout="this.style.backgroundColor='transparent'; this.style.transform='scale(1)';">
                    <td style="padding: 1rem 1.5rem; color: #6b7280; font-weight: 600; font-size: 0.875rem;">#${p.id}</td>
                    <td style="padding: 1rem 1.5rem;">
                        <div style="color: #1f2937; font-weight: 600; font-size: 0.9375rem; margin-bottom: 0.25rem;">${p.name}</div>
                        ${p.description ? `<div style="color: #6b7280; font-size: 0.8125rem; line-height: 1.4; max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">${p.description.substring(0, 60)}${p.description.length > 60 ? '...' : ''}</div>` : ''}
                    </td>
                    <td style="padding: 1rem 1.5rem;">
                        <span style="color: #059669; font-weight: 700; font-size: 1rem;">${formatCurrency(parseFloat(p.price))}</span>
                    </td>
                    <td style="padding: 1rem 1.5rem;">
                        <span class="status-badge ${getProductStatusBadge(parseInt(p.stock))}" style="font-weight: 600; padding: 0.375rem 0.75rem; border-radius: 0.375rem; font-size: 0.8125rem;">${p.stock} units</span>
                    </td>
                    <td style="padding: 1rem 1.5rem;">
                        <span style="display: inline-flex; align-items: center; gap: 0.375rem; background: #e0e7ff; color: #4f46e5; padding: 0.375rem 0.75rem; border-radius: 0.375rem; font-size: 0.8125rem; font-weight: 500;">
                            <i data-lucide="tag" style="width: 0.75rem; height: 0.75rem;"></i>
                            ${p.category || 'N/A'}
                        </span>
                    </td>
                    <td style="padding: 1rem 1.5rem;">
                        <span class="status-badge ${statusClass}" style="font-weight: 600; padding: 0.375rem 0.75rem; border-radius: 0.375rem; font-size: 0.8125rem; text-transform: capitalize;">${p.status}</span>
                    </td>
                    <td style="padding: 1rem 1.5rem; width: 200px;">
                        <div style="display: flex; gap: 0.5rem; align-items: center; justify-content: center;">
                            <button class="btn-base" 
                                onclick="showProductForm(${p.id})" 
                                title="Edit Product"
                                style="padding: 0.5rem 0.875rem; font-size: 0.8125rem; background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; border-radius: 0.5rem; font-weight: 500; display: flex; align-items: center; gap: 0.375rem; transition: all 0.2s; cursor: pointer;"
                                onmouseover="this.style.background='#dbeafe'; this.style.borderColor='#93c5fd'; this.style.transform='translateY(-1px)'"
                                onmouseout="this.style.background='#eff6ff'; this.style.borderColor='#bfdbfe'; this.style.transform='translateY(0)'">
                                <i data-lucide="edit-2" style="width: 0.875rem; height: 0.875rem;"></i>
                                <span>Edit</span>
                            </button>
                            <button class="btn-base"
                                onclick="deleteProduct(${p.id}, '${p.name.replace(/'/g, "\\'")}')" 
                                title="Delete Product"
                                style="padding: 0.5rem 0.875rem; font-size: 0.8125rem; background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; border-radius: 0.5rem; font-weight: 500; display: flex; align-items: center; gap: 0.375rem; transition: all 0.2s; cursor: pointer;"
                                onmouseover="this.style.background='#fee2e2'; this.style.borderColor='#fca5a5'; this.style.transform='translateY(-1px)'"
                                onmouseout="this.style.background='#fef2f2'; this.style.borderColor='#fecaca'; this.style.transform='translateY(0)'">
                                <i data-lucide="trash-2" style="width: 0.875rem; height: 0.875rem;"></i>
                                <span>Delete</span>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
    }).join('');


    switch (submodule) {
        case 'products':
            moduleTitle = 'Product List (Inventory & Pricing)';
            submoduleContent = `
                                    <div class="mb-6">
                                        <!-- Header Section -->
                                        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 0.75rem; padding: 2rem; margin-bottom: 1.5rem; color: white;">
                                            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                                                <div>
                                                    <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem; color: white;">Product Management</h2>
                                                    <p style="opacity: 0.9; font-size: 0.9375rem; margin: 0;">Manage your product inventory. Add, edit, or delete products easily.</p>
                                                </div>
                                                <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                                                    ${productsData.length > 0 ? `
                                        <button class="btn-base" onclick="clearAllProducts()" 
                                            style="background: rgba(255, 255, 255, 0.2); color: white; border: 1px solid rgba(255, 255, 255, 0.3); padding: 0.625rem 1.25rem; font-weight: 500; transition: all 0.2s;"
                                            onmouseover="this.style.background='rgba(255, 255, 255, 0.3)'" 
                                            onmouseout="this.style.background='rgba(255, 255, 255, 0.2)'">
                                            <i data-lucide="trash-2" style="width: 1rem; height: 1rem; margin-right: 0.5rem;"></i>
                                            Clear All
                                        </button>
                                        ` : ''}
                                                    <button class="btn-base" onclick="showProductForm()" 
                                                        style="background: white; color: #667eea; padding: 0.625rem 1.25rem; font-weight: 600; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); transition: all 0.2s;"
                                                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 12px -1px rgba(0, 0, 0, 0.15)'" 
                                                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px -1px rgba(0, 0, 0, 0.1)'">
                                                        <i data-lucide="plus" style="width: 1rem; height: 1rem; margin-right: 0.5rem;"></i>
                                                        Add New Product
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                            
                                        ${productsData.length === 0 ? `
                            <div class="kpi-card p-8 mb-4" style="background: linear-gradient(135deg, #f0f9ff 0%, #e0e7ff 100%); border: 2px dashed #c7d2fe; text-align: center; border-radius: 1rem;">
                                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                                    <i data-lucide="package" style="width: 2.5rem; height: 2.5rem; color: white;"></i>
                                </div>
                                <h3 style="font-size: 1.5rem; font-weight: 700; color: #1f2937; margin-bottom: 0.75rem;">No Products Yet</h3>
                                <p style="color: #6b7280; font-size: 1rem; margin-bottom: 2rem; max-width: 500px; margin-left: auto; margin-right: auto;">Start building your inventory by adding your first product. You can manage all your products from here.</p>
                                <button class="btn-base" onclick="showProductForm()" 
                                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-weight: 600; padding: 0.875rem 2rem; border-radius: 0.5rem; box-shadow: 0 4px 6px -1px rgba(102, 126, 234, 0.4); transition: all 0.2s;"
                                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 12px -1px rgba(102, 126, 234, 0.5)'" 
                                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px -1px rgba(102, 126, 234, 0.4)'">
                                    <i data-lucide="plus" style="width: 1.125rem; height: 1.125rem; margin-right: 0.5rem;"></i>
                                    Add Your First Product
                                </button>
                            </div>
                            ` : ''}
                                    </div>
                        
                                    <!-- Products Table Card -->
                                    <div class="kpi-card" style="padding: 0; overflow: hidden; border-radius: 0.75rem; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);">
                                        <div style="background: #f9fafb; padding: 1.25rem 1.5rem; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
                                            <div>
                                                <h3 style="font-size: 1.125rem; font-weight: 700; color: #1f2937; margin: 0;">Product Inventory</h3>
                                                <p style="font-size: 0.875rem; color: #6b7280; margin: 0.25rem 0 0 0;">${productsData.length} ${productsData.length === 1 ? 'product' : 'products'} in your inventory</p>
                                            </div>
                                            <div style="display: flex; align-items: center; gap: 0.5rem; background: white; padding: 0.5rem 0.75rem; border-radius: 0.5rem; border: 1px solid #e5e7eb;">
                                                <i data-lucide="package" style="width: 1rem; height: 1rem; color: #667eea;"></i>
                                                <span style="font-weight: 600; color: #1f2937; font-size: 0.875rem;">${productsData.length}</span>
                                            </div>
                                        </div>
                                        <div class="table-container" style="overflow-x: auto;">
                                            <table class="data-table" style="margin: 0;">
                                                <thead>
                                                    <tr style="background: #f9fafb;">
                                                        <th style="padding: 1rem 1.5rem; font-weight: 600; color: #374151; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 2px solid #e5e7eb;">ID</th>
                                                        <th style="padding: 1rem 1.5rem; font-weight: 600; color: #374151; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 2px solid #e5e7eb;">Product Name</th>
                                                        <th style="padding: 1rem 1.5rem; font-weight: 600; color: #374151; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 2px solid #e5e7eb;">Price</th>
                                                        <th style="padding: 1rem 1.5rem; font-weight: 600; color: #374151; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 2px solid #e5e7eb;">Stock</th>
                                                        <th style="padding: 1rem 1.5rem; font-weight: 600; color: #374151; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 2px solid #e5e7eb;">Category</th>
                                                        <th style="padding: 1rem 1.5rem; font-weight: 600; color: #374151; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 2px solid #e5e7eb;">Status</th>
                                                        <th style="padding: 1rem 1.5rem; font-weight: 600; color: #374151; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 2px solid #e5e7eb; text-align: center;">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    ${productsData.length > 0 ? productRows : `
                                        <tr>
                                            <td colspan="7" style="text-align: center; padding: 3rem; color: #9ca3af;">
                                                <i data-lucide="package-x" style="width: 3rem; height: 3rem; margin: 0 auto 1rem; display: block; opacity: 0.5;"></i>
                                                <p style="font-size: 1rem; font-weight: 500; margin-bottom: 0.5rem;">No products found</p>
                                                <p style="font-size: 0.875rem;">Click "Add New Product" to create your first product.</p>
                                            </td>
                                        </tr>
                                        `}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                `;
            break;
        case 'categories':
            moduleTitle = 'Category Management';
            const categoryRows = categoriesData.map(cat => `
                                    <tr>
                                        <td>${cat.id}</td>
                                        <td style="color: #1f2937; font-weight: 500;">${cat.name}</td>
                                        <td>${cat.description || 'N/A'}</td>
                                        <td><span class="status-badge ${cat.status === 'Active' ? 'active' : 'inactive'}">${cat.status}</span></td>
                                        <td style="width: 150px;">
                                            <button class="btn-base" style="padding: 0.25rem 0.5rem; margin-right: 0.5rem; background-color: var(--color-light-grey);" 
                                                onclick="showCategoryForm(${cat.id})">
                                                <i data-lucide="edit" style="width: 1rem; height: 1rem;"></i>
                                            </button>
                                            <button class="btn-base" style="padding: 0.25rem 0.5rem; background-color: var(--color-red-600); color: white;"
                                                onclick="deleteCategory(${cat.id}, '${cat.name}')">
                                                <i data-lucide="trash-2" style="width: 1rem; height: 1rem;"></i>
                                            </button>
                                        </td>
                                    </tr>
                                `).join('');

            submoduleContent = `
                                    <div class="mb-6 flex justify-between items-center">
                                        <p class="text-gray-500">Create and manage product categories.</p>
                                        <button class="btn-base btn-primary text-sm" onclick="showCategoryForm()">
                                            <i data-lucide="plus" style="width: 1rem; height: 1rem; margin-right: 0.5rem;"></i>
                                            Add New Category
                                        </button>
                                    </div>
                                    <div class="kpi-card p-6">
                                        <h3 class="text-xl font-semibold mb-4">Category List (${categoriesData.length} Categories)</h3>
                                        <div class="table-container" style="overflow-x: auto;">
                                            <table class="data-table">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Name</th>
                                                        <th>Description</th>
                                                        <th>Status</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    ${categoriesData.length > 0 ? categoryRows : `<tr><td colspan="5" class="text-center text-gray-500 py-4">No categories found. Click "Add New Category" to create one.</td></tr>`}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                `;
            break;
        case 'storefront':
            moduleTitle = 'Storefront Preview';
            const activeProducts = productsData.filter(p => p.status === 'Active').slice(0, 6);
            const productCards = activeProducts.map(p => `
                                    <div style="border: 1px solid #e5e7eb; border-radius: 0.75rem; overflow: hidden; background: white; transition: transform 0.2s, box-shadow 0.2s;" 
                                         onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 10px 15px -3px rgba(0,0,0,0.1)'"
                                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                        <div style="width: 100%; height: 200px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem; font-weight: bold;">
                                            ${p.name.charAt(0)}
                                        </div>
                                        <div style="padding: 1rem;">
                                            <h4 style="font-weight: 600; color: #1f2937; margin-bottom: 0.5rem; font-size: 1rem;">${p.name}</h4>
                                            <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.75rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">${p.description || 'No description'}</p>
                                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                                <span style="font-size: 1.25rem; font-weight: 700; color: #1f2937;">${formatCurrency(parseFloat(p.price))}</span>
                                                <span class="status-badge ${p.stock < 10 ? 'low-stock' : 'active'}" style="font-size: 0.75rem;">Stock: ${p.stock}</span>
                                            </div>
                                        </div>
                                    </div>
                                `).join('');

            submoduleContent = `
                                    <p class="mb-6 text-gray-500">Preview how products appear to customers on the storefront.</p>
                                    <div class="kpi-card p-6">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                                            <h3 class="text-xl font-semibold">Storefront Preview</h3>
                                            <div style="display: flex; gap: 0.5rem;">
                                                <button class="btn-base btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                                                    <i data-lucide="monitor" style="width: 1rem; height: 1rem; margin-right: 0.5rem;"></i>
                                                    Desktop
                                                </button>
                                                <button class="btn-base btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                                                    <i data-lucide="smartphone" style="width: 1rem; height: 1rem; margin-right: 0.5rem;"></i>
                                                    Mobile
                                                </button>
                                            </div>
                                        </div>
                                        <div style="border: 2px solid #e5e7eb; border-radius: 0.75rem; overflow: hidden; background-color: #f9fafb;">
                                            <div style="background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-dark-grey) 100%); color: white; padding: 1rem; display: flex; justify-content: space-between; align-items: center;">
                                                <div>
                                                    <h4 style="font-size: 1.25rem; font-weight: 700; margin: 0;">iMARKET Store</h4>
                                                    <p style="font-size: 0.875rem; margin: 0.25rem 0 0 0; opacity: 0.9;">Your one-stop shop</p>
                                                </div>
                                                <div style="display: flex; gap: 1rem; align-items: center;">
                                                    <i data-lucide="search" style="width: 1.25rem; height: 1.25rem; opacity: 0.9;"></i>
                                                    <i data-lucide="shopping-cart" style="width: 1.25rem; height: 1.25rem; opacity: 0.9;"></i>
                                                </div>
                                            </div>
                                            <div style="padding: 1.5rem;">
                                                <div style="margin-bottom: 1.5rem;">
                                                    <h5 style="font-size: 1.125rem; font-weight: 600; color: #1f2937; margin-bottom: 1rem;">Featured Products</h5>
                                                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1.5rem;">
                                                        ${productCards}
                                                    </div>
                                                </div>
                                                <div style="text-align: center; padding: 2rem; background: #f3f4f6; border-radius: 0.5rem;">
                                                    <p style="color: #6b7280; margin: 0;">Showing ${activeProducts.length} of ${productsData.filter(p => p.status === 'Active').length} active products</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;
            break;
    }

    content.innerHTML = `<h2 class="page-header">${moduleTitle}</h2>${submoduleContent}`;
    lucide.createIcons();
}

// 2. Order & Checkout Management
function renderOrderModule(submodule) {
    setPageTitle('Order & Checkout Management');
    const content = document.getElementById('content-container');
    let moduleTitle = 'Order & Checkout Management';
    let submoduleContent = '';

    const getOrderStatusBadge = (status) => {
        // Ensure statuses match CSS classes
        return status.toLowerCase().replace(' ', '-');
    };

    const orderRows = ordersData.map((o, index) => `
                            <tr class="order-row" data-order-id="${o.id}" data-customer="${o.customer.toLowerCase()}" data-status="${o.status.toLowerCase()}" data-amount="${o.total}">
                                <td><input type="checkbox" class="order-checkbox" value="${o.id}" onchange="updateSelectedCount()"></td>
                                <td style="color: #1f2937; font-weight: 500;">#${o.id}</td>
                                <td>${o.customer}</td>
                                <td>${formatCurrency(o.total)}</td>
                                <td>${o.date || new Date().toLocaleDateString()}</td>
                                <td><span class="status-badge ${getOrderStatusBadge(o.status)}">${o.status}</span></td>
                                <td style="width: 200px;">
                                    <div style="display: flex; gap: 0.5rem; align-items: center;">
                                        <button onclick="viewOrderDetails(${o.id})" class="btn-base btn-secondary" style="padding: 0.35rem 0.75rem; font-size: 0.75rem;">
                                            <i data-lucide="eye" style="width: 0.875rem; height: 0.875rem; margin-right: 0.25rem;"></i>
                                            View
                                        </button>
                                        <select onchange="showCustomActionModal('Confirm Status Change', 'Change status for order **#${o.id}** to **' + this.value + '**?', 'Confirm', () => updateOrderStatus(${o.id}, this.value))" 
                                            class="form-group" style="padding: 0.35rem 0.5rem; font-size: 0.75rem; border-radius: 0.3rem; flex: 1;">
                                            <option value="${o.status}" selected disabled>${o.status}</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Processing">Processing</option>
                                            <option value="Shipped">Shipped</option>
                                            <option value="Delivered">Delivered</option>
                                            <option value="Cancelled">Cancelled</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                        `).join('');

    switch (submodule) {
        case 'orders':
            moduleTitle = 'View All Orders & Status Management';
            submoduleContent = `
                                    <div class="mb-6">
                                        <p class="text-gray-500 mb-4">View all orders and manage their status. Search, filter, and export orders.</p>
                            
                                        <!-- Search and Filter Controls -->
                                        <div class="kpi-card p-4 mb-4" style="background: #f9fafb;">
                                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr auto; gap: 1rem; align-items: end;">
                                                <div>
                                                    <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Search Orders</label>
                                                    <input type="text" id="order-search" placeholder="Search by Order ID, Customer, or Amount..." 
                                                        style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.875rem;"
                                                        onkeyup="filterOrders()">
                                                </div>
                                                <div>
                                                    <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Filter by Status</label>
                                                    <select id="status-filter" onchange="filterOrders()" 
                                                        style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.875rem;">
                                                        <option value="">All Statuses</option>
                                                        <option value="Pending">Pending</option>
                                                        <option value="Processing">Processing</option>
                                                        <option value="Shipped">Shipped</option>
                                                        <option value="Delivered">Delivered</option>
                                                        <option value="Cancelled">Cancelled</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Sort By</label>
                                                    <select id="sort-orders" onchange="filterOrders()" 
                                                        style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.875rem;">
                                                        <option value="id-desc">Newest First</option>
                                                        <option value="id-asc">Oldest First</option>
                                                        <option value="amount-desc">Highest Amount</option>
                                                        <option value="amount-asc">Lowest Amount</option>
                                                        <option value="customer-asc">Customer A-Z</option>
                                                    </select>
                                                </div>
                                                <div style="display: flex; gap: 0.5rem;">
                                                    <button onclick="exportOrders()" class="btn-base btn-secondary" style="padding: 0.75rem 1rem; font-size: 0.875rem; white-space: nowrap;">
                                                        <i data-lucide="download" style="width: 1rem; height: 1rem; margin-right: 0.5rem;"></i>
                                                        Export
                                                    </button>
                                                    <button onclick="printOrders()" class="btn-base btn-secondary" style="padding: 0.75rem 1rem; font-size: 0.875rem; white-space: nowrap;">
                                                        <i data-lucide="printer" style="width: 1rem; height: 1rem; margin-right: 0.5rem;"></i>
                                                        Print
                                                    </button>
                                                </div>
                                            </div>
                                
                                            <!-- Bulk Actions -->
                                            <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #e5e7eb; display: flex; gap: 0.5rem; align-items: center;">
                                                <input type="checkbox" id="select-all-orders" onchange="toggleSelectAllOrders()" style="margin-right: 0.5rem;">
                                                <label for="select-all-orders" style="font-size: 0.875rem; color: #374151; margin-right: 1rem;">Select All</label>
                                                <select id="bulk-status-action" style="padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem;">
                                                    <option value="">Bulk Actions</option>
                                                    <option value="Processing">Mark as Processing</option>
                                                    <option value="Shipped">Mark as Shipped</option>
                                                    <option value="Delivered">Mark as Delivered</option>
                                                    <option value="Cancelled">Mark as Cancelled</option>
                                                </select>
                                                <button onclick="bulkUpdateOrderStatus()" class="btn-base btn-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                                                    Apply
                                                </button>
                                                <span id="selected-count" style="font-size: 0.875rem; color: #6b7280; margin-left: auto;"></span>
                                            </div>
                                        </div>
                                    </div>
                        
                                    <div class="kpi-card p-6">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                                            <h3 class="text-xl font-semibold" id="order-count-title">Order List (<span id="filtered-order-count">${ordersData.length}</span> Orders Found)</h3>
                                        </div>
                                        <div class="table-container" style="overflow-x: auto;">
                                            <table class="data-table" id="orders-table">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 40px;"><input type="checkbox" id="table-select-all" onchange="toggleSelectAllOrders()"></th>
                                                        <th>Order ID</th>
                                                        <th>Customer</th>
                                                        <th>Total Amount</th>
                                                        <th>Date</th>
                                                        <th>Current Status</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="orders-table-body">
                                                    ${ordersData.length > 0 ? orderRows : `<tr><td colspan="7" class="text-center text-gray-500 py-4">No orders placed yet.</td></tr>`}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                `;
            break;
        case 'payments':
            moduleTitle = 'Payment Transaction Logs';
            const transactionRows = transactionsData.map(t => {
                const statusClass = t.status === 'Completed' ? 'active' : (t.status === 'Pending' ? 'pending' : (t.status === 'Failed' ? 'cancelled' : 'pending'));
                return `
                                    <tr>
                                        <td>${t.transaction_number}</td>
                                        <td>${t.order_number || 'N/A'}</td>
                                        <td>${t.customer_name || 'N/A'}</td>
                                        <td>${formatCurrency(parseFloat(t.amount))}</td>
                                        <td>${t.payment_method}</td>
                                        <td><span class="status-badge ${statusClass}">${t.status}</span></td>
                                        <td>${new Date(t.transaction_date).toLocaleDateString()}</td>
                                    </tr>
                                `;
            }).join('');

            submoduleContent = `
                                    <p class="mb-6 text-gray-500">Monitor all payment transactions and their status.</p>
                                    <div class="kpi-card p-6">
                                        <h3 class="text-xl font-semibold mb-4">Transaction Logs (${transactionsData.length} Transactions)</h3>
                                        <div class="table-container" style="overflow-x: auto;">
                                            <table class="data-table">
                                                <thead>
                                                    <tr>
                                                        <th>Transaction #</th>
                                                        <th>Order #</th>
                                                        <th>Customer</th>
                                                        <th>Amount</th>
                                                        <th>Payment Method</th>
                                                        <th>Status</th>
                                                        <th>Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    ${transactionsData.length > 0 ? transactionRows : `<tr><td colspan="7" class="text-center text-gray-500 py-4">No transactions found.</td></tr>`}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                `;
            break;
    }

    content.innerHTML = `<h2 class="page-header">${moduleTitle}</h2>${submoduleContent}`;
    lucide.createIcons();

    // Store original orders data for filtering
    if (submodule === 'orders') {
        window.allOrdersData = ordersData;
        updateSelectedCount();
    }
}

// --- ORDER MANAGEMENT FUNCTIONS ---
function updateOrderStatus(orderId, newStatus) {
    // This submits a functional PHP POST form to update the database
    const updateForm = document.createElement('form');
    updateForm.method = 'POST';
    updateForm.action = 'index.php';
    updateForm.style.display = 'none';

    const actionInput = document.createElement('input');
    actionInput.type = 'hidden';
    actionInput.name = 'action';
    actionInput.value = 'update_order_status';
    updateForm.appendChild(actionInput);

    const idInput = document.createElement('input');
    idInput.type = 'hidden';
    idInput.name = 'id';
    idInput.value = orderId;
    updateForm.appendChild(idInput);

    const statusInput = document.createElement('input');
    statusInput.type = 'hidden';
    statusInput.name = 'status';
    statusInput.value = newStatus;
    updateForm.appendChild(statusInput);

    document.body.appendChild(updateForm);
    updateForm.submit();
}

function filterOrders() {
    const searchTerm = document.getElementById('order-search')?.value.toLowerCase() || '';
    const statusFilter = document.getElementById('status-filter')?.value.toLowerCase() || '';
    const sortBy = document.getElementById('sort-orders')?.value || 'id-desc';
    const tbody = document.getElementById('orders-table-body');
    const countSpan = document.getElementById('filtered-order-count');

    if (!tbody) return;

    let filtered = window.allOrdersData || ordersData;

    // Apply search filter
    if (searchTerm) {
        filtered = filtered.filter(o =>
            o.id.toString().includes(searchTerm) ||
            o.customer.toLowerCase().includes(searchTerm) ||
            o.total.toString().includes(searchTerm)
        );
    }

    // Apply status filter
    if (statusFilter) {
        filtered = filtered.filter(o => o.status.toLowerCase() === statusFilter);
    }

    // Apply sorting
    filtered.sort((a, b) => {
        switch (sortBy) {
            case 'id-desc': return b.id - a.id;
            case 'id-asc': return a.id - b.id;
            case 'amount-desc': return b.total - a.total;
            case 'amount-asc': return a.total - b.total;
            case 'customer-asc': return a.customer.localeCompare(b.customer);
            default: return b.id - a.id;
        }
    });

    // Update table
    const getOrderStatusBadge = (status) => status.toLowerCase().replace(' ', '-');
    const rows = filtered.map(o => `
                            <tr class="order-row" data-order-id="${o.id}" data-customer="${o.customer.toLowerCase()}" data-status="${o.status.toLowerCase()}" data-amount="${o.total}">
                                <td><input type="checkbox" class="order-checkbox" value="${o.id}" onchange="updateSelectedCount()"></td>
                                <td style="color: #1f2937; font-weight: 500;">#${o.id}</td>
                                <td>${o.customer}</td>
                                <td>${formatCurrency(o.total)}</td>
                                <td>${o.date || new Date().toLocaleDateString()}</td>
                                <td><span class="status-badge ${getOrderStatusBadge(o.status)}">${o.status}</span></td>
                                <td style="width: 200px;">
                                    <div style="display: flex; gap: 0.5rem; align-items: center;">
                                        <button onclick="viewOrderDetails(${o.id})" class="btn-base btn-secondary" style="padding: 0.35rem 0.75rem; font-size: 0.75rem;">
                                            <i data-lucide="eye" style="width: 0.875rem; height: 0.875rem; margin-right: 0.25rem;"></i>
                                            View
                                        </button>
                                        <select onchange="showCustomActionModal('Confirm Status Change', 'Change status for order **#${o.id}** to **' + this.value + '**?', 'Confirm', () => updateOrderStatus(${o.id}, this.value))" 
                                            class="form-group" style="padding: 0.35rem 0.5rem; font-size: 0.75rem; border-radius: 0.3rem; flex: 1;">
                                            <option value="${o.status}" selected disabled>${o.status}</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Processing">Processing</option>
                                            <option value="Shipped">Shipped</option>
                                            <option value="Delivered">Delivered</option>
                                            <option value="Cancelled">Cancelled</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                        `).join('');

    tbody.innerHTML = filtered.length > 0 ? rows : `<tr><td colspan="7" class="text-center text-gray-500 py-4">No orders found matching your criteria.</td></tr>`;
    if (countSpan) countSpan.textContent = filtered.length;

    lucide.createIcons();
    updateSelectedCount();
}

function viewOrderDetails(orderId) {
    const order = (window.allOrdersData || ordersData).find(o => o.id == orderId);
    if (!order) {
        showCustomActionModal('Error', 'Order not found.', 'OK');
        return;
    }

    const detailsHTML = `
                            <div style="padding: 1.5rem;">
                                <h3 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin-bottom: 1.5rem;">Order Details #${order.id}</h3>
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                                    <div>
                                        <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.25rem;">Customer</p>
                                        <p style="font-weight: 600; color: #1f2937;">${order.customer}</p>
                                    </div>
                                    <div>
                                        <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.25rem;">Order Date</p>
                                        <p style="font-weight: 600; color: #1f2937;">${order.date || new Date().toLocaleDateString()}</p>
                                    </div>
                                    <div>
                                        <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.25rem;">Status</p>
                                        <p><span class="status-badge ${order.status.toLowerCase().replace(' ', '-')}">${order.status}</span></p>
                                    </div>
                                    <div>
                                        <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.25rem;">Total Amount</p>
                                        <p style="font-weight: 700; color: #059669; font-size: 1.125rem;">${formatCurrency(order.total)}</p>
                                    </div>
                                </div>
                                <div style="border-top: 1px solid #e5e7eb; padding-top: 1rem; margin-top: 1rem;">
                                    <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.5rem;">Order Items</p>
                                    <p style="color: #1f2937;">Product details and items will be displayed here.</p>
                                </div>
                            </div>
                        `;

    const modalContainer = document.getElementById('modal-container');
    modalContainer.innerHTML = detailsHTML;
    document.getElementById('custom-modal-backdrop').classList.remove('hidden');
    lucide.createIcons();
}

function exportOrders() {
    const searchTerm = document.getElementById('order-search')?.value.toLowerCase() || '';
    const statusFilter = document.getElementById('status-filter')?.value.toLowerCase() || '';
    let filtered = window.allOrdersData || ordersData;

    if (searchTerm) {
        filtered = filtered.filter(o =>
            o.id.toString().includes(searchTerm) ||
            o.customer.toLowerCase().includes(searchTerm) ||
            o.total.toString().includes(searchTerm)
        );
    }
    if (statusFilter) {
        filtered = filtered.filter(o => o.status.toLowerCase() === statusFilter);
    }

    // Create CSV content
    const headers = ['Order ID', 'Customer', 'Total Amount', 'Status', 'Date'];
    const rows = filtered.map(o => [
        o.id,
        o.customer,
        o.total,
        o.status,
        o.date || new Date().toLocaleDateString()
    ]);

    const csvContent = [
        headers.join(','),
        ...rows.map(row => row.map(cell => `"${cell}"`).join(','))
    ].join('\\n');

    // Download CSV
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);
    link.setAttribute('href', url);
    link.setAttribute('download', `orders_export_${new Date().toISOString().split('T')[0]}.csv`);
    link.style.visibility = 'hidden';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

function printOrders() {
    const printWindow = window.open('', '_blank');
    const searchTerm = document.getElementById('order-search')?.value.toLowerCase() || '';
    const statusFilter = document.getElementById('status-filter')?.value.toLowerCase() || '';
    let filtered = window.allOrdersData || ordersData;

    if (searchTerm) {
        filtered = filtered.filter(o =>
            o.id.toString().includes(searchTerm) ||
            o.customer.toLowerCase().includes(searchTerm) ||
            o.total.toString().includes(searchTerm)
        );
    }
    if (statusFilter) {
        filtered = filtered.filter(o => o.status.toLowerCase() === statusFilter);
    }

    const printContent = `
                            <!DOCTYPE html>
                            <html>
                            <head>
                                <title>Orders Report</title>
                                <style>
                                    body { font-family: Arial, sans-serif; padding: 20px; }
                                    h1 { color: #1f2937; }
                                    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                                    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                                    th { background-color: #f3f4f6; font-weight: 600; }
                                </style>
                            </head>
                            <body>
                                <h1>Orders Report</h1>
                                <p>Generated: ${new Date().toLocaleString()}</p>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Customer</th>
                                            <th>Total Amount</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${filtered.map(o => `
                                            <tr>
                                                <td>#${o.id}</td>
                                                <td>${o.customer}</td>
                                                <td>${formatCurrency(o.total)}</td>
                                                <td>${o.status}</td>
                                                <td>${o.date || new Date().toLocaleDateString()}</td>
                                            </tr>
                                        `).join('')}
                                    </tbody>
                                </table>
                            </body>
                            </html>
                        `;

    printWindow.document.write(printContent);
    printWindow.document.close();
    printWindow.print();
}

function toggleSelectAllOrders() {
    const selectAll = document.getElementById('select-all-orders') || document.getElementById('table-select-all');
    const checkboxes = document.querySelectorAll('.order-checkbox');
    checkboxes.forEach(cb => cb.checked = selectAll?.checked || false);
    updateSelectedCount();
}

function updateSelectedCount() {
    const checked = document.querySelectorAll('.order-checkbox:checked');
    const countSpan = document.getElementById('selected-count');
    if (countSpan) {
        countSpan.textContent = checked.length > 0 ? `${checked.length} selected` : '';
    }
}

function bulkUpdateOrderStatus() {
    const selected = Array.from(document.querySelectorAll('.order-checkbox:checked')).map(cb => cb.value);
    const newStatus = document.getElementById('bulk-status-action')?.value;

    if (selected.length === 0) {
        showCustomActionModal('No Selection', 'Please select at least one order.', 'OK');
        return;
    }

    if (!newStatus) {
        showCustomActionModal('No Action', 'Please select a status to apply.', 'OK');
        return;
    }

    showCustomActionModal(
        'Confirm Bulk Update',
        `Update ${selected.length} order(s) to status "${newStatus}"?`,
        'Confirm',
        () => {
            selected.forEach(orderId => {
                updateOrderStatus(parseInt(orderId), newStatus);
            });
        }
    );
}

// 3. Shipping & Address Management
function renderShippingModule(submodule) {
    setPageTitle('Shipping & Address Management');
    const content = document.getElementById('content-container');
    let moduleTitle = 'Shipping & Address Management';
    let submoduleContent = '';

    switch (submodule) {
        case 'addresses':
            moduleTitle = 'Customer Addresses & Validation';
            const addressRows = mockAddresses.map(a => `
                <tr>
                    <td>${a.id}</td>
                    <td>${a.customer}</td>
                    <td>${a.address}</td>
                    <td>${a.phone || 'N/A'}</td>
                    <td><span class="status-badge ${a.status === 'Verified' ? 'active' : 'pending'}">${a.status}</span></td>
                     <td style="display: flex; gap: 0.5rem;">
                        <button class="btn-base" style="padding: 0.25rem 0.5rem; background-color: var(--color-indigo-600); color: white;" 
                            onclick="showCustomActionModal('View Address', 'Customer: ${a.customer}<br>Address: ${a.address}<br>Phone: ${a.phone || 'N/A'}', 'Close')">
                            View
                        </button>
                        <button class="btn-base" style="padding: 0.25rem 0.5rem; background-color: var(--color-blue-600); color: white;" 
                            onclick="showCustomActionModal('Edit Address', 'Update address for **${a.customer}**?', 'Update')">
                            Update
                        </button>
                    </td>
                </tr>
            `).join('');

            submoduleContent = `
                <p class="mb-6 text-gray-500">View and validate customer shipping addresses. Data pulled from the <strong>users</strong> table.</p>
                <div class="kpi-card p-6">
                    <h3 class="text-xl font-semibold mb-4">Customer Addresses List (${mockAddresses.length} Addresses)</h3>
                    <div class="table-container" style="overflow-x: auto;">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Customer</th>
                                    <th>Full Address</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${mockAddresses.length > 0 ? addressRows : `<tr><td colspan="6" class="text-center text-gray-500 py-4">No addresses found in users table.</td></tr>`}
                            </tbody>
                        </table>
                    </div>
                </div>
            `;
            break;
        case 'tracking':
            moduleTitle = 'Shipment Tracking';
            const shipmentRows = shipmentsData.map(s => {
                const statusClass = s.status === 'Delivered' ? 'delivered' : (s.status === 'Out for Delivery' ? 'out-for-delivery' : (s.status === 'In Transit' ? 'in-transit' : 'processing'));
                return `
                                    <tr>
                                        <td>${s.tracking_number}</td>
                                        <td>${s.order_number || 'N/A'}</td>
                                        <td>${s.customer_name || 'N/A'}</td>
                                        <td>${s.courier || 'N/A'}</td>
                                        <td><span class="status-badge ${statusClass}">${s.status}</span></td>
                                        <td>${s.current_location || 'N/A'}</td>
                                        <td>${s.estimated_delivery ? new Date(s.estimated_delivery).toLocaleDateString() : 'N/A'}</td>
                                    </tr>
                                `;
            }).join('');

            submoduleContent = `
                                    <p class="mb-6 text-gray-500">Track shipments and monitor real-time delivery status.</p>
                                    <div class="kpi-card p-6">
                                        <h3 class="text-xl font-semibold mb-4">Shipment Tracking (${shipmentsData.length} Shipments)</h3>
                                        <div class="table-container" style="overflow-x: auto;">
                                            <table class="data-table">
                                                <thead>
                                                    <tr>
                                                        <th>Tracking #</th>
                                                        <th>Order #</th>
                                                        <th>Customer</th>
                                                        <th>Courier</th>
                                                        <th>Status</th>
                                                        <th>Current Location</th>
                                                        <th>Est. Delivery</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    ${shipmentsData.length > 0 ? shipmentRows : `<tr><td colspan="7" class="text-center text-gray-500 py-4">No shipments found.</td></tr>`}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                `;
            break;
    }

    content.innerHTML = `<h2 class="page-header">${moduleTitle}</h2>${submoduleContent}`;
    lucide.createIcons();
}

// 5. User & Role Management
function renderUserModule(submodule) {
    setPageTitle('User & Role Management');
    const content = document.getElementById('content-container');
    let moduleTitle = 'User & Role Management';
    let submoduleContent = '';

    const currentUsername = adminDetails.username || adminConfig.username;
    const currentRole = adminDetails.role || adminConfig.role;
    const currentFullName = adminDetails.full_name || '';
    const currentEmail = adminDetails.email || '';
    const currentPhoneNumber = adminDetails.phone_number || '';
    const profileImageUrl = adminDetails.profile_image_url || '';

    switch (submodule) {
        case 'profile':
            moduleTitle = 'Admin Profile (Functional Update)';
            const accountCreatedAt = adminDetails.created_at ? new Date(adminDetails.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }) : 'N/A';
            const lastUpdated = adminDetails.updated_at ? new Date(adminDetails.updated_at).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }) : 'N/A';
            const avatarFallback = `https://placehold.co/140x140/4bc5ec/FFFFFF?text=${currentUsername.charAt(0).toUpperCase() || 'A'}`;
            const avatarSrc = profileImageUrl || avatarFallback;

            submoduleContent = `
                                    <div class="module-container" style="grid-template-columns: 1fr; gap: 1.5rem;">
                                        <!-- Profile Header Card -->
                                        <div class="kpi-card" style="background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-dark-grey) 100%); color: white; padding: 2.5rem;">
                                            <div style="display: flex; gap: 2rem; align-items: flex-start; flex-wrap: wrap;">
                                                <div style="position: relative; flex-shrink: 0;">
                                                    <img id="profile-avatar" 
                                                        src="${avatarSrc}" 
                                                        alt="Admin Avatar"
                                                        style="width: 140px; height: 140px; border-radius: 50%; border: 4px solid rgba(255,255,255,0.3); object-fit: cover; box-shadow: 0 8px 16px rgba(0,0,0,0.2);">
                                                    <button type="button" 
                                                        onclick="triggerProfileImagePicker()"
                                                        title="Upload new picture"
                                                        style="position: absolute; bottom: 10px; right: 10px; background: var(--color-white); color: var(--color-primary-dark); border: none; border-radius: 50%; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 4px 8px rgba(0,0,0,0.2); transition: transform 0.2s;"
                                                        onmouseover="this.style.transform='scale(1.1)'"
                                                        onmouseout="this.style.transform='scale(1)'">
                                                        <i data-lucide="camera" style="width: 18px; height: 18px;"></i>
                                                    </button>
                                                </div>
                                                <div style="flex: 1; min-width: 250px;">
                                                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.75rem;">
                                                        <h2 style="font-size: 2rem; font-weight: 800; margin: 0; color: white;">${currentFullName || currentUsername}</h2>
                                                        <span style="background: rgba(255,255,255,0.2); padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">
                                                            ${currentRole}
                                                        </span>
                                                    </div>
                                                    <p style="font-size: 1.125rem; margin: 0 0 0.5rem 0; color: rgba(255,255,255,0.9); font-weight: 500;">@${currentUsername}</p>
                                                    ${currentEmail ? `<p style="font-size: 0.9375rem; margin: 0.25rem 0; color: rgba(255,255,255,0.8); display: flex; align-items: center; gap: 0.5rem;">
                                                        <i data-lucide="mail" style="width: 16px; height: 16px;"></i> ${currentEmail}
                                                    </p>` : ''}
                                                    ${currentPhoneNumber ? `<p style="font-size: 0.9375rem; margin: 0.25rem 0; color: rgba(255,255,255,0.8); display: flex; align-items: center; gap: 0.5rem;">
                                                        <i data-lucide="phone" style="width: 16px; height: 16px;"></i> ${currentPhoneNumber}
                                                    </p>` : ''}
                                                </div>
                                            </div>
                                            <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid rgba(255,255,255,0.2); display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1.5rem;">
                                                <div>
                                                    <p style="font-size: 0.75rem; color: rgba(255,255,255,0.7); margin: 0 0 0.25rem 0; text-transform: uppercase; letter-spacing: 0.05em;">Member Since</p>
                                                    <p style="font-size: 0.9375rem; color: white; margin: 0; font-weight: 600;">${accountCreatedAt}</p>
                                                </div>
                                                <div>
                                                    <p style="font-size: 0.75rem; color: rgba(255,255,255,0.7); margin: 0 0 0.25rem 0; text-transform: uppercase; letter-spacing: 0.05em;">Last Updated</p>
                                                    <p style="font-size: 0.9375rem; color: white; margin: 0; font-weight: 600;">${lastUpdated}</p>
                                                </div>
                                                <div>
                                                    <p style="font-size: 0.75rem; color: rgba(255,255,255,0.7); margin: 0 0 0.25rem 0; text-transform: uppercase; letter-spacing: 0.05em;">Status</p>
                                                    <p style="font-size: 0.9375rem; color: #10b981; margin: 0; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                                                        <i data-lucide="check-circle" style="width: 16px; height: 16px;"></i> Active
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Profile Edit Form Card -->
                                        <div class="kpi-card p-6">
                                            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 2px solid var(--color-gray-100);">
                                                <div style="background: var(--color-indigo-600); padding: 0.75rem; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                                                    <i data-lucide="user-cog" style="width: 24px; height: 24px; color: white;"></i>
                                                </div>
                                                <div>
                                                    <h3 style="font-size: 1.5rem; font-weight: 700; color: #1f2937; margin: 0;">Edit Profile Information</h3>
                                                    <p style="font-size: 0.875rem; color: var(--color-gray-500); margin: 0.25rem 0 0 0;">Update your account details and preferences</p>
                                                </div>
                                            </div>

                                            <form id="profile-edit-form" method="POST" action="index.php" enctype="multipart/form-data" onsubmit="return validateProfileForm(event);">
                                                <input type="hidden" name="action" value="update_profile">
                                                <input type="hidden" name="module" value="user">
                                                <input type="hidden" name="submodule" value="profile">
                                                <input type="file" id="profile_image" name="profile_image" accept="image/png,image/jpeg,image/jpg,image/webp" style="display: none;" onchange="handleProfileImageChange(event)">

                                                <!-- Personal Information Section -->
                                                <div style="margin-bottom: 2.5rem;">
                                                    <h4 style="font-size: 1.125rem; font-weight: 600; color: #1f2937; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                                                        <i data-lucide="user" style="width: 20px; height: 20px; color: var(--color-indigo-600);"></i>
                                                        Personal Information
                                                    </h4>
                                                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
                                                        <div class="form-group">
                                                            <label for="full_name" style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                                                                <i data-lucide="user-circle" style="width: 16px; height: 16px; color: var(--color-gray-500);"></i>
                                                                Full Name
                                                            </label>
                                                            <input type="text" id="full_name" name="full_name" value="${currentFullName}" placeholder="Enter your full name" style="padding: 0.875rem 1rem; border: 1px solid var(--color-gray-300); border-radius: 0.5rem; font-size: 0.9375rem; transition: all 0.2s; width: 100%;">
                                                        </div>
                                            
                                                        <div class="form-group">
                                                            <label for="new_username" style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                                                                <i data-lucide="at-sign" style="width: 16px; height: 16px; color: var(--color-gray-500);"></i>
                                                                Username
                                                            </label>
                                                            <input type="text" id="new_username" name="new_username" value="${currentUsername}" required 
                                                                style="padding: 0.875rem 1rem; border: 1px solid var(--color-gray-300); border-radius: 0.5rem; font-size: 0.9375rem; transition: all 0.2s; width: 100%;">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Contact Information Section -->
                                                <div style="margin-bottom: 2.5rem;">
                                                    <h4 style="font-size: 1.125rem; font-weight: 600; color: #1f2937; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                                                        <i data-lucide="phone" style="width: 20px; height: 20px; color: var(--color-indigo-600);"></i>
                                                        Contact Information
                                                    </h4>
                                                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
                                                        <div class="form-group">
                                                            <label for="email" style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                                                                <i data-lucide="mail" style="width: 16px; height: 16px; color: var(--color-gray-500);"></i>
                                                                Email Address <span style="color: var(--color-red-600);">*</span>
                                                            </label>
                                                            <input type="email" id="email" name="email" value="${currentEmail}" placeholder="Enter your email address" required 
                                                                style="padding: 0.875rem 1rem; border: 1px solid var(--color-gray-300); border-radius: 0.5rem; font-size: 0.9375rem; transition: all 0.2s; width: 100%;">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="phone_number" style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                                                                <i data-lucide="phone-call" style="width: 16px; height: 16px; color: var(--color-gray-500);"></i>
                                                                Mobile Number <span style="color: var(--color-gray-500); font-size: 0.75rem;">(Optional)</span>
                                                            </label>
                                                            <input type="tel" id="phone_number" name="phone_number" value="${currentPhoneNumber}" placeholder="Enter your mobile number" pattern="[0-9]*"
                                                                style="padding: 0.875rem 1rem; border: 1px solid var(--color-gray-300); border-radius: 0.5rem; font-size: 0.9375rem; transition: all 0.2s; width: 100%;">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Security Section -->
                                                <div style="margin-bottom: 2.5rem;">
                                                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 2px solid var(--color-gray-100);">
                                                        <div style="background: #fee2e2; padding: 0.75rem; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                                                            <i data-lucide="shield" style="width: 20px; height: 20px; color: var(--color-red-600);"></i>
                                                        </div>
                                                        <div>
                                                            <h4 style="font-size: 1.125rem; font-weight: 600; color: #1f2937; margin: 0;">Password & Security</h4>
                                                            <p style="font-size: 0.875rem; color: var(--color-gray-500); margin: 0.25rem 0 0 0;">Change your password to keep your account secure</p>
                                                        </div>
                                                    </div>
                                        
                                                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
                                                        <div class="form-group">
                                                            <label for="current_password" style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                                                                <i data-lucide="lock" style="width: 16px; height: 16px; color: var(--color-gray-500);"></i>
                                                                Current Password <span style="color: var(--color-red-600);">*</span>
                                                            </label>
                                                            <input type="password" id="current_password" name="current_password" placeholder="Enter current password" autocomplete="off" required 
                                                                style="padding: 0.875rem 1rem; border: 1px solid var(--color-gray-300); border-radius: 0.5rem; font-size: 0.9375rem; transition: all 0.2s; width: 100%;">
                                                            <p style="font-size: 0.75rem; color: var(--color-gray-500); margin: 0.5rem 0 0 0;">Required to save any changes</p>
                                                        </div>
                                                    </div>

                                                    <div style="margin-top: 1.5rem; padding: 1.5rem; background: var(--color-gray-100); border-radius: 0.5rem; border-left: 4px solid var(--color-indigo-600);">
                                                        <p style="font-size: 0.875rem; font-weight: 600; color: #1f2937; margin: 0 0 0.75rem 0;">Change Password (Optional)</p>
                                                        <p style="font-size: 0.8125rem; color: var(--color-gray-500); margin: 0 0 1rem 0;">Leave blank if you don't want to change your password</p>
                                            
                                                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
                                                            <div class="form-group" style="margin-bottom: 0;">
                                                                <label for="new_password" style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                                                                    <i data-lucide="key" style="width: 16px; height: 16px; color: var(--color-gray-500);"></i>
                                                                    New Password
                                                                </label>
                                                                <input type="password" id="new_password" name="new_password" placeholder="Enter new password (min 6 characters)" autocomplete="new-password"
                                                                    style="padding: 0.875rem 1rem; border: 1px solid var(--color-gray-300); border-radius: 0.5rem; font-size: 0.9375rem; transition: all 0.2s; width: 100%;">
                                                            </div>
                                                
                                                            <div class="form-group" style="margin-bottom: 0;">
                                                                <label for="confirm_password" style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                                                                    <i data-lucide="key-round" style="width: 16px; height: 16px; color: var(--color-gray-500);"></i>
                                                                    Confirm New Password
                                                                </label>
                                                                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password" autocomplete="new-password"
                                                                    style="padding: 0.875rem 1rem; border: 1px solid var(--color-gray-300); border-radius: 0.5rem; font-size: 0.9375rem; transition: all 0.2s; width: 100%;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                    
                                                <!-- Action Buttons -->
                                                <div style="display: flex; gap: 1rem; padding-top: 2rem; border-top: 2px solid var(--color-gray-100); margin-top: 1rem;">
                                                    <button type="submit" class="btn-base btn-primary" style="padding: 0.875rem 2rem; font-size: 1rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                                                        <i data-lucide="save" style="width: 20px; height: 20px;"></i>
                                                        Save Changes
                                                    </button>
                                                    <button type="button" class="btn-base btn-secondary" onclick="window.location.reload()" style="padding: 0.875rem 2rem; font-size: 1rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                                                        <i data-lucide="x" style="width: 20px; height: 20px;"></i>
                                                        Cancel
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                `;
            break;
        case 'admins':
            moduleTitle = 'Admin Accounts & Role-Based Access Control (RBAC)';
            const adminRows = adminUsersData.map(a => `
                                    <tr>
                                        <td>${a.username}</td>
                                        <td>${a.full_name || 'N/A'}</td>
                                        <td>${a.email || 'N/A'}</td>
                                        <td>${a.role}</td>
                                        <td>${new Date(a.created_at).toLocaleDateString()}</td>
                                        <td style="width: 100px;">
                                            ${a.id != adminConfig.currentAdminId ? `
                                            <button class="btn-base" style="padding: 0.25rem 0.5rem; background-color: var(--color-red-600); color: white;"
                                                onclick="deleteAdmin(${a.id}, '${a.username.replace(/'/g, "\\'")}')">
                                                <i data-lucide="trash-2" style="width: 1rem; height: 1rem;"></i>
                                            </button>
                                            ` : '<span class="text-gray-400 text-sm">Current User</span>'
                }
                                        </td >
                                    </tr>
                `).join('');

            submoduleContent = `
                <p class="mb-6 text-gray-500">Manage admin accounts and role-based access control.</p>
                    <div class="kpi-card p-6">
                        <h3 class="text-xl font-semibold mb-4">Admin/Staff List (${adminUsersData.length} Admins)</h3>
                        <div class="table-container" style="overflow-x: auto;">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${adminUsersData.length > 0 ? adminRows : `<tr><td colspan="6" class="text-center text-gray-500 py-4">No admin users found.</td></tr>`}
                                </tbody>
                            </table>
                        </div>
                    </div>
            `;
            break;
        case 'customers':
            moduleTitle = 'Customer List';
            const customerRows = customersData.map(c => {
                const statusClass = c.status === 'Active' ? 'active' : (c.status === 'Banned' ? 'cancelled' : 'inactive');
                return `
                <tr>
                                        <td>${c.full_name}</td>
                                        <td>${c.email}</td>
                                        <td>${c.phone_number || 'N/A'}</td>
                                        <td>${c.total_orders || 0}</td>
                                        <td>${c.total_spent ? formatCurrency(parseFloat(c.total_spent)) : '$0.00'}</td>
                                        <td><span class="status-badge ${statusClass}">${c.status}</span></td>
                                        <td>${new Date(c.created_at).toLocaleDateString()}</td>
                                    </tr>
                `;
            }).join('');

            submoduleContent = `
                <p class="mb-6 text-gray-500">View all customers, their order history, and account status.</p>
                    <div class="kpi-card p-6">
                        <h3 class="text-xl font-semibold mb-4">Customer Directory (${customersData.length} Customers)</h3>
                        <div class="table-container" style="overflow-x: auto;">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Total Orders</th>
                                        <th>Total Spent</th>
                                        <th>Status</th>
                                        <th>Joined</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${customersData.length > 0 ? customerRows : `<tr><td colspan="7" class="text-center text-gray-500 py-4">No customers found.</td></tr>`}
                                </tbody>
                            </table>
                        </div>
                    </div>
            `;
            break;
    }

    content.innerHTML = `<h2 class="page-header">${moduleTitle}</h2>${submoduleContent}`;
    lucide.createIcons();
}

function triggerProfileImagePicker() {
    const fileInput = document.getElementById('profile_image');
    if (fileInput) {
        fileInput.click();
    }
}

function handleProfileImageChange(event) {
    const file = event.target.files && event.target.files[0];
    if (!file) {
        return;
    }

    if (file.size > 2 * 1024 * 1024) {
        showCustomActionModal('Error', 'Profile image must be 2MB or smaller.', 'OK');
        event.target.value = '';
        return;
    }

    const preview = document.getElementById('profile-avatar');
    if (preview) {
        preview.src = URL.createObjectURL(file);
    }
}

// Form Validation for Profile Update
function validateProfileForm(event) {
    const newPass = document.getElementById('new_password').value;
    const confirmPass = document.getElementById('confirm_password').value;

    if (newPass && newPass.length < 6) {
        showCustomActionModal('Error', 'New password must be at least 6 characters long.', 'OK');
        return false;
    }

    if (newPass && newPass !== confirmPass) {
        showCustomActionModal('Error', 'New password and confirmation password do not match.', 'OK');
        return false;
    }

    // If valid, submit the form via the custom modal to handle the POST logic
    showCustomActionModal('Confirm Update', 'Are you sure you want to save these profile changes?', 'Confirm Save', () => event.target.submit());

    // Prevent default submission here as we use the callback in the modal
    return false;
}

// 6. Customer Support Center
function renderSupportModule() {
    setPageTitle('Customer Support Center');
    const content = document.getElementById('content-container');

    const ticketRows = supportTicketsData.map(t => {
        const statusClass = t.status === 'Resolved' ? 'active' : (t.status === 'In Progress' ? 'processing' : (t.status === 'Closed' ? 'inactive' : 'pending'));
        const priorityClass = t.priority === 'Urgent' ? 'critical-stock' : (t.priority === 'High' ? 'low-stock' : 'active');
        return `
                <tr>
                                <td>${t.ticket_number}</td>
                                <td>${t.customer_name || 'N/A'}</td>
                                <td>${t.subject}</td>
                                <td><span class="status-badge ${statusClass}">${t.status}</span></td>
                                <td><span class="status-badge ${priorityClass}">${t.priority}</span></td>
                                <td>${t.assigned_admin || 'Unassigned'}</td>
                                <td>${new Date(t.created_at).toLocaleDateString()}</td>
                                <td style="width: 100px;">
                                    <button class="btn-base" style="padding: 0.25rem 0.5rem; background-color: var(--color-light-grey);" 
                                        onclick="showTicketDetails(${t.id})">
                                        <i data-lucide="eye" style="width: 1rem; height: 1rem;"></i>
                                    </button>
                                </td>
                            </tr>
                `;
    }).join('');

    const openTickets = supportTicketsData.filter(t => t.status === 'Open' || t.status === 'In Progress').length;
    const resolvedTickets = supportTicketsData.filter(t => t.status === 'Resolved' || t.status === 'Closed').length;

    content.innerHTML = `
                <h2 class="page-header">Customer Support Center</h2>
                            <p class="mb-6 text-gray-500">Manage support tickets and customer communications.</p>
                
                            <div class="kpi-card-grid" style="margin-bottom: 2rem;">
                                ${createKPICard('Open Tickets', openTickets, 'message-square', 'kpi-yellow')}
                                ${createKPICard('Resolved', resolvedTickets, 'check-circle', 'kpi-green')}
                                ${createKPICard('Total Tickets', supportTicketsData.length, 'ticket', 'kpi-indigo')}
                                ${createKPICard('High Priority', supportTicketsData.filter(t => t.priority === 'High' || t.priority === 'Urgent').length, 'alert-triangle', 'kpi-red')}
                            </div>
                
                            <div class="kpi-card p-6">
                                <h3 class="text-xl font-semibold mb-4">Support Tickets (${supportTicketsData.length} Total)</h3>
                                <div class="table-container" style="overflow-x: auto;">
                                    <table class="data-table" style="text-align: center;">
                                        <thead>
                                            <tr>
                                                <th>Ticket #</th>
                                                <th>Customer</th>
                                                <th>Subject</th>
                                                <th>Status</th>
                                                <th>Priority</th>
                                                <th>Assigned To</th>
                                                <th>Created</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${supportTicketsData.length > 0 ? ticketRows : `<tr><td colspan="8" class="text-center text-gray-500 py-4">No support tickets found.</td></tr>`}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
            `;
    lucide.createIcons();
}

function showTicketDetails(ticketId) {
    const ticket = supportTicketsData.find(t => t.id == ticketId);
    if (!ticket) return;

    const formHTML = `
                <form id="ticket-form" method="POST" action="index.php">
                    <input type="hidden" name="action" value="update_ticket">
                        <input type="hidden" name="id" value="${ticket.id}">
                            <input type="hidden" name="module" value="support">

                                <div style="margin-bottom: 1.5rem;">
                                    <p><strong>Ticket:</strong> ${ticket.ticket_number}</p>
                                    <p><strong>Customer:</strong> ${ticket.customer_name || 'N/A'}</p>
                                    <p><strong>Subject:</strong> ${ticket.subject}</p>
                                    <p><strong>Message:</strong></p>
                                    <div style="padding: 1rem; background: #f3f4f6; border-radius: 0.5rem; margin-top: 0.5rem; margin-bottom: 1rem;">${ticket.message}</div>
                                    
                                    <!-- Admin Reply Section -->
                                    <div class="form-group" style="margin-top: 1rem;">
                                        <label>Reply Message</label>
                                        <textarea name="reply_message" rows="4" 
                                            placeholder="Write your response here..."
                                            style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-gray-300); border-radius: 0.5rem;"></textarea>
                                    </div>
                                </div>

                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status"
                                            style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-gray-300); border-radius: 0.5rem;">
                                            <option value="Open" ${ticket.status === 'Open' ? 'selected' : ''}>Open</option>
                                            <option value="In Progress" ${ticket.status === 'In Progress' ? 'selected' : ''}>In Progress</option>
                                            <option value="Resolved" ${ticket.status === 'Resolved' ? 'selected' : ''}>Resolved</option>
                                            <option value="Closed" ${ticket.status === 'Closed' ? 'selected' : ''}>Closed</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Priority</label>
                                        <select name="priority"
                                            style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-gray-300); border-radius: 0.5rem;">
                                            <option value="Low" ${ticket.priority === 'Low' ? 'selected' : ''}>Low</option>
                                            <option value="Medium" ${ticket.priority === 'Medium' ? 'selected' : ''}>Medium</option>
                                            <option value="High" ${ticket.priority === 'High' ? 'selected' : ''}>High</option>
                                            <option value="Urgent" ${ticket.priority === 'Urgent' ? 'selected' : ''}>Urgent</option>
                                        </select>
                                    </div>
                                </div>

                                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                                    <button type="submit" class="btn-base btn-primary" style="flex: 1;">Update & Send Reply</button>
                                    <button type="button" class="btn-base btn-secondary" onclick="document.getElementById('custom-modal-backdrop').classList.add('hidden')" style="flex: 1;">Close</button>
                                </div>
                            </form>
                            `;

    const modalContainer = document.getElementById('modal-container');
    modalContainer.innerHTML = `
                            <h3 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin-bottom: 1.5rem;">Ticket Details</h3>
                            <div id="modal-form-content">${formHTML}</div>
                            `;
    document.getElementById('custom-modal-backdrop').classList.remove('hidden');
}

function deleteAdmin(id, username) {
    showCustomActionModal(
        'Delete Admin User',
        `Are you sure you want to delete admin user <strong>${username}</strong>? This action cannot be undone.`,
        'Delete',
        () => {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'index.php';
            form.innerHTML = `
                                    <input type="hidden" name="action" value="delete_admin">
                                    <input type="hidden" name="id" value="${id}">
                                    <input type="hidden" name="module" value="user">
                                    <input type="hidden" name="submodule" value="admins">
                                `;
            document.body.appendChild(form);
            form.submit();
        }
    );
}

// 7. Notification & Alert System
function renderAlertsModule() {
    setPageTitle('Notification & Alert System');
    const content = document.getElementById('content-container');

    // Generate real alerts based on data
    const lowStockProducts = productsData.filter(p => parseInt(p.stock) < 10 && p.status !== 'Inactive');
    const pendingOrders = ordersData.filter(o => o.status === 'Pending');
    const openTickets = supportTicketsData.filter(t => t.status === 'Open' || t.status === 'In Progress');
    const pendingTransactions = transactionsData.filter(t => t.status === 'Pending');

    const alertsList = [];

    if (lowStockProducts.length > 0) {
        alertsList.push({
            type: 'warning',
            icon: 'alert-triangle',
            title: 'Low Stock Alert',
            message: `${lowStockProducts.length} product(s) are running low on stock (less than 10 units)`,
            count: lowStockProducts.length
        });
    }

    if (pendingOrders.length > 0) {
        alertsList.push({
            type: 'info',
            icon: 'shopping-cart',
            title: 'Pending Orders',
            message: `${pendingOrders.length} order(s) are pending approval`,
            count: pendingOrders.length
        });
    }

    if (openTickets.length > 0) {
        alertsList.push({
            type: 'warning',
            icon: 'message-square',
            title: 'Open Support Tickets',
            message: `${openTickets.length} support ticket(s) require attention`,
            count: openTickets.length
        });
    }

    if (pendingTransactions.length > 0) {
        alertsList.push({
            type: 'info',
            icon: 'dollar-sign',
            title: 'Pending Payments',
            message: `${pendingTransactions.length} transaction(s) are pending`,
            count: pendingTransactions.length
        });
    }

    const alertsHTML = alertsList.map(alert => `
                            <div class="p-4 rounded-lg mb-3" style="background-color: ${alert.type === 'warning' ? '#fffbe6' : '#e0e7ff'}; border: 1px solid ${alert.type === 'warning' ? '#f59e0b' : '#4f46e5'};">
                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    <div style="padding: 0.5rem; background: ${alert.type === 'warning' ? '#f59e0b' : '#4f46e5'}; border-radius: 0.5rem; color: white;">
                                        <i data-lucide="${alert.icon}" style="width: 1.5rem; height: 1.5rem;"></i>
                                    </div>
                                    <div style="flex: 1;">
                                        <h4 style="font-weight: 600; color: #1f2937; margin-bottom: 0.25rem;">${alert.title}</h4>
                                        <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">${alert.message}</p>
                                    </div>
                                    <span style="background: ${alert.type === 'warning' ? '#f59e0b' : '#4f46e5'}; color: white; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">${alert.count}</span>
                                </div>
                            </div>
                            `).join('');

    content.innerHTML = `
                            <h2 class="page-header">Notification & Alert System</h2>
                            <p class="mb-6 text-gray-500">Manage system alerts and send broadcast messages to customers.</p>

                            <div class="module-container" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 1.5rem;">
                                <div class="kpi-card p-6">
                                    <h3 class="text-xl font-semibold mb-4">System Alerts (${alertsList.length} Active)</h3>
                                    ${alertsList.length > 0 ? alertsHTML : '<div class="p-3 text-sm text-center text-gray-500 rounded-lg" style="border: 1px solid #e5e7eb;">No active system alerts. All systems operational.</div>'}
                                </div>

                                <div class="kpi-card p-6">
                                    <h3 class="text-xl font-semibold mb-4">Broadcast Message</h3>
                                    <textarea id="broadcast-message" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; outline: none;" rows="4" placeholder="Enter message for Email/SMS Broadcast..."></textarea>
                                    <select id="broadcast-audience" style="margin-top: 0.75rem; width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; outline: none;">
                                        <option>Send to All Customers</option>
                                        <option>Send to Active Customers Only</option>
                                    </select>
                                    <button class="btn-base btn-primary w-full" style="margin-top: 1rem; padding: 0.75rem 1.25rem;"
                                        onclick="showCustomActionModal('Send Broadcast', 'Are you sure you want to send this broadcast message?', 'Send', () => console.log('Broadcast message sent'))">
                                        <i data-lucide="send" style="width: 1rem; height: 1rem; margin-right: 0.5rem;"></i>
                                        Send Broadcast
                                    </button>
                                </div>
                            </div>
                            `;
    lucide.createIcons();
}

// 8. System Settings & Security
function renderSettingsModule() {
    setPageTitle('System Settings & Security');
    const content = document.getElementById('content-container');
    content.innerHTML = `
                            <h2 class="page-header">System Settings & Security</h2>
                            <p class="mb-6 text-gray-500">Protect system integrity and ensure compliance.</p>

                            <div class="module-container" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
                                <div class="kpi-card p-6 space-y-4">
                                    <h3 class="text-xl font-semibold pb-2" style="border-bottom: 1px solid #e5e7eb;">Database and Audit</h3>
                                    <div class="flex justify-between items-center">
                                        <span>Backup and Restore Database</span>
                                        <button class="btn-base btn-secondary" style="padding: 0.5rem 1rem;"
                                            onclick="showCustomActionModal('Database Backup', 'Are you sure you want to initiate a full database backup now?', 'Backup', () => console.log('Backup initiated'))">Execute Backup</button>
                                    </div>
                                    <div style="border-bottom: 1px solid #e5e7eb; padding-bottom: 1rem;">
                                        <div class="flex justify-between items-center mb-3">
                                            <span>View Audit Logs</span>
                                            <button class="btn-base btn-secondary" style="padding: 0.5rem 1rem;"
                                                onclick="showCustomActionModal('System Audit', 'The complete audit log history would load in a new window/tab.', 'View')">View Logs</button>
                                        </div>
                                        <p class="text-sm text-gray-500">*(Record who changed what)*</p>
                                    </div>

                                </div>

                                <div class="kpi-card p-6 space-y-4">
                                    <h3 class="text-xl font-semibold pb-2" style="border-bottom: 1px solid #e5e7eb;">Security & API</h3>
                                    <div class="flex justify-between items-center">
                                        <span>API Key Management</span>
                                        <button class="btn-base btn-secondary" style="padding: 0.5rem 1rem;"
                                            onclick="showCustomActionModal('API Key Management', 'The interface to manage, generate, and revoke API keys would open here.', 'OK')">Manage Keys</button>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span>SSL / Firewall Monitoring</span>
                                        <span class="text-green-600 font-bold" style="color: var(--color-green-600);">Status: Secure</span>
                                    </div>
                                </div>
                            </div>
                            `;
    lucide.createIcons();
}

// --- MAIN ROUTER ---
function showModule(moduleName, element = null) {

    // Close all submenus when switching main modules
    document.querySelectorAll('.submenu').forEach(sub => sub.classList.add('hidden'));
    document.querySelectorAll('.nav-item .chevron-icon').forEach(icon => {
        icon.classList.remove('rotate-90');
    });

    // Set the clicked main module or default module to active
    let navElement = element;
    if (!navElement) {
        navElement = document.querySelector(`.nav-menu a[onclick*="'${moduleName}'"]`);
    }
    if (navElement) {
        setActiveNav(navElement);
    }

    // Render the content based on the module
    switch (moduleName) {
        case 'dashboard':
            renderDashboard();
            break;
        case 'product':
            // Default to product list
            showSubModule('product', 'products');
            break;
        case 'order':
            // Default to view all orders
            showSubModule('order', 'orders');
            break;
        case 'shipping':
            // Default to addresses
            showSubModule('shipping', 'addresses');
            break;
        case 'support':
            renderSupportModule();
            break;
        case 'alerts':
            renderAlertsModule();
            break;
        case 'settings':
            renderSettingsModule();
            break;
        default:
            renderDashboard();
            break;
    }

    // Update URL state
    if (moduleName !== 'dashboard') { // Avoid redundant default state push if feasible, but consistent is better
        // If module routes to a submodule by default, let the submodule function handle the state push to avoid double push
        // checking if it's a direct render module
        if (['support', 'alerts', 'settings', 'dashboard'].includes(moduleName)) {
            const newUrl = new URL(window.location);
            newUrl.searchParams.set('module', moduleName);
            newUrl.searchParams.delete('submodule'); // Clear submodule if switching to a main module
            window.history.pushState({ module: moduleName }, '', newUrl);
        }
    } else {
        const newUrl = new URL(window.location);
        newUrl.searchParams.delete('module');
        newUrl.searchParams.delete('submodule');
        window.history.pushState({ module: 'dashboard' }, '', newUrl);
    }

    window.scrollTo(0, 0);
}

function showSubModule(modulePrefix, submodule) {
    const moduleMap = {
        'product': renderProductModule,
        'order': renderOrderModule,
        'shipping': renderShippingModule,
        'user': renderUserModule,
    };

    if (moduleMap[modulePrefix]) {
        moduleMap[modulePrefix](submodule);

        // --- Navigation Fix for Submodules ---
        // 1. Find the specific submenu link
        const submenuLink = document.querySelector(`.submenu a[onclick*="'${submodule}'"]`);

        // 2. Clear all active states
        document.querySelectorAll('.nav-menu a').forEach(item => item.classList.remove('active-nav'));

        if (submenuLink) {
            // 3. Set submenu link to active
            submenuLink.classList.add('active-nav');

            // 4. Set parent navigation item to active AND ensure its submenu is open
            const parentGroup = submenuLink.closest('.group');
            const parentNav = parentGroup.querySelector('.nav-item');
            if (parentNav) {
                parentNav.classList.add('active-nav');
                const submenu = parentGroup.querySelector('.submenu');
                const icon = parentNav.querySelector('.chevron-icon');
                if (submenu && submenu.classList.contains('hidden')) {
                    submenu.classList.remove('hidden');
                    icon.classList.add('rotate-90');
                }
            }
        }

        // Update URL state for submodule
        const newUrl = new URL(window.location);
        newUrl.searchParams.set('module', modulePrefix);
        newUrl.searchParams.set('submodule', submodule);
        window.history.pushState({ module: modulePrefix, submodule: submodule }, '', newUrl);
    }
    window.scrollTo(0, 0);
}

// --- PRODUCT FORM FUNCTIONS ---
function showProductForm(productId = null) {
    const product = productId ? productsData.find(p => p.id == productId) : null;
    const isEdit = !!product;
    const categoryOptions = categoriesData.map(cat =>
        `<option value="${cat.id}" ${product && product.category_id == cat.id ? 'selected' : ''}>${cat.name}</option>`
    ).join('');

    const formHTML = `
                            <form id="product-form" method="POST" action="index.php">
                                <input type="hidden" name="action" value="${isEdit ? 'edit_product' : 'add_product'}">
                                    <input type="hidden" name="module" value="product">
                                        <input type="hidden" name="submodule" value="products">
                                            ${isEdit ? `<input type="hidden" name="id" value="${product.id}">` : ''}

                                            <div class="form-group" style="margin-bottom: 1.5rem;">
                                                <label>Product Name *</label>
                                                <input type="text" name="name" value="${product ? product.name.replace(/" /g, '&quot;') : ''}" required 
                                        style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-gray-300); border-radius: 0.5rem;">
                                            </div>

                                            <div class="form-group" style="margin-bottom: 1.5rem;">
                                                <label>Description</label>
                                                <textarea name="description" rows="3"
                                                    style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-gray-300); border-radius: 0.5rem;">${product ? (product.description || '').replace(/"/g, '&quot;') : ''}</textarea>
                                            </div>

                                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                                                <div class="form-group">
                                                    <label>Price *</label>
                                                    <input type="number" name="price" step="0.01" value="${product ? product.price : ''}" required
                                                        style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-gray-300); border-radius: 0.5rem;">
                                                </div>

                                                <div class="form-group">
                                                    <label>Stock Quantity *</label>
                                                    <input type="number" name="stock" value="${product ? product.stock : ''}" required
                                                        style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-gray-300); border-radius: 0.5rem;">
                                                </div>
                                            </div>

                                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                                                <div class="form-group">
                                                    <label>Category *</label>
                                                    <select name="category_id" required
                                                        style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-gray-300); border-radius: 0.5rem;">
                                                        <option value="">Select Category</option>
                                                        ${categoryOptions}
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label>Status</label>
                                                    <select name="status"
                                                        style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-gray-300); border-radius: 0.5rem;">
                                                        <option value="Active" ${product && product.status === 'Active' ? 'selected' : ''}>Active</option>
                                                        <option value="Inactive" ${product && product.status === 'Inactive' ? 'selected' : ''}>Inactive</option>
                                                        <option value="Low Stock" ${product && product.status === 'Low Stock' ? 'selected' : ''}>Low Stock</option>
                                                        <option value="Critical Stock" ${product && product.status === 'Critical Stock' ? 'selected' : ''}>Critical Stock</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group" style="margin-bottom: 1.5rem;">
                                                <label>Image URL (Optional)</label>
                                                <input type="url" name="image_url" value="${product ? (product.image_url || '') : ''}"
                                                    placeholder="https://example.com/image.jpg"
                                                    style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-gray-300); border-radius: 0.5rem;">
                                                    <small style="color: #6b7280; font-size: 0.75rem; margin-top: 0.25rem; display: block;">Enter a URL to an image for this product</small>
                                            </div>

                                            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                                                <button type="submit" class="btn-base btn-primary" style="flex: 1; padding: 0.75rem; font-weight: 600;">
                                                    <i data-lucide="${isEdit ? 'save' : 'plus'}" style="width: 1rem; height: 1rem; margin-right: 0.5rem;"></i>
                                                    ${isEdit ? 'Update Product' : 'Add Product'}
                                                </button>
                                                <button type="button" class="btn-base btn-secondary" onclick="document.getElementById('custom-modal-backdrop').classList.add('hidden')" style="flex: 1; padding: 0.75rem;">
                                                    Cancel
                                                </button>
                                            </div>
                                        </form>
                                        `;

    const modalContainer = document.getElementById('modal-container');
    modalContainer.innerHTML = `
                                        <h3 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin-bottom: 1.5rem;">${isEdit ? 'Edit Product' : 'Add New Product'}</h3>
                                        <div id="modal-form-content">${formHTML}</div>
                                        `;
    document.getElementById('custom-modal-backdrop').classList.remove('hidden');
}

function deleteProduct(id, name) {
    showCustomActionModal(
        'Delete Product',
        `Are you sure you want to delete <strong>${name}</strong>? This action cannot be undone.`,
        'Delete',
        () => {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'index.php';
            form.innerHTML = `
                                    <input type="hidden" name="action" value="delete_product">
                                    <input type="hidden" name="id" value="${id}">
                                    <input type="hidden" name="module" value="product">
                                    <input type="hidden" name="submodule" value="products">
                                `;
            document.body.appendChild(form);
            form.submit();
        }
    );
}

function clearAllProducts() {
    const productCount = productsData.length;
    showCustomActionModal(
        'Clear All Products',
        `Are you sure you want to delete <strong>ALL ${productCount} product(s)</strong> from the database?<br><br><strong style="color: #ef4444;">This action cannot be undone!</strong><br>All sample products will be permanently removed.`,
        'Delete All',
        () => {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'index.php';
            form.innerHTML = `
                                            <input type="hidden" name="action" value="clear_all_products">
                                                <input type="hidden" name="module" value="product">
                                                    <input type="hidden" name="submodule" value="products">
                                                        `;
            document.body.appendChild(form);
            form.submit();
        }
    );
}

// --- CATEGORY FORM FUNCTIONS ---
function showCategoryForm(categoryId = null) {
    const category = categoryId ? categoriesData.find(c => c.id == categoryId) : null;
    const isEdit = !!category;

    const formHTML = `
                                                        <form id="category-form" method="POST" action="index.php">
                                                            <input type="hidden" name="action" value="${isEdit ? 'edit_category' : 'add_category'}">
                                                                <input type="hidden" name="module" value="product">
                                                                    <input type="hidden" name="submodule" value="categories">
                                                                        ${isEdit ? `<input type="hidden" name="id" value="${category.id}">` : ''}

                                                                        <div class="form-group" style="margin-bottom: 1.5rem;">
                                                                            <label>Category Name *</label>
                                                                            <input type="text" name="name" value="${category ? category.name.replace(/" /g, '&quot;') : ''}" required 
                                        style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-gray-300); border-radius: 0.5rem;">
                                                                        </div>

                                                                        <div class="form-group" style="margin-bottom: 1.5rem;">
                                                                            <label>Description</label>
                                                                            <textarea name="description" rows="3"
                                                                                style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-gray-300); border-radius: 0.5rem;">${category ? (category.description || '').replace(/"/g, '&quot;') : ''}</textarea>
                                                                        </div>

                                                                        <div class="form-group" style="margin-bottom: 1.5rem;">
                                                                            <label>Status</label>
                                                                            <select name="status"
                                                                                style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-gray-300); border-radius: 0.5rem;">
                                                                                <option value="Active" ${category && category.status === 'Active' ? 'selected' : ''}>Active</option>
                                                                                <option value="Inactive" ${category && category.status === 'Inactive' ? 'selected' : ''}>Inactive</option>
                                                                            </select>
                                                                        </div>

                                                                        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                                                                            <button type="submit" class="btn-base btn-primary" style="flex: 1;">
                                                                                ${isEdit ? 'Update Category' : 'Add Category'}
                                                                            </button>
                                                                            <button type="button" class="btn-base btn-secondary" onclick="document.getElementById('custom-modal-backdrop').classList.add('hidden')" style="flex: 1;">
                                                                                Cancel
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                    `;

    const modalContainer = document.getElementById('modal-container');
    modalContainer.innerHTML = `
                                                                    <h3 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin-bottom: 1.5rem;">${isEdit ? 'Edit Category' : 'Add New Category'}</h3>
                                                                    <div id="modal-form-content">${formHTML}</div>
                                                                    `;
    document.getElementById('custom-modal-backdrop').classList.remove('hidden');
}

function deleteCategory(id, name) {
    showCustomActionModal(
        'Delete Category',
        `Are you sure you want to delete category <strong>${name}</strong>? This action cannot be undone.`,
        'Delete',
        () => {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'index.php';
            form.innerHTML = `
                                    <input type="hidden" name="action" value="delete_category">
                                    <input type="hidden" name="id" value="${id}">
                                    <input type="hidden" name="module" value="product">
                                    <input type="hidden" name="submodule" value="categories">
                                `;
            document.body.appendChild(form);
            form.submit();
        }
    );
}

// Initial load
document.addEventListener('DOMContentLoaded', () => {
    if (document.querySelector('.sidebar')) {
        const urlParams = new URLSearchParams(window.location.search);
        const initialModule = urlParams.get('module') || 'dashboard';
        const initialSubmodule = urlParams.get('submodule');

        if (initialSubmodule) {
            showSubModule(initialModule, initialSubmodule);
        } else {
            const navElement = document.querySelector(`.nav-menu a[onclick*="'${initialModule}'"]`);
            showModule(initialModule, navElement);
        }
    }

    // Show message on load (for success/error from redirects)
    const urlParams = new URLSearchParams(window.location.search);
    const message = urlParams.get('msg');
    const isOtp = urlParams.get('view') === 'otp';

    if (message && !isOtp) {
        const isSuccess = message.toLowerCase().includes('success') || message.toLowerCase().includes('welcome');
        const title = isSuccess ? 'Success' : 'Action Required';
        showCustomActionModal(title, decodeURIComponent(message), 'OK');

        // Remove query params to prevent reappearing on reload
        window.history.replaceState({}, document.title, window.location.pathname);
    } else if (message && isOtp) {
        const title = 'OTP Required';
        showCustomActionModal(title, decodeURIComponent(message), 'OK');
    }

    // Ensure icons are rendered for the sidebar/static content
    lucide.createIcons();
});
