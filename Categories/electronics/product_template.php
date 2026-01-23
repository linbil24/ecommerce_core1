<?php
// Centralized Product Data
// This replaces the need for 12+ separate files.
// Ideally, this should come from a database.

$products_data = [

    //Product 1
    301 => [
        'name' => 'Wireless Bluetooth Earbuds',
        'price_range' => '₱149 - ₱170',
        'original_price' => '₱198',
        'discount' => '35% OFF',
        'image' => '../../image/Electronics/Wireless Bluetooth Earbuds.jpeg',
        'stock' => 1209,
        'colors' => ['Black', 'Grey', 'Blue'],
        'sizes' => ['S', 'M', 'L']
    ],

    //Product 2
    302 => [
        'name' => 'Smart Watch (Fitness Tracker)',
        'price_range' => '₱340',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Electronics/Smart Watch (Fitness Tracker).jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    //Product 3
    303 => [
        'name' => 'Portable Power Bank 20,000mAh',
        'price_range' => '₱340',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Electronics/Portable Power Bank 20,000mAh.jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    //Product 4
    304 => [
        'name' => 'Bluetooth Speaker (Waterproof)',
        'price_range' => '₱1,500',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Electronics/Bluetooth Speaker (Waterproof).jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    //Product 5
    305 => [
        'name' => 'USB-C Fast Charging Cable',
        'price_range' => '₱2,500',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Electronics/USB-C Fast Charging Cable.jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    //Product 6
    306 => [
        'name' => 'Smart Watch (Fitness Tracker)',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Electronics/Smart Watch (Fitness Tracker).jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    //Product 7
    307 => [
        'name' => 'Noise Cancelling Headphones',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Electronics/Noise Cancelling Headphones.jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    //Product 8
    308 => [
        'name' => 'Mini WiFi Router / Pocket WiFi',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Electronics/Mini WiFi Router Pocket WiFi.jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    //Product 9
    309 => [
        'name' => 'Smart LED Light Bulb (WiFi Controlled)',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Electronics/Smart LED Light Bulb (WiFi Controlled).jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    //Product 10
    310 => [
        'name' => 'Laptop Cooling Pad (RGB Fan)',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Electronics/Laptop Cooling Pad RGB Fan.jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],


    //Product 11
    311 => [
        'name' => '1080p HD Web Camera',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Electronics/1080p HD Web Camera.jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    //Product 12
    312 => [
        'name' => 'Smart Plug (App Controlled)',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Electronics/Smart Plug (App Controlled).jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    //Product 13
    313 => [
        'name' => 'Portable SSD 500GB',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Electronics/Portable SSD 500GB.jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    //Product 14
    314 => [
        'name' => 'Digital Alarm Clock with LED Display',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Electronics/Digital Alarm Clock with LED Display.jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    315 => [
        'name' => 'Car Phone Holder (Magnetic)',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Electronics/Car Phone Holder (Magnetic).jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

];

// Get ID or default
$p_id = isset($product_id) ? $product_id : 301;
$product = isset($products_data[$p_id]) ? $products_data[$p_id] : $products_data['default'];

// Use simpler variable names for the template
$name = $product['name'];
$price = $product['price_range'];
$img = $product['image'];
?>

<link rel="stylesheet" href="../../css/components/product-view.css?v=<?php echo time(); ?>">

<div class="product-image">
    <img class="img1" src="<?php echo $img; ?>" alt="Product">
</div>
<div class="product-info">
    <p class="box-check">Choice</p>
    <h2><?php echo htmlspecialchars($name); ?></h2>

    <!-- Rating/Sold Summary -->
    <div class="rating-summary-row">
        <div class="rating-summary-item">
            <span class="rating-count" style="color: #ee4d2d; border-bottom: 1px solid #ee4d2d;">4.9</span>
            <div class="stars-orange">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>
        </div>
        <div class="rating-summary-item">
            <span class="rating-count">1.5k</span>
            <span style="color: #757575; font-size: 14px; margin-left: 5px;">Ratings</span>
        </div>
        <div class="rating-summary-item">
            <span style="color: #222; font-weight: 500;">4.2k</span>
            <span style="color: #757575; font-size: 14px; margin-left: 5px;">Sold</span>
        </div>
    </div>

    <!-- Price Section -->
    <div class="price-section">
        <span class="original-price"><?php echo $product['original_price']; ?></span>
        <span class="price"><?php echo $price; ?></span>
        <span class="discount"><?php echo $product['discount']; ?></span>
    </div>

    <!-- Shipping -->
    <div class="row-item">
        <span class="row-label">Shipping</span>
        <div class="shipping-info">
            <div class="shipping-row">
                <i class="fas fa-truck free-shipping-icon" style="color:#00bfa5;"></i>
                <span>Free shipping</span>
            </div>
            <div class="shipping-row">
                <i class="fas fa-truck" style="color:#757575;"></i>
                <span>Shipping to Metro Manila, Metro Manila</span>
            </div>
        </div>
    </div>

    <!-- Color Options -->
    <div class="row-item">
        <span class="row-label">Color</span>
        <div class="options-container" id="color-options">
            <?php foreach ($product['colors'] as $color): ?>
                <button class="option-btn" data-val="<?php echo $color; ?>">
                    <?php if (file_exists($img)): ?><img src="<?php echo $img; ?>" alt=""><?php endif; ?>
                    <?php echo $color; ?>
                </button>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Size Options -->
    <div class="row-item">
        <span class="row-label">Size</span>
        <div class="options-container" id="size-options">
            <?php foreach ($product['sizes'] as $size): ?>
                <button class="option-btn" data-val="<?php echo $size; ?>"><?php echo $size; ?></button>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Quantity -->
    <div class="row-item">
        <span class="row-label">Quantity</span>
        <div class="quantity-input">
            <button class="qty-btn" onclick="let q=document.getElementById('qty'); if(q.value>1)q.value--;">-</button>
            <input type="text" id="qty" class="qty-val" value="1">
            <button class="qty-btn" onclick="document.getElementById('qty').value++;">+</button>
        </div>
        <span
            style="margin-left: 15px; font-size: 14px; color: #757575;"><?php echo number_format($product['stock']); ?>
            pieces available</span>
    </div>

    <!-- Actions -->
    <div class="action-buttons">
        <a class="btn-add-cart" href="#" onclick="addToCart()">
            <i class="fas fa-cart-plus"></i> Add To Cart
        </a>
        <a href="#"
            onclick="const qty = document.getElementById('qty').value; window.location.href='../../Content/Payment.php?product_name=<?php echo urlencode($name); ?>&price=<?php echo floatval(preg_replace('/[^0-9.]/', '', $price)); ?>&image=<?php echo urlencode($img); ?>&quantity=' + qty + '&product_id=<?php echo $p_id; ?>'; return false;"
            class="btn-buy-now">Buy Now</a>
    </div>



    <script>
        function addToCart() {
            // Simplified for brevity, same logic applies
            const colorBtn = document.querySelector('#color-options .option-btn.selected');
            const sizeBtn = document.querySelector('#size-options .option-btn.selected');

            // Validation (Optional: You can uncomment these)
            // if (!colorBtn) { alert('Please select a Color first.'); return; }
            // if (!sizeBtn) { alert('Please select a Size first.'); return; }

            const color = colorBtn ? colorBtn.getAttribute('data-val') : 'Default';
            const size = sizeBtn ? sizeBtn.getAttribute('data-val') : 'Default';
            const qty = document.getElementById('qty').value;

            const fullName = `<?php echo addslashes($name); ?> (${color}, ${size})`;
            const price = <?php echo floatval(preg_replace('/[^0-9.]/', '', $price)); ?>;
            const img = '<?php echo $img; ?>';

            window.location.href = `../../Content/add-to-cart.php?add_to_cart=1&product_name=${encodeURIComponent(fullName)}&price=${price}&image=${img}&quantity=${qty}&store=IMarket%20Best%20Selling`;
        }

        // Add click event to all option buttons
        document.querySelectorAll('.options-container').forEach(container => {
            container.querySelectorAll('.option-btn').forEach(button => {
                button.addEventListener('click', function () {
                    container.querySelectorAll('.option-btn').forEach(btn => btn.classList.remove('selected'));
                    this.classList.add('selected');
                });
            });
        });
    </script>
</div>