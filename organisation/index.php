<?php
$page_title = "Organisation Dashboard";

require_once "dashboard-header.php";
?>

<div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <h1 class="text-primary display-1 mb-5 text-center"><?php echo $page_title?></h1>

                <div class="col-12 col-md-9 mx-auto">
                    <table class="table table-striped table-hover table-sm text-center mb-5">
                        <tbody>
                            <tr>
                                <th class="p-2 align-middle">Organisation Name</th>
                                <td class="p-2">
                                    <img class="flex-shrink-0 img-fluid border rounded"
                                         src="<?php echo $organisation->get_logo()?>"
                                         alt="Organisation Logo" style="width: 120px; height: 60px;"><br>
                                    <?php echo $organisation->organisation_name?>
                                </td>
                            </tr>
                            <tr>
                                <th class="p-2">Address<i class="fa fa-map-marker-alt text-primary ms-1"></i></th>
                                <td class="p-2"><?php echo $organisation->address?></td>
                            </tr>
                            <tr>
                                <th class="p-2">Description</th>
                                <td class="p-2"><?php echo $organisation->display_description()?></td>
                            </tr>
                            <tr>
                                <th class="p-2">Email Address<i class="fa fa-laptop text-primary ms-1"></i></th>
                                <td class="p-2"><?php echo $organisation->email_address?></td>
                            </tr>
                            <tr>
                                <th class="p-2">Phone Number<i class="fa fa-phone-alt text-primary ms-1"></i></th>
                                <td class="p-2"><?php echo $organisation->phone_number?></td>
                            </tr>
                            <tr>
                                <th colspan="2"><a href="update-profile.php">Update Details</a></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
require_once "../student/footer.php";
?>
