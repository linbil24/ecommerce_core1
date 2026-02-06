-- SQL for AI Features (Voice Command & Image Search)

-- Table to store Voice Command Logs
CREATE TABLE IF NOT EXISTS `ai_voice_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `command_text` text NOT NULL,
  `command_type` varchar(50) DEFAULT 'general', -- e.g., 'search', 'navigation', 'question'
  `response_generated` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table to store Image Search Logs
CREATE TABLE IF NOT EXISTS `ai_image_searches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `image_path` varchar(255) NOT NULL,
  `detected_labels` text DEFAULT NULL, -- JSON or comma-separated tags detected by AI
  `search_result_count` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
