<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
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
                        <span class="widget-icon"> <i class="fa fa-clock-o"></i> </span>
                        <h2>New Booking </h2>

                    </header>

                    <form id="checkout-form" method="POST" action="<?= base_url('theatre/create_booking') ?>" class="smart-form" novalidate="novalidate">
                        <div class="well">
                            <fieldset >
                                <div class="row">
                                    <section class="col col-4">
                                        <label>Folder Number</label>
                                        <label for="folder_number" class="input">
                                            <input type="text" name="folder_number" id="folder_number" placeholder="Folder Number">
                                            <input type="hidden" name="patient_id" id="patient_id"  >
                                        </label>
                                    </section>
                                    <section class="col col-4">
                                        <label>Surname</label>
                                        <label class="input"><i class="icon-prepend fa fa-user"></i>
                                            <input type="text" name="surname" id="surname" placeholder="Surname">
                                        </label>
                                    </section>
                                    <section class="col col-4">
                                        <label>Other names</label>
                                        <label class="input"><i class="icon-prepend fa fa-user"></i>
                                            <input type="text" name="other_names" id="other_names" placeholder="Other names">
                                        </label>
                                    </section>
                                </div>
                            </fieldset>
                        </div>
                        <fieldset id="existingpatient">
                            <section class="well">
                                <div id="patientdetails">
                                </div> 
                            </section>

                            <section > <h2> New Booking Details</h2></section>

                            <div class="row">
                                <section class="col col-3">
                                    <label>Type of Booking</label>
                                    <label class="select">
                                        <select name="booking_status" id="booking_status">
                                            <option value="0" selected="" >Waiting List</option>
                                            <option value="1"  >Admission List</option>
                                            <option value="2"  >Theatre List</option>
                                        </select> <i></i> </label>
                                </section>
                                <section class="col col-3">
                                    <label>Side</label>
                                    <label class="select">
                                        <select name="laterality" id="laterality" required="required" >
                                            <option value="None">None</option>
                                            <option value="Left">Left</option>
                                            <option value="Right">Right</option>
                                            <option value="Bilateral">Bilateral</option>
                                        </select> <i></i> </label>
                                </section>
                                <section class="col col-3">
                                    <label>Procedure</label>
                                    <label class="select">
                                        <select name="procedure" id="procedure">
                                            <option value="0" selected="" disabled="">Procedure</option>
                                            <?php
                                            if(!empty($procedures)) {
                                                foreach ($procedures as $row) {
                                                    $selected = isset($procedures) && $procedures->procedure_id == $row->procedure_id ? 'selected="selected"' : '';
                                                    echo '<option ' . $selected . ' value="' . $row->procedure_id . '">' . $row->procedure_name . '</option>';
                                                }
                                            }
                                            ?>

                                        </select> <i></i> </label>
                                </section>
                                <section class="col col-3">
                                    <label>Category</label>
                                    <label class="select">
                                        <select name="category" id="category" disabled="disabled">

                                        </select> <i></i> </label>
                                </section>
                            </div>
                            <div class="row"> 

                                <section class="col col-3">
                                    <label>ANESTHESIA</label>
                                    <label class="select">
                                        <select name="anesthesia" id="anesthesia" >
                                            <option value="Local">Local</option>
                                            <option value="Local with screening">Local with screening</option>
                                            <option value="GA only">GA only</option>
                                            <option value="GA with screening">GA with screening</option>
                                            <option value="Spinal">Spinal</option>
                                        </select> <i></i> </label>
                                </section>
                                <section class="col col-3">
                                    <label>POSTOP BED</label>
                                    <label class="select">
                                        <select name="postopbed" id="postopbed" >
                                            <option value="ward">Ward</option>
                                            <option value="PACU">PACU</option>
                                            <option value="ICU">ICU</option>
                                            <option value="clinic">Clinic</option>
                                        </select> <i></i> </label>
                                </section>
                                <section class="col col-3">
                                    <label>Theatre</label>
                                    <label class="select">
                                        <select name="theatre">
                                            <option value="0" selected="" disabled="">Theatre</option>
                                            <?php
                                            if(!empty($theatre)) {
                                            foreach ($theatre as $row) {
                                                $selected = isset($booking) && $booking->theatre_id == $row->theatre_id ? 'selected="selected"' : '';
                                                echo '<option ' . $selected . ' value="' . $row->theatre_id . '">' . $row->theatre_name . '</option>';
                                            }
                                            }
                                            ?>
                                        </select> <i></i> </label>
                                </section>
                                <section class="col col-3">
                                    <label> Ward/Location</label>
                                    <label class="select">
                                        <select name="ward">
                                            <option value="0" selected="" disabled="">Ward/Location</option>
                                            <?php
                                            if(!empty($wards)) {
                                                foreach ($wards as $row) {
                                                    $selected = isset($booking->ward_id) && $booking->ward_id == $row->ward_id ? 'selected="selected"' : '';
                                                    echo '<option ' . $selected . ' value="' . $row->ward_id . '">' . $row->ward_name . '</option>';
                                                }
                                            }
                                            ?>
                                        </select> <i></i> </label>
                                </section>

                            </div>
                            <div class="row"> 
                                <section class="col col-3">
                                    <label>Priority</label>
                                    <label class="select">
                                        <select name="priority">
                                            <option value="0" selected="" disabled="">Priority</option>
                                            <?php
                                            if(!empty($priorities)) {
                                                foreach ($priorities as $row) {
                                                    $selected = isset($priorities) && $priorities->priority_id == $row->priority_id ? 'selected="selected"' : ($row->priority_id == '1' ? 'selected="selected"' : '');
                                                    echo '<option ' . $selected . ' value="' . $row->priority_id . '">' . $row->priority_name . '</option>';
                                                }
                                            }
                                            ?>
                                        </select> <i></i> </label>
                                </section>
                                <section class="col col-3">
                                    <label>Firm</label>
                                    <label class="select">
                                                <select name="firm" id="booking_firm">
                                                    <option value="0" selected="" disabled="">Firm</option>
                                                    <?php
                                                    if(!empty($firms)){
                                                        foreach ($firms as $row) {
                                                            $selected = (isset($booking_details) && $booking_details->firm_id == $row->firm_id) || $myfirm == $row->firm_id ? 'selected="selected"' : '';
                                                            echo '<option ' . $selected . ' value="' . $row->firm_id . '">' . $row->firm_name . '</option>';
                                                        }
                                                    }

                                                    ?>
                                                </select> <i></i> </label>
                                </section>
                                <section class="col col-3">
                                    <label>Estimated Duration of Surgery</label>
                                    <label class="select">
                                        <select name="duration">
                                            <option value="0" selected="" disabled="">Duration</option>
                                            <?php
                                            if(!empty($slots)) {
                                                foreach ($slots as $row) {
                                                    $selected = isset($booking_details) && $booking_details->slot_id == $row->slot_id ? 'selected="selected"' : '';
                                                    echo '<option ' . $selected . ' value="' . $row->slot_id . '">' . $row->slot_name . '</option>';
                                                }
                                            }
                                            ?>
                                        </select> <i></i> </label>
                                </section>
                                <section class="col col-3">
                                    <label>Booked By</label>
                                    <label class="select">
                                        <select name="booked_by" required="required" id="booked_by" >
                                            <option value="0" selected="" disabled="">Booked By</option>
                                            <?php
                                            if(!empty($bookedby)) {
                                                foreach ($bookedby as $row) {
                                                    $selected = (isset($myuserid) && $myuserid == $row->userid) || $myuserid == $row->userid ? 'selected="selected"' : '';
                                                    echo '<option ' . $selected . ' value="' . $row->userid . '">' . $row->surgeon . '</option>';
                                                }
                                            }
                                            ?>
                                        </select> <i></i> </label>
                                </section>
                            </div>
                            <div class="row">                                
                                <section class="col col-3">
                                    <label>Date of Booking</label>
                                    <label class="input"> <i class="icon-prepend fa fa-calendar"></i>
                                        <input type="text" name="booking_date" placeholder="Date of Booking" class="datepicker" data-dateformat='yy-mm-dd' value='<?= date('Y-m-d') ?>'>
                                    </label>
                                </section>
                                <section class="col col-3" id="toadmissionlist">
                                    <label>Date of Admission</label>
                                    <label class="input"> <i class="icon-prepend fa fa-calendar"></i>
                                        <input type="text" name="admission_date" id="admission_date" placeholder="Date of Admission" class="datepicker" data-dateformat='yy-mm-dd' >
                                    </label>
                                </section>
                                <section class="col col-3" id="totheatrelist">
                                    <label>Date of Surgery</label>
                                    <label class="input"> <i class="icon-prepend fa fa-calendar"></i>
                                        <input type="text" name="surgery_date" id="surgerydate" placeholder="Date of Surgery"  data-dateformat='yy-mm-dd' >
                                    </label>
                                </section>
                            </div>

                            <section>
                                <label> Indication for Surgery</label>
                                <label class="textarea"> 										
                                    <textarea rows="3" name="surgery_indication" placeholder="Indication for Surgery"></textarea> 
                                </label>
                            </section>

                        </fieldset>


                        <footer id="existingpatient2">
                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">
                                Close
                            </button>
                            <button type="reset" class="btn btn-warning">
                                Clear
                            </button>
                            <button type="submit" class="btn btn-success">
                                Save
                            </button>
                        </footer>
                    </form>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal -->
