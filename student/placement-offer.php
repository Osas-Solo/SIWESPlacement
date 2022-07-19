<?php
$page_title = "View Placement Offer";

require_once "dashboard-header.php";

$placement_offer_id = "";

if (isset($_GET["id"])) {
    $placement_offer_id = $_GET["id"];
}

$placement_offer = new PlacementOffer($database_connection, $placement_offer_id);
?>

        <!-- Job Detail Start -->
        <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="container">
                <?php
                if ($placement_offer->is_found()) {
                ?>
                <div class="row gy-5 gx-4">
                    <div class="col-lg-8">
                        <div class="d-flex align-items-center mb-5">
                            <img class="flex-shrink-0 img-fluid border rounded"
                                 src="<?php echo $placement_offer->organisation->get_logo()?>"
                                 alt="Organisation Logo" style="width: 100px; height: 60px;">
                            <div class="text-start ps-4">
                                <h5 class="mb-3"><?php echo $placement_offer->organisation->organisation_name?></h5>
                                <span class="text-truncate me-3"><i class="fa fa-map-marker-alt text-primary me-2"></i>
                                                <?php echo $placement_offer->organisation->address?></span><br>
                                <?php
                                if ($placement_offer->is_salary_offered()) {
                                    ?>
                                    <span class="text-truncate me-0"><i class="far fa-money-bill-alt text-primary me-2"></i>
                                        <?php echo $placement_offer->get_salary()?>
                                    </span>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>

                        <div class="mb-5">
                            <h4 class="mb-3">Organisation description</h4>
                            <?php
                            $placement_offer->organisation->display_description();
                            ?>
                            <h4 class="mb-3">Qualifications</h4>
                            <p>Magna et elitr diam sed lorem. Diam diam stet erat no est est. Accusam sed lorem stet voluptua sit sit at stet consetetur, takimata at diam kasd gubergren elitr dolor</p>
                            <ul class="list-unstyled">
                                <li><i class="fa fa-angle-right text-primary me-2"></i>Dolor justo tempor duo ipsum accusam</li>
                                <li><i class="fa fa-angle-right text-primary me-2"></i>Elitr stet dolor vero clita labore gubergren</li>
                                <li><i class="fa fa-angle-right text-primary me-2"></i>Rebum vero dolores dolores elitr</li>
                                <li><i class="fa fa-angle-right text-primary me-2"></i>Est voluptua et sanctus at sanctus erat</li>
                                <li><i class="fa fa-angle-right text-primary me-2"></i>Diam diam stet erat no est est</li>
                            </ul>
                        </div>
        
                        <div class="">
                            <h4 class="mb-4">Apply For The Job</h4>
                            <form>
                                <div class="row g-3">
                                    <div class="col-12 col-sm-6">
                                        <input type="text" class="form-control" placeholder="Your Name">
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <input type="email" class="form-control" placeholder="Your Email">
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <input type="text" class="form-control" placeholder="Portfolio Website">
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <input type="file" class="form-control bg-white">
                                    </div>
                                    <div class="col-12">
                                        <textarea class="form-control" rows="5" placeholder="Coverletter"></textarea>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100" type="submit">Apply Now</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
        
                    <div class="col-lg-4">
                        <div class="bg-light rounded p-5 mb-4 wow slideInUp" data-wow-delay="0.1s">
                            <h4 class="mb-4">Job Summery</h4>
                            <p><i class="fa fa-angle-right text-primary me-2"></i>Published On: 01 Jan, 2045</p>
                            <p><i class="fa fa-angle-right text-primary me-2"></i>Vacancy: 123 Position</p>
                            <p><i class="fa fa-angle-right text-primary me-2"></i>Job Nature: Full Time</p>
                            <p><i class="fa fa-angle-right text-primary me-2"></i>Salary: $123 - $456</p>
                            <p><i class="fa fa-angle-right text-primary me-2"></i>Location: New York, USA</p>
                            <p class="m-0"><i class="fa fa-angle-right text-primary me-2"></i>Date Line: 01 Jan, 2045</p>
                        </div>
                        <div class="bg-light rounded p-5 wow slideInUp" data-wow-delay="0.1s">
                            <h4 class="mb-4">Company Detail</h4>
                            <p class="m-0">Ipsum dolor ipsum accusam stet et et diam dolores, sed rebum sadipscing elitr vero dolores. Lorem dolore elitr justo et no gubergren sadipscing, ipsum et takimata aliquyam et rebum est ipsum lorem diam. Et lorem magna eirmod est et et sanctus et, kasd clita labore.</p>
                        </div>
                    </div>
                </div>
                <?php
                } else {
                ?>
                <div class="row my-5 gy-5 gx-4">
                    <div class="col-12 my-5">
                        <div class="text-center ps-4">
                            <h3 class="mb-3">
                                Sorry, no placement offer with the id: <?php echo $placement_offer_id?> could be found.
                            </h3>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
        <!-- Job Detail End -->

<?php
require_once "footer.php";
?>