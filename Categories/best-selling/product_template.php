<?php
// Centralized Product Data
// This replaces the need for 12+ separate files.
// Ideally, this should come from a database.

$products_data = [
    101 => [
        'name' => 'Shoulder Bag Men',
        'price_range' => '₱149 - ₱170',
        'original_price' => '₱198',
        'discount' => '35% OFF',
        'image' => '../../image/Best-seller/bag-men.jpeg',
        'stock' => 1209,
        'colors' => ['Black', 'Grey', 'Blue'],
        'sizes' => ['S', 'M', 'L']
    ],
    102 => [
        'name' => 'Bag Women',
        'price_range' => '₱340',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Best-seller/bag-women.jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],
    103 => [
        'name' => 'Notebook',
        'price_range' => '₱340',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Best-seller/Notebooks.jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    104 => [
        'name' => 'Earphone Bluetooth',
        'price_range' => '₱1,500',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Best-seller/Earphone-bluetooth.jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    105 => [
        'name' => 'Snikers Shoes',
        'price_range' => '₱2,500',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Best-seller/snikers%20shoes.avif',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    106 => [
        'name' => 'Swatch Watch',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Best-seller/Snart%20watch.jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    107 => [
        'name' => 'Brand New SEALED HP Laptop i3',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Best-seller/laptop.jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    108 => [
        'name' => 'Desktop Computers & 2-in-1 PCs | Dell Philippines',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Best-seller/pc%20computer.avif',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    109 => [
        'name' => 'vivo pro max',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Best-seller/vivo%20pro%20max.jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    110 => [
        'name' => 'iphone 15 pro max na may kagat',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Best-seller/iphone.jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    111 => [
        'name' => 'Keyboard mechanical',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Best-seller/Keyboard-maagas.jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    112 => [
        'name' => 'Ben10 brief',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Best-seller/brief.jpg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    113 => [
        'name' => 'USB C Fast Charging Cable (2-Pack)',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Best-seller/USB%20C%20Fast%20Charging%20Cable%20(2-Pack).jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    114 => [
        'name' => 'Mini Bluetooth Speaker',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Best-seller/Mini%20Bluetooth%20Speaker.jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    115 => [
        'name' => 'Phone Ring Holder    ',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Best-seller/Phone%20Ring%20Holder.jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],
];

    // Fix pricing data for consistency
    foreach ($products_data as $id => &$p) {
        if (!$p) continue;
        if ($id == 101) continue; // Skip already correct one
        // Default logic: original price should be higher than current price
        if (isset($p['price_range']) && strpos($p['price_range'], '10,200') !== false) {
            $p['original_price'] = '₱15,000';
            $p['price_range'] = '₱10,200';
        } elseif ($id == 104) {
            $p['original_price'] = '₱2,200';
            $p['price_range'] = '₱1,500';
        } elseif ($id == 105) {
            $p['original_price'] = '₱3,800';
            $p['price_range'] = '₱2,500';
        } else {
            $p['original_price'] = '₱500';
            $p['price_range'] = '₱340';
        }
    }
    unset($p);

    // Get ID correctly
    $p_id = isset($product_id) ? $product_id : 101;

    // Refresh current product after data fix
    $product = isset($products_data[$p_id]) ? $products_data[$p_id] : $products_data[101];
    $price = $product['price_range'];
    $name = $product['name'];
    $img = $product['image'];
?>

<link rel="stylesheet" href="../../css/components/shared-product-view.css?v=<?php echo time(); ?>">

<div class="pv-left">
    <img class="pv-product-img" src="<?php echo $img; ?>" alt="Product">
</div>
<div class="pv-right">
    <div class="pv-header">
        <div class="pv-header-title">
            <img src="../../image/logo.png" alt="IMarket" class="pv-header-logo"> |
            <span>IMarket Official Store</span>
        </div>
        <p class="pv-category">
            Best Selling
        </p>
    </div>

    <h2 class="pv-title"><?php echo htmlspecialchars($name); ?></h2>
    
    <div class="pv-meta">
        <div class="pv-rating">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
        </div>
        <span>1.5k Ratings</span>
        <span>|</span>
        <span>4.2k Sold</span>
    </div>

    <div class="pv-price-container">
        <?php if (isset($product['original_price'])): ?>
            <span class="pv-original-price"><?php echo $product['original_price']; ?></span>
        <?php endif; ?>
        <span class="pv-price"><?php echo $price; ?></span>
        <?php if (isset($product['discount'])): ?>
            <span class="pv-discount-badge"><?php echo $product['discount']; ?></span>
        <?php endif; ?>
    </div>

    <!-- Color Options -->
    <div class="pv-option-group">
        <span class="pv-option-label">Color</span>
        <div class="pv-options" id="color-options">
            <?php foreach ($product['colors'] as $index => $color): ?>
                <button class="pv-option-btn <?php echo $index === 0 ? 'selected' : ''; ?>" data-val="<?php echo $color; ?>">
                    <?php echo $color; ?>
                </button>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Size Options -->
    <div class="pv-option-group">
        <span class="pv-option-label">Size</span>
        <div class="pv-options" id="size-options">
            <?php foreach ($product['sizes'] as $index => $size): ?>
                <button class="pv-option-btn <?php echo $index === 0 ? 'selected' : ''; ?>" data-val="<?php echo $size; ?>"><?php echo $size; ?></button>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Quantity -->
    <div class="pv-option-group">
        <span class="pv-option-label">Quantity</span>
        <div style="display: flex; align-items: center; gap: 15px;">
            <div class="pv-quantity-control">
                <button class="pv-qty-btn" onclick="let q=document.getElementById('qty'); if(q.value>1)q.value--;">-</button>
                <input type="text" id="qty" class="pv-qty-input" value="1">
                <button class="pv-qty-btn" onclick="document.getElementById('qty').value++;">+</button>
            </div>
            <span style="font-size: 14px; color: #757575;"><?php echo number_format($product['stock']); ?> pieces available</span>
        </div>
    </div>

    <!-- Actions -->
    <div class="pv-actions">
        <a class="pv-btn pv-btn-cart" href="#" onclick="addToCart()">
            <i class="fas fa-cart-plus" style="margin-right: 8px;"></i> Add To Cart
        </a>
        <a href="#"
            onclick="const qty = document.getElementById('qty').value; window.location.href='../../Content/Payment.php?product_name=<?php echo urlencode($name); ?>&price=<?php echo floatval(preg_replace('/[^0-9.]/', '', $price)); ?>&image=<?php echo urlencode($img); ?>&quantity=' + qty + '&product_id=<?php echo $p_id; ?>'; return false;"
            class="pv-btn pv-btn-buy">Buy Now</a>
    </div>

    <script>
        function addToCart() {
            const colorBtn = document.querySelector('#color-options .pv-option-btn.selected');
            const sizeBtn = document.querySelector('#size-options .pv-option-btn.selected');
            const color = colorBtn ? colorBtn.getAttribute('data-val') : 'Default';
            const size = sizeBtn ? sizeBtn.getAttribute('data-val') : 'Default';
            const qty = document.getElementById('qty').value;
            const fullName = `<?php echo addslashes($name); ?> (${color}, ${size})`;
            const price = <?php echo floatval(preg_replace('/[^0-9.]/', '', $price)); ?>;
            const img = '<?php echo $img; ?>';

            window.location.href = `../../Content/add-to-cart.php?add_to_cart=1&product_name=${encodeURIComponent(fullName)}&price=${price}&image=${img}&quantity=${qty}&store=IMarket%20Best%20Selling`;
        }

        document.querySelectorAll('.pv-options').forEach(container => {
            container.querySelectorAll('.pv-option-btn').forEach(button => {
                button.addEventListener('click', function () {
                    container.querySelectorAll('.pv-option-btn').forEach(btn => btn.classList.remove('selected'));
                    this.classList.add('selected');
                });
            });
        });
    </script>
</div>