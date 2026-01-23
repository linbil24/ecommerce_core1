<?php
// Centralized Product Data
// This replaces the need for 12+ separate files.
// Ideally, this should come from a database.

$products_data = [

    //Product 1
    801 => [
        'name' => 'Board Game (Strategy)',
        'price_range' => '₱149 - ₱170',
        'original_price' => '₱198',
        'discount' => '35% OFF',
        'image' => '../../image/Toys & Games/Board Game (Strategy).jpeg',
        'stock' => 1209,
        'colors' => ['Black', 'Grey', 'Blue'],
        'sizes' => ['S', 'M', 'L']
    ],

    //Product 2
    802 => [
        'name' => 'Action Figure (Superhero)',
        'price_range' => '₱340',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Toys & Games/Action Figure (Superhero).jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    //Product 3
    803 => [
        'name' => 'Puzzle Set (1000 Pieces)',
        'price_range' => '₱340',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Toys & Games/Puzzle Set (1000 Pieces).jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    //Product 4
    804 => [
        'name' => 'Remote Control Car',
        'price_range' => '₱1,500',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Toys & Games/Remote Control Car.jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    //Product 5
    805 => [
        'name' => 'Doll House (Wooden)',
        'price_range' => '₱2,500',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Toys & Games/Doll House (Wooden).jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    //Product 6
    806 => [
        'name' => 'Building Blocks Set',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Toys & Games/Building Blocks Set.jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    //Product 7
    807 => [
        'name' => 'Plush Teddy Bear',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Toys & Games/Plush Teddy Bear.jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    //Product 8
    808 => [
        'name' => 'Educational Toy Tablet',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Toys & Games/Educational Toy Tablet.jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    //Product 9
    809 => [
        'name' => 'Drone with Camera',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Toys & Games/Drone with Camera.jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    //Product 10
    810 => [
        'name' => 'Chess Set (Magnetic)',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Toys & Games/Chess Set (Magnetic).jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],


    //Product 11
    811 => [
        'name' => 'Card Game (Family Fun)',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Toys & Games/Card Game (Family Fun).jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    //Product 12
    812 => [
        'name' => 'Toy Kitchen Set',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Toys & Games/Toy Kitchen Set.jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    //Product 13
    813 => [
        'name' => 'Inflatable Pool for Kids',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Toys & Games/Inflatable Pool for Kids.jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    //Product 14
    814 => [
        'name' => 'Musical Keyboard Toy',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Toys & Games/Musical Keyboard Toy.jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

    815 => [
        'name' => 'Yo-Yo (Pro Level)',
        'price_range' => '₱10,200',
        'original_price' => '₱500',
        'discount' => '32% OFF',
        'image' => '../../image/Toys & Games/Yo-Yo (Pro Level).jpeg',
        'stock' => 500,
        'colors' => ['Black', 'Pink', 'White'],
        'sizes' => ['Standard']
    ],

];

// Get ID or default
$p_id = isset($product_id) ? $product_id : 801;
$product = isset($products_data[$p_id]) ? $products_data[$p_id] : $products_data['default'];

// Use simpler variable names for the template
$name = $product['name'];
$price = $product['price_range'];
$img = $product['image'];
?>

<link rel="stylesheet" href="../../css/dashboard/best.css?v=<?php echo time(); ?>">

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


