<?php
// Shopee-style Search Bar Component - Blue Theme
if (!isset($path_prefix)) {
    $path_prefix = '../';
}

// Categories for dynamic suggestions
$search_categories = [
    'Electronics',
    'Fashion & Apparel',
    'Home & Living',
    'Beauty & Health',
    'Sports & Outdoor',
    'Toys & Games',
    'Groceries'
];
?>
<div class="shopee-search-bar">
    <form action="<?php echo $path_prefix; ?>Shop/index.php" method="GET" class="search-form">
        <div class="search-input-wrapper">
            <input type="text" name="search" placeholder="Search for products, brands and more..."
                class="shopee-search-input" autocomplete="off"
                value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
            <div class="search-ai-buttons">
                <button type="button" class="ai-icon-btn" onclick="openCameraSearch()" title="Search by Image">
                    <i class="fas fa-camera"></i>
                </button>
                <button type="button" class="ai-icon-btn" onclick="openVoiceCommand()" title="Search by Voice">
                    <i class="fas fa-microphone"></i>
                </button>
                <button type="button" class="ai-icon-btn" onclick="openAiChat()" title="Chat with AI">
                    <i class="fas fa-robot"></i>
                </button>
            </div>
        </div>
        <button type="submit" class="shopee-search-button">
            <i class="fas fa-search"></i>
        </button>
    </form>

    <!-- Suggestions Dropdown -->
    <div id="search-suggestions" class="search-suggestions-dropdown"></div>

    <style>
        .shopee-search-bar {
            width: 100%;
            max-width: 700px;
            position: relative;
        }

        .search-form {
            display: flex;
            background: #fff;
            padding: 3px;
            border-radius: 4px;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
            border: 2px solid #2A3B7E;
            /* Site Blue Theme */
            transition: border-color 0.2s;
        }

        .search-form:focus-within {
            border-color: #3b82f6;
        }

        .search-input-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            padding: 0 10px;
            position: relative;
        }

        .shopee-search-input {
            flex: 1;
            border: none;
            outline: none;
            padding: 10px 0;
            font-size: 14px;
            color: #222;
        }

        .search-ai-buttons {
            display: flex;
            gap: 12px;
            margin-right: 10px;
        }

        .ai-icon-btn {
            background: none;
            border: none;
            color: #64748b;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.2s;
            padding: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ai-icon-btn:hover {
            color: #2A3B7E;
            transform: scale(1.1);
        }

        .shopee-search-button {
            background: #2A3B7E;
            /* Updated to Blue */
            color: white;
            border: none;
            padding: 0 20px;
            border-radius: 2px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.2s;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .shopee-search-button:hover {
            background: #1d2b5e;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .search-suggestions-dropdown {
            position: absolute;
            top: calc(100% + 4px);
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            z-index: 1000;
            display: none;
            max-height: 400px;
            overflow-y: auto;
            padding: 8px 0;
            animation: slideDown 0.2s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .suggestion-item {
            padding: 10px 20px;
            cursor: pointer;
            font-size: 14px;
            color: #334155;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.1s;
        }

        .suggestion-item i {
            color: #94a3b8;
            font-size: 12px;
            width: 16px;
            text-align: center;
        }

        .suggestion-item:hover {
            background: #f1f5f9;
            color: #2A3B7E;
        }

        .suggestion-item:hover i {
            color: #2A3B7E;
        }

        .suggestion-category {
            font-size: 11px;
            background: #f1f5f9;
            color: #64748b;
            padding: 2px 8px;
            border-radius: 4px;
            margin-left: auto;
            font-weight: 600;
        }
    </style>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const categories = <?php echo json_encode($search_categories); ?>;
        const searchInput = document.querySelector('.shopee-search-input');
        const suggestions = document.getElementById('search-suggestions');

        searchInput.addEventListener('input', function (e) {
            const query = e.target.value.trim().toLowerCase();

            if (query.length > 0) {
                let html = '';

                // 1. Direct match with categories
                const matchedCats = categories.filter(c => c.toLowerCase().includes(query));
                matchedCats.forEach(cat => {
                    html += `
                        <div class="suggestion-item" onclick="selectSuggestion('${cat.replace(/'/g, "\\'")}')">
                            <i class="fas fa-list"></i>
                            <span>${cat}</span>
                            <span class="suggestion-category">Category</span>
                        </div>
                    `;
                });

                // 2. Generic suggestions based on common commerce terms if query matches
                const commonTerms = ['Buy', 'Best', 'Latest', 'Sale', 'New'];
                commonTerms.forEach(term => {
                    html += `
                        <div class="suggestion-item" onclick="selectSuggestion('${term} ${query}')">
                            <i class="fas fa-search"></i>
                            <span>${term} <strong>${query}</strong></span>
                        </div>
                    `;
                });

                // 3. Fallback/Default if no direct cat match
                if (matchedCats.length === 0) {
                    html += `
                        <div class="suggestion-item" onclick="selectSuggestion('${query} in Fashion')">
                            <i class="fas fa-search"></i>
                            <span>${query} in Fashion</span>
                        </div>
                        <div class="suggestion-item" onclick="selectSuggestion('${query} in Electronics')">
                            <i class="fas fa-search"></i>
                            <span>${query} in Electronics</span>
                        </div>
                   `;
                }

                suggestions.innerHTML = html;
                suggestions.style.display = 'block';
            } else {
                suggestions.style.display = 'none';
            }
        });

        // Global function to handle selection
        window.selectSuggestion = function (text) {
            searchInput.value = text;
            suggestions.style.display = 'none';
            document.querySelector('.search-form').submit();
        };

        // Close on click outside
        document.addEventListener('click', function (e) {
            if (!e.target.closest('.shopee-search-bar')) {
                suggestions.style.display = 'none';
            }
        });
    });
</script>
