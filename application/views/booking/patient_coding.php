<!-- RIBBON -->
<div id="ribbon">

    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>Home</li><li>Patient's</li><li>Coding</li>
    </ol>
    <!-- end breadcrumb -->

    <!-- You can also add more buttons to the
    ribbon for further usability

    Example below:
    -->
    <span class="ribbon-button-alignment pull-right">
        <span id="search" class="btn btn-ribbon hidden-xs" data-title="back"><i class="fa fa-backward"></i> <a href="<?= base_url('theatre/op_coding') ?>" >  Back to List</a></span>
        <span id="add" class="btn btn-ribbon hidden-xs" data-title="add"><i class="fa fa-plus"></i> Add</span>
        <span id="search" class="btn btn-ribbon" data-title="search"><i class="fa fa-search"></i> <span class="hidden-mobile">Search</span></span>
    </span> 

</div>
<!-- END RIBBON -->

<!-- MAIN CONTENT -->
<div id="content">

    <div class="row">
        <!-- NEW WIDGET START -->
        <article class="col-sm-12 col-md-12 col-lg-12">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget " id="wid-id-3" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false" data-widget-sortable="false">
                <header>
                    <span class="widget-icon"> <i class="fa fa-list-alt"></i> </span>
                    <h2>Patients Coding: </h2>
                </header>
                <!-- widget div-->
                <div class="widget-body ">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-8">
                            <span class="patients-display"> <h2 > <b><?= isset($patient_details->folder_number) ? $patient_details->folder_number . ':' : '' ?></b> <b><?= isset($patient_details->surname) ? $patient_details->surname . ',' : '' ?></b> <?= isset($patient_details->other_names) ? $patient_details->other_names : '' ?> <span class="pull-right"><?= isset($patient_details->phone) ? $patient_details->phone : '' ?></span></h2></span>
                            <hr class="simple">
                            <?= $patient_booking_details ?>
                            <div id="infoMessage"><?= $message; ?></div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-4">
                            <div class="text-center">
                                <h2 >OPERATION DONE:</h2>  
                                <b><?= isset($patient_details->operation_done) ? $patient_details->operation_done : '' ?> </b>
                                <hr class="simple">
                                <button class="btn btn-block  btn-lg btn-primary" data-toggle="modal" data-target="#myModalAddProcedures">ADD PROCEDURES</button>
                            
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <div id="message"></div>
                        </div>
                    </div>


                </div>
                <!-- end widget div -->
                <!-- widget div-->
                <div class="widget-body ">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-5">
                            <h4> RPL Procedures Done</h4>
                            <hr class="simple">
                            <table id="booking_procedures" class="table table-striped table-bordered" >
                                <thead>
                                    <tr>
                                        <th style="width: 20%">RPL Code</th>
                                        <th style="width: 50%">Procedure</th> 
                                        <th style="width: 15%">Service Fee</th> 
                                        <th></th>
                                    </tr>
                                </thead>

                            </table>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-7">
                            <h4> RPL Consumables <span class="pull-right"><button class="btn btn-success" data-toggle="modal" data-target="#myModalAddOtherConsumables"><i class="fa fa-plus"></i> Add More Consumables</button></span></h4>
                            <hr class="simple">
                            <form id="booking-consumables-form" action="#" class="" novalidate="novalidate">
                                <table id="rpl_nappi_codes" class="table table-striped table-bordered"  >                                    
                                        <?= $procedure_consumable_form ?>                                    
                                </table>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="hidden" class="" id="booking_id" name="booking_id" value="<?= isset($booking_id) ? $booking_id . ':' : '' ?>">

                                            <div class="pull-left">
                                                <button type="button" onclick="view_patients_coding('<?= isset($booking_id) ? $booking_id . ':' : '' ?>')" class="btn btn-danger"><i class="fa fa-file-pdf-o" ></i>  Preview</button>
                                            <button type="reset" class="btn btn-info"><i class="fa fa-send-o" ></i> Submit to Finance</button>
                                            </div>
                                            <div class="pull-right">
                                            <button type="reset" class="btn btn-warning"> Clear</button>
                                            <button type="button" name="save_booking_consumables" id="save_booking_consumables" class="btn btn-primary">
                                              <i class="fa fa-save" ></i>  Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>
                            
                        </div>
                    </div>

                </div>
                <!-- end widget div -->
                <!-- widget div-->


            </div>
            <!-- end widget div -->
    </div>
    <!-- end widget -->
</article>
<!-- WIDGET END -->
</div>


