<?php
$page_title = "Home";

require_once "header.php";
?>

        <!-- Carousel Start -->
        <div class="container-fluid p-0">
            <div class="owl-carousel header-carousel position-relative">
                <div class="owl-carousel-item position-relative">
                    <img class="img-fluid" src="img/carousel-1.jpg" alt="">
                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(43, 57, 64, .5);">
                        <div class="container">
                            <div class="row justify-content-start">
                                <div class="col-10 col-lg-8">
                                    <h1 class="display-3 text-white animated slideInDown mb-4">Find The Placement That You Deserve</h1>
                                    <p class="fs-5 fw-medium text-white mb-4 pb-2">Get the opportunity to work with organisation in your field of study.</p>
                                    <a href="student/find-placement.php" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Find Placement</a>
                                    <a href="organisation/post-placement.php" class="btn btn-secondary py-md-3 px-md-5 animated slideInRight">Post Placement</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="owl-carousel-item position-relative">
                    <img class="img-fluid" src="img/carousel-2.jpg" alt="">
                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(43, 57, 64, .5);">
                        <div class="container">
                            <div class="row justify-content-start">
                                <div class="col-10 col-lg-8">
                                    <h1 class="display-3 text-white animated slideInDown mb-4">Find The Best Organisation That Fits You</h1>
                                    <p class="fs-5 fw-medium text-white mb-4 pb-2">Get a feel of what it's like working in the real world.</p>
                                    <a href="student/find-placement.php" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Find Placement</a>
                                    <a href="organisation/post-placement.php" class="btn btn-secondary py-md-3 px-md-5 animated slideInRight">Post Placement</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Carousel End -->

<?php
require_once "footer.php";
?>