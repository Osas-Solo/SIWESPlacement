<?php
$page_title = "View Placement Request";

require_once "dashboard-header.php";

$placement_request_id = "";

if (isset($_GET["id"])) {
    $placement_request_id = $_GET["id"];
}

$placement_request = new PlacementRequest($database_connection, placement_request_id: $placement_request_id,
    matriculation_number: $student->matriculation_number);
?>

<div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <h1 class="text-primary mb-5 text-center"><?php echo $page_title?></h1>

                <?php
                if ($placement_request->is_found()) {
                ?>
                <div class="col-12 col-md-9 mx-auto">
                    <table class="table table-striped table-hover table-sm text-center mb-5">
                        <tbody>
                        <tr>
                            <th class="p-2 align-middle">Organisation</th>
                            <td class="p-2">
                                <img class="flex-shrink-0 img-fluid border rounded"
                                     src="<?php echo $placement_request->placement_offer->organisation->get_logo()?>"
                                     alt="Organisation Logo" style="width: 120px; height: 60px;"><br>
                                <?php echo $placement_request->placement_offer->organisation->organisation_name?>
                            </td>
                        </tr>
                        <tr>
                            <th class="p-2">Status</th>
                            <td class="p-2 <?php
                            if ($placement_request->is_pending()) {
                                echo 'text-warning';
                            } else if ($placement_request->is_accepted()) {
                                echo 'text-success';
                            } else if ($placement_request->is_rejected()) {
                                echo 'text-danger';
                            }
                            ?>">
                                <?php echo $placement_request->status?>
                            </td>
                        </tr>
                        <?php
                        if ($placement_request->is_accepted()) {
                        ?>
                        <tr>
                            <th class="p-2">Acceptance Date</th>
                            <td class="p-2"><?php echo $placement_request->get_acceptance_date()?></td>
                        </tr>
                        <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>

                <?php
                } else {
                    ?>
                    <div class="row my-5 gy-5 gx-4">
                        <div class="col-12 my-5">
                            <div class="text-center ps-4">
                                <h3 class="mb-3">
                                    Sorry, no placement request with the id: <?php echo $placement_request_id?> could be found.
                                </h3>
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


<?php
require_once "footer.php";
?>
