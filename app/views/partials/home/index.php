<?php 
$page_id = null;
$comp_model = new SharedController;
$current_page = $this->set_current_page_link();
?>
<div>
    <div  class="bg-light p-3 mb-3">
        <div class="container">
            <div class="row ">
                <div class="col-md-12 comp-grid">
                    <h4 >Student Dashboard</h4>
                </div>
            </div>
        </div>
    </div>
    <div  class="p-3 mb-3">
        <div class="container">
            <div class="row ">
                <div class="col-md-12 comp-grid">
                </div>
                <div class="col-md-4 col-sm-4 comp-grid">
                    <?php $rec_count = $comp_model->getcount_projects();  ?>
                    <a class="animated zoomIn record-count card bg-light text-dark"  href="<?php print_link("#") ?>">
                        <div class="row">
                            <div class="col-2">
                                <i class="fa fa-align-justify "></i>
                            </div>
                            <div class="col-10">
                                <div class="flex-column justify-content align-center">
                                    <div class="title">Projects</div>
                                    <small class="">Projects Submitted</small>
                                </div>
                            </div>
                            <h4 class="value"><strong><?php echo $rec_count; ?></strong></h4>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 col-sm-4 comp-grid">
                    <?php $rec_count = $comp_model->getcount_students();  ?>
                    <a class="animated zoomIn record-count card bg-light text-dark"  href="<?php print_link("#") ?>">
                        <div class="row">
                            <div class="col-2">
                                <i class="fa fa-users "></i>
                            </div>
                            <div class="col-10">
                                <div class="flex-column justify-content align-center">
                                    <div class="title">Students</div>
                                    <small class="">Number of Students</small>
                                </div>
                            </div>
                            <h4 class="value"><strong><?php echo $rec_count; ?></strong></h4>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 col-sm-4 comp-grid">
                    <?php $rec_count = $comp_model->getcount_supervisors();  ?>
                    <a class="animated zoomIn record-count card bg-light text-dark"  href="<?php print_link("#") ?>">
                        <div class="row">
                            <div class="col-2">
                                <i class="fa fa-leanpub "></i>
                            </div>
                            <div class="col-10">
                                <div class="flex-column justify-content align-center">
                                    <div class="title">Supervisors</div>
                                    <small class="">Number of supervisors</small>
                                </div>
                            </div>
                            <h4 class="value"><strong><?php echo $rec_count; ?></strong></h4>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
