<link rel="stylesheet" href="../css/Components/floating-buttons.css">
<link rel="stylesheet" href="../css/Components/ai-features.css">

<!-- Background Modal Overlay -->
<div id="ai-modal-overlay" class="ai-modal-overlay">
    <div id="ai-modal-content-inject" class="ai-modal-content">
        <!-- Content Injected via JS -->
    </div>
</div>

<div class="floating-buttons">
    <!-- Camera Search Button (Left) -->
    <button class="btn-float btn-camera" onclick="openCameraSearch()" title="Image Search (Google Lens Style)">
        <i class="fas fa-camera"></i>
    </button>

    <!-- Voice Command AI Button (Right) -->
    <button class="btn-float btn-voice" onclick="openVoiceCommand()" title="Natural Language Search">
        <i class="fas fa-microphone"></i> Voice Command AI
    </button>
</div>

<!-- TensorFlow.js & MobileNet -->
<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"></script>
<script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/mobilenet"></script>

<script src="../javascript/ai-features.js"></script>


