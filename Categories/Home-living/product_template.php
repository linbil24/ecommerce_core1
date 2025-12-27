<?php
// Centralized Product Data
// This replaces the need for 12+ separate files.
// Ideally, this should come from a database.

$products_data = [

    //Product 1
    501 => [
        'name' => 'Decorative Throw Pillow Set',
        'price_range' => '₱149 - ₱170',
        'original_price' => '₱198',
        'discount' => '35% OFF',
        'image' => '../../Image/Home & living/Decorative Throw Pillow Set.jpeg',
        'stock' => 1209,
        'colors' => ['Black', 'Grey', 'Blue'],
        'sizes' => ['S', 'M', 'L']
    ],
    502 => [
        'name' => 'Aromatherapy Scented Candles',
        'price_range' => '₱340',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../Image/Home & living/Aromatherapy Scented Candles.jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],
    503 => [
        'name' => 'Non-Slip Floor Mat - Rug',
        'price_range' => '₱340',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../Image/Home & living/Non-Slip Floor Mat - Rug.jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    504 => [
        'name' => 'Wall Art Canvas Frame',
        'price_range' => '₱1,500',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../Image/Home & living/Wall Art Canvas Frame.jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    505 => [
        'name' => 'LED Table Lamp (Touch Control)',
        'price_range' => '₱2,500',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../Image/Home & living/LED Table Lamp (Touch Control).jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    506 => [
        'name' => 'Storage Basket Organizer',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../Image/Home & living/Storage Basket Organizer.jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    507 => [
        'name' => 'Ceramic Vase (Modern Design)',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../Image/Home & living/Ceramic Vase (Modern Design).jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    508 => [
        'name' => 'Kitchen Spice Rack Organizer',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../Image/Home & living/Kitchen Spice Rack Organizer.jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    509 => [
        'name' => 'Foldable Laundry Basket',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../Image/Home & living/Foldable Laundry Basket.jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    510 => [
        'name' => 'Electric Kettle (1.7L)',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../Image/Home & living/Electric Kettle (1.7L).jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    511 => [
        'name' => 'Bedside Alarm Clock (Digital)',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../Image/Home & living/Bedside Alarm Clock (Digital).jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    512 => [
        'name' => 'Multi-Purpose Storage Box',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../Image/Home & living/Multi-Purpose Storage Box.jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    513 => [
        'name' => 'Wall Mounted Floating Shelf',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../Image/Home & living/Wall Mounted Floating Shelf.jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    514 => [
        'name' => 'Bathroom Shower Caddy Organizer',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../Image/Home & living/Bathroom Shower Caddy Organizer.jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    515 => [
        'name' => 'Tabletop Indoor Plant (Artificial)',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../Image/Home & living/Tabletop Indoor Plant (Artificial).jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],






];

// Get ID or default
$p_id = isset($product_id) ? $product_id : 501;
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