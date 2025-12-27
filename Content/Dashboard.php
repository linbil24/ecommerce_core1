<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../php/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DASHBOARD - IMARKET PH</title>
    <link rel="icon" type="image/x-icon" href="../Image/Logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../Css/Dashboard/Dashboard.css?v=<?php echo time(); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../Css/Components/footer.css">
</head>

<body>
    <nav>
        <?php include '../Components/header.php'; ?>
    </nav>

    <div class="hero-section">
        <div class="hero-slider">
            <div class="slide active" style="background-image: url('../Image/Dashboard/brand new bag.jpeg');"></div>
            <div class="slide" style="background-image: url('../Image/Dashboard/Ipone 17.jpeg');"></div>
            <div class="slide" style="background-image: url('../Image/Dashboard/laptop red dragon.jpeg');"></div>
            <div class="slide" style="background-image: url('../Image/Dashboard/logitech.jpeg');"></div>
            <div class="slide" style="background-image: url('../Image/Dashboard/nike logo basketball.jpeg');"></div>
        </div>

        <div class="hero-content">
            <span class="welcome-text">WELCOME TO</span>
            <br>
            <h1 class="brand-title">IMARKET PH</h1>
            <p class="hero-subtitle">Your Ultimate Shopping Destination in the Philippines</p>

            <div class="stats-container">
                <div class="stat-box">
                    <h3>300</h3>
                    <p>Products</p>
                </div>
                <div class="stat-box">
                    <h3>24/7</h3>
                    <p>Support</p>
                </div>
                <div class="stat-box">
                    <h3>99%</h3>
                    <p>Satisfaction</p>
                </div>
            </div>

            <div class="hero-buttons">
                <a href="../Shop-now/index.php" class="btn-shop">
                    <i class="fas fa-shopping-bag"></i> Shop Now
                </a>
                <a href="../Categories/Best-selling/index.php" class="btn-best">
                    <i class="fas fa-fire"></i> Best Sellers
                </a>
            </div>
        </div>

        <div class="slider-indicators">
            <span class="indicator active" onclick="currentSlide(0)"></span>
            <span class="indicator" onclick="currentSlide(1)"></span>
            <span class="indicator" onclick="currentSlide(2)"></span>
            <span class="indicator"></span>
            <span class="indicator"></span>
        </div>

        <?php include '../Components/floating-buttons.php'; ?>
        <?php include '../Components/ai_confirmation_modal.php'; ?>
        <?php include '../Components/product-modal.php'; ?>
        <script>
            let currentSlideIndex = 0;
            const slides = document.querySelectorAll('.slide');
            const indicators = document.querySelectorAll('.indicator');
            const totalSlides = slides.length;
            let slideInterval;

            function showSlide(index) {
                // Remove active class from all slides and indicators
                slides.forEach(slide => slide.classList.remove('active'));
                indicators.forEach(indicator => indicator.classList.remove('active'));

                // Handle wrapping
                if (index >= totalSlides) currentSlideIndex = 0;
                else if (index < 0) currentSlideIndex = totalSlides - 1;
                else currentSlideIndex = index;

                // Add active class to current slide and indicator
                slides[currentSlideIndex].classList.add('active');

                // Safe check for indicator existence to avoid errors if mismatch
                if (indicators[currentSlideIndex]) {
                    indicators[currentSlideIndex].classList.add('active');
                }
            }

            function nextSlide() {
                showSlide(currentSlideIndex + 1);
            }

            function currentSlide(index) {
                showSlide(index);
                resetInterval();
            }

            function resetInterval() {
                clearInterval(slideInterval);
                slideInterval = setInterval(nextSlide, 5000); // Change slide every 5 seconds
            }

            // Initialize slider
            showSlide(currentSlideIndex);
            resetInterval();
        </script>


</body>

</html>