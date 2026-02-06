<!-- Save Card Component (Result Card Style) -->
<style>
    .result-card {
        position: relative;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        padding: 15px;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        display: flex;
        align-items: center;
        gap: 15px;
        text-align: left;
        border: 1px solid rgba(0, 0, 0, 0.05);
        max-width: 400px;
        margin: 10px auto;
    }

    .rc-image {
        width: 60px;
        height: 60px;
        border-radius: 10px;
        overflow: hidden;
        flex-shrink: 0;
        border: 1px solid #eee;
    }

    .rc-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .rc-details {
        flex: 1;
    }

    .rc-store {
        font-size: 0.7rem;
        color: #888;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .rc-title {
        font-weight: 700;
        font-size: 0.95rem;
        color: #333;
        margin-bottom: 2px;
        line-height: 1.2;
    }

    .rc-price {
        color: #e74c3c;
        font-weight: 800;
        font-size: 1rem;
    }

    .rc-action {
        background: #0f8392;
        color: white;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: 0 4px 10px rgba(15, 131, 146, 0.4);
    }
</style>

<div class="result-card">
    <div class="rc-image">
        <img src="<?php echo isset($image_path) ? $image_path : '../image/Electronics/Portable Power Bank 20,000mAh.jpeg'; ?>"
            alt="Product">
    </div>
    <div class="rc-details">
        <div class="rc-store"><?php echo isset($store_name) ? $store_name : 'TECHZONE PH'; ?></div>
        <div class="rc-title"><?php echo isset($product_name) ? $product_name : 'iPhone 15 Pro Max'; ?></div>
        <div class="rc-price"><?php echo isset($product_price) ? $product_price : '₱84,990.00'; ?></div>
    </div>
    <div class="rc-action">
        <i class="fas fa-arrow-right"></i>
    </div>
</div>


