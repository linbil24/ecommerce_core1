<?php
if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
    session_start();
}
if (!isset($path_prefix)) {
    $path_prefix = '../';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo $path_prefix; ?>image/logo.png">
    <title>Terms & Conditions | ImarketPH</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS (Shared) -->
    <link rel="stylesheet" href="<?php echo $path_prefix; ?>css/about/about_us.css">
</head>

<body>

    <?php include '../Components/header.php'; ?>

    <main class="legal-wrapper">
        <div class="legal-header">
            <h1>Terms & Conditions</h1>
            <p>Please read these terms carefully before using our services.</p>
        </div>

        <div class="legal-content-wrapper">
            <div class="legal-container">
                <span class="last-updated">Last Updated: December 27, 2025</span>

                <h2>1. Agreement to Terms</h2>
                <p>These Terms and Conditions constitute a legally binding agreement made between you, whether
                    personally or on behalf of an entity (“you”) and ImarketPH (“we,” “us” or “our”), concerning your
                    access to and use of the ImarketPH website as well as any other media form, media channel, mobile
                    website or mobile application related, linked, or otherwise connected thereto (collectively, the
                    “Site”).</p>

                <h2>2. User Representations</h2>
                <p>By using the Site, you represent and warrant that:</p>
                <ul>
                    <li>All registration information you submit will be true, accurate, current, and complete.</li>
                    <li>You will maintain the accuracy of such information and promptly update such registration
                        information as necessary.</li>
                    <li>You have the legal capacity and you agree to comply with these Terms and Conditions.</li>
                    <li>You are not a minor in the jurisdiction in which you reside.</li>
                </ul>

                <h2>3. Products and Purchases</h2>
                <p>We make every effort to display as accurately as possible the colors, features, specifications, and
                    details of the products available on the Site. However, we do not guarantee that the colors,
                    features, specifications, and details of the products will be accurate, complete, reliable, current,
                    or free of other errors, and your electronic display may not accurately reflect the actual colors
                    and details of the products.</p>
                <p>We reserve the right to discontinue any products at any time for any reason. Prices for all products
                    are subject to change.</p>

                <h2>4. Intellectual Property Rights</h2>
                <p>Unless otherwise indicated, the Site is our proprietary property and all source code, databases,
                    functionality, software, website designs, audio, video, text, photographs, and graphics on the Site
                    (collectively, the “Content”) and the trademarks, service marks, and logos contained therein (the
                    “Marks”) are owned or controlled by us or licensed to us, and are protected by copyright and
                    trademark laws.</p>

                <h2>5. Site Management</h2>
                <p>We reserve the right, but not the obligation, to:</p>
                <ul>
                    <li>Monitor the Site for violations of these Terms and Conditions.</li>
                    <li>Take appropriate legal action against anyone who, in our sole discretion, violates the law or
                        these Terms and Conditions.</li>
                    <li>Refuse, restrict access to, limit the availability of, or disable (to the extent technologically
                        feasible) any of your Contributions or any portion thereof.</li>
                    <li>Otherwise manage the Site in a manner designed to protect our rights and property and to
                        facilitate the proper functioning of the Site.</li>
                </ul>

                <h2>6. Modifications and Interruptions</h2>
                <p>We reserve the right to change, modify, or remove the contents of the Site at any time or for any
                    reason at our sole discretion without notice. However, we have no obligation to update any
                    information on our Site. We also reserve the right to modify or discontinue all or part of the Site
                    without notice at any time.</p>

                <h2>7. Contact Us</h2>
                <p>In order to resolve a complaint regarding the Site or to receive further information regarding use of
                    the Site, please contact us at:</p>
                <p><strong>Email:</strong> legal@imarketph.com<br>
                    <strong>Phone:</strong> +63 123 456 7890
                </p>
            </div>
        </div>
    </main>

    <?php include '../Components/footer.php'; ?>

</body>

</html>



