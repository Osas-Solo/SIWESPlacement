<?php
$page_title = "Placement Offers";

require_once "dashboard-header.php";

$placement_offers = PlacementOffer::get_placement_offers($database_connection,
    organisation_id: $organisation->organisation_id, is_placement_full: null);
?>

    <!-- Jobs Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <h1 class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s"><?php echo $page_title?></h1>
            <div class="text-center wow fadeInUp" data-wow-delay="0.3s">
                <div>
                    <div class="fade show p-0 active">
                        <?php
                        if (count($placement_offers) > 0) {
                            foreach ($placement_offers as $current_placement_offer) {
                                ?>
                                <div class="job-item p-4 mb-4">
                                    <div class="row g-4">
                                        <div class="col-sm-12 col-md-8 d-flex align-items-center">
                                            <div class="text-start ps-4">
                                                <h5>
                                                    <?php echo $current_placement_offer->department->department_name?>
                                                </h5>
                                            </div>
                                            <div class="text-start ps-4">
                                                <h5>
                                                    <?php
                                                    $number_of_students = $current_placement_offer->calculate_number_of_students_allowed($database_connection);
                                                    echo $number_of_students . (($number_of_students <= 1) ? " student"
                                                            : " students") . " left";
                                                    ?>
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-2 d-flex flex-column align-items-start align-items-md-end justify-content-center">
                                            <div class="d-flex mb-3">
                                                <h5><?php
                                                if ($current_placement_offer->is_salary_offered()) {
                                                    echo $current_placement_offer->get_salary();
                                                }
                                                ?>
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-2 d-flex flex-column align-items-start align-items-md-end justify-content-center">
                                            <div class="d-flex mb-3">
                                                <a class="btn btn-primary"
                                                   href="view-placement-offer.php?id=<?php echo $current_placement_offer->placement_offer_id?>">
                                                    View Offer
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
                                                Sorry, your organisation has no placement offer that hasn't gotten any response.
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
require_once "../student/footer.php";
?>