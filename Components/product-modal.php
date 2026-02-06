<!-- Product Details Modal (AI Search Result) -->
<style>
    .product-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 2000;
        backdrop-filter: blur(5px);
        animation: fadeIn 0.3s;
    }

    .product-modal-content {
        background: #b2e0f0;
        /* Light blue/cyan background from image */
        width: 800px;
        max-width: 90%;
        height: 500px;
        display: flex;
        border-radius: 10px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
        animation: slideUp 0.4s ease-out;
    }

    .product-modal-close {
        position: absolute;
        top: 15px;
        right: 20px;
        font-size: 24px;
        color: #fff;
        cursor: pointer;
        z-index: 10;
        background: rgba(0, 0, 0, 0.1);
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    /* Left Side: Image */
    .pm-image-section {
        width: 50%;
        background: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
    }

    .pm-image-section img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Right Side: Details */
    .pm-details-section {
        width: 50%;
        padding: 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .pm-store-header {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .pm-store-logo {
        width: 40px;
        height: 40px;
        border: 1px solid #ccc;
        margin-right: 10px;
    }

    .pm-store-name {
        font-weight: 600;
        font-size: 1.2rem;
        color: #333;
    }

    .pm-product-title {
        font-size: 1.8rem;
        font-weight: bold;
        color: #000;
        margin-bottom: 5px;
        line-height: 1.2;
    }

    .pm-price {
        font-size: 1.6rem;
        font-weight: 800;
        color: #000;
        margin-bottom: 10px;
    }

    .pm-rating {
        color: #333652;
        margin-bottom: 30px;
        font-size: 0.9rem;
    }

    .pm-options {
        margin-bottom: 30px;
    }

    .pm-label {
        font-weight: bold;
        display: block;
        margin-bottom: 8px;
        font-size: 0.9rem;
    }

    .pm-btn-group {
        display: flex;
        gap: 10px;
    }

    .pm-btn-option {
        padding: 8px 15px;
        background: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 500;
    }

    .pm-btn-option.selected {
        background: #2A3B7E;
        color: white;
    }

    .pm-actions {
        display: flex;
        gap: 15px;
        margin-top: auto;
    }

    .pm-btn-action {
        flex: 1;
        padding: 15px;
        border: none;
        border-radius: 5px;
        font-weight: bold;
        font-size: 1rem;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
    }

    .pm-btn-cart {
        background: #2A3B7E;
        color: #fff;
    }

    .pm-btn-buy {
        background: #2A3B7E;
        /* Assuming same color or darker */
        color: #fff;
        opacity: 0.9;
    }
</style>

<div id="product-modal-overlay" class="product-modal-overlay">
    <div class="product-modal-content">
        <span class="product-modal-close" onclick="closeProductModal()">&times;</span>

        <div class="pm-image-section">
            <img id="pm-img" src="" alt="Product Image">
        </div>

        <div class="pm-details-section">
            <div class="pm-store-header">
                <img src="../image/logo.png" class="pm-store-logo"> <!-- Placeholder Logo -->
                <span class="pm-store-name" id="pm-store">TechZone PH</span>
            </div>

            <h2 class="pm-product-title" id="pm-title">iPhone 15 Pro Max</h2>
            <div class="pm-price" id="pm-price">₱84,990.00</div>

            <div class="pm-rating">
                <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i
                    class="fas fa-star"></i> <i class="far fa-star"></i>
                433 Sold
            </div>

            <div class="pm-options">
                <span class="pm-label">Color</span>
                <div class="pm-btn-group">
                    <button class="pm-btn-option selected">Black</button>
                    <button class="pm-btn-option">White</button>
                    <button class="pm-btn-option">Blue</button>
                </div>
            </div>

            <div class="pm-actions">
                <button class="pm-btn-action pm-btn-cart">Add to Cart</button>
                <button class="pm-btn-action pm-btn-buy">Buy Now</button>
            </div>
        </div>
    </div>
</div>

<script>
    function openProductModal(productData) {
        document.getElementById('product-modal-overlay').style.display = 'flex';
        // Hydrate data if passed
        if (productData) {
            if (productData.image) document.getElementById('pm-img').src = productData.image;
            if (productData.price) document.getElementById('pm-price').innerText = productData.price;
            if (productData.name) document.getElementById('pm-title').innerText = productData.name;
        }
    }

    function closeProductModal() {
        document.getElementById('product-modal-overlay').style.display = 'none';
        // Clear params to avoid reopening on refresh
        const url = new URL(window.location);
        url.searchParams.delete('ai_action');
        url.searchParams.delete('product');
        window.history.pushState({}, '', url);
    }

    // Check URL params on load
    window.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('ai_action') === 'open_modal') {

            let imageUrl = urlParams.get('image');

            // Check if we should use the captured image from AI search
            if (urlParams.get('use_captured') === 'true') {
                const capturedImage = sessionStorage.getItem('ai_captured_image');
                if (capturedImage) {
                    imageUrl = capturedImage;
                }
            }

            // Simple map for names based on ID (since PHP redirect doesn't pass full name yet)
            const productId = urlParams.get('product');
            let productName = "iPhone 15 Pro Max";
            if (productId === 'sneakers_casual') productName = "Casual Sneakers";
            if (productId === 'hoodie_black') productName = "H&M Loose Fit Hoodie";
            if (productId === 'webcam_1080p') productName = "1080p HD Web Camera";

            const productData = {
                id: productId,
                price: urlParams.get('price'),
                image: imageUrl,
                name: productName
            };
            openProductModal(productData);
        }
    });
</script>


