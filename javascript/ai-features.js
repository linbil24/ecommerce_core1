let videoStream = null;

function openCameraSearch() {
    const modal = document.getElementById('ai-modal-overlay');
    const content = document.getElementById('ai-modal-content-inject');

    modal.style.display = 'flex';
    content.innerHTML = `
        <div class="ai-modal-header">
            <h3 class="ai-modal-title"><i class="fas fa-camera"></i> Image Search</h3>
            <span class="ai-modal-close" onclick="closeAiModal()">&times;</span>
        </div>
        <div class="ai-modal-body">
            <div class="camera-preview-box" id="camera-view">
                <video id="camera-stream" autoplay playsinline muted style="width:100%; height:100%; object-fit:cover; display:none;"></video>
                <img id="image-preview" style="display:none; width:100%; height:100%; object-fit:cover;">
                
                <div id="camera-placeholder">
                    <i class="fas fa-image" style="font-size: 40px; margin-bottom: 10px;"></i>
                    <p>Starting Camera...</p>
                </div>

                <!-- Scanner Overlay -->
                <div class="scanner-overlay" id="scanner-ui">
                    <div class="scanner-line"></div>
                </div>
            </div>
            
            <p style="color:#666; font-size: 0.9rem;" id="camera-status">Point at a product to search.</p>
            
            <div style="display:flex; gap:10px;">
                <button class="btn-capture" onclick="captureAndSearch()" id="btn-action">
                    <i class="fas fa-search"></i> Capture & Search
                </button>
                <button class="btn-capture" style="background:#555;" onclick="triggerFileUpload()" title="Upload File">
                    <i class="fas fa-upload"></i>
                </button>
                <input type="file" id="file-upload-input" accept="image/*" style="display:none;" onchange="previewImage(this)">
            </div>
        </div>
    `;

    // Try to start camera
    startCamera();
}

function startCamera() {
    const video = document.getElementById('camera-stream');
    const placeholder = document.getElementById('camera-placeholder');

    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } })
            .then(function (stream) {
                videoStream = stream;
                video.srcObject = stream;
                video.style.display = 'block';
                placeholder.style.display = 'none';
            })
            .catch(function (err) {
                console.log("Camera Error: " + err);
                placeholder.innerHTML = '<i class="fas fa-exclamation-triangle"></i><p>Camera access denied</p>';
            });
    } else {
        placeholder.innerHTML = '<p>Camera not supported</p>';
    }
}

function triggerFileUpload() {
    document.getElementById('file-upload-input').click();
}

