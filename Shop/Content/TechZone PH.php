<?php
if (isset($rendering_header) && $rendering_header) {
    ?>
    <div class="store-header-panel">
        <div class="store-info">
            <img src="https://ui-avatars.com/api/?name=TB&background=27ae60&color=fff&size=64" alt="Logo"
                class="store-logo-small">
            <div class="store-details">
                <h1>TechZone PH</h1>
                <p>Latest Tech Products</p>
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
            'name' => 'AMD Ryzen 7 7800X3D',
            'price' => '₱1,200.00',
            'raw_price' => 1200.00,
            'image' => '../image/Shop/TechZone PH/AMD Ryzen 7 7800X3D.jpeg',
            'rating' => 4.8,
            'sold' => 1020
        ],
        // Product 2
        [
            'name' => 'Gigabyte GS27QCA 27 Curved Monitor',
            'price' => '₱899.00',
            'raw_price' => 899.00,
            'image' => '../image/Shop/TechZone PH/Gigabyte GS27QCA 27 Curved Monitor.webp',
            'rating' => 4.5,
            'sold' => 3400
        ],
        // Product 3
        [
            'name' => 'MSI B550M PRO-VDH WiFi Motherboard',
            'price' => '₱1,250.00',
            'raw_price' => 1250.00,
            'image' => '../image/Shop/TechZone PH/MSI B550M PRO-VDH WiFi Motherboard.webp',
            'rating' => 4.7,
            'sold' => 850
        ],
        // Product 4
        [
            'name' => 'Redmi Turbo 4 Pro (Snapdragon 8s Gen 4)',
            'price' => '₱2,800.00',
            'raw_price' => 2800.00,
            'image' => '../image/Shop/TechZone PH/Redmi Turbo 4 Pro (Snapdragon 8s Gen 4).jpeg',
            'rating' => 4.9,
            'sold' => 540
        ],
        // Product 5
        [
            'name' => 'Sony PlayStation 5 Slim (1TB)',
            'price' => '₱750.00',
            'raw_price' => 750.00,
            'image' => '../image/Shop/TechZone PH/Sony PlayStation 5 Slim (1TB).webp',
            'rating' => 4.3,
            'sold' => 2100
        ],
        // Product 6
        [
            'name' => 'Samsung Galaxy S25 Ultra (512GB)',
            'price' => '₱1,200.00',
            'raw_price' => 1200.00,
            'image' => '../image/Shop/TechZone PH/Samsung Galaxy S25 Ultra (512GB).jpeg', // Fallback
            'rating' => 4.6,
            'sold' => 3000
        ],
        // Product 7
        [
            'name' => 'Edifier Hi-Res Bookshelf Speakers',
            'price' => '₱1,500.00',
            'raw_price' => 1500.00,
            'image' => '../image/Shop/TechZone PH/Edifier Hi-Res Bookshelf Speakers.jpeg',
            'rating' => 4.8,
            'sold' => 1500
        ],
        // Product 8
        [
            'name' => 'Logitech M350S Pebble Mouse 2',
            'price' => '₱350.00',
            'raw_price' => 350.00,
            'image' => '../image/Shop/TechZone PH/Logitech M350S Pebble Mouse 2.jpeg', // Using stylized image
            'rating' => 4.2,
            'sold' => 1100
        ],
        // Product 9
        [
            'name' => 'Tecno CAMON 40 Pro 5G',
            'price' => '₱1,100.00',
            'raw_price' => 1100.00,
            'image' => '../image/Shop/TechZone PH/Tecno CAMON 40 Pro 5G.jpeg',
            'rating' => 4.5,
            'sold' => 980
        ],
        // Product 10
        [
            'name' => 'Lexar THOR 8GB DDR4 3200MHz RAM',
            'price' => '₱850.00',
            'raw_price' => 850.00,
            'image' => '../image/Shop/TechZone PH/Lexar THOR 8GB DDR4 3200MHz RAM.jpeg',
            'rating' => 4.4,
            'sold' => 1300
        ],
        // Product 11
        [
            'name' => 'Xbox Wireless Controller (Carbon Black)',
            'price' => '₱1,800.00',
            'raw_price' => 1800.00,
            'image' => '../image/Shop/TechZone PH/Xbox Wireless Controller (Carbon Black).jpeg',
            'rating' => 4.7,
            'sold' => 670
        ],
        // Product 12
        [
            'name' => 'Lexar THOR 8GB DDR4 3200MHz RAM',
            'price' => '₱1,350.00',
            'raw_price' => 1350.00,
            'image' => '../image/Shop/TechZone PH/Lexar THOR 8GB DDR4 3200MHz RAM.jpeg',
            'rating' => 4.3,
            'sold' => 2500
        ],
        // Product 13
        [
            'name' => 'Tecno CAMON 40 Pro 5G',
            'price' => '₱450.00',
            'raw_price' => 450.00,
            'image' => '../image/Shop/TechZone PH/Tecno CAMON 40 Pro 5G.jpeg',
            'rating' => 4.1,
            'sold' => 4200
        ],
        // Product 14
        [
            'name' => '1stPlayer Go2 Mesh Gaming Case',
            'price' => '₱1,200.00',
            'raw_price' => 1200.00,
            'image' => '../image/Shop/TechZone PH/1stPlayer Go2 Mesh Gaming Case.jpeg',
            'rating' => 4.9,
            'sold' => 3100
        ],
        // Product 15
        [
            'name' => 'KZ EDC In-Ear Monitors (IEMs)',
            'price' => '₱299.00',
            'raw_price' => 299.00,
            'image' => '../image/Shop/TechZone PH/KZ EDC In-Ear Monitors (IEMs).jpeg',
            'rating' => 4.0,
            'sold' => 1800
        ]
    ];
    return; // Stop processing
}
?>