<div class="modal fade" id="myModalMAPT" tabindex="-1" role="dialog">
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
                    <header >
                        <span class="widget-icon"> <i class="fa fa-clock-o"></i> </span>
                        <h2>Patient's MAPT </h2>
                    </header>

                    <div class="table-responsive">
                        <form id="fill-mapt-form" method="POST" action="#" class="smart-form" novalidate="novalidate">
                            <div id="alertMessage">
                                <div  class="alert alert-block alert-success">
                                    <a class="close" data-dismiss="alert" href="#">×</a>
                                    <div id="message"></div>
                                </div>
                            </div>
                            <div id="admissiondetails"></div>
                            <footer>
                                <button type="button" class="btn btn-warning" data-dismiss="modal">
                                    Cancel
                                </button>
                                <button type="button" id="savebookingmapt" class="btn btn-success">
                                    Save MAPT
                                </button>
                            </footer>
                        </form>
                    </div>


                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal -->
<div class="modal fade" id="myModalViewMAPT" tabindex="-1" role="dialog">
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
                        <span class="widget-icon"> <i class="fa fa-clock-o"></i> </span>
                        <h2>Patient's MAPT(s) </h2>
                    </header>
                    <div class="table-responsive">
                        <div id="patient_mapt" ></div>
                    </div>
                </div>

            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- Modal -->
