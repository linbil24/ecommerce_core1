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
    <title>Privacy Policy | ImarketPH</title>

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
            <h1>Privacy Policy</h1>
            <p>Transparency is key to our relationship.</p>
        </div>

        <div class="legal-content-wrapper">
            <div class="legal-container">
                <span class="last-updated">Last Updated: December 27, 2025</span>

                <h2>1. Introduction</h2>
                <p>Welcome to ImarketPH. We value your privacy and are committed to protecting your personal data. This
                    Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit
                    our website.</p>

                <h2>2. Information We Collect</h2>
                <p>We may collect information about you in a variety of ways. The information we may collect on the Site
                    includes:</p>
                <ul>
                    <li><strong>Personal Data:</strong> Personally identifiable information, such as your name, shipping
                        address, email address, and telephone number, that you voluntarily give to us when you register
                        with the Site or when you choose to participate in various activities related to the Site.</li>
                    <li><strong>Derivative Data:</strong> Information our servers automatically collect when you access
                        the Site, such as your IP address, your browser type, your operating system, your access times,
                        and the pages you have viewed directly before and after accessing the Site.</li>
                </ul>

                <h2>3. Use of Your Information</h2>
                <p>Having accurate information about you permits us to provide you with a smooth, efficient, and
                    customized experience. Specifically, we may use information collected about you via the Site to:</p>
                <ul>
                    <li>Create and manage your account.</li>
                    <li>Process your orders and deliver products.</li>
                    <li>Email you regarding your account or order.</li>
                    <li>Prevent fraudulent transactions, monitor against theft, and protect against criminal activity.
                    </li>
                </ul>

                <h2>4. Disclosure of Your Information</h2>
                <p>We may share information we have collected about you in certain situations. Your information may be
                    disclosed as follows:</p>
                <ul>
                    <li><strong>By Law or to Protect Rights:</strong> If we believe the release of information about you
                        is necessary to respond to legal process, to investigate or remedy potential violations of our
                        policies, or to protect the rights, property, and safety of others.</li>
                    <li><strong>Third-Party Service Providers:</strong> We may share your information with third parties
                        that perform services for us or on our behalf, including payment processing, data analysis,
                        email delivery, hosting services, customer service, and marketing assistance.</li>
                </ul>

                <h2>5. Security of Your Information</h2>
                <p>We use administrative, technical, and physical security measures to help protect your personal
                    information. While we have taken reasonable steps to secure the personal information you provide to
                    us, please be aware that despite our efforts, no security measures are perfect or impenetrable.</p>

                <h2>6. Contact Us</h2>
                <p>If you have questions or comments about this Privacy Policy, please contact us at:</p>
                <p><strong>Email:</strong> privacy@imarketph.com<br>
                    <strong>Phone:</strong> +63 123 456 7890
                </p>
            </div>
        </div>
    </main>

    <?php include '../Components/footer.php'; ?>

</body>

</html>



