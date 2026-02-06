<?php
if (isset($rendering_header) && $rendering_header) {
    ?>
    <div class="store-header-panel">
        <div class="store-info">
            <img src="https://ui-avatars.com/api/?name=TB&background=8e44ad&color=fff&size=64" alt="Logo"
                class="store-logo-small">
            <div class="store-details">
                <h1>TrendyBags PH</h1>
                <p>Stylish Bags</p>
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
// Custom Products List for TrendyBags PH
// ------------------------------------
if (isset($definingProducts) && $definingProducts) {
    $manualProducts = [
        // Product 1
        [
            'name' => 'Olive Utility Messenger',
            'price' => '₱1,200.00',
            'raw_price' => 1200.00,
            'image' => '../image/Shop/TrendyBags PH/Olive Utility Messenger.jpeg',
            'rating' => 4.8,
            'sold' => 1020
        ],
        // Product 2
        [
            'name' => 'Suede Shoulder Bag (Dark Moss)',
            'price' => '₱899.00',
            'raw_price' => 899.00,
            'image' => '../image/Shop/TrendyBags PH/Suede Shoulder Bag (Dark Moss).jpeg',
            'rating' => 4.5,
            'sold' => 3400
        ],
        // Product 3
        [
            'name' => 'Half Moon Leather Purse',
            'price' => '₱1,250.00',
            'raw_price' => 1250.00,
            'image' => '../image/Shop/TrendyBags PH/Half Moon Leather Purse.jpeg',
            'rating' => 4.7,
            'sold' => 850
        ],
        // Product 4
        [
            'name' => 'Canvas Tote with Scarf',
            'price' => '₱2,800.00',
            'raw_price' => 2800.00,
            'image' => '../image/Shop/TrendyBags PH/Canvas Tote with Scarf.jpeg',
            'rating' => 4.9,
            'sold' => 540
        ],
        // Product 5
        [
            'name' => 'Mother of Pearl Clutch',
            'price' => '₱750.00',
            'raw_price' => 750.00,
            'image' => '../image/Shop/TrendyBags PH/Mother of Pearl Clutch.jpeg',
            'rating' => 4.3,
            'sold' => 2100
        ],
        // Product 6
        [
            'name' => 'Nylon Dumpling Bag',
            'price' => '₱1,200.00',
            'raw_price' => 1200.00,
            'image' => '../image/Shop/TrendyBags PH/Nylon Dumpling Bag.jpeg',
            'rating' => 4.6,
            'sold' => 3000
        ],
        // Product 7
        [
            'name' => 'Anderson Top Handle Bag',
            'price' => '₱1,500.00',
            'raw_price' => 1500.00,
            'image' => '../image/Shop/TrendyBags PH/Anderson Top Handle Bag.jpeg',
            'rating' => 4.8,
            'sold' => 1500
        ],
        // Product 8
        [
            'name' => 'Crocodile Vanity Bag',
            'price' => '₱350.00',
            'raw_price' => 350.00,
            'image' => '../image/Shop/TrendyBags PH/Crocodile Vanity Bag.jpeg', // Using stylized image
            'rating' => 4.2,
            'sold' => 1100
        ],
        // Product 9
        [
            'name' => 'Pop Toft Tote Bag',
            'price' => '₱1,100.00',
            'raw_price' => 1100.00,
            'image' => '../image/Shop/TrendyBags PH/Pop Toft Tote Bag.jpeg',
            'rating' => 4.5,
            'sold' => 980
        ],
        // Product 10
        [
            'name' => 'Woven Suede Crossbody',
            'price' => '₱850.00',
            'raw_price' => 850.00,
            'image' => '../image/Shop/TrendyBags PH/Woven Suede Crossbody.jpeg',
            'rating' => 4.4,
            'sold' => 1300
        ],
        // Product 11
        [
            'name' => 'Buntal Shoulder Bag',
            'price' => '₱1,800.00',
            'raw_price' => 1800.00,
            'image' => '../image/Shop/TrendyBags PH/Buntal Shoulder Bag.jpeg',
            'rating' => 4.7,
            'sold' => 670
        ],
        // Product 12
        [
            'name' => 'Metallic Ruched Hobo Bag',
            'price' => '₱1,350.00',
            'raw_price' => 1350.00,
            'image' => '../image/Shop/TrendyBags PH/Metallic Ruched Hobo Bag.jpeg',
            'rating' => 4.3,
            'sold' => 2500
        ],
        // Product 13
        [
            'name' => 'Snoopy Peanuts Shopper',
            'price' => '₱450.00',
            'raw_price' => 450.00,
            'image' => '../image/Shop/TrendyBags PH/Snoopy Peanuts Shopper.jpeg',
            'rating' => 4.1,
            'sold' => 4200
        ],
        // Product 14
        [
            'name' => 'Landscape Satchel',
            'price' => '₱1,200.00',
            'raw_price' => 1200.00,
            'image' => '../image/Shop/TrendyBags PH/Landscape Satchel.jpeg',
            'rating' => 4.9,
            'sold' => 3100
        ],
        // Product 15
        [
            'name' => 'Faux Shearling Shoulder Bag',
            'price' => '₱299.00',
            'raw_price' => 299.00,
            'image' => '../image/Shop/TrendyBags PH/Faux Shearling Shoulder Bag.jpeg',
            'rating' => 4.0,
            'sold' => 1800
        ]
    ];
    return; // Stop processing
}
?>