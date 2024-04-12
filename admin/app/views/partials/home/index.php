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
                    <h4 >Supervisor Dashboard</h4>
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
                    <?php $rec_count = $comp_model->getcount_submittedprojects();  ?>
                    <a class="animated zoomIn record-count alert alert-primary"  href="<?php print_link("projects/") ?>">
                        <div class="row">
                            <div class="col-2">
                                <i class="fa fa-cogs fa-2x"></i>
                            </div>
                            <div class="col-10">
                                <div class="flex-column justify-content align-center">
                                    <div class="title">Submitted Projects</div>
                                    <small class="">Projects submitted by students</small>
                                </div>
                            </div>
                            <h4 class="value"><strong><?php echo $rec_count; ?></strong></h4>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 col-sm-4 comp-grid">
                    <?php $rec_count = $comp_model->getcount_completedprojects();  ?>
                    <a class="animated zoomIn record-count alert alert-success"  href="<?php print_link("#") ?>">
                        <div class="row">
                            <div class="col-2">
                                <i class="fa fa-check-square-o fa-2x"></i>
                            </div>
                            <div class="col-10">
                                <div class="flex-column justify-content align-center">
                                    <div class="title">Completed Projects</div>
                                    <small class="">Projects fully submitted</small>
                                </div>
                            </div>
                            <h4 class="value"><strong><?php echo $rec_count; ?></strong></h4>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 col-sm-4 comp-grid">
                    <?php $rec_count = $comp_model->getcount_pendingprojects();  ?>
                    <a class="animated zoomIn record-count alert alert-warning"  href="<?php print_link("#") ?>">
                        <div class="row">
                            <div class="col-2">
                                <i class="fa fa-folder-open-o fa-2x"></i>
                            </div>
                            <div class="col-10">
                                <div class="flex-column justify-content align-center">
                                    <div class="title">Pending Projects</div>
                                    <small class="">Projects partially submitted</small>
                                </div>
                            </div>
                            <h4 class="value"><strong><?php echo $rec_count; ?></strong></h4>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div  class="p-3 mb-3">
        <div class="container">
            <div class="row ">
                <div class="col-md-12 comp-grid">
                </div>
                <div class="col-md-6 comp-grid">
                    <div class="card card-body">
                        <?php 
                        $chartdata = $comp_model->piechart_reviewstatus();
                        ?>
                        <div>
                            <h4>Review Status</h4>
                            <small class="text-muted"></small>
                        </div>
                        <hr />
                        <canvas id="piechart_reviewstatus"></canvas>
                        <script>
                            $(function (){
                            var chartData = {
                            labels : <?php echo json_encode($chartdata['labels']); ?>,
                            datasets : [
                            {
                            label: 'Reviews',
                            backgroundColor:[
                            <?php 
                            foreach($chartdata['labels'] as $g){
                            echo "'" . random_color(0.9) . "',";
                            }
                            ?>
                            ],
                            borderWidth:3,
                            data : <?php echo json_encode($chartdata['datasets'][0]); ?>,
                            }
                            ]
                            }
                            var ctx = document.getElementById('piechart_reviewstatus');
                            var chart = new Chart(ctx, {
                            type:'pie',
                            data: chartData,
                            options: {
                            responsive: true,
                            scales: {
                            yAxes: [{
                            ticks:{display: false},
                            gridLines:{display: false},
                            scaleLabel: {
                            display: true,
                            labelString: ""
                            }
                            }],
                            xAxes: [{
                            ticks:{display: false},
                            gridLines:{display: false},
                            scaleLabel: {
                            display: true,
                            labelString: ""
                            }
                            }],
                            },
                            }
                            ,
                            })});
                        </script>
                    </div>
                </div>
                <div class="col-md-6 comp-grid">
                    <div class=" ">
                        <?php  
                        $this->render_page("recent_projects/list?limit_count=20"); 
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
