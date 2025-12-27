<?php
// Centralized Product Data for New Arrivals
$products_data = [

    //Product 1
    201 => [
        'name' => 'Classic Leather Wallet (Men)',
        'price_range' => '₱180',
        'original_price' => '₱225',
        'discount' => '20% OFF',
        'image' => '../../Image/New-arrivals/Classic Leather Wallet (Men).jpeg',
        'stock' => 50,
        'colors' => ['Brown', 'Black', 'Tan'],
        'sizes' => ['Standard']
    ],

    //Product 2
    202 => [
        'name' => 'Trendy Crossbody Bag (Women)',
        'price_range' => '₱1,495',
        'original_price' => '₱1,899',
        'discount' => '20% OFF',
        'image' => '../../Image/New-arrivals/Trendy Crossbody Bag (Women).jpeg',
        'stock' => 30,
        'colors' => ['Beige', 'Black', 'Pink'],
        'sizes' => ['Standard']
    ],

    //Product 3
    203 => [
        'name' => 'Wireless Bluetooth Earbuds',
        'price_range' => '₱219',
        'original_price' => '₱300',
        'discount' => '27% OFF',
        'image' => '../../Image/New-arrivals/Wireless Bluetooth Earbuds.jpeg',
        'stock' => 100,
        'colors' => ['Black', 'White'],
        'sizes' => ['Standard']
    ],

    //Product 4
    204 => [
        'name' => 'Oversized Graphic T-Shirt',
        'price_range' => '₱149',
        'original_price' => '₱299',
        'discount' => '50% OFF',
        'image' => '../../Image/New-arrivals/Oversized Graphic T-Shirt.jpeg',
        'stock' => 200,
        'colors' => ['Black', 'White', 'Navy'],
        'sizes' => ['S', 'M', 'L', 'XL']
    ],

    //Product 5
    205 => [
        'name' => 'Smart LED Desk Lamp',
        'price_range' => '₱299',
        'original_price' => '₱499',
        'discount' => '40% OFF',
        'image' => '../../Image/New-arrivals/Smart LED Desk Lamp.jpeg',
        'stock' => 45,
        'colors' => ['White'],
        'sizes' => ['Standard']
    ],

    //Product 6
    206 => [
        'name' => 'Minimalist Wrist Watch',
        'price_range' => '₱299',
        'original_price' => '₱499',
        'discount' => '40% OFF',
        'image' => '../../Image/New-arrivals/Minimalist Wrist Watch.jpeg',
        'stock' => 45,
        'colors' => ['Black', 'Silver'],
        'sizes' => ['Standard']
    ],

    //Product 7
    207 => [
        'name' => 'Canvas Tote Bag',
        'price_range' => '₱299',
        'original_price' => '₱499',
        'discount' => '40% OFF',
        'image' => '../../Image/New-arrivals/Canvas Tote Bag.jpeg',
        'stock' => 45,
        'colors' => ['Beige', 'Black'],
        'sizes' => ['Standard']
    ],

    //Product 8
    208 => [
        'name' => 'Portable Power Bank 10,000mAh',
        'price_range' => '₱299',
        'original_price' => '₱499',
        'discount' => '40% OFF',
        'image' => '../../Image/New-arrivals/Portable Power Bank 10,000mAh.jpeg',
        'stock' => 45,
        'colors' => ['Black', 'White'],
        'sizes' => ['Standard']
    ],

    //Product 9
    209 => [
        'name' => 'Fashion Sunglasses (UV Protected)',
        'price_range' => '₱299',
        'original_price' => '₱499',
        'discount' => '40% OFF',
        'image' => '../../Image/New-arrivals/Fashion Sunglasses (UV Protected).jpeg',
        'stock' => 45,
        'colors' => ['Black', 'Brown'],
        'sizes' => ['Standard']
    ],

    //Product 10
    210 => [
        'name' => 'Bluetooth Mini Speaker',
        'price_range' => '₱299',
        'original_price' => '₱499',
        'discount' => '40% OFF',
        'image' => '../../Image/New-arrivals/Bluetooth Mini Speaker.jpeg',
        'stock' => 45,
        'colors' => ['White', 'Black'],
        'sizes' => ['Standard']
    ],

    //Product 11
    211 => [
        'name' => 'Stainless Steel Water Bottle',
        'price_range' => '₱299',
        'original_price' => '₱499',
        'discount' => '40% OFF',
        'image' => '../../Image/New-arrivals/Stainless Steel Water Bottle.jpeg',
        'stock' => 45,
        'colors' => ['Silver', 'Black'],
        'sizes' => ['500ml']
    ],

    //Product 12
    212 => [
        'name' => 'Casual Sneakers (Unisex)',
        'price_range' => '₱299',
        'original_price' => '₱499',
        'discount' => '40% OFF',
        'image' => '../../Image/New-arrivals/Casual Sneakers (Unisex).jpeg',
        'stock' => 45,
        'colors' => ['White', 'Black'],
        'sizes' => ['38', '39', '40', '41', '42']
    ],

    //Product 13
    213 => [
        'name' => 'Phone Stand Holder (Adjustable)',
        'price_range' => '₱299',
        'original_price' => '₱499',
        'discount' => '40% OFF',
        'image' => '../../Image/New-arrivals/Phone Stand Holder (Adjustable).jpeg',
        'stock' => 45,
        'colors' => ['Black', 'White'],
        'sizes' => ['Standard']
    ],

    //Product 14
    214 => [
        'name' => 'Wireless Mouse (Silent Click)',
        'price_range' => '₱299',
        'original_price' => '₱499',
        'discount' => '40% OFF',
        'image' => '../../Image/New-arrivals/Wireless Mouse (Silent Click).jpeg',
        'stock' => 45,
        'colors' => ['Black', 'Grey'],
        'sizes' => ['Standard']
    ],

    //Product 15
    215 => [
        'name' => 'Aesthetic Desk Organizer Set',
        'price_range' => '₱299',
        'original_price' => '₱499',
        'discount' => '40% OFF',
        'image' => '../../Image/New-arrivals/Aesthetic Desk Organizer Set.jpeg',
        'stock' => 45,
        'colors' => ['White', 'Pink'],
        'sizes' => ['Standard']
    ],

];

// Get ID or default
$p_id = isset($product_id) ? $product_id : 201;
$product = isset($products_data[$p_id]) ? $products_data[$p_id] : $products_data['default'];

// Variables for the template
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