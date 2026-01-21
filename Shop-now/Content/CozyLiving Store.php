<?php
if (isset($rendering_header) && $rendering_header) {
    ?>
    <div class="store-header-panel">
        <div class="store-info">
            <img src="https://ui-avatars.com/api/?name=CL&background=27ae60&color=fff&size=64" alt="Logo"
                class="store-logo-small">
            <div class="store-details">
                <h1>CozyLiving Store</h1>
                <p>Home Decor</p>
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
// Custom Products List for DailyFits Co
// ------------------------------------
if (isset($definingProducts) && $definingProducts) {
    $manualProducts = [
        // Product 1
        [
            'name' => 'HAY Flowerpot and Saucer',
            'price' => '₱290.00',
            'raw_price' => 1200.00,
            'image' => '../image/Shop/CozyLiving Store/HAY Flowerpot and Saucer.jpeg',
            'rating' => 4.8,
            'sold' => 1020
        ],
        // Product 2
        [
            'name' => 'George Glass Vase Clear Shape 3',
            'price' => '₱1,195',
            'raw_price' => 1099.00,
            'image' => '../image/Shop/CozyLiving Store/George Glass Vase Clear Shape 3.jpeg',
            'rating' => 4.5,
            'sold' => 3400
        ],
        // Product 3
        [
            'name' => 'Village Thrive Imperfect Rattan Eye Decor',
            'price' => '₱990.00',
            'raw_price' => 2299.00,
            'image' => '../image/Shop/CozyLiving Store/Village Thrive Imperfect Rattan Eye Decor.jpeg',
            'rating' => 4.7,
            'sold' => 850
        ],
        // Product 4
        [
            'name' => 'WAN JAI Rattan Wall Hanging Decor',
            'price' => '₱229.00',
            'raw_price' => 95.00,
            'image' => '../image/Shop/CozyLiving Store/WAN JAI Rattan Wall Hanging Decor.jpeg',
            'rating' => 4.9,
            'sold' => 540
        ],
        // Product 5
        [
            'name' => 'Wood Chain',
            'price' => '₱199.00',
            'raw_price' => 95.00,
            'image' => '../image/Shop/CozyLiving Store/Wood Chain.jpeg',
            'rating' => 4.3,
            'sold' => 2100
        ],
        // Product 6
        [
            'name' => 'Disco Mushroom',
            'price' => '₱450',
            'raw_price' => 2295.00,
            'image' => '../image/Shop/CozyLiving Store/Disco Mushroom.jpeg',
            'rating' => 4.6,
            'sold' => 3000
        ],
        // Product 7
        [
            'name' => 'Ceramic Candle Set ',
            'price' => '₱249',
            'raw_price' => 1500.00,
            'image' => '../image/Shop/CozyLiving Store/Ceramic Candle Set.jpeg',
            'rating' => 4.8,
            'sold' => 1500
        ],
        // Product 8
        [
            'name' => 'Decorative Wall Art Frame',
            'price' => '₱1,250',
            'raw_price' => 350.00,
            'image' => '../image/Shop/CozyLiving Store/Decorative Wall Art Frame.jpeg',
            'rating' => 4.2,
            'sold' => 1100
        ],
        // Product 9
        [
            'name' => 'Throw Pillow Set (2 pcs)',
            'price' => '₱349',
            'raw_price' => 1100.00,
            'image' => '../image/Shop/CozyLiving Store/Throw Pillow Set (2 pcs).jpeg',
            'rating' => 4.5,
            'sold' => 980
        ],
        // Product 10
        [
            'name' => 'LED Marquee Sign',
            'price' => '₱580',
            'raw_price' => 850.00,
            'image' => '../image/Shop/CozyLiving Store/LED Marquee Sign.jpeg',
            'rating' => 4.4,
            'sold' => 1300
        ],
        // Product 11
        [
            'name' => 'Woven Storage Basket',
            'price' => '₱180',
            'raw_price' => 1800.00,
            'image' => '../image/Shop/CozyLiving Store/Woven Storage Basket.jpeg',
            'rating' => 4.7,
            'sold' => 670
        ],
        // Product 12
        [
            'name' => 'Faux Green Potted Plant',
            'price' => '₱1,495',
            'raw_price' => 1350.00,
            'image' => '../image/Shop/CozyLiving Store/Faux Green Potted Plant.jpeg',
            'rating' => 4.3,
            'sold' => 2500
        ],
        // Product 13
        [
            'name' => 'Macramé Wall Hanging',
            'price' => '₱219',
            'raw_price' => 450.00,
            'image' => '../image/Shop/CozyLiving Store/Macramé Wall Hanging.jpeg',
            'rating' => 4.1,
            'sold' => 4200
        ],
        // Product 14
        [
            'name' => 'Wooden Serving Tray',
            'price' => '₱149',
            'raw_price' => 1200.00,
            'image' => '../image/Shop/CozyLiving Store/Wooden Serving Tray.jpeg',
            'rating' => 4.9,
            'sold' => 3100
        ],
        // Product 15
        [
            'name' => 'Framed Mirror Accent (Medium)',
            'price' => '₱299',
            'raw_price' => 299.00,
            'image' => '../image/Shop/CozyLiving Store/Framed Mirror Accent (Medium).jpeg',
            'rating' => 4.0,
            'sold' => 1800
        ]
    ];
    return; // Stop processing
}
?>
