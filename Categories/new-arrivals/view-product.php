<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../../image/logo.png">
    <title><?php echo htmlspecialchars($page_title); ?> - IMarket</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo $path_prefix; ?>css/components/product-view.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="<?php echo $path_prefix; ?>css/dashboard/reviews.css?v=<?php echo time(); ?>">
</head>

<body>
    <nav>
        <?php

        $path_prefix = '../../';
        include '../../Components/header.php';
        ?>
    </nav>



    <div style="text-align: center; margin: 20px 0 10px;">
        <img src="../../image/logo.png" alt="iMarket Logo"
            style="height: 32px; vertical-align: middle; margin-right: 10px;">
        <span
            style="font-size: 20px; font-weight: bold; color: #2A3B7E; vertical-align: middle; font-family: sans-serif;">New
            Arrivals | IMarket</span>
    </div>

    <div class="content">
        <div style="width: 100%; max-width: 1200px; display: flex; flex-direction: column; gap: 40px;">
            <div class="product">
                <?php

                // Get product ID from URL, default to 201
                $product_id = isset($_GET['id']) ? intval($_GET['id']) : 201;

                // Include the template which handles data retrieval and display
                include 'Product_template.php';
                ?>
            </div>

            <?php

            // Set product_id for reviews (default to 0 or map based on name if needed)
            $product_id = isset($p_id) ? $p_id : 0;
            include 'reviews_section.php';
            ?>
        </div>
    </div>


    <footer>
        <?php

        $path_prefix = '../../';
        include '../../Components/footer.php';
        ?>
    </footer>
</body>

</html>










