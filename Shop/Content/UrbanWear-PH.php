<?php
if (isset($rendering_header) && $rendering_header) {
    ?>
    <div class="store-header-panel">
        <div class="store-info">
            <img src="https://ui-avatars.com/api/?name=UW&background=000000&color=fff&size=64" alt="Logo"
                class="store-logo-small">
            <div class="store-details">
                <h1>UrbanWear PH</h1>
                <p>Streetwear & Casual Outfits</p>
            </div>
        </div>
        <!-- Sort Controls -->
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
// Option to Define Custom Products List (Overrides Random Loop)
if (isset($definingProducts) && $definingProducts) {
    $manualProducts = [
        // Product 1
        [
            'name' => 'H&M Loose Fit Hoodie',
            'price' => '₱999',
            'raw_price' => 999,
            'image' => '../image/Shop/UrbanWear PH/H&M Loose Fit Hoodie.jpeg',
            'rating' => 4.5,
            'sold' => 433
        ],
        // Product 2
        [
            'name' => 'Pilipinas Hoodie',
            'price' => '₱4,108.06',
            'raw_price' => 4108.06,
            'image' => '../image/Shop/UrbanWear PH/Pilipinas Hoodie.avif',
            'rating' => 4.2,
            'sold' => 2400
        ],
        // Product 3
        [
            'name' => 'Team SKOOP Denim Jacket',
            'price' => '₱7,999.00',
            'raw_price' => 7999.00,
            'image' => '../image/Shop/UrbanWear PH/Team SKOOP Denim Jacket.jpeg',
            'rating' => 4.8,
            'sold' => 4700
        ],
        // Product 4
        [
            'name' => 'Adidas MU Tracksuit Jacket',
            'price' => '₱3,800.00',
            'raw_price' => 3800.00,
            'image' => '../image/Shop/UrbanWear PH/Adidas MU Tracksuit Jacket.jpeg',
            'rating' => 4.1,
            'sold' => 1100
        ],
        // Product 5
        [
            'name' => 'Baggy Denim Jeans',
            'price' => '₱288.00',
            'raw_price' => 288.00,
            'image' => '../image/Shop/UrbanWear PH/Baggy Denim Jeans.jpeg', // Using fallback
            'rating' => 4.5,
            'sold' => 4500
        ],
        // Product 6
        [
            'name' => 'GentEssential Korean Cargo Jogger Pants',
            'price' => '₱187.00',
            'raw_price' => 187.00,
            'image' => '../image/Shop/UrbanWear PH/GentEssential Korean Cargo Jogger Pants.jpeg',
            'rating' => 4.0,
            'sold' => 5000
        ],
        // Product 7
        [
            'name' => 'Branded Mens Twill Cargo Jogger Pants',
            'price' => '₱699.00',
            'raw_price' => 699.00,
            'image' => '../image/Shop/UrbanWear PH/Branded Men\'s Twill Cargo Jogger Pants.jpeg',
            'rating' => 4.3,
            'sold' => 3200
        ],
        // Product 8
        [
            'name' => 'Hot Big Pockets Cargo Pants',
            'price' => '₱1,299.00',
            'raw_price' => 1299.00,
            'image' => '../image/Shop/UrbanWear PH/Hot Big Pockets Cargo Pants.jpeg',
            'rating' => 4.6,
            'sold' => 1200
        ],
        // Product 9
        [
            'name' => 'Pants',
            'price' => '₱2,597.00',
            'raw_price' => 2597.00,
            'image' => '../image/Shop/UrbanWear PH/Pants.jpeg',
            'rating' => 4.9,
            'sold' => 890
        ],
        // Product 10
        [
            'name' => 'Harajuku Fashion Techwear Cargo Pants',
            'price' => '₱890.00',
            'raw_price' => 890.00,
            'image' => '../image/Shop/UrbanWear PH/Pant.jpeg',
            'rating' => 4.7,
            'sold' => 500
        ],
        // Product 11
        [
            'name' => 'Men H&M Loose Fit Sweatshirt',
            'price' => '₱899.00',
            'raw_price' => 899.00,
            'image' => '../image/Shop/UrbanWear PH/Men H&M Loose Fit Sweatshirt.jpeg',
            'rating' => 4.4,
            'sold' => 6000
        ],
        // Product 12
        [
            'name' => 'Philippines Baybayin Hoodie',
            'price' => '₱348.00',
            'raw_price' => 348.00,
            'image' => '../image/Shop/UrbanWear PH/Philippines Baybayin Hoodie.jpeg',
            'rating' => 4.5,
            'sold' => 1500
        ],
        // Product 13
        [
            'name' => 'Pilipinas AOP Hoodie',
            'price' => '₱3,500',
            'raw_price' => 3500,
            'image' => '../image/Shop/UrbanWear PH/Pilipinas AOP Hoodie.jpeg',
            'rating' => 4.8,
            'sold' => 900
        ],
        // Product 14
        [
            'name' => 'solid street drip',
            'price' => '₱1,399.00',
            'raw_price' => 1399.00,
            'image' => '../image/Shop/UrbanWear PH/solid street drip.avif',
            'rating' => 4.1,
            'sold' => 2100
        ],
        // Product 15
        [
            'name' => 'Graphic Street Tee',
            'price' => '₱499.00',
            'raw_price' => 499.00,
            'image' => '../image/Shop/UrbanWear PH/Graphic Street Tee.jpeg', // Fallback for cap
            'rating' => 4.2,
            'sold' => 800
        ],
    ];
    return; // Stop processing
}
// ------------------------------------

if (isset($definingProducts) && $definingProducts) {
    $manualProducts = [
        [
            'name' => 'Urban Revivo Slim‑Fit Long‑Sleeved Shirt',
            'price' => '₱976.50',
            'raw_price' => 976.50,
            'image' => '../image/Shop/UrbanWear PH/longsleeve.jpeg', // Path to your image
            'rating' => 4.5, // 0 to 5
            'sold' => 433
        ],
        // You can copy the block above to add more unique products!
    ];
    return; // Stop processing
}
// 



