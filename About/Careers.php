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
    <title>CAREERS | IMARKETPH</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS (Shared with About Us) -->
    <link rel="stylesheet" href="<?php echo $path_prefix; ?>css/about/about_us.css">
</head>

<body>

    <?php include '../Components/header.php'; ?>

    <main class="careers-wrapper">

        <!-- Hero Section -->
        <section class="careers-hero">
            <div class="hero-bg-overlay"></div>
            <div class="careers-hero-content">
                <h1>Shape the Future of E-Commerce</h1>
                <p>Join ImarketPH and be part of a team that's redefining how people shop online. We are looking for
                    passionate, innovative, and driven individuals.</p>
                <a href="#open-positions" class="btn-explore">View Openings</a>
            </div>
        </section>

        <!-- Perks & Benefits -->
        <section class="section-perks">
            <div class="section-header">
                <h2>Why Join Us?</h2>
                <p>We take care of our team so they can take care of our customers.</p>
            </div>
            <div class="perks-grid">
                <div class="perk-card">
                    <div class="perk-icon"><i class="fas fa-laptop-house"></i></div>
                    <h3>Remote Friendly</h3>
                    <p>Work from where you feel most productive. We embrace a hybrid work model.</p>
                </div>
                <div class="perk-card">
                    <div class="perk-icon"><i class="fas fa-briefcase-medical"></i></div>
                    <h3>Health & Wellness</h3>
                    <p>Comprehensive health insurance and wellness programs to keep you fit and happy.</p>
                </div>
                <div class="perk-card">
                    <div class="perk-icon"><i class="fas fa-chart-line"></i></div>
                    <h3>Growth Opportunities</h3>
                    <p>Continuous learning, mentorship, and career advancement paths.</p>
                </div>
                <div class="perk-card">
                    <div class="perk-icon"><i class="fas fa-coffee"></i></div>
                    <h3>Work-Life Balance</h3>
                    <p>Flexible hours and generous paid time off to recharge your batteries.</p>
                </div>
            </div>
        </section>

        <!-- Open Positions -->
        <section id="open-positions" class="section-positions">
            <div class="section-header">
                <h2>Open Positions</h2>
                <p>Find the role that fits your skills and passion.</p>
            </div>

            <div class="jobs-container">
                <!-- Engineering -->
                <div class="job-category">
                    <h3>Engineering & Tech</h3>
                    <div class="job-card">
                        <div class="job-info">
                            <h4>Senior Full Stack Developer</h4>
                            <span class="job-loc"><i class="fas fa-map-marker-alt"></i> Manila / Remote</span>
                            <span class="job-type">Full Time</span>
                        </div>
                        <a href="#" class="btn-apply">Apply Now</a>
                    </div>
                    <div class="job-card">
                        <div class="job-info">
                            <h4>UX/UI Designer</h4>
                            <span class="job-loc"><i class="fas fa-map-marker-alt"></i> Remote</span>
                            <span class="job-type">Full Time</span>
                        </div>
                        <a href="#" class="btn-apply">Apply Now</a>
                    </div>
                </div>

                <!-- Operations -->
                <div class="job-category">
                    <h3>Operations & Support</h3>
                    <div class="job-card">
                        <div class="job-info">
                            <h4>Customer Success Specialist</h4>
                            <span class="job-loc"><i class="fas fa-map-marker-alt"></i> Manila</span>
                            <span class="job-type">Full Time</span>
                        </div>
                        <a href="#" class="btn-apply">Apply Now</a>
                    </div>
                    <div class="job-card">
                        <div class="job-info">
                            <h4>Logistics Manager</h4>
                            <span class="job-loc"><i class="fas fa-map-marker-alt"></i> Quezon City</span>
                            <span class="job-type">Full Time</span>
                        </div>
                        <a href="#" class="btn-apply">Apply Now</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Gallery / Culture Section -->
        <section class="section-culture">
            <div class="culture-content">
                <h2>Life at ImarketPH</h2>
                <p>We are more than just a company. We are a community of diverse individuals united by a shared
                    mission.</p>
            </div>
            <div class="culture-gallery">
                <!-- Using placeholders or reusing existing images with standard classes -->
                <div class="gallery-item item-1"></div>
                <div class="gallery-item item-2"></div>
                <div class="gallery-item item-3"></div>
            </div>
        </section>

        <!-- CTA Section -->
        <div class="careers-footer-cta">
            <h2>Don't see a perfect fit?</h2>
            <p>We are always on the lookout for talent. Send us your resume and we'll keep you in mind for future
                openings.</p>
            <a href="mailto:careers@imarketph.com" class="btn-outline-white">Email Us</a>
        </div>

    </main>

    <?php include '../Components/footer.php'; ?>

</body>

</html>



