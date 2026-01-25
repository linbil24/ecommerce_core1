<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../image/logo.png">
    <title>
        <?php echo isset($_GET['store']) ? htmlspecialchars(urldecode($_GET['store'])) . ' - IMARKET PH' : 'SHOP NOW - IMARKET PH'; ?>
    </title>
</head>

<body>
    <nav>
        <?php $path_prefix = '../';
        include '../Components/header.php'; ?>
    </nav>

    <!-- Link Shop CSS after header to ensure it takes precedence or cascades correctly -->
    <link rel="stylesheet" href="../css/shop/shop.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/shop/shop_landing.css?v=<?php echo time(); ?>">

    <div class="content">
        <div class="shop-container">
            <?php
            // Define Shops Array
            $shops = [
                [
                    "name" => "UrbanWear PH",
                    "category" => "Streetwear & Casual Outfits",
                    "rating" => "4.8",
                    "sold" => "25k",
                    "initials" => "UW",
                    "bg" => "000000"
                ],
                [
                    "name" => "StyleHub Manila",
                    "category" => "Trendy Men & Women Fashion",
                    "rating" => "4.9",
                    "sold" => "18k",
                    "initials" => "SH",
                    "bg" => "d68910"
                ],
                [
                    "name" => "DailyFits Co.",
                    "category" => "Pang-daily na damit",
                    "rating" => "4.7",
                    "sold" => "30k",
                    "initials" => "DF",
                    "bg" => "27ae60"
                ],
                [
                    "name" => "LuxeBasics",
                    "category" => "Minimalist & Basic Wear",
                    "rating" => "4.8",
                    "sold" => "22k",
                    "initials" => "LB",
                    "bg" => "333333"
                ],
                [
                    "name" => "TechZone PH",
                    "category" => "Gadgets & Accessories",
                    "rating" => "4.9",
                    "sold" => "40k",
                    "initials" => "TZ",
                    "bg" => "2980b9"
                ],
                [
                    "name" => "SmartGear Store",
                    "category" => "Phone Accessories",
                    "rating" => "4.8",
                    "sold" => "28k",
                    "initials" => "SG",
                    "bg" => "2c3e50"
                ],
                [
                    "name" => "GadgetLab PH",
                    "category" => "Budget Electronics",
                    "rating" => "4.6",
                    "sold" => "15k",
                    "initials" => "GL",
                    "bg" => "e67e22"
                ],
                [
                    "name" => "CozyLiving Store",
                    "category" => "Home Decor",
                    "rating" => "4.7",
                    "sold" => "14k",
                    "initials" => "CL",
                    "bg" => "8e44ad"
                ],
                [
                    "name" => "GlowUp Beauty",
                    "category" => "Skincare & Makeup",
                    "rating" => "4.9",
                    "sold" => "20k",
                    "initials" => "GU",
                    "bg" => "e91e63"
                ],
                [
                    "name" => "FreshLook PH",
                    "category" => "Personal Care Products",
                    "rating" => "4.8",
                    "sold" => "17k",
                    "initials" => "FL",
                    "bg" => "1abc9c"
                ],
                [
                    "name" => "HomeEssentials PH",
                    "category" => "Kitchen & Home Items",
                    "rating" => "4.8",
                    "sold" => "35k",
                    "initials" => "HE",
                    "bg" => "c0392b"
                ],
                [
                    "name" => "TrendyBags PH",
                    "category" => "Stylish Bags",
                    "rating" => "4.7",
                    "sold" => "14k",
                    "initials" => "TB",
                    "bg" => "795548"
                ]
            ];

            // Mock Products Data
            function getMockProducts($storeName)
            {
                // Generate some deterministic mock products based on store name
                $seed = crc32($storeName);
                srand($seed);

                $products = [];
                $productNames = ['T-Shirt', 'Jeans', 'Sneakers', 'Watch', 'Headphones', 'Bag', 'Lamp', 'Phone Case', 'Lipstick', 'Coffee Maker', 'Hoodie', 'Socks', 'Cap', 'Shorts'];
                $adjectives = ['Classic', 'Premium', 'Basic', 'Stylish', 'Modern', 'Urban', 'Cozy'];

                // 1. Determine Correct Content File (Once)
                $safeStoreName = rtrim($storeName, '.');
                $exactFile = 'Content/' . $safeStoreName . '.php';
                $dashedFile = 'Content/' . str_replace(' ', '-', $safeStoreName) . '.php';
                $fileToLoad = 'Content/UrbanWear-PH.php'; // Default
            

                if (file_exists($exactFile) && filesize($exactFile) > 0) {
                    $fileToLoad = $exactFile;
                } elseif (file_exists($dashedFile) && filesize($dashedFile) > 0) {
                    $fileToLoad = $dashedFile;
                }

                // 2. Check for Manual Product List (No Loop Mode)
                $manualProducts = [];
                $definingProducts = true; // Signal to included file
                include $fileToLoad;

                if (!empty($manualProducts)) {
                    return $manualProducts;
                }

                // 3. Fallback: Generate Mock Products Loop
                for ($i = 0; $i < 15; $i++) {
                    $price = rand(150, 1500);
                    $name = $adjectives[array_rand($adjectives)] . ' ' . $productNames[array_rand($productNames)];
                    $image = 'https://via.placeholder.com/300x400/f5f5f5/999999?text=' . urlencode($name);

                    // image/Override selection logic
                    include $fileToLoad;

                    $products[] = [
                        'name' => $name,
                        'price' => is_numeric($price) ? '₱' . number_format($price) : $price,
                        'raw_price' => is_numeric($price) ? $price : floatval(preg_replace('/[^0-9.]/', '', $price)),
                        'image' => $image,
                        'rating' => 4.0 + (rand(0, 9) / 10),
                        'sold' => rand(100, 5000)
                    ];
                }
                return $products;
            }


            // CHECK: Is a store selected?
            if (isset($_GET['store'])) {
                $selectedStore = urldecode($_GET['store']);

                // Find selected shop details
                $currentShop = null;
                foreach ($shops as $s) {
                    if ($s['name'] === $selectedStore) {
                        $currentShop = $s;
                        break;
                    }
                }
                if (!$currentShop)
                    $currentShop = $shops[0];

                $products = getMockProducts($selectedStore);

                // --- Sorting Logic ---
                $sort = $_GET['sort'] ?? 'best';
                if ($sort === 'price_asc') {
                    usort($products, fn($a, $b) => $a['raw_price'] <=> $b['raw_price']);
                } elseif ($sort === 'price_desc') {
                    usort($products, fn($a, $b) => $b['raw_price'] <=> $a['raw_price']);
                } elseif ($sort === 'sales') {
                    usort($products, fn($a, $b) => $b['sold'] <=> $a['sold']);
                } elseif ($sort === 'latest') {
                    // Start deterministic, but if sorted by latest, shuffle properly
                    shuffle($products);
                }
                // 'best' is default order
                // ---------------------
                ?>

                <!-- Mimic Category UI: Link CSS -->
                <link rel="stylesheet" href="../css/components/category-base.css?v=<?php echo time(); ?>">
                <style>
                    /* Specific Overrides for Shop View */
                    .best-selling-container {
                        margin-top: 20px;
                        margin-bottom: 40px;
                    }

                    .shop-seller-profile {
                        color: #fff;
                    }

                    .shop-seller-stats {
                        display: flex;
                        gap: 15px;
                        margin: 15px 0;
                        font-size: 0.9em;
                    }

                    .stat-item {
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                    }

                    .stat-val {
                        font-weight: bold;
                        font-size: 1.1em;
                    }

                    .stat-label {
                        font-size: 0.8em;
                        opacity: 0.8;
                    }

                    .seller-actions {
                        display: flex;
                        gap: 10px;
                        margin-top: 20px;
                    }

                    .btn-seller-action {
                        padding: 8px 15px;
                        border-radius: 4px;
                        text-decoration: none;
                        font-size: 0.9em;
                        border: 1px solid rgba(255, 255, 255, 0.3);
                        color: white;
                        transition: all 0.2s;
                    }

                    .btn-seller-action:hover {
                        background: rgba(255, 255, 255, 0.1);
                        border-color: white;
                    }

                    .btn-seller-primary {
                        background: white;
                        color: #333;
                        border: none;
                        font-weight: 600;
                    }

                    .btn-seller-primary:hover {
                        background: #f0f0f0;
                        color: #333;
                    }
                </style>

                <!-- NEW LAYOUT: Hero Split (Seller Profile + Banner) -->
                <div class="best-selling-container"
                    style="background: linear-gradient(135deg, #<?php echo $currentShop['bg']; ?> 0%, #1a1a1a 100%);">
                    <!-- Left: Seller Account/Profile -->
                    <div class="text-section" style="flex: 1; padding: 40px;">
                        <div class="shop-seller-profile">
                            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 10px;">
                                <img src="https://ui-avatars.com/api/?name=<?php echo $currentShop['initials']; ?>&background=fff&color=<?php echo $currentShop['bg']; ?>&size=64"
                                    alt="Logo"
                                    style="width: 64px; height: 64px; border-radius: 50%; border: 2px solid rgba(255,255,255,0.2);">
                                <div>
                                    <div
                                        style="font-size: 0.8em; opacity: 0.7; text-transform: uppercase; letter-spacing: 1px;">
                                        Official Store</div>
                                    <h2 style="margin: 0; font-size: 2em;"><?php echo htmlspecialchars($selectedStore); ?>
                                    </h2>
                                </div>
                            </div>

                            <p style="opacity: 0.9; margin-bottom: 5px;">
                                <?php echo htmlspecialchars($currentShop['category']); ?></p>

                            <div class="shop-seller-stats">
                                <div class="stat-item">
                                    <span class="stat-val"><?php echo $currentShop['rating']; ?>/5.0</span>
                                    <span class="stat-label">Rating</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-val"><?php echo $currentShop['sold']; ?></span>
                                    <span class="stat-label">Products Sold</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-val">100%</span>
                                    <span class="stat-label">Chat Response</span>
                                </div>
                            </div>

                            <div class="seller-actions">
                                <a href="#" class="btn-seller-action btn-seller-primary"><i class="fas fa-plus"></i>
                                    Follow</a>
                                <a href="#" class="btn-seller-action"><i class="fas fa-comment-dots"></i> Chat</a>
                                <a href="../Content/user-account.php?view=profile" class="btn-seller-action"><i
                                        class="fas fa-info-circle"></i> Seller Info</a>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Banner/Slider -->
                    <div class="slider-section" style="flex: 1.5;">
                        <div class="fade-slider">
                            <div class="fade-slide active"
                                style="background-image: url('https://via.placeholder.com/800x400/<?php echo $currentShop['bg']; ?>/ffffff?text=<?php echo urlencode($selectedStore . ' Collection'); ?>'); background-size: cover; background-position: center;">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content-card">
                    <div class="section-header"
                        style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 20px;">
                        <div>
                            <h2>Store Products</h2>
                            <p>Browse our latest collection</p>
                        </div>

                        <!-- Sort Controls -->
                        <div class="sort-controls">
                            <span class="sort-label">Sort By:</span>
                            <a href="?store=<?php echo urlencode($selectedStore); ?>&sort=best"
                                class="sort-btn <?php echo (!isset($_GET['sort']) || $_GET['sort'] == 'best') ? 'active' : ''; ?>">Best
                                Match</a>
                            <a href="?store=<?php echo urlencode($selectedStore); ?>&sort=latest"
                                class="sort-btn <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'latest') ? 'active' : ''; ?>">Latest</a>
                            <a href="?store=<?php echo urlencode($selectedStore); ?>&sort=sales"
                                class="sort-btn <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'sales') ? 'active' : ''; ?>">Top
                                Sales</a>
                        </div>
                    </div>

                    <!-- Product Grid -->
                    <div class="product-grid">
                        <?php
                        foreach ($products as $index => $product):
                            $rating = $product['rating'];
                            $soldVal = $product['sold'];
                            if ($soldVal > 1000) {
                                $soldDisp = number_format($soldVal / 1000, 1) . 'k';
                            } else {
                                $soldDisp = $soldVal;
                            }
                            ?>
                            <div class="product-card" data-name="<?php echo htmlspecialchars($product['name']); ?>"
                                data-price="<?php echo $product['price']; ?>"
                                data-raw-price="<?php echo $product['raw_price']; ?>"
                                data-image="<?php echo $product['image']; ?>" data-rating="<?php echo $product['rating']; ?>"
                                data-sold="<?php echo $soldDisp; ?>"
                                data-store="<?php echo htmlspecialchars($selectedStore); ?>" onclick="openProductModal(this)">

                                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>"
                                    class="product-img">
                                <h3 class="product-title"><?php echo htmlspecialchars($product['name']); ?></h3>
                                <div class="product-price"><?php echo $product['price']; ?></div>
                                <div class="product-meta-row">
                                    <div class="product-rating">
                                        <?php
                                        for ($i = 0; $i < 5; $i++) {
                                            if ($i < floor($rating))
                                                echo '<i class="fas fa-star"></i>';
                                            else
                                                echo '<i class="far fa-star"></i>';
                                        }
                                        ?>
                                    </div>
                                    <span class="product-sold"><?php echo $soldDisp; ?> Sold</span>
                                </div>
                                <button class="add-to-cart-btn">View Details</button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <?php
            } else {
                // DEFAULT VIEW: Shop List
                ?>
                <!-- LANDING VIEW (Hero + Featured) -->
                <div class="shop-hero">
                    <div class="shop-hero-overlay"></div>
                    <div class="shop-hero-content">
                        <h1 class="shop-hero-title">SHOP ALL PRODUCTS</h1>
                        <a href="?store=UrbanWear+PH" class="btn-hero-shop style-user">
                            <i class="fas fa-shopping-bag"></i> Shop Now
                        </a>
                    </div>
                </div>

                <div class="featured-section" style="margin-top: -3px; margin-bottom: 50px;">
                    <div class="featured-row" style="margin-top: 0; border-radius: 3px; overflow: hidden;">
                        <!-- Item 1 -->
                        <div class="featured-card">
                            <a href="?store=UrbanWear+PH" style="display:block; width:100%;">
                                <img src="../image/Shop/UrbanWear PH/H&M Loose Fit Hoodie.jpeg" alt="H&M Hoodie"
                                    style="width: 100%; height: 350px; object-fit: cover; object-position: top; border-radius: 0; margin-bottom: 0;">
                            </a>
                        </div>

                        <!-- Item 2 -->
                        <div class="featured-card">
                            <a href="?store=UrbanWear+PH" style="display:block; width:100%;">
                                <img src="../image/Shop/UrbanWear PH/Pilipinas Hoodie.avif" alt="Pilipinas Hoodie"
                                    style="width: 100%; height: 350px; object-fit: cover; object-position: center; border-radius: 0; margin-bottom: 0;">
                            </a>
                        </div>

                        <!-- Item 3 -->
                        <div class="featured-card">
                            <a href="?store=UrbanWear+PH" style="display:block; width:100%;">
                                <img src="../image/Shop/UrbanWear PH/Team SKOOP Denim Jacket.jpeg" alt="Team SKOOP"
                                    style="width: 100%; height: 350px; object-fit: cover; object-position: top; border-radius: 0; margin-bottom: 0;">
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Featured / Shop Grid (Keeping original grid below mostly for functionality, but stylized) -->
                <!-- Featured / Shop Grid removed as per request -->
                <!-- You can add featured categories or other content here later -->
                <?php
            }
            ?>
        </div>
    </div>
    <footer>
        <?php include '../Components/footer.php'; ?>
    </footer>

    <!-- Product Detail Modal -->
    <div id="productModal" class="modal-overlay">
        <div class="modal-content">
            <span class="modal-close" onclick="closeProductModal()">&times;</span>
            <div class="modal-left">
                <img id="modalImg" src="" alt="Product" class="modal-product-img">
            </div>
            <div class="modal-right">

                <div class="title">
                    <h1 id="modalHeaderTitle">
                        <img src="../image/logo.png" alt="IMarket" style="height: 50px; border:1px solid #000"> |
                        <span id="modalStoreSpan"><?php echo htmlspecialchars($selectedStore); ?></span>
                    </h1>
                </div>
                <p
                    style="margin-top: 0; margin-bottom: 20px; color: #000; text-align: center; font-family: 'Lato', sans-serif;">
                    <?php echo htmlspecialchars($currentShop['category']); ?>
                </p>
                <h2 id="modalTitle" class="modal-title">Product Name</h2>
                <div id="modalPrice" class="modal-price">₱0.00</div>

                <div class="modal-meta">
                    <div id="modalRating" class="modal-rating"></div>
                    <span id="modalSold"></span>
                </div>

                <!-- Mock Options -->
                <div class="modal-options">
                    <div class="option-group">
                        <span class="option-label">Color</span>
                        <div style="display:flex;">
                            <div class="option-btn selected" onclick="selectOption(this)">Black</div>
                            <div class="option-btn" onclick="selectOption(this)">White</div>
                            <div class="option-btn" onclick="selectOption(this)">Blue</div>
                        </div>
                    </div>
                    <div class="option-group">
                        <span class="option-label">Size</span>
                        <div style="display:flex;">
                            <div class="option-btn selected" onclick="selectOption(this)">M</div>
                            <div class="option-btn" onclick="selectOption(this)">L</div>
                            <div class="option-btn" onclick="selectOption(this)">XL</div>
                        </div>
                    </div>
                </div>

                <div class="quantity-control">
                    <button class="qty-btn" onclick="updateModalQty(-1)">-</button>
                    <input type="text" id="modalQty" class="qty-input" value="1" readonly>
                    <button class="qty-btn" onclick="updateModalQty(1)">+</button>
                </div>

                <div class="modal-actions">
                    <a id="modalAddToCartBtn" href="#" class="btn-add-cart">Add to Cart</a>
                    <a id="modalBuyNowBtn" href="#" class="btn-buy-now">Buy Now</a>
                </div>

                <!-- Reviews Section -->
                <div class="modal-reviews">
                    <h3>Reviews</h3>
                    <div id="modalReviewsList" class="reviews-list">
                        <!-- Reviews will be loaded here via JS or empty state -->
                        <div class="review-item" style="text-align:center; color:#999; border:none;">
                            No reviews yet.
                        </div>
                    </div>
                    <a id="modalRateLink" href="#" class="rate-product-link">Rate Product <i
                            class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentProduct = {};

        function selectOption(btn) {
            // Remove selected from siblings
            let group = btn.parentNode;
            let options = group.getElementsByClassName('option-btn');
            for (let i = 0; i < options.length; i++) options[i].classList.remove('selected');
            btn.classList.add('selected');
        }

        function openProductModal(element) {
            const name = element.getAttribute('data-name');
            const price = element.getAttribute('data-price');
            const rawPrice = element.getAttribute('data-raw-price');
            const image = element.getAttribute('data-image');
            const rating = element.getAttribute('data-rating');
            const sold = element.getAttribute('data-sold');
            const store = element.getAttribute('data-store');

            currentProduct = { name, price, rawPrice, image, store };

            document.getElementById('modalTitle').innerText = name;
            document.getElementById('modalPrice').innerText = price;
            document.getElementById('modalImg').src = image;

            document.getElementById('modalSold').innerText = sold + ' Sold';

            // Set Modal Store Name (Reset to product store on open)
            document.getElementById('modalStoreSpan').innerText = store;

            document.getElementById('modalQty').value = 1;

            updateModalLinks();

            // Fetch Reviews
            const reviewsContainer = document.getElementById('modalReviewsList');
            reviewsContainer.innerHTML = '<div style="text-align:center; padding:20px;">Loading...</div>';

            fetch(`fetch_reviews.php?product_name=${encodeURIComponent(name)}`)
                .then(response => response.text())
                .then(html => {
                    reviewsContainer.innerHTML = html;
                })
                .catch(err => {
                    reviewsContainer.innerHTML = '<div style="text-align:center; color:red;">Failed to load reviews.</div>';
                });

            const ratingVal = parseFloat(rating);
            let starsHtml = '';
            for (let i = 0; i < 5; i++) {
                if (i < Math.floor(ratingVal)) starsHtml += '<i class="fas fa-star"></i>';
                else starsHtml += '<i class="far fa-star"></i>';
            }
            document.getElementById('modalRating').innerHTML = starsHtml;

            const modal = document.getElementById('productModal');
            modal.style.display = 'flex';
            setTimeout(() => {
                modal.classList.add('show');
            }, 10);
        }

        function closeProductModal() {
            const modal = document.getElementById('productModal');
            modal.classList.remove('show');
            setTimeout(() => {
                modal.style.display = 'none';
            }, 300);
        }

        function updateModalQty(change) {
            const input = document.getElementById('modalQty');
            let val = parseInt(input.value);
            val += change;
            if (val < 1) val = 1;
            input.value = val;
            updateModalLinks();
        }

        function updateModalLinks() {
            const qty = document.getElementById('modalQty').value;
            // Construct URL for Add to Cart
            const baseAdd = `../Content/add-to-cart.php?add_to_cart=1&product_name=${encodeURIComponent(currentProduct.name)}&price=${currentProduct.rawPrice}&store=${encodeURIComponent(currentProduct.store)}&image=${encodeURIComponent(currentProduct.image)}&quantity=${qty}`;

            // Construct URL for Buy Now (Direct Checkout)
            const buyNowUrl = `../Content/Payment.php?product_name=${encodeURIComponent(currentProduct.name)}&price=${currentProduct.rawPrice}&quantity=${qty}&image=${encodeURIComponent(currentProduct.image)}`;

            document.getElementById('modalAddToCartBtn').href = baseAdd;
            document.getElementById('modalBuyNowBtn').href = buyNowUrl;

            // Rate Product Link
            document.getElementById('modalRateLink').href = `Rate-Reviews.php?product_name=${encodeURIComponent(currentProduct.name)}`;
        }

        window.onclick = function (event) {
            const modal = document.getElementById('productModal');
            if (event.target == modal) {
                closeProductModal();
            }
        }
    </script>
</body>

</html>