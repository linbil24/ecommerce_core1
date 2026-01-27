<?php
// Shopee-style Search Bar Component
if (!isset($path_prefix)) {
    $path_prefix = '../';
}
?>
<div class="shopee-search-bar">
    <form action="<?php echo $path_prefix; ?>Shop-now/index.php" method="GET" class="search-form">
        <div class="search-input-wrapper">
            <input type="text" name="search" placeholder="Search for products, brands and more..."
                class="shopee-search-input" autocomplete="off">
            <div class="search-ai-buttons">
                <button type="button" class="ai-icon-btn" onclick="openCameraSearch()" title="Search by Image">
                    <i class="fas fa-camera"></i>
                </button>
                <button type="button" class="ai-icon-btn" onclick="openVoiceCommand()" title="Search by Voice">
                    <i class="fas fa-microphone"></i>
                </button>
            </div>
        </div>
        <button type="submit" class="shopee-search-button">
            <i class="fas fa-search"></i>
        </button>
    </form>

    <!-- Suggestions Dropdown (Hidden by default) -->
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
            border: 2px solid #ee4d2d;
            /* Shopee Orange */
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
            gap: 10px;
            margin-right: 10px;
        }

        .ai-icon-btn {
            background: none;
            border: none;
            color: #555;
            cursor: pointer;
            font-size: 16px;
            transition: color 0.2s;
            padding: 5px;
        }

        .ai-icon-btn:hover {
            color: #ee4d2d;
        }

        .shopee-search-button {
            background: #ee4d2d;
            color: white;
            border: none;
            padding: 0 20px;
            border-radius: 2px;
            cursor: pointer;
            font-size: 16px;
            transition: opacity 0.2s;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .shopee-search-button:hover {
            opacity: 0.9;
        }

        .search-suggestions-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #e8e8e8;
            border-top: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            display: none;
            max-height: 300px;
            overflow-y: auto;
        }

        .suggestion-item {
            padding: 10px 15px;
            cursor: pointer;
            font-size: 14px;
            color: #333;
        }

        .suggestion-item:hover {
            background: #fafafa;
            color: #ee4d2d;
        }
    </style>
</div>

<script>
    // Standard Search Functionality
    document.querySelector('.shopee-search-input').addEventListener('input', function (e) {
        const query = e.target.value;
        const suggestions = document.getElementById('search-suggestions');

        if (query.length > 1) {
            // Mock suggestions for now
            const mockSuggestions = [
                query + ' in Fashion',
                query + ' in Electronics',
                'Recommended ' + query,
                'Latest ' + query
            ];

            suggestions.innerHTML = mockSuggestions.map(s => `<div class="suggestion-item">${s}</div>`).join('');
            suggestions.style.display = 'block';

            // Handle clicking on suggestions
            document.querySelectorAll('.suggestion-item').forEach(item => {
                item.addEventListener('click', function () {
                    document.querySelector('.shopee-search-input').value = this.innerText;
                    suggestions.style.display = 'none';
                    document.querySelector('.search-form').submit();
                });
            });
        } else {
            suggestions.style.display = 'none';
        }
    });

    // Close suggestions on click outside
    document.addEventListener('click', function (e) {
        if (!e.target.closest('.shopee-search-bar')) {
            document.getElementById('search-suggestions').style.display = 'none';
        }
    });
</script>