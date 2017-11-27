<!-- RIBBON -->
<div id="ribbon">

    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>

    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>Home</li><li>Theatre</li><li>Patient Log</li>
    </ol>
    <!-- end breadcrumb -->

    <!-- You can also add more buttons to the
    ribbon for further usability

    Example below:

    <span class="ribbon-button-alignment pull-right">
    <span id="search" class="btn btn-ribbon hidden-xs" data-title="search"><i class="fa-grid"></i> Change Grid</span>
    <span id="add" class="btn btn-ribbon hidden-xs" data-title="add"><i class="fa-plus"></i> Add</span>
    <span id="search" class="btn btn-ribbon" data-title="search"><i class="fa-search"></i> <span class="hidden-mobile">Search</span></span>
    </span> -->

</div>
<!-- END RIBBON -->



<!-- MAIN CONTENT -->
<div id="content">

    <div class="row">
        <!-- NEW WIDGET START -->
        <article class="col-sm-12 col-md-12 col-lg-12">

            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget " id="wid-id-3" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false" data-widget-sortable="false">
                <!-- widget options:
                usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

                data-widget-colorbutton="false"
                data-widget-editbutton="false"
                data-widget-togglebutton="false"
                data-widget-deletebutton="false"
                data-widget-fullscreenbutton="false"
                data-widget-custombutton="false"
                data-widget-collapsed="true"
                data-widget-sortable="false"

                -->
                <header>
                    <span class="widget-icon"> <i class="fa fa-list-alt"></i> </span>
                    <h2> <b><?= isset($patient_details->folder_number) ? $patient_details->folder_number.':' : '' ?></b> <b><?= isset($patient_details->surname) ? $patient_details->surname.',' : '' ?></b> <?= isset($patient_details->other_names) ? $patient_details->other_names : '' ?> </h2>
                    <a href="<?= base_url('patients/patient_page/' . $patient_details->patient_id) ?>" style="margin:5px;margin-left:5px;" class="btn  btn-xs btn-danger pull-right text-align-left"><i class="fa fa-arrow-left"></i> Go to Patient's Page</a>
                </header>

                <!-- widget div-->


                <!-- widget content -->
                <div class="widget-body">

                    <!-- widget grid -->
                    <section id="widget-grid" class="">
                        <!-- START ROW -->

                        <div class="row">

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                                <div class="well well-sm">

                                    <div class="activity-stream">
                                        
                                        <?php
                                        foreach($logs as $log){
                                            if($log->log_type =='user_comment'){
                                                $logtype= 'Comments';
                                                $bg='bg-primary';
                                            }
                                            elseif($log->log_type =='user_action'){
                                                $logtype= 'User Action';
                                                $bg='bg-warning';
                                            }
                                            echo '<div class="stream">
                                            <div class="stream-badge">
                                                <i class="fa fa-circle '.$bg.'"></i>
                                            </div>
                                            <div class="stream-panel">
                                                <div class="stream-info">
                                                    <a href="#">
                                                        <span><b>'.$logtype.': </b> <b>'.$log->action.'</b></span>
                                                        <span class="date">'.$log->logtime.'</span>
                                                    </a>
                                                </div>
                                                 '.$log->logdetails.'.
                                                    <br><a href="#"><span>'.$log->user_name.'</span></a>
                                            </div>
                                        </div>';
                                        }
                                        ?>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </article>
    </div>