<div class="modal fade" id="myModalViewOpNotes" tabindex="-1" role="dialog">
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
                        <span class="widget-icon"> <i class="fa fa-clock-o"></i> </span>
                        <h2>Patient's Op Notes </h2>
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



<!-- Modal -->
<div class="modal fade" id="myModalAdmissionSMS" tabindex="-1" role="dialog">
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
                    <header >
                        <span class="widget-icon"> <i class="fa fa-clock-o"></i> </span>
                        <h2>Send Admission Notification SMS </h2>
                    </header>

                    <div class="table-responsive">
                        <form id="send-admission-sms" method="POST" action="#" class="smart-form" novalidate="novalidate">
                            <div id="alertMessage">
                                <div  class="alert alert-block alert-success">
                                    <a class="close" data-dismiss="alert" href="#">×</a>
                                    <div id="message"></div>
                                </div>
                            </div>
                            <div id="admissiondetails"></div>

                            <footer>
                                <button type="button" class="btn btn-warning" data-dismiss="modal">
                                    Cancel
                                </button>
                                <button type="button" id="sendadmissionsms" class="btn btn-success">
                                    Send SMS
                                </button>
                            </footer>
                        </form>
                    </div>


                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal -->
<div class="modal fade" id="myModalComments" tabindex="-1" role="dialog">
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
                    <header >
                        <span class="widget-icon"> <i class="fa fa-clock-o"></i> </span>
                        <h2>Add Comments </h2>
                    </header>

                    <div class="table-responsive">
                        <form id="fill-comments" method="POST" action="#" class="smart-form" novalidate="novalidate">

                            <div id="admissiondetails"></div>
                            <fieldset>
                                <input type="hidden" id="booking_id" name="booking_id" />
                                <section>
                                    <label class="label">Comment</label>
                                    <label class="textarea textarea-resizable textarea-expandable "> 										
                                        <textarea name="comment" id="comment" maxlength="160" rows="4" class="summernote">
                            
                                        </textarea> 
                                    </label>
                                    <div class="note">
                                        <strong>Note:</strong> the comments will be timestamped @ <?= date('d-m-Y H:i:s') ?>
                                    </div>
                                </section>
                            </fieldset>
                            <div id="comment_alertMessage">
                                <div  class="alert alert-block alert-success  ">
                                    <a class="close" data-dismiss="alert" href="#">×</a>
                                    <div id="comment_message"></div>
                                </div>
                            </div>
                            <footer>
                                <button type="button" class="btn btn-warning" data-dismiss="modal">
                                    Cancel
                                </button>
                                <button type="button" id="save_comment" class="btn btn-success">
                                    Save Comment
                                </button>
                            </footer>
                        </form>
                    </div>


                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal -->
<div class="modal fade" id="myModalConsumables" tabindex="-1" role="dialog">
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
                    <header >
                        <span class="widget-icon"> <i class="fa fa-clock-o"></i> </span>
                        <h2>Add Consumables </h2>
                    </header>

                    <div class="table-responsive">
                        <form id="fill-comments" method="POST" action="#" class="smart-form" novalidate="novalidate">

                            <div id="admissiondetails"></div>

                            <fieldset>
                                <legend>Add Consumables</legend>
                                <input type="hidden" id="booking_id" name="booking_id" />

                                <div class="row">
                                    <section class="col col-7">
                                        <div id="procedure_template"></div>
                                        <fieldset>
                                            <legend>Add More</legend>
                                            <br>
                                            <div id="education_fields">
                                            </div>
                                            <div >
                                                <button class="btn btn-md btn-block btn-success " type="button" id="addconsumable" ><i class="fa fa-plus-square-o "></i> Add Consumable</button>
                                            </div>

                                            <div class="note">
                                                <strong>Note:</strong> Add Consumables used for this booking @ <?= date('d-m-Y H:i:s') ?>
                                            </div>
                                        </fieldset>
                                    </section>
                                    <section class="col col-5">

                                    </section>
                                </div>

                            </fieldset>
                            <div id="consumables_alertMessage">
                                <div  class="alert alert-block alert-success  ">
                                    <a class="close" data-dismiss="alert" href="#">×</a>
                                    <div id="comment_message"></div>
                                </div>
                            </div>
                            <footer>
                                <button type="button" class="btn btn-warning" data-dismiss="modal">
                                    Cancel
                                </button>
                                <button type="button" id="save_comment" class="btn btn-success">
                                    Save 
                                </button>
                            </footer>
                        </form>
                    </div>


                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->