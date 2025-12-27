<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NEW ARRIVALS | IMARKET</title>
    <link rel="icon" type="image/x-icon" href="../../Image/Logo.png">
    <link rel="stylesheet" href="../../Css/Best-selling/Best.css?v=<?php echo time(); ?>">
</head>

<body>
    <nav>
        <?php $path_prefix = '../../';
        include '../../Components/header.php'; ?>
    </nav>

    <div class="content">
        <div class="best-selling-container">
            <!-- Text Section (Left) -->
            <div class="text-section">
                <h2>ImarketPH</h2>
                <p>New Arrivals</p>

                <a class="btn-shop" href="../../Shop-now/index.php">Shop now</a>
            </div>

            <!-- Slider Section (Right)-->
            <div class="slider-section">
                <div class="fade-slider">
                    <!-- Slides -->
                    <div class="fade-slide active"
                        style="background-image: url('../../Image/New-arrivals/Aesthetic Desk Organizer Set.jpeg');">
                    </div>
                    <div class="fade-slide"
                        style="background-image: url('../../Image/New-arrivals/Classic Leather Wallet (Men).jpeg');">
                    </div>
                    <div class="fade-slide"
                        style="background-image: url('../../Image/New-arrivals/Canvas Tote Bag.jpeg');">
                    </div>
                    <div class="fade-slide"
                        style="background-image: url('../../Image/New-arrivals/Trendy Crossbody Bag (Women).');"></div>
                    <div class="fade-slide"
                        style="background-image: url('../../Image/Best/Wireless Bluetooth Earbuds.jpeg');"></div>

                    <!-- Indicators (White Lines) -->
                    <div class="slider-indicators">
                        <span class="indicator active" onclick="goToSlide(0)"></span>
                        <span class="indicator" onclick="goToSlide(1)"></span>
                        <span class="indicator" onclick="goToSlide(2)"></span>
                        <span class="indicator" onclick="goToSlide(3)"></span>
                        <span class="indicator" onclick="goToSlide(4)"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-card">
        <div class="section-header">
            <h2>New Arrivals</h2>
            <p>Check out our New Arrivals!</p>
        </div>
        <?php include 'card.php'; ?>
    </div>



    <script>
        let currentSlideIndex = 0;
        const slides = document.querySelectorAll('.fade-slide');
        const indicators = document.querySelectorAll('.indicator');
        const totalSlides = slides.length;
        let slideInterval;

        function showSlide(index) {
            if (index >= totalSlides) index = 0;
            if (index < 0) index = totalSlides - 1;

            // Allow transition
            slides.forEach(slide => slide.classList.remove('active'));
            indicators.forEach(ind => ind.classList.remove('active'));

            currentSlideIndex = index;
            slides[currentSlideIndex].classList.add('active');
            indicators[currentSlideIndex].classList.add('active');
        }

        function nextSlide() {
            showSlide(currentSlideIndex + 1);
        }

        function goToSlide(index) {
            showSlide(index);
            resetInterval();
        }

        function resetInterval() {
            clearInterval(slideInterval);
            slideInterval = setInterval(nextSlide, 4000);
        }

        resetInterval();
    </script>

    <footer>
        <?php include '../../Components/footer.php'; ?>
    </footer>
</body>

</html>