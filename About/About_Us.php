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
    <title>ABOUT US | IMARKETPH</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo $path_prefix; ?>css/about/about_us.css">
</head>

<body>

    <?php include '../Components/header.php'; ?>

    <main class="about-us-wrapper">

        <!-- Hero Section -->
        <section class="about-hero">
            <div class="hero-content">
                <h1>Redefining Online Shopping</h1>
                <p>Welcome to ImarketPH, where quality meets convenience. We are dedicated to providing you with the
                    very best of online shopping, with an emphasis on dependability, customer service, and uniqueness.
                </p>
                <a href="#our-story" class="btn-explore">Our Story</a>
            </div>
            <div class="hero-image-container">
                <!-- Using a placeholder or appropriate image if available. 
                     If no specific image, I'll use a gradient or a nice shape overlay in CSS. 
                     Or I can use a generic shop image from the project if one exists. 
                     For now, I'll style this heavily with CSS. -->
                <div class="hero-shape"></div>
                <img src="<?php echo $path_prefix; ?>image/logo.png" alt="ImarketPH Logo" class="hero-img-floating">
            </div>
        </section>

        <!-- Stats / Trust Badge Strip -->
        <div class="stats-strip">
            <div class="stat-item">
                <i class="fas fa-users"></i>
                <h3>10k+</h3>
                <p>Happy Customers</p>
            </div>
            <div class="stat-item">
                <i class="fas fa-box-open"></i>
                <h3>5,000+</h3>
                <p>Quality Products</p>
            </div>
            <div class="stat-item">
                <i class="fas fa-shipping-fast"></i>
                <h3>Fast</h3>
                <p>Nationwide Delivery</p>
            </div>
        </div>

        <!-- Our Story Section -->
        <section id="our-story" class="section-story">
            <div class="story-container">
                <div class="story-text">
                    <h2>Our Journey</h2>
                    <p>Founded in 2024, ImarketPH has come a long way from its beginnings. When we first started out,
                        our passion for "Eco-friendly and Affordable Products" drove us to start our own business.</p>
                    <p>We hope you enjoy our products as much as we enjoy offering them to you. If you have any
                        questions or comments, please don't hesitate to contact us.</p>

                    <div class="signature">
                        <p>Sincerely,</p>
                        <h4>The ImarketPH Team</h4>
                    </div>
                </div>
                <div class="story-visual">
                    <div class="visual-card">
                        <i class="fas fa-store-alt"></i>
                    </div>
                </div>
            </div>
        </section>

        <!-- Mission & Vision -->
        <section class="section-mission-vision">
            <div class="mv-grid">
                <div class="mv-card mission">
                    <div class="icon-box">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3>Our Mission</h3>
                    <p>To empower consumers by providing easy access to quality products while supporting local
                        businesses and sustainable practices.</p>
                </div>
                <div class="mv-card vision">
                    <div class="icon-box">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3>Our Vision</h3>
                    <p>To be the Philippines' most customer-centric online marketplace, where people can find and
                        discover anything they might want to buy online.</p>
                </div>
            </div>
        </section>

        <!-- Core Values -->
        <section class="section-values">
            <h2>Our Core Values</h2>
            <div class="values-grid">
                <div class="value-item">
                    <div class="val-icon"><i class="fas fa-heart"></i></div>
                    <h3>Customer First</h3>
                    <p>We exist to serve our customers and exceed their expectations.</p>
                </div>
                <div class="value-item">
                    <div class="val-icon"><i class="fas fa-shield-alt"></i></div>
                    <h3>Integrity</h3>
                    <p>We build relationships based on trust and transparency.</p>
                </div>
                <div class="value-item">
                    <div class="val-icon"><i class="fas fa-rocket"></i></div>
                    <h3>Innovation</h3>
                    <p>We constantly seek new ways to improve the shopping experience.</p>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="section-cta">
            <div class="cta-content">
                <h2>Ready to Start Shopping?</h2>
                <p>Explore our wide range of collections today.</p>
                <a href="<?php echo $path_prefix; ?>Content/Dashboard.php" class="btn-shop-now">Shop Now</a>
            </div>
        </section>

    </main>

    <?php include '../Components/footer.php'; ?>

</body>

</html>
