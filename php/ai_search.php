<?php
header('Content-Type: application/json');

// Check if image is uploaded
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {

    // 1. Save valid image temporarily
    $uploadDir = '../uploads/ai_searches/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $fileName = uniqid('search_') . '.' . $fileExtension;
    $targetPath = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {

        // ------------------------------------------------------------------
        // GOOGLE VISION API (COMMENTED OUT / OPTIONAL)
        // ------------------------------------------------------------------
        /*
        $apiKey = "YOUR_API_KEY";
        // ... (API logic would go here)
        */

        $selected_product = null;

        // ------------------------------------------------------------------
        // FALLBACK / SIMULATION LOGIC
        // ------------------------------------------------------------------
        // Since we are using Client-Side AI primarily, this PHP script
        // acts as a fallback or a logger. If no API result, we use random.


        // ------------------------------------------------------------------
        // SAVE TO DATABASE
        // ------------------------------------------------------------------
        include('../Database/config.php');
        session_start();
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0; // Default to 0 if guest
        $detected_label = $selected_product['name']; // In real AI, use $result response

        $sql = "INSERT INTO ai_image_searches (user_id, image_path, detected_labels, search_result_count) VALUES (?, ?, ?, 1)";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("iss", $user_id, $targetPath, $detected_label);
            $stmt->execute();
            $stmt->close();
        }

        $ai_response = [
            'success' => true,
            'message' => 'Product identified successfully',
            'data' => [
                'id' => $selected_product['id'],
                'name' => $selected_product['name'],
                'price' => $selected_product['price'],
                'store' => $selected_product['store'],
                'category' => $selected_product['category'],
                'image' => $selected_product['image'],
                'redirect_url' => "../Content/Dashboard.php?ai_action=open_modal&product=" . $selected_product['id'] . "&price=" . urlencode($selected_product['price']) . "&image=" . urlencode($selected_product['image'])
            ]
        ];

        // Return JSON
        echo json_encode($ai_response);
        exit;

    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to move uploaded file.']);
    }

} else {
    echo json_encode(['success' => false, 'message' => 'No image received.']);
}

// Function to call AI (Placeholder for future use)
function callOpenAIVision($imagePath, $apiKey)
{
    // Curl logic would go here...
    return [];
}
?>
