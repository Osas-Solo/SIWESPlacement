<?php
$page_title = "Find Placement";

require_once "dashboard-header.php";

$placement_offers = PlacementOffer::get_placement_offers($database_connection, "", "", false);
$distinct_placement_offers = PlacementOffer::get_distinct_placement_offers($placement_offers);
$department_placement_offers = PlacementOffer::get_placement_offers($database_connection, "",
    $student->department->department_name, false);
$distinct_department_placement_offers = PlacementOffer::get_distinct_placement_offers($department_placement_offers);
?>

<!-- Jobs Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <h1 class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s"><?php echo $page_title?></h1>
                <div class="tab-class text-center wow fadeInUp" data-wow-delay="0.3s">
                    <ul class="nav nav-pills d-inline-flex justify-content-center border-bottom mb-5">
                        <li class="nav-item">
                            <a class="d-flex align-items-center text-start mx-3 ms-0 pb-3 active" data-bs-toggle="pill" href="#tab-1">
                                <h6 class="mt-n1 mb-0">All Offers</h6>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="d-flex align-items-center text-start mx-3 pb-3" data-bs-toggle="pill" href="#tab-2">
                                <h6 class="mt-n1 mb-0">Department Offers</h6>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane fade show p-0 active">
                        <?php
                        if (count($distinct_placement_offers) > 0) {
                            foreach ($distinct_placement_offers as $current_distinct_placement_offer) {
                        ?>
                            <div class="job-item p-4 mb-4">
                                <div class="row g-4">
                                    <div class="col-sm-12 col-md-8 d-flex align-items-center">
                                        <img class="flex-shrink-0 img-fluid border rounded"
                                             src="<?php echo $current_distinct_placement_offer->organisation->get_logo()?>"
                                             alt="Organisation Logo" style="width: 100px; height: 60px;">
                                        <div class="text-start ps-4">
                                            <h5 class="mb-3"><?php echo $current_distinct_placement_offer->organisation->organisation_name?></h5>
                                            <span class="text-truncate me-3"><i class="fa fa-map-marker-alt text-primary me-2"></i>
                                                <?php echo $current_distinct_placement_offer->organisation->address?></span><br>
                                            <?php
                                            if ($current_distinct_placement_offer->is_salary_offered()) {
                                            ?>
                                            <span class="text-truncate me-0"><i class="far fa-money-bill-alt text-primary me-2"></i>
                                                <?php echo $current_distinct_placement_offer->get_salary()?>
                                            </span>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center">
                                        <div class="d-flex mb-3">
                                            <a class="btn btn-primary"
                                               href="placement-offer.php?id=<?php echo $current_distinct_placement_offer->placement_offer_id?>">
                                                Apply Now
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                            }
                        } else {
                        ?>
                            <div class="job-item p-4 mb-4">
                                <div class="row g-4">
                                    <div class="col-12">
                                        <div class="text-center ps-4">
                                            <h5 class="mb-3">
                                                Sorry, no placement offer is currently available. Please check back later.
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                        </div>
                        <div id="tab-2" class="tab-pane fade show p-0">
                            <?php
                            if (count($distinct_department_placement_offers) > 0) {
                                foreach ($distinct_department_placement_offers as $current_distinct_placement_offer) {
                                    ?>
                                    <div class="job-item p-4 mb-4">
                                        <div class="row g-4">
                                            <div class="col-sm-12 col-md-8 d-flex align-items-center">
                                                <img class="flex-shrink-0 img-fluid border rounded"
                                                     src="<?php echo $current_distinct_placement_offer->organisation->get_logo()?>"
                                                     alt="Organisation Logo" style="width: 100px; height: 60px;">
                                                <div class="text-start ps-4">
                                                    <h5 class="mb-3"><?php echo $current_distinct_placement_offer->organisation->organisation_name?></h5>
                                                    <span class="text-truncate me-3"><i class="fa fa-map-marker-alt text-primary me-2"></i>
                                                <?php echo $current_distinct_placement_offer->organisation->address?></span><br>
                                                    <?php
                                                    if ($current_distinct_placement_offer->is_salary_offered()) {
                                                        ?>
                                                        <span class="text-truncate me-0"><i class="far fa-money-bill-alt text-primary me-2"></i>
                                                <?php echo $current_distinct_placement_offer->get_salary()?>
                                            </span>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center">
                                                <div class="d-flex mb-3">
                                                    <a class="btn btn-primary"
                                                       href="placement-offer.php?id=<?php echo $current_distinct_placement_offer->placement_offer_id?>">
                                                        Apply Now
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                ?>
                                <div class="job-item p-4 mb-4">
                                    <div class="row g-4">
                                        <div class="col-12">
                                            <div class="text-center ps-4">
                                                <h5 class="mb-3">
                                                    Sorry, no placement offered is currently available for your department. Please check back later.
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Jobs End -->


<?php
require_once "footer.php";
?>