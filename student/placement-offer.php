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
                                    </span><br>
                                    <?php
                                }
                                ?>
                                <span class="text-truncate me-3"><i class="fa fa-phone-alt text-primary me-2"></i>
                                                <?php echo $placement_offer->organisation->phone_number?></span><br>
                                <span class="text-truncate me-3"><i class="fa fa-laptop text-primary me-2"></i>
                                                <?php echo $placement_offer->organisation->email_address?></span><br>
                            </div>
                        </div>

                        <div class="my-5">
                            <h4 class="mb-3">Organisation description</h4>
                            <?php
                            $placement_offer->organisation->display_description();
                            ?>
                            <h4 class="mb-3">Department(s) offered</h4>
                            <?php
                            $placement_offer->display_departments($database_connection);
                            ?>
                        </div>
        
                        <div class="">
                            <div class="col-12">
                                <button class="btn btn-primary w-100" type="button">Request Placement</button>
                            </div>
                        </div>
                    </div>
        
                    <div class="col-lg-4">
                        <div class="bg-light rounded p-5 mb-4 wow slideInUp" data-wow-delay="0.1s">
                            <h4 class="mb-4">Placement Offer Summary</h4>
                            <p><i class="fa fa-angle-right text-primary me-2"></i><b>Salary:</b>
                                <?php
                                if ($placement_offer->is_salary_offered()) {
                                    echo $placement_offer->get_salary();
                                } else {
                                    echo "No salary offered";
                                }
                                ?>
                            </p>
                            <p><i class="fa fa-angle-right text-primary me-2"></i><b>Location:</b>
                                <?php echo $placement_offer->organisation->address?></p>
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