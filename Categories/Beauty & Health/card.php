<?php
$products = [
    //Product 1
    [
        'name' => 'Facial Cleanser (Gentle Formula)',
        'price' => '₱100.00',
        'image' => '../../Image/Beauty & Health/Facial Cleanser (Gentle Formula).jpeg',
        'link' => 'view-product.php?id=601',
        'discount' => '-20%'
    ],

    //Product 2
    [
        'name' => 'Vitamin C Serum',
        'price' => '₱340.00',
        'image' => '../../Image/Beauty & Health/Vitamin C Serum.jpeg',
        'link' => 'view-product.php?id=602',
        'discount' => '-20%'
    ],

    //Product 3
    [
        'name' => 'Aloe Vera Soothing Gel',
        'price' => '₱50.00',
        'image' => '../../Image/Beauty & Health/Aloe Vera Soothing Gel.jpeg',
        'link' => 'view-product.php?id=603',
        'discount' => '-20%'
    ],

    //Product 4
    [
        'name' => 'Sunscreen SPF 50+',
        'price' => '₱1,500.00',
        'image' => '../../Image/Beauty & Health/Sunscreen SPF 50+.jpeg',
        'link' => 'view-product.php?id=604',
        'discount' => '-20%'
    ],

    //Product 5
    [
        'name' => 'Moisturizing Face Cream',
        'price' => '₱2,500.00',
        'image' => '../../Image/Beauty & Health/Moisturizing Face Cream.jpeg',
        'link' => 'view-product.php?id=605',
        'discount' => '-20%'
    ],

    //Product 6
    [
        'name' => 'Charcoal Face Mask',
        'price' => '₱10,200.00',
        'image' => '../../Image/Beauty & Health/Charcoal Face Mask.jpeg',
        'link' => 'view-product.php?id=606',
        'discount' => '-20%'
    ],


    //Product 7
    [
        'name' => 'Hair Growth Shampoo',
        'price' => '₱15,000.00',
        'image' => '../../Image/Beauty & Health/Hair Growth Shampoo.jpeg',
        'link' => 'view-product.php?id=607',
        'discount' => '-20%'
    ],

    //Product 8
    [
        'name' => 'Hair Conditioner (Repair Care)',
        'price' => '₱15,000.00',
        'image' => '../../Image/Beauty & Health/Hair Conditioner (Repair Care).jpeg',
        'link' => 'view-product.php?id=608',
        'discount' => '-20%'
    ],

    //Product 9
    [
        'name' => 'Makeup Brush Set (10pcs)',
        'price' => '₱20,000.00',
        'image' => '../../Image/Beauty & Health/Makeup Brush Set (10pcs).jpeg',
        'link' => 'view-product.php?id=609',
        'discount' => '-20%'
    ],

    //Product 10
    [
        'name' => 'Lip Tint - Lip Gloss Set',
        'price' => '₱59,000.00',
        'image' => '../../Image/Beauty & Health/Lip Tint - Lip Gloss Set.jpeg',
        'link' => 'view-product.php?id=610',
        'discount' => '-20%'
    ],

    //Product 11
    [
        'name' => 'Body Scrub (Whitening & Exfoliating)',
        'price' => '₱100.00',
        'image' => '../../Image/Beauty & Health/Body Scrub (Whitening & Exfoliating).jpeg',
        'link' => 'view-product.php?id=611',
        'discount' => '-20%'
    ],

    //Product 12
    [
        'name' => 'Electric Facial Cleanser Brush',
        'price' => '₱1,000.00',
        'image' => '../../Image/Beauty & Health/Electric Facial Cleanser Brush.jpeg',
        'link' => 'view-product.php?id=612',
        'discount' => '-20%'
    ],

    //Product 13
    [
        'name' => 'Nail Care Kit (Manicure Set)',
        'price' => '₱100.00',
        'image' => '../../Image/Beauty & Health/Nail Care Kit (Manicure Set).jpeg',
        'link' => 'view-product.php?id=613',
        'discount' => '-20%'
    ],

    //Product 14
    [
        'name' => 'Essential Oil Set (Relaxing Blend)',
        'price' => '₱299.00',
        'image' => '../../Image/Beauty & Health/Essential Oil Set (Relaxing Blend).jpeg',
        'link' => 'view-product.php?id=614',
        'discount' => '-20%'
    ],

    //Product 15
    [
        'name' => 'Foot Spa Massager Roller',
        'price' => '₱299',
        'image' => '../../Image/Beauty & Health/Foot Spa Massager Roller.jpeg',
        'link' => 'view-product.php?id=615',
        'discount' => '-20%'
    ],


];
?>

<div class="product-grid">
    <?php foreach ($products as $product): ?>
        <div class="product-card" onclick="window.location.href='<?php echo $product['link']; ?>'">
            <div class="image-wrapper">
                <?php if (isset($product['discount'])): ?>
                    <span class="discount-badge"><?php echo $product['discount']; ?></span>
                <?php endif; ?>
                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="product-img">
            </div>
            <div class="product-details">
                <h3 class="product-title"
                    style="text-align: center; white-space: normal; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; max-width: 100%; height: 40px; line-height: 20px;">
                    <?php echo htmlspecialchars($product['name']); ?>
                </h3>
            </div>
            <div class="card-action-area">
                <div class="product-price"><?php echo $product['price']; ?></div>
                <a href="#" class="add-to-cart-btn">Find Similar</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>