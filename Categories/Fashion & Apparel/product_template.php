<?php
// Centralized Product Data
// This replaces the need for 12+ separate files.
// Ideally, this should come from a database.

$products_data = [


    //product 1
    401 => [
        'name' => 'Men’s Plain T-Shirt (Cotton)',
        'price_range' => '₱149 - ₱170',
        'original_price' => '₱198',
        'discount' => '35% OFF',
        'image' => '../../image/Fashion & Apparel/Men’s Plain T-Shirt (Cotton).jpeg',
        'stock' => 1209,
        'colors' => ['Black', 'Grey', 'Blue'],
        'sizes' => ['S', 'M', 'L']
    ],

    //product 2
    402 => [
        'name' => 'Women’s Oversized Blouse',
        'price_range' => '₱340',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Fashion & Apparel/Women’s Oversized Blouse.jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],
    403 => [
        'name' => 'Slim Fit Denim Jeans (Men)',
        'price_range' => '₱340',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Fashion & Apparel/Slim Fit Denim Jeans (Men).jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    404 => [
        'name' => 'High-Waist Skinny Jeans (Women)',
        'price_range' => '₱1,500',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Fashion & Apparel/High-Waist Skinny Jeans (Women).jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    405 => [
        'name' => 'Unisex Hoodie (Pullover Style)',
        'price_range' => '₱2,500',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Fashion & Apparel/Unisex Hoodie (Pullover Style).jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    406 => [
        'name' => 'Casual Polo Shirt',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Fashion & Apparel/Casual Polo Shirt.jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    407 => [
        'name' => 'Summer Floral Dress',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Fashion & Apparel/Summer Floral Dress.jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    408 => [
        'name' => 'Jogger Pants (Unisex)',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Fashion & Apparel/Jogger Pants (Unisex).jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    409 => [
        'name' => 'Bomber Jacket (Lightweight)',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Fashion & Apparel/Bomber Jacket (Lightweight).jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    410 => [
        'name' => 'Crop Top (Trendy Style)',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Fashion & Apparel/Crop Top (Trendy Style).jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    411 => [
        'name' => 'Long Sleeve Polo Shirt',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Fashion & Apparel/Long Sleeve Polo Shirt.jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    412 => [
        'name' => 'Denim Jacket (Classic Fit)',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Fashion & Apparel/Denim Jacket (Classic Fit).jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    413 => [
        'name' => 'Cotton Shorts (Men Women)',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Fashion & Apparel/Cotton Shorts (Men Women).jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    414 => [
        'name' => 'Cardigan Sweater (Women)',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Fashion & Apparel/Cardigan Sweater (Women).jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    415 => [
        'name' => 'Athletic Leggings (High Waist)',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Fashion & Apparel/Athletic Leggings (High Waist).jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],



];

// Get ID or default
$p_id = isset($product_id) ? $product_id : 401;
$product = isset($products_data[$p_id]) ? $products_data[$p_id] : $products_data['default'];

// Use simpler variable names for the template
$name = $product['name'];
$price = $product['price_range'];
$img = $product['image'];
?>

<link rel="stylesheet" href="../../Css/Dashboard/Best.css?v=<?php echo time(); ?>">

<div class="product-image">
    <img class="img1" src="<?php echo $img; ?>" alt="Product">
</div>
<div class="product-info">
    <p class="box-check">Choice</p>
    <h2><?php echo htmlspecialchars($name); ?></h2>

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