function previewImage(input) {
    if (input.files && input.files[0]) {
        // Stop camera if running
        stopCamera();

        var reader = new FileReader();
        reader.onload = function (e) {
            const video = document.getElementById('camera-stream');
            const img = document.getElementById('image-preview');
            const placeholder = document.getElementById('camera-placeholder');

            video.style.display = 'none';
            placeholder.style.display = 'none';
            img.src = e.target.result;
            img.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}

let aiModel = null;

// Pre-load the model when script runs
async function loadAiModel() {
    console.log("Loading AI Model...");
    try {
        aiModel = await mobilenet.load();
        console.log("AI Model Loaded Successfully!");
    } catch (error) {
        console.error("Failed to load AI model:", error);
    }
}
loadAiModel();

async function captureAndSearch() {
    const scanner = document.getElementById('scanner-ui');
    const status = document.getElementById('camera-status');
    const btn = document.getElementById('btn-action');
    const cameraView = document.getElementById('camera-view');

    // UI Updates
    scanner.style.display = 'block';
    status.innerText = "Scanning objects...";
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Analyzing...';

    // Get the image source (Video or Preview Image)
    let imgElement = document.getElementById('camera-stream'); // Default to video
    if (imgElement.style.display === 'none') {
        imgElement = document.getElementById('image-preview'); // Use uploaded image if video is hidden
    }

    // Create a canvas to capture the current frame/image
    const canvas = document.createElement('canvas');
    const context = canvas.getContext('2d');

    // Set canvas dimensions based on the imgElement
    canvas.width = imgElement.videoWidth || imgElement.naturalWidth || imgElement.width;
    canvas.height = imgElement.videoHeight || imgElement.naturalHeight || imgElement.height;

    // Draw the current frame/image onto the canvas
    context.drawImage(imgElement, 0, 0, canvas.width, canvas.height);

    // Convert to Blob
    canvas.toBlob(async blob => {
        // Create a URL for the captured image to show in the result card
        const capturedImageUrl = URL.createObjectURL(blob);

        // Prepare FormData
        const formData = new FormData();
        formData.append('image', blob, 'capture.jpg');

        // Show scanning UI
        scanner.style.display = 'block';
        status.innerText = "Analyzing...";
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Analyzing...';

        // NOTE: We are doing Client-Side Analysis, but still sending to PHP for specific logging/fallback if needed
        // For the result card, we will use the logic below directly.

        // Ensure model is loaded
        if (!aiModel) {
            status.innerText = "Loading Model...";
            await loadAiModel();
        }

        // Predict using MobileNet (classify the canvas content)
        try {
            const predictions = await aiModel.classify(canvas);
            console.log('Predictions:', predictions);

            if (predictions && predictions.length > 0) {
                const topResult = predictions[0];
                const detectedName = topResult.className;

                // MAP RESULT TO PRODUCT
                let product = null;

                if (detectedName.includes('telephone') || detectedName.includes('phone')) {
                    product = { id: "iphone15", name: "iPhone 15 Pro Max", price: "₱84,990.00", store: "TechZone PH", image: "../image/Electronics/Portable Power Bank 20,000mAh.jpeg" };
                } else if (detectedName.includes('shoe') || detectedName.includes('sneaker') || detectedName.includes('sandal')) {
                    product = { id: "sneakers_casual", name: "Casual Sneakers", price: "₱1,299.00", store: "UrbanWear PH", image: "../image/Shop/UrbanWear PH/Casual Sneakers.jpeg" };
                } else if (detectedName.includes('shirt') || detectedName.includes('jersey') || detectedName.includes('clothing')) {
                    product = { id: "hoodie_black", name: "H&M Loose Fit Hoodie", price: "₱999.00", store: "UrbanWear PH", image: "../image/Shop/UrbanWear PH/H&M Loose Fit Hoodie.jpeg" };
                } else {
                    // NO MATCH IN SYSTEM
                    product = null;
                }

                scanner.style.display = 'none';

                // Show Result Card
                let resultCard = '';

                if (product) {
                    // PRODUCT FOUND IN SYSTEM
                    resultCard = `
                        <div style="
                            position: absolute; bottom: 10px; left: 10px; right: 10px; 
                            background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);
                            padding: 15px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); 
                            display: flex; align-items: center; gap: 15px; text-align: left; 
                            animation: slideUp 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                            border: 3px solid #0f8392; z-index: 10;
                        ">
                            <div style="width: 60px; height: 60px; border-radius: 10px; overflow: hidden; flex-shrink: 0; border: 1px solid #eee;">
                                <img src="${capturedImageUrl}" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <div style="flex: 1;">
                                <div style="font-size: 0.7rem; color: #0f8392; text-transform: uppercase; font-weight: 700;">Included in System</div>
                                <div style="font-weight: 700; font-size: 0.95rem; color: #333;">${product.name}</div>
                                <div style="color: #e74c3c; font-weight: 800; font-size: 1rem;">${product.price}</div>
                            </div>
                            <div style="background: #0f8392; color: white; width: 35px; height: 35px; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                    `;
                } else {
                    // PRODUCT NOT FOUND / OUT OF ORDER
                    resultCard = `
                        <div style="
                            position: absolute; bottom: 10px; left: 10px; right: 10px; 
                            background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);
                            padding: 15px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); 
                            display: flex; align-items: center; gap: 15px; text-align: left; 
                            animation: slideUp 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                            border: 3px solid #e74c3c; z-index: 10;
                        ">
                            <div style="width: 60px; height: 60px; border-radius: 10px; overflow: hidden; flex-shrink: 0; border: 1px solid #eee; opacity: 0.7;">
                                <img src="${capturedImageUrl}" style="width: 100%; height: 100%; object-fit: cover; filter: grayscale(100%);">
                            </div>
                            <div style="flex: 1;">
                                <div style="font-size: 0.7rem; color: #e74c3c; text-transform: uppercase; font-weight: 700;">Detection: ${detectedName}</div>
                                <div style="font-weight: 700; font-size: 0.95rem; color: #333;">THIS PRODUCT IS OUT OF ORDER</div>
                                <div style="color: #777; font-size: 0.8rem;">Item not available in current inventory.</div>
                            </div>
                            <div style="background: #e74c3c; color: white; width: 35px; height: 35px; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                <i class="fas fa-times"></i>
                            </div>
                        </div>
                    `;
                }

                cameraView.insertAdjacentHTML('beforeend', resultCard);
                status.innerText = "";
                btn.style.display = 'none';

                // Send to PHP Backend for Logging (Background)
                fetch('../php/ai_search.php', { method: 'POST', body: formData });

                setTimeout(() => {
                    closeAiModal();

                    // Save image
                    const reader = new FileReader();
                    reader.readAsDataURL(blob);
                    reader.onloadend = function () {
                        const base64data = reader.result;
                        sessionStorage.setItem('ai_captured_image', base64data);

                        // Redirect to CONFIRMATION MODAL only if product found
                        if (product) {
                            // DETERMINE CATEGORY based on Product Name/ID
                            let category = "General";
                            if (product.store === "TechZone PH" || product.name.includes("Phone") || product.name.includes("Camera")) {
                                category = "Electronics";
                            } else if (product.store === "UrbanWear PH" || product.name.includes("Hoodie") || product.name.includes("Sneakers")) {
                                category = "Fashion";
                            }

                            window.location.href = `../Content/Dashboard.php?ai_action=confirm_scan&detected=${encodeURIComponent(product.name)}&category=${encodeURIComponent(category)}`;
                        } else {
                            // If not found, stay on modal so they see "Out of Order" message, then maybe close after delay
                            setTimeout(() => {
                                // Optional: Reset UI or close
                                // closeAiModal();
                            }, 2000);
                        }
                    }

                }, 1500);

            } else {
                status.innerText = "No object detected.";
                btn.disabled = false;
                URL.revokeObjectURL(capturedImageUrl); // Revoke if no product found
            }
        } catch (error) {
            console.error(error);
            status.innerText = "AI Error. Try again.";
            btn.disabled = false;
            URL.revokeObjectURL(capturedImageUrl); // Revoke on error
        }
    }, 'image/jpeg');
}

function openVoiceCommand() {
    stopCamera(); // Ensure camera is off
    const modal = document.getElementById('ai-modal-overlay');
    const content = document.getElementById('ai-modal-content-inject');

    modal.style.display = 'flex';
    content.innerHTML = `
        <div class="ai-modal-header">
            <h3 class="ai-modal-title"><i class="fas fa-microphone"></i> Voice Assistant</h3>
            <span class="ai-modal-close" onclick="closeAiModal()">&times;</span>
        </div>
        <div class="ai-modal-body">
            <div class="voice-wave">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
            <p class="voice-status" id="voice-status-text">Listening...</p>
            <p style="color:#999; font-size: 0.8rem;">Try saying "Hello" or "Best Sellers"</p>
        </div>
    `;

    // Check browser support
    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;

    if (!SpeechRecognition) {
        document.getElementById('voice-status-text').innerText = "Browser does not support Voice API.";
        return;
    }

    const recognition = new SpeechRecognition();
    recognition.lang = 'en-US'; // Default to English but it usually picks up simple Tagalog/English mix
    recognition.interimResults = false;
    recognition.maxAlternatives = 1;

    recognition.start();

    recognition.onresult = (event) => {
        const transcript = event.results[0][0].transcript.toLowerCase();
        console.log("Voice Result:", transcript);

        const statusText = document.getElementById('voice-status-text');
        statusText.innerText = `You said: "${transcript}"`;

        if (transcript.includes('hello') || transcript.includes('hi')) {
            speakResponse("Hello! How can I help you today?");
            statusText.innerText = "Hello! How can I help you?";
        }
        else if (transcript.includes('best selling') || transcript.includes('best seller') || transcript.includes('best sellers')) {
            speakResponse("Showing you our Best Selling products.");
            statusText.innerText = "Opening Best Sellers...";

            setTimeout(() => {
                closeAiModal();
                window.location.href = '../Shop-now/index.php?store=UrbanWear+PH&search_query=best+sellers';
            }, 1500);
        }
        else {
            speakResponse("Searching for " + transcript);
            statusText.innerText = "Searching for " + transcript + "...";

            setTimeout(() => {
                closeAiModal();
                // Determine path prefix based on current location (simple check)
                let prefix = '../';
                if (window.location.pathname.includes('/Shop-now/')) prefix = '';

                // Redirect to Shop Search
                window.location.href = prefix + '../Shop-now/index.php?search_query=' + encodeURIComponent(transcript);
            }, 1500);
        }
    };

    recognition.onerror = (event) => {
        document.getElementById('voice-status-text').innerText = "Error occurred in recognition: " + event.error;
    };

    recognition.onend = () => {
        // Optionally restart or just let it stop
    };
}

function speakResponse(text) {
    if ('speechSynthesis' in window) {
        const utterance = new SpeechSynthesisUtterance(text);
        // Optional: Set voice
        // const voices = window.speechSynthesis.getVoices();
        // utterance.voice = voices[0]; 
        window.speechSynthesis.speak(utterance);
    }
}

function closeAiModal() {
    document.getElementById('ai-modal-overlay').style.display = 'none';
    stopCamera();
}

function stopCamera() {
    if (videoStream) {
        videoStream.getTracks().forEach(track => track.stop());
        videoStream = null;
    }
}



