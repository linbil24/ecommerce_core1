<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iMarket - Diagnostics</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            background: #1a1a1a;
            color: #00ff00;
            padding: 20px;
            line-height: 1.6;
        }

        .section {
            background: #2a2a2a;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            border-left: 4px solid #00ff00;
        }

        h2 {
            color: #00ff00;
            margin-top: 0;
        }

        .success {
            color: #00ff00;
        }

        .error {
            color: #ff0000;
        }

        .warning {
            color: #ffaa00;
        }

        pre {
            background: #1a1a1a;
            padding: 10px;
            border-radius: 3px;
            overflow-x: auto;
        }
    </style>
</head>

<body>
    <h1>🔍 iMarket System Diagnostics</h1>

    <div class="section">
        <h2>PHP Configuration</h2>
        <pre><?php
        echo "PHP Version: " . phpversion() . "\n";
        echo "Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "\n";
        echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "\n";
        echo "Current Script: " . $_SERVER['SCRIPT_FILENAME'] . "\n";
        ?></pre>
    </div>

    <div class="section">
        <h2>File System Check</h2>
        <pre><?php
        $files_to_check = [
            'logo.png',
            'favicon.ico',
            'index.php',
            'index.html',
            'php/login.php',
            'Components/header.php',
            'css/login-reg-forget/login.css'
        ];

        foreach ($files_to_check as $file) {
            if (file_exists($file)) {
                echo "✓ <span class='success'>$file</span> - EXISTS (" . filesize($file) . " bytes)\n";
            } else {
                echo "✗ <span class='error'>$file</span> - NOT FOUND\n";
            }
        }
        ?></pre>
    </div>

    <div class="section">
        <h2>Headers Test</h2>
        <pre><?php
        echo "Current Headers:\n";
        foreach (headers_list() as $header) {
            echo "$header\n";
        }
        ?></pre>
    </div>

    <div class="section">
        <h2>JavaScript Test</h2>
        <p>Testing for regex errors...</p>
        <div id="js-test"></div>
    </div>

    <div class="section">
        <h2>Image Loading Test</h2>
        <p>Testing image paths...</p>
        <img src="logo.png" alt="Logo Test" style="max-width: 100px;"
            onload="document.getElementById('img-test').innerHTML='<span class=success>✓ logo.png loaded successfully</span>'"
            onerror="document.getElementById('img-test').innerHTML='<span class=error>✗ logo.png failed to load</span>'">
        <div id="img-test"></div>
    </div>

    <div class="section">
        <h2>Recommendations</h2>
        <ul>
            <li>Clear browser cache (Ctrl+F5 or Cmd+Shift+R)</li>
            <li>Clear server cache (visit clear-cache.php)</li>
            <li>Check .htaccess file for rewrite rules</li>
            <li>Verify file permissions (644 for files, 755 for directories)</li>
            <li>Check server error logs for detailed information</li>
        </ul>
    </div>

    <script>
        // Test for JavaScript errors
        try {
            // Test regex that might cause issues
            const testRegex = /test/g;
            document.getElementById('js-test').innerHTML = '<span class="success">✓ JavaScript and regex working correctly</span>';
        } catch (e) {
            document.getElementById('js-test').innerHTML = '<span class="error">✗ JavaScript error: ' + e.message + '</span>';
        }

        // Log all loaded resources
        console.log('=== Resource Loading Check ===');
        performance.getEntriesByType('resource').forEach(resource => {
            console.log(resource.name, '-', resource.duration + 'ms');
        });
    </script>
</body>

</html>
