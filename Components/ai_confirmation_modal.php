<!-- AI Confirmation Modal -->
<style>
    .ai-confirm-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.85);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 3000;
        backdrop-filter: blur(8px);
    }

    .ai-confirm-box {
        background: white;
        width: 400px;
        padding: 30px;
        border-radius: 15px;
        text-align: center;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
        position: relative;
        animation: scaleIn 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    @keyframes scaleIn {
        from {
            transform: scale(0.8);
            opacity: 0;
        }

        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    .aic-image-container {
        width: 150px;
        height: 150px;
        margin: 0 auto 20px;
        border-radius: 10px;
        overflow: hidden;
        border: 3px solid #f0f0f0;

        img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    }

    .aic-title {
        font-size: 1.2rem;
        color: #555;
        margin-bottom: 5px;
    }

    .aic-detected {
        font-size: 1.8rem;
        font-weight: 800;
        color: #2A3B7E;
        margin-bottom: 20px;
    }

    .aic-category-group {
        text-align: left;
        margin-bottom: 25px;
        background: #f9f9f9;
        padding: 15px;
        border-radius: 8px;
    }

    .aic-label {
        font-size: 0.85rem;
        color: #888;
        display: block;
        margin-bottom: 5px;
        font-weight: 600;
    }

    .aic-input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 1rem;
        color: #333;
        font-weight: 500;
    }

    .aic-buttons {
        display: flex;
        gap: 10px;
    }

    .aic-btn {
        flex: 1;
        padding: 12px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        transition: 0.2s;
    }

    .aic-btn-cancel {
        background: #eee;
        color: #555;
    }

    .aic-btn-cancel:hover {
        background: #e0e0e0;
    }

    .aic-btn-confirm {
        background: #2A3B7E;
        color: white;
    }

    .aic-btn-confirm:hover {
        background: #1a2555;
    }
</style>

<div id="ai-confirm-overlay" class="ai-confirm-overlay">
    <div class="ai-confirm-box">
        <div class="aic-image-container">
            <img id="aic-img" src="" alt="Captured Image">
        </div>

        <p class="aic-title">AI Detected:</p>
        <h2 class="aic-detected" id="aic-detected-text">Loading...</h2>

        <div class="aic-category-group">
            <label class="aic-label">Auto-filled Category:</label>
            <input type="text" id="aic-category-input" class="aic-input" value="Electronics" readonly>
        </div>

        <div class="aic-buttons">
            <button class="aic-btn aic-btn-cancel" onclick="closeAiConfirm()">Retake</button>
            <button class="aic-btn aic-btn-confirm" onclick="confirmAiDetection()">Confirm & Save</button>
        </div>
    </div>
</div>

<script>
    // Functions to handle the Confirmation Modal
    function openAiConfirm(imageSrc, detectedName, category) {
        document.getElementById('aic-img').src = imageSrc;
        document.getElementById('aic-detected-text').innerText = detectedName;
        document.getElementById('aic-category-input').value = category;
        document.getElementById('ai-confirm-overlay').style.display = 'flex';
    }

    function closeAiConfirm() {
        document.getElementById('ai-confirm-overlay').style.display = 'none';
    }

    function confirmAiDetection() {
        // Here you would typically save to DB or proceed to the Product Modal
        // For this flow, we will redirect to the Product Modal as the "Result" 
        // to show the users flow is complete.

        const detectedName = document.getElementById('aic-detected-text').innerText;
        // Map detected name back to an ID for the demo
        let productId = 'iphone15';
        if (detectedName.includes('Sneakers')) productId = 'sneakers_casual';
        if (detectedName.includes('Hoodie')) productId = 'hoodie_black';
        if (detectedName.includes('Camera')) productId = 'webcam_1080p';

        // Retrieve price/store based on ID (Simplified for demo)
        const productMap = {
            'iphone15': { price: '₱84,990.00' },
            'sneakers_casual': { price: '₱1,299.00' },
            'hoodie_black': { price: '₱999.00' },
            'webcam_1080p': { price: '₱10,200.00' }
        };

        const price = productMap[productId].price;

        // Use the captured image flag
        window.location.href = `../Content/Dashboard.php?ai_action=open_modal&product=${productId}&price=${encodeURIComponent(price)}&use_captured=true`;
    }

    // Check if we need to open this modal based on URL (Triggered from Scan)
    window.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('ai_action') === 'confirm_scan') {

            // Get Image from Session Storage
            const capturedImage = sessionStorage.getItem('ai_captured_image');
            const detectedItem = urlParams.get('detected');
            const category = urlParams.get('category');

            if (capturedImage) {
                openAiConfirm(capturedImage, detectedItem, category);
            }
        }
    });
</script>
