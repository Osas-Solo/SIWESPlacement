<?php
$page_title = "Placement Requests";

require_once "dashboard-header.php";

$placement_requests = PlacementRequest::get_placement_requests($database_connection,
    matriculation_number: $student->matriculation_number);
?>

    <!-- Jobs Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <h1 class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s"><?php echo $page_title?></h1>
            <div class="text-center wow fadeInUp" data-wow-delay="0.3s">
                <div>
                    <div class="fade show p-0 active">
                        <?php
                        if (count($placement_requests) > 0) {
                            foreach ($placement_requests as $current_placement_request) {
                                ?>
                                <div class="job-item p-4 mb-4">
                                    <div class="row g-4">
                                        <div class="col-sm-12 col-md-8 d-flex align-items-center">
                                            <img class="flex-shrink-0 img-fluid border rounded"
                                                 src="<?php echo $current_placement_request->placement_offer->organisation->get_logo()?>"
                                                 alt="Organisation Logo" style="width: 100px; height: 60px;">
                                            <div class="text-start ps-4">
                                                <h5>
                                                    <?php echo $current_placement_request->placement_offer->organisation->organisation_name?>
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-2 d-flex flex-column align-items-start align-items-md-end justify-content-center">
                                            <div class="d-flex mb-3">
                                                <a class="btn <?php
                                                if ($current_placement_request->is_pending()) {
                                                    echo 'btn-warning';
                                                } else if ($current_placement_request->is_accepted()) {
                                                    echo 'btn-success';
                                                } else if ($current_placement_request->is_rejected()) {
                                                    echo 'btn-danger';
                                                }
                                                ?>" href="view-placement-request.php?id=<?php echo $current_placement_request->placement_request_id?>">
                                                    <?php echo $current_placement_request->status?>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-2 d-flex flex-column align-items-start align-items-md-end justify-content-center">
                                            <div class="d-flex mb-3">
                                                <a class="btn btn-primary"
                                                   href="view-placement-request.php?id=<?php echo $current_placement_request->placement_request_id?>">
                                                    View Request
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
                </div>
            </div>
        </div>
    </div>
    <!-- Jobs End -->


<?php
require_once "footer.php";
?>