<!-- Modal -->
<div class="modal fade" id="myModalAddProcedures" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title">
                    <img src="<?= base_url() ?>assets/img/logo.png" width="150" alt="SurgiTrack">
                </h4>
            </div>
            <div class="modal-body no-padding">
                <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-deletebutton="false"
                     data-widget-fullscreenbutton="false">

                    <header>
                        <span class="widget-icon"> <i class="fa fa-clock-o"></i> </span>
                        <h2>ADD PROCEDURES </h2>

                    </header>
                    <div class="widget-body">
                        <form id="add_booking_procedures" method="POST" action="#" class="" novalidate="novalidate">
                            <input type="hidden" class="" id="booking_id" name="booking_id" value="<?= isset($booking_id) ? $booking_id . ':' : '' ?>">

                            <fieldset >

                                <div class="form-group">
                                    <label>Procedure</label>
                                    <select name="procedures[]" id="procedures" multiple="" class="select2">
                                        <optgroup label="Add Procedures">
                                            <?php
                                            foreach ($rplprocedures as $row) {
                                                $selected = isset($rpl_procedures->procedure_id) && $rpl_procedures->procedure_id == $row->procedure_id ? 'selected="selected"' : '';
                                                echo '<option ' . $selected . ' value="' . $row->procedure_id . '">' . $row->rpl_code . ' - ' . $row->procedure_name . '</option>';
                                            }
                                            ?>
                                        </optgroup>
                                    </select>  
                                </div>

                            </fieldset>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button class="btn btn-default" type="reset">
                                            Cancel
                                        </button>
                                        <button class="btn btn-primary" id="save_booking_procedure" type="button">
                                            <i class="fa fa-save"></i>
                                            Add Procedures
                                        </button>
                                    </div>
                                </div>
                            </div>


                        </form>
                    </div>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal -->
<div class="modal fade" id="myModalAddOtherConsumables" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title">
                    <img src="<?= base_url() ?>assets/img/logo.png" width="150" alt="SurgiTrack">
                </h4>
            </div>
            <div class="modal-body no-padding">
                <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-deletebutton="false"
                     data-widget-fullscreenbutton="false">

                    <header>
                        <span class="widget-icon"> <i class="fa fa-clock-o"></i> </span>
                        <h2>ADD MORE CONSUMABLES </h2>

                    </header>
                    <div class="widget-body">
                        <form id="add_more_consumables"  action="#" class="" novalidate="novalidate">
                            <input type="hidden" class="" id="booking_id" name="booking_id" value="<?= isset($booking_id) ? $booking_id . ':' : '' ?>">

                            <fieldset >

                                <div class="form-group">
                                    <label>Consumable</label>
                                    <select name="consumables[]" id="consumables" multiple=""  class="select2">
                                                <optgroup label="Consumables">
                                                    <?php
                                                    foreach ($consumables as $row) {
                                                        $selected = isset($rpl_procedures->consumable_id) && $rpl_procedures->consumable_id == $row->consumable_id ? 'selected="selected"' : '';
                                                        echo '<option ' . $selected . ' value="' . $row->consumable_id . '">' . $row->nappi_code . ' ' . $row->product_name . '</option>';
                                                    }
                                                    ?>
                                                </optgroup>
                                            </select>   
                                </div>

                            </fieldset>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button class="btn btn-default" type="reset">
                                            Cancel
                                        </button>
                                        <button class="btn btn-primary" id="save_more_consumable" type="button">
                                            <i class="fa fa-save"></i>
                                            Add Consumable
                                        </button>
                                    </div>
                                </div>
                            </div>


                        </form>
                    </div>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal -->
<div class="modal fade" id="myModalViewPatientsCoding" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title">
                    <img src="<?= base_url() ?>assets/img/logo.png" width="150" alt="SurgiTrack">
                </h4>
            </div>
            <div class="modal-body no-padding">
                <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-deletebutton="false"
                     data-widget-fullscreenbutton="false">


                    <header>
                        <span class="widget-icon"> <i class="fa fa-flask"></i> </span>
                        <h2>Patient's Coding </h2>
                    </header>
                    <form method="POST" action="#" class="smart-form " novalidate="novalidate" >
                        <div class="table-responsive">
                            <div id="patient_opnotes" ></div>
                        </div>
                        <input type="hidden" id="booking_id" name="booking_id" />
                        <footer class="center-block">
                            <button type="button" class="btn btn-danger " data-dismiss="modal">
                                Close
                            </button>
                            <button type="button" id="save_opnotes" class="btn btn-success">
                                <i class="fa fa-save"></i> Save to local 
                            </button>
                            <button type="button" id="send_dropbox"  class="btn btn-info">
                                <i class="fa fa-dropbox"></i> Send to Dropbox
                            </button>
                        </footer>
                    </form>
                </div>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


