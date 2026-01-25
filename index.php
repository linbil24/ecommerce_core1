<?php
// iMarket Loading Page v3.6 (Hard Cache-Break Version)
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iMarket - Loading...</title>
    <!-- Use root-relative paths for maximum reliability -->
    <meta http-equiv="refresh" content="2;url=php/login.php">
    <link rel="icon" type="image/png" href="logo.png">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #4A6E95 0%, #2B4560 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            color: white;
        }

        .loader-container {
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        .logo-img {
            width: 120px;
            height: auto;
            margin-bottom: 20px;
            animation: pulse 2s infinite ease-in-out;
            filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.3));
        }

        .brand-name {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 5px;
            letter-spacing: 1px;
        }

        .tagline {
            font-size: 1.1rem;
            font-weight: 300;
            opacity: 0.8;
            margin-bottom: 50px;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 3px solid rgba(255, 255, 255, 0.2);
            border-top: 3px solid #fff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }
    </style>
</head>

<body>
    <div class="loader-container">
        <!-- Using the root logo.png we just created -->
        <img src="logo.png" alt="iMarket Logo" class="logo-img">
        <div class="text-content">
            <h1 class="brand-name">iMarket</h1>
            <p class="tagline">Your Market, Your Choice</p>
        </div>
        <div class="spinner"></div>
    </div>
</body>

</html>