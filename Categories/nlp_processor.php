<?php
header('Content-Type: application/json');

/**
 * Simulates an AI NLP Engine for Sentiment Analysis
 * Returns JSON response
 */

include_once 'nlp_core.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, true);
    $text = isset($input['text']) ? $input['text'] : '';

    $analysis = analyzeSentimentAI($text);

    echo json_encode($analysis);
    exit;
}
?>