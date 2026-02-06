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
            <p>iMarket: E-Commerce Core Transaction 1</p>
        </div>

        <div class="legal-content-wrapper">
            <div class="legal-container">
                <p>By accessing and using the iMarket system, you agree to the following Terms and Conditions:</p>

                <h2>1. Use of the System</h2>
                <p>iMarket is an academic e-commerce platform developed for educational and research purposes. Users agree to use the system only for lawful and intended activities such as browsing products, using AI image and voice search, placing orders, and submitting reviews.</p>

                <h2>2. Account Responsibility</h2>
                <p>Users are responsible for keeping their login credentials confidential. Any activity performed using a registered account is the responsibility of the account holder. Providing false or misleading information may result in account suspension.</p>

                <h2>3. Acceptable Use</h2>
                <p>Users must not:</p>
                <ul>
                    <li>Upload harmful or malicious content</li>
                    <li>Attempt unauthorized access to the system</li>
                    <li>Manipulate product data, reviews, or transactions</li>
                    <li>Use the platform for fraudulent or illegal activities</li>
                </ul>

                <h2>4. AI Features Disclaimer</h2>
                <p>AI Image Search, Voice Search, and NLP-based review summaries are provided to assist product discovery. The system does not guarantee 100% accuracy of AI results. Users should verify product details before making purchases.</p>

                <h2>5. Product Information and Reviews</h2>
                <p>Product details and reviews are provided by sellers and users. iMarket does not guarantee their accuracy. Inappropriate or misleading content may be removed without notice.</p>

                <h2>6. Transactions and Payments</h2>
                <p>Users are responsible for ensuring correct order and payment details. The system is not liable for errors caused by incorrect input or third-party payment services.</p>

                <h2>7. Privacy and Data Protection</h2>
                <p>Personal data is collected for system functionality and improvement. All data is handled in accordance with the Data Privacy Act of 2012 (RA 10173).</p>

                <h2>8. System Availability and Security</h2>
                <p>iMarket may undergo maintenance that can temporarily affect access. Users must not attempt to bypass system security features.</p>

                <h2>9. Limitation of Liability</h2>
                <p>iMarket is provided “as is.” The developers are not liable for data loss, downtime, incorrect AI results, or disputes between buyers and sellers.</p>

                <h2>10. Termination of Access</h2>
                <p>Accounts may be suspended or terminated for violations of these Terms and Conditions.</p>

                <h2>11. Acceptance of Terms</h2>
                <p>By using iMarket, you confirm that you have read, understood, and agreed to these Terms and Conditions.</p>
            </div>
        </div>
    </main>

    <?php include '../Components/footer.php'; ?>

</body>

</html>
