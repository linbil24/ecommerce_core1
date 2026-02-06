<?php
if (isset($rendering_header) && $rendering_header) {
    ?>
    <div class="store-header-panel">
        <div class="store-info">
            <img src="https://ui-avatars.com/api/?name=SG&background=27ae60&color=fff&size=64" alt="Logo"
                class="store-logo-small">
            <div class="store-details">
                <h1>SmartGear Store</h1>
                <p>Phone Accessories</p>
            </div>
        </div>
        <!-- Sort Controls -->
        <div class="sort-controls">
            <span class="sort-label">Sort By</span>
            <a href="?store=<?php echo urlencode($selectedStore); ?>&sort=best"
                class="sort-btn <?php echo (!isset($_GET['sort']) || $_GET['sort'] == 'best') ? 'active' : ''; ?>">Best
                Match</a>
            <a href="?store=<?php echo urlencode($selectedStore); ?>&sort=latest"
                class="sort-btn <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'latest') ? 'active' : ''; ?>">Latest</a>
            <a href="?store=<?php echo urlencode($selectedStore); ?>&sort=sales"
                class="sort-btn <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'sales') ? 'active' : ''; ?>">Top
                Sales</a>
            <a href="?store=<?php echo urlencode($selectedStore); ?>&sort=<?php echo (isset($_GET['sort']) && $_GET['sort'] == 'price_asc') ? 'price_desc' : 'price_asc'; ?>"
                class="sort-btn <?php echo (isset($_GET['sort']) && strpos($_GET['sort'], 'price') !== false) ? 'active' : ''; ?>">
                Price <i
                    class="fas fa-chevron-<?php echo (isset($_GET['sort']) && $_GET['sort'] == 'price_asc') ? 'up' : 'down'; ?>"></i>
            </a>
        </div>
    </div>
    <?php
    return; // Exit to prevent running product logic when rendering header
}

// ------------------------------------
// Custom Products List for TechZone PH
// ------------------------------------
if (isset($definingProducts) && $definingProducts) {
    $manualProducts = [
        // Product 1
        [
            'name' => '3-in-1 Wireless Charging Station',
            'price' => '₱1,200.00',
            'raw_price' => 1200.00,
            'image' => '../image/Shop/SmartGear Store/3-in-1 Wireless Charging Station.jpeg',
            'rating' => 4.8,
            'sold' => 1020
        ],
        // Product 2
        [
            'name' => 'Active-Noise Cancelling Earbuds',
            'price' => '₱899.00',
            'raw_price' => 899.00,
            'image' => '../image/Shop/SmartGear Store/Active-Noise Cancelling Earbuds.jpeg',
            'rating' => 4.5,
            'sold' => 3400
        ],
        // Product 3
        [
            'name' => 'Heavy-Duty Braided USB-C Cable (2m)',
            'price' => '₱1,250.00',
            'raw_price' => 1250.00,
            'image' => '../image/Shop/SmartGear Store/Heavy-Duty Braided USB-C Cable (2m).jpeg',
            'rating' => 4.7,
            'sold' => 850
        ],
        // Product 4
        [
            'name' => 'MagSafe Magnetic Car Mount',
            'price' => '₱2,800.00',
            'raw_price' => 2800.00,
            'image' => '../image/Shop/SmartGear Store/MagSafe Magnetic Car Mount.jpeg',
            'rating' => 4.9,
            'sold' => 540
        ],
        // Product 5
        [
            'name' => 'Ultra-Slim Power Bank (10,000mAh)',
            'price' => '₱750.00',
            'raw_price' => 750.00,
            'image' => '../image/Shop/SmartGear Store/Ultra-Slim Power Bank (10,000mAh).jpeg',
            'rating' => 4.3,
            'sold' => 2100
        ],
        // Product 6
        [
            'name' => 'Privacy Tempered Glass Screen Protector',
            'price' => '₱1,200.00',
            'raw_price' => 1200.00,
            'image' => '../image/Shop/SmartGear Store/Privacy Tempered Glass Screen Protector.jpeg',
            'rating' => 4.6,
            'sold' => 3000
        ],
        // Product 7
        [
            'name' => 'Universal Neck Phone Holder',
            'price' => '₱1,500.00',
            'raw_price' => 1500.00,
            'image' => '../image/Shop/SmartGear Store/Universal Neck Phone Holder.jpeg',
            'rating' => 4.8,
            'sold' => 1500
        ],
        // Product 8
        [
            'name' => '65W GaN Fast Wall Charger',
            'price' => '₱350.00',
            'raw_price' => 350.00,
            'image' => '../image/Shop/SmartGear Store/65W GaN Fast Wall Charger.jpeg', // Using stylized image
            'rating' => 4.2,
            'sold' => 1100
        ],
        // Product 9
        [
            'name' => 'Bluetooth Remote Camera Shutter',
            'price' => '₱1,100.00',
            'raw_price' => 1100.00,
            'image' => '../image/Shop/SmartGear Store/Bluetooth Remote Camera Shutter.jpeg',
            'rating' => 4.5,
            'sold' => 980
        ],
        // Product 10
        [
            'name' => 'Shockproof Clear Magnetic Case',
            'price' => '₱850.00',
            'raw_price' => 850.00,
            'image' => '../image/Shop/SmartGear Store/Shockproof Clear Magnetic Case.jpeg',
            'rating' => 4.4,
            'sold' => 1300
        ],
        // Product 11
        [
            'name' => 'Portable Pocket Vlog Tripod',
            'price' => '₱1,800.00',
            'raw_price' => 1800.00,
            'image' => '../image/Shop/SmartGear Store/Portable Pocket Vlog Tripod.jpeg',
            'rating' => 4.7,
            'sold' => 670
        ],
        // Product 12
        [
            'name' => 'LED Ring Light for Selfies',
            'price' => '₱1,350.00',
            'raw_price' => 1350.00,
            'image' => '../image/Shop/SmartGear Store/LED Ring Light for Selfies.jpeg',
            'rating' => 4.3,
            'sold' => 2500
        ],
        // Product 13
        [
            'name' => 'Tile-Compatible Smart Tag Tracker',
            'price' => '₱450.00',
            'raw_price' => 450.00,
            'image' => '../image/Shop/SmartGear Store/Tile-Compatible Smart Tag Tracker.jpeg',
            'rating' => 4.1,
            'sold' => 4200
        ],
        // Product 14
        [
            'name' => 'Universal Waterproof Phone Pouch',
            'price' => '₱1,200.00',
            'raw_price' => 1200.00,
            'image' => '../image/Shop/SmartGear Store/Universal Waterproof Phone Pouch.jpeg',
            'rating' => 4.9,
            'sold' => 3100
        ],
        // Product 15
        [
            'name' => 'Laptop/Tablet Sleeve',
            'price' => '₱299.00',
            'raw_price' => 299.00,
            'image' => '../image/Shop/SmartGear Store/LaptopTablet Sleeve.jpeg',
            'rating' => 4.0,
            'sold' => 1800
        ]
    ];
    return; // Stop processing
}
?>