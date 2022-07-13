<?php
$page_title = "Login";

require_once "header.php";
?>

    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-12">
                    <h1 class="text-primary display-1 mb-5"><?php echo $page_title?></h1>

                    <div class="row mt-5">
                        <div class="col-4 shadow p-3 mx-auto">
                            <i class="fa fa-5x fa-user mb-3 text-primary"></i>
                            <p>Are you a student searched for an organisation to be placed at during SIWES?</p>
                            <a href="student/login.php" class="btn btn-primary py-md-3 px-md-5 me-3 my-3">
                                Login as a student
                            </a>
                            <p>Not registered yet? <a href="student/signup.php">Signup as a student instead.</a></p>
                        </div>

                        <div class="col-4 shadow p-3 mx-auto">
                            <i class="fa fa-5x fa-building mb-3 text-primary"></i>
                            <p>Are you an organisation looking for students to intern?</p>
                            <a href="organisation/login.php" class="btn btn-primary py-md-3 px-md-5 me-3 my-3">
                                Login as an organisation
                            </a>
                            <p>Not registered yet? <a href="organisation/signup.php">Signup as an organisation instead.</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php
require_once "footer.php";
?>