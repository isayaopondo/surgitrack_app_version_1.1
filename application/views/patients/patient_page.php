

<!-- RIBBON -->
<div id="ribbon">

    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>Home</li><li>Patients</li><li>Details</li>
    </ol>
    <!-- end breadcrumb -->

    <!-- You can also add more buttons to the
    ribbon for further usability

    Example below:
    -->
    <span class="ribbon-button-alignment pull-right">
        <span id="default_firm" style="font-size:large;  background-color:  <?=$default_firm_color;?>;" class="label " data-title="search"> <i class="fa-grid"></i><?=$default_firm?></span>
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
                    <h2>Patients Details: </h2>
                    <a href="<?= base_url('patients/lists') ?>" style="margin:5px;margin-left:5px;" class="btn  btn-xs btn-primary pull-right text-align-left"><i class="fa fa-arrow-left"></i> Go to Patients List</a>

                </header>

                <!-- widget div-->
                <div class="widget-body ">
                       <input type="hidden" name="folder_number" id="folder_number_patient" value="<?= isset($patient_details->folder_number) ? $patient_details->folder_number : '' ?>">
                        <input type="hidden" name="patient_id" id="patient_id" value="<?= isset($patient_details->patient_id) ? $patient_details->patient_id : '' ?>">
                        <input type="hidden" name="mydepartmentid" id="mydepartmentid" value="<?= isset($mydepartmentid) ? $mydepartmentid : '' ?>">
                        <input type="hidden" name="booking_id"  id="mapt_booking_id" value="<?= isset($booking_id) ? $booking_id : '' ?>">

                        <span class="patients-display"> <h2 > <b><?= isset($patient_details->folder_number) ? $patient_details->folder_number . ':' : '' ?></b> <b><?= isset($patient_details->surname) ? $patient_details->surname . ',' : '' ?></b> <?= isset($patient_details->other_names) ? $patient_details->other_names : '' ?> <span class="pull-right"> <?= isset($patient_details->time_to_hospital) ? ' | <i class="fa fa-car"></i>  '.$patient_details->time_to_hospital : '' ?> </span><span class="pull-right" id="send_generalsms_patient">  <i class="fa fa-envelope"></i> <?= isset($patient_details->phone) ? $patient_details->phone.' ' : '' ?></span> </h2></span>
                        <hr class="simple">
                        <div id="infoMessage"><?= $message; ?></div>
                        <div class="row">
                            <div class="col-md-8">
                                <table class="table">
                                    <tr class="active">
                                        <td>
                                            <b>Gender</b>
                                        </td>

                                        <td>
                                            <b>Date of Birth</b>
                                        </td>
                                        <td>
                                            <b>Age</b>
                                        </td>
                                        <td>
                                            <b>Phone 1</b>
                                        </td>
                                        <td>
                                            <b>Phone 2</b>
                                        </td>
                                        <td>
                                            <b>Post Code</b>
                                        </td>
                                        <td>
                                            <b>Suburb</b>
                                        </td>
                                    </tr>
                                    <tr class="active">
                                        <td>
                                            <?= isset($patient_details->gender) ? ($patient_details->gender == '1' ? 'Male' : ($patient_details->gender == '2' ? 'Female' : '')) : '' ?>
                                        </td>

                                        <td>
                                            <?= isset($patient_details->dateofbirth) ? $patient_details->dateofbirth : '' ?>
                                        </td>
                                        <td>
                                            <?= isset($patient_details->age) ? $patient_details->age : '' ?>
                                        </td>
                                        <td>
                                            <?= isset($patient_details->phone) ? $patient_details->phone : '' ?>
                                        </td>
                                        <td>
                                            <?= isset($patient_details->phone2) ? $patient_details->phone2 : '' ?>
                                        </td>
                                        <td>
                                            <?= isset($patient_details->postal_code) ? $patient_details->postal_code : '' ?>
                                             <?= isset($patient_details->time_to_hospital) ? '<br>('.$patient_details->time_to_hospital.')' : '' ?>
                                        </td>
                                        <td>
                                            <?= isset($patient_details->suburb_name) ? $patient_details->suburb_name : '' ?>
                                            <?= isset($patient_details->distance_km) ? '<br>('.$patient_details->distance_km.')' : '' ?>
                                        </td>
                                    </tr>                           
                                </table>
                            </div>
                            <div class="col-md-2">
                                <?php
                                if ($usergroup == 'doctor'|| $usergroup == 'nurse') {
                                    $booking_link = base_url('patients/add_patient/' . $patient_details->patient_id) . "#s2";
                                    $edit_patient= base_url('patients/add_patient/' . $patient_details->patient_id).'#s1';
                                    $button='success';
                                    $editbutton='warning';
                                }else
                                {
                                    $booking_link ='#';
                                    $edit_patient='#';
                                    $button='default';
                                    $editbutton='default';
                                }

                                ?>
                                <a href="<?= $booking_link ?>"   class="btn btn-md btn-block btn-<?=$button?>  text-align-center">  Add New <br> Booking <br>to waiting List</a>
                            </div>
                            <div class="col-md-2">
                                <a href="<?= base_url('booking/patient_log/' . $patient_details->patient_id) ?>" style="margin-left:5px;margin-right:5px"  class="btn btn-block btn-info btn-xs pull-right text-align-left" data-toggle="tooltip" data-placement="top" data-original-title="View Patient Log"><i class="fa fa-search"></i> View Patient Log</a>
                                <a href="<?= $edit_patient?>" style="margin-right:5px;margin-left:5px" class="btn btn-block btn-<?=$editbutton?>  btn-xs pull-right text-align-left" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil"></i> Edit Patient's Details</a>
                                <button class="btn btn-block btn-xs btn-success pull-right text-align-left" style="margin-left:5px;margin-right:5px" onclick="get_patient_traveldistance('<?= $patient_details->patient_id ?>');"><i class="fa fa-car"></i> Calculate Travel Distance </button>  
                                <button class="btn btn-block btn-xs btn-danger pull-right text-align-left" style="margin-left:5px;margin-right:5px" onclick="delete_patient('<?= $patient_details->patient_id ?>');"><i class="fa fa-trash"></i> Delete Patient</button>  
                            </div>
                        </div>
                    
                </div>

                <!-- widget content -->
                <div class="widget-body">



                    <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-deletebutton="false"
                         data-widget-fullscreenbutton="false">

                        <header>
                            <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                            <h2>BOOKING STATUS</h2>

                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <table id="patientwaitinglist_table" class="projects-table table table-striped table-bordered table-hover" width="100%">
                                    <thead>  
                                        <tr>
                                            <th style="width:5%"></th>
                                            <th style="width:10%" data-hide="expand" >Booking date</th>
                                            <th style="width:25%" data-hide="expand">Procedure</th>

                                            <th  style="width:10%" data-hide="expand">Waiting Time(D)</th>
                                            <th style="width:20%" data-class="expand">Theatre</th>
                                            <th style="width:10%" data-hide="expand">Status</th>
                                            <th style="width:10%" data-hide="expand">Department</th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>
                            <!-- end widget content -->
                        </div>
                        <!-- end widget div -->

                    </div>

                </div>
                <!-- end widget content -->


                <!-- end widget div -->

            </div>
            <!-- end widget -->


        </article>
        <!-- WIDGET END -->
    </div>
</div>
<div class="modal fade" id="myModalTheatre" tabindex="-1" role="dialog">
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
                        <h2>Add to Theatre </h2>

                    </header>
                    <div class="table-responsive">
                        <div id="admissiondetails"></div>
                    </div>

                    <form id="admission-form" method="POST" action="<?= base_url('booking/add_theatre_list') ?>" class="smart-form" novalidate="novalidate">

                        <fieldset>
                            <div class="row">
                                <section class="col col-6">
                                    <input type="hidden" name="booking_id" id="booking_id" >
                                    <label>Date of Surgery</label>
                                    <label class="input"> <i class="icon-prepend fa fa-calendar"></i>
                                        <input type="text" name="surgery_date" id="surgerydate" placeholder="Date of Surgery"  data-dateformat='yy-mm-dd' >
                                    </label>
                                </section>

                                <section class="col col-6">
                                    <label>Theatre</label>
                                    <label class="select">
                                        <select name="theatre" id="theatre" >
                                            <option value="0" selected="" disabled="">Theatre</option>
                                            <?php
                                            if(!empty($theatre)) {
                                                foreach ($theatre as $row) {
                                                    $selected = isset($booking_details) && $booking_details->theatre_id == $row->theatre_id ? 'selected="selected"' : '';
                                                    echo '<option  value="' . $row->theatre_id . '">' . $row->theatre_name . '</option>';
                                                }
                                            }
                                            ?>
                                        </select> <i></i> </label>
                                </section>
                            </div>
                            <section >
                                <label> Comments</label>
                                <label class="textarea"> 										
                                    <textarea rows="3" name="sugery_notes" placeholder="Surgery Notes"></textarea> 
                                </label>
                            </section>

                        </fieldset>

                        <footer>
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

<div class="modal fade" id="myModalFirmAdmissionListPrint" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
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
                        <h2>Admission List Filter(FIRM) </h2>

                    </header>

                    <form id="admission-form" method="POST" action="#" class="smart-form" novalidate="novalidate">


                        <fieldset >

                            <section >
                                <label>Firm</label>
                                <label class="select">
                                    <select name="firm" id="firm">
                                        <option value="0" selected="" disabled="">Firm</option>
                                        <?php
                                        if(!empty($fdepartment_firms)) {
                                            foreach ($fdepartment_firms as $row) {
                                                echo '<option  value="' . $row->firm_id . '">' . $row->firm_name . '</option>';
                                            }
                                        }
                                        ?>
                                    </select> <i></i> </label>
                            </section>

                        </fieldset>

                        <footer>
                            <button type="button" class="btn btn-warning" data-dismiss="modal" aria-hidden="true">
                                Close
                            </button>

                            <button type="button" id="download_firm_admission_list" class="btn btn-danger">
                                <i class="fa fa-download"></i> <i class="fa fa-file-pdf-o"></i> Download
                            </button>
                        </footer>
                    </form>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<div class="modal fade" id="myModalDateAdmissionListPrint" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
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
                        <h2>Admission List Filter(DATE) </h2>

                    </header>

                    <form id="admission-form" method="POST" action="#" class="smart-form" novalidate="novalidate">
                        <fieldset >
                            <section >
                                <label>Admission Date </label>
                                <label class="input"> <i class="icon-prepend fa fa-calendar"></i>
                                    <input type="text" name="admissiondate" id="admissiondate" class="form-control"  placeholder="Date of Admission" data-dateformat='yy-mm-dd' >

                                </label>
                            </section>

                        </fieldset>
                        <footer>
                            <button type="button" class="btn btn-warning" data-dismiss="modal" aria-hidden="true">
                                Close
                            </button>

                            <button type="button" id="download_date_admission_list" class="btn btn-danger">
                                <i class="fa fa-download"></i> <i class="fa fa-file-pdf-o"></i> Download
                            </button>
                        </footer>
                    </form>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="myModalMultiAdmissionListPrint" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
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
                        <h2>Admission List Filters </h2>

                    </header>

                    <form id="admission-form" method="POST" action="#" class="smart-form" novalidate="novalidate">
                        <fieldset >
                            <section >
                                <label>Firm</label>
                                <label class="select">
                                    <select class="select-multiple" name="firm[]" multiple="multiple" id="firm-2">
                                        <?php
                                        if(!empty($department_firms)) {
                                            foreach ($department_firms as $row) {
                                                echo '<option  value="' . $row->firm_id . '">  ' . $row->firm_name . '</option>';
                                            }
                                        }
                                        ?>
                                    </select> <i></i> </label>
                            </section>
                            <!-- <section >
                                <label>Select Firms</label>
                            <?php /*
                              if (!empty($department_firms) && $department_firms != '') {
                              foreach ($department_firms as $row) {
                              echo '
                              <label class="checkbox">
                              <input   name="firms[]" type="checkbox" >
                              <i></i><span>' . $row->firm_name . '  </span>
                              </label>
                              ';
                              }
                              } */
                            ?>
                            </section>-->

                            <section >
                                <label>Admission Date </label>
                                <label class="input"> <i class="icon-prepend fa fa-calendar"></i>
                                    <input type="text" name="admissiondate" id="admission_date" class="form-control"  placeholder="Date of Admission" data-dateformat='yy-mm-dd' value='<?= date('Y-m-d') ?>' >

                                </label>
                            </section>

                        </fieldset>
                        <footer>
                            <button type="button" class="btn btn-warning" data-dismiss="modal" aria-hidden="true">
                                Close
                            </button>

                            <button type="button" id="download_multi_admission_list" class="btn btn-danger">
                                <i class="fa fa-download"></i> <i class="fa fa-file-pdf-o"></i> Download
                            </button>
                        </footer>
                    </form>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<!-- Modal -->
<div class="modal fade" id="myModalRemoveTheatre" tabindex="-1" role="dialog">
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
                        <h2>New Admission </h2>

                    </header>
                    <div class="table-responsive">
                        <div id="admissiondetails"></div>
                    </div>

                    <form id="admission-form" method="POST" action="<?= base_url('booking/add_admission') ?>" class="smart-form" novalidate="novalidate">


                        <fieldset >
                            <section class="col col-6">
                                <input type="hidden" name="booking_id" id="booking_id" >
                                <label>Date </label>
                                <label class="input"> <i class="icon-prepend fa fa-calendar"></i>

                                    <input type="text" name="admission_date" placeholder="Date" class="datepicker" data-dateformat='yy-mm-dd' >
                                </label>
                            </section>


                            <section class="col col-6">
                                <label> Notes</label>
                                <label class="textarea"> 										
                                    <textarea rows="3" name="admission_notes" placeholder="Notes"></textarea> 
                                </label>
                            </section>
                        </fieldset>
                        <footer>
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
<div class="modal fade" id="myModalRecordOps" tabindex="-1" role="dialog">
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
                        <h2>Record Post Ops Results </h2>

                    </header>
                    <div class="table-responsive">
                        <div id="admissiondetails"></div>
                    </div>
                    <form id="admission-form" method="POST" action="<?= base_url('booking/add_post_op') ?>" class="smart-form" novalidate="novalidate">

                        <input type="hidden" name="booking_id" id="booking_id" >
                        <fieldset >
                            <div class="row">
                                <section class="col col-6">
                                    <label>Start Time of Anethesia</label>
                                    <label class="input" > <i class="icon-prepend  fa fa-clock-o"></i>
                                        <input name="anethesia_start" id="anethesia_start" data-format="yy-mm-dd hh:mm:ss" type="text" placeholder="Start Time of Anethesia"></input>
                                        <span class="add-on">
                                            <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                            </i>
                                        </span>
                                    </label>

                                </section>


                                <section class="col col-6">

                                    <label>End Time of Anethesia</label>
                                    <label class="input"> <i class="icon-prepend fa fa-clock-o"></i>
                                        <input type="text" name="anethesia_end" id="anethesia_end" placeholder="End Time of Anethesia" data-format="hh:mm:ss" >
                                    </label>
                                </section>
                            </div>
                            <div class="row">
                                <section class="col col-6">
                                    <label>Start Time of Operation</label>
                                    <label class="input"> <i class="icon-prepend fa fa-clock-o"></i>
                                        <input type="text" name="op_date_start" id="op_date_start" placeholder="Start Time of Operation" >
                                    </label>
                                </section>

                                <section class="col col-6 ">

                                    <label>End Time of Operation</label>
                                    <label class="input"> <i class="icon-prepend fa fa-clock-o"></i>
                                        <input type="text" name="op_date_end" id="op_date_end" placeholder="End Time of Operation"  >
                                    </label>
                                </section>
                            </div>

                            <div class="row">
                                <section class="col col-6">
                                    <label>Operation Done</label>                                    
                                    <label class="input"> <i class="icon-prepend fa fa-scissors"></i>
                                        <input type="text" name="operation_done" id="operation_done" placeholder="Operation Done"  >
                                    </label>

                                </section>

                                <section class="col col-6">
                                    <label> Primary Surgeon</label>

                                    <label class="select">
                                        <select name="surgeon_uid" id="surgeon_name" >
                                            <option value="0" selected="" disabled="">Lead Surgeon</option>
                                            <?php
                                            if(!empty($leadsurgeon)) {
                                                foreach ($leadsurgeon as $row) {
                                                    $selected = (isset($myuserid) && $myuserid == $row->userid) || $myuserid == $row->userid ? 'selected="selected"' : '';
                                                    echo '<option ' . $selected . ' value="' . $row->userid . '">' . $row->surgeon . '</option>';
                                                }
                                            }
                                            ?>
                                        </select> <i></i> </label>

                                </section>

                            </div>
                            <div class="row">
                                <section class="col col-6" >
                                    <label> Surgeon Assistant(s)</label>
                                    <label class="select">
                                        <select class="js-example-theme-multiple" style="width: 100%" name="surgeon_assistant[]" multiple="multiple" id="surgeon_assistant"  >
                                            <optgroup label="Surgeon Assistant">
                                                <?php
                                                if(!empty($leadsurgeon)) {
                                                    foreach ($leadsurgeon as $row) {
                                                        echo '<option  value="' . $row->userid . '">' . $row->surgeon . '</option>';
                                                    }
                                                }
                                                ?>
                                            </optgroup>
                                        </select>
                                    </label>
                                </section>
                                <section class="col col-6">
                                    <label> Supervisor</label>

                                    <label class="select">
                                        <select name="surgeon_supervisor" id="surgeon_supervisor" >
                                            <option value="" selected="selected" >Supervisor</option>
                                            <?php
                                            if(!empty($leadsurgeon)) {
                                                foreach ($leadsurgeon as $row) {
                                                    echo '<option ' . $selected . ' value="' . $row->userid . '">' . $row->surgeon . '</option>';
                                                }
                                            }
                                            ?>
                                        </select> <i></i> </label>

                                </section>
                            </div>
                            <section>
                                <label> Procedure Details</label>
                                <label class="textarea"> 										
                                    <textarea rows="10" name="op_notes" class="summernote" placeholder="Procedure Details"></textarea> 
                                </label>
                            </section>
                        </fieldset>
                        <footer>
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
<div class="modal fade" id="myModalSurgeonAssistants" tabindex="-1" role="dialog">
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
                        <h2>Add Surgeon Assistants</h2>

                    </header>


                    <form id="form-add-surgeon-assistants" method="POST" action="#" class="smart-form" novalidate="novalidate">
                        <div id="surg_message"></div>
                        <input type="hidden" name="booking_id" id="booking_id2" >

                        <fieldset >

                            <section >
                                <label> 1st Assistant</label>

                                <label class="select">
                                    <select name="surgeon_first_assistant" id="first_assistant" >
                                        <option value="" selected="selected" >1st Assistant</option>
                                        <?php
                                        if(!empty($leadsurgeon)) {
                                            foreach ($leadsurgeon as $row) {
                                                $selected = (isset($myuserid) && $myuserid == $row->userid) || $myuserid == $row->userid ? 'selected="selected"' : '';
                                                echo '<option ' . $selected . ' value="' . $row->userid . '">' . $row->surgeon . '</option>';
                                            }
                                        }
                                        ?>
                                    </select> <i></i> </label>

                            </section>
                            <section >
                                <label> 2nd Assistant</label>

                                <label class="select">
                                    <select name="surgeon_second_assistant" id="second_assistant" >
                                        <option value="" selected="selected" >2nd Assistant</option>
                                        <?php
                                        if(!empty($leadsurgeon)) {
                                            foreach ($leadsurgeon as $row) {
                                                $selected = (isset($myuserid) && $myuserid == $row->userid) || $myuserid == $row->userid ? 'selected="selected"' : '';
                                                echo '<option ' . $selected . ' value="' . $row->userid . '">' . $row->surgeon . '</option>';
                                            }
                                        }
                                        ?>
                                    </select> <i></i> </label>

                            </section>
                            <section >
                                <label> 3rd Assistant</label>

                                <label class="select">
                                    <select name="surgeon_third_assistant" id="thirdassistant" >
                                        <option value="" selected="selected" >3rd Assistant</option>
                                        <?php
                                        foreach ($leadsurgeon as $row) {
                                            $selected = (isset($myuserid) && $myuserid == $row->userid ) || $myuserid == $row->userid ? 'selected="selected"' : '';
                                            echo '<option ' . $selected . ' value="' . $row->userid . '">' . $row->surgeon . '</option>';
                                        }
                                        ?>
                                    </select> <i></i> </label>

                            </section>
                            <section >
                                <label> Supervisor</label>

                                <label class="select">
                                    <select name="surgeon_supervisor" id="supervisor" >
                                        <option value="" selected="selected" >Supervisor</option>
                                        <?php
                                        if(!empty($leadsurgeon)) {
                                            foreach ($leadsurgeon as $row) {
                                                $selected = (isset($myuserid) && $myuserid == $row->userid) || $myuserid == $row->userid ? 'selected="selected"' : '';
                                                echo '<option ' . $selected . ' value="' . $row->userid . '">' . $row->surgeon . '</option>';
                                            }
                                        }
                                        ?>
                                    </select> <i></i> </label>

                            </section>



                        </fieldset>
                        <footer>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">
                                Close
                            </button>
                            <button type="reset" class="btn btn-warning">
                                Clear
                            </button>
                            <button type="button" id="add-surgeon-assistants" class="btn btn-success">
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
<div class="modal fade" id="myModalTheatreListPrint" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
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
                        <h2>Theatre List Filter(THEATRE) </h2>

                    </header>

                    <form id="admission-form" method="POST" action="#" class="smart-form" novalidate="novalidate">


                        <fieldset >

                            <section >
                                <label>Date</label>
                                <label class="input"> <i class="icon-prepend fa fa-calendar"></i>
                                    <input type="text" name="op_date_start" id="datepicker2" placeholder="Date" class="datetimepicker" data-dateformat='yy-mm-dd' >
                                </label>
                            </section>


                            <section >
                                <label>Theatre</label>
                                <label class="select">
                                    <select name="theatre" id="theatre">
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
                            <section >
                                <label>Operating Firm</label>
                                <label class="select">
                                    <select name="firm" id="firm">
                                        <option value="0" selected="" disabled="">Firm</option>
                                        <?php
                                        if(!empty($firms)) {
                                            foreach ($firms as $row) {
                                                $selected = isset($booking) && $booking->firm_id == $row->firm_id ? 'selected="selected"' : '';
                                                echo '<option ' . $selected . ' value="' . $row->firm_id . '">' . $row->firm_name . '</option>';
                                            }
                                        }
                                        ?>
                                    </select> <i></i> </label>
                            </section>


                        </fieldset>

                        <footer>
                            <button type="button" class="btn btn-warning" data-dismiss="modal" aria-hidden="true">
                                Close
                            </button>

                            <button type="button" id="download_theatre_list" class="btn btn-danger">
                                <i class="fa fa-download"></i> <i class="fa fa-file-pdf-o"></i> Download
                            </button>
                        </footer>
                    </form>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal -->
<div class="modal fade" id="myModalFirmTheatreListPrint" tabindex="-1" role="dialog">
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
                        <h2>Theatre List Filter(FIRM) </h2>

                    </header>

                    <form id="admission-form" method="POST" action="#" class="smart-form" novalidate="novalidate">


                        <fieldset >
                            <div class="row">
                                <section class="col col-6">
                                    <label>Date</label>
                                    <label class="input"> <i class="icon-prepend fa fa-calendar"></i>
                                        <input type="text" name="op_date_start" id="datepicker" placeholder="Date" class="datetimepicker" data-dateformat='yy-mm-dd' >
                                    </label>
                                </section>


                                <section class="col col-6">
                                    <label>Firm</label>
                                    <label class="select">
                                        <select name="firm" id="firm">
                                            <option value="0" selected="" disabled="">Firm</option>
                                            <?php
                                            if(!empty($firms)) {
                                                foreach ($firms as $row) {
                                                    $selected = isset($booking) && $booking->firm_id == $row->firm_id ? 'selected="selected"' : '';
                                                    echo '<option ' . $selected . ' value="' . $row->firm_id . '">' . $row->firm_name . '</option>';
                                                }
                                            }
                                            ?>
                                        </select> <i></i> </label>
                                </section>
                            </div>

                        </fieldset>

                        <footer>
                            <button type="button" class="btn btn-warning" data-dismiss="modal" aria-hidden="true">
                                Close
                            </button>

                            <button type="button" id="download_firm_list" class="btn btn-danger">
                                <i class="fa fa-download"></i> <i class="fa fa-file-pdf-o"></i> Download
                            </button>
                        </footer>
                    </form>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->





<!-- Modal -->
<div class="modal fade" id="myModalfullCaselogListPrint" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
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
                        <h2>Caselog List Filter (FULL LIST) </h2>

                    </header>

                    <form id="admission-form" method="POST" action="#" class="smart-form" novalidate="novalidate">


                        <fieldset >


                            <section >
                                <label>Theatre</label>
                                <label class="select">
                                    <select name="theatre" id="theatre">
                                        <option value="" selected="" disabled="">Theatre</option>
                                        <option value="0" selected="" >All</option>
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


                        </fieldset>

                        <footer>
                            <button type="button" class="btn btn-warning" data-dismiss="modal" aria-hidden="true">
                                Close
                            </button>

                            <button type="button" id="download_caselog" class="btn btn-danger">
                                <i class="fa fa-download"></i> <i class="fa fa-file-pdf-o"></i> Download
                            </button>
                        </footer>
                    </form>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal -->
<div class="modal fade" id="myModalFirmcaselogListPrint" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
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
                        <h2>Caselog List Filter(FIRM) </h2>

                    </header>

                    <form id="admission-form" method="POST" action="#" class="smart-form" novalidate="novalidate">


                        <fieldset >




                            <section >
                                <label>Firm</label>
                                <label class="select">
                                    <select name="firm" id="firm">
                                        <option value="0" selected="" disabled="">Firm</option>
                                        <?php
                                        if(!empty($firms)) {
                                            foreach ($firms as $row) {
                                                $selected = isset($booking) && $booking->firm_id == $row->firm_id ? 'selected="selected"' : '';
                                                echo '<option ' . $selected . ' value="' . $row->firm_id . '">' . $row->firm_name . '</option>';
                                            }
                                        }
                                        ?>
                                    </select> <i></i> </label>
                            </section>


                        </fieldset>

                        <footer>
                            <button type="button" class="btn btn-warning" data-dismiss="modal" aria-hidden="true">
                                Close
                            </button>

                            <button type="button" id="download_firm_caselog" class="btn btn-danger">
                                <i class="fa fa-download"></i> <i class="fa fa-file-pdf-o"></i> Download
                            </button>
                        </footer>
                    </form>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal -->
<div class="modal fade" id="myModalsurgeonCaselogListPrint" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
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
                        <h2>Caselog List Filter(SURGEON) </h2>

                    </header>

                    <form id="admission-form" method="POST" action="#" class="smart-form" novalidate="novalidate">


                        <fieldset >
                            <section >
                                <label>Firm</label>
                                <label class="select">
                                    <select name="firm" id="firm">
                                        <option value="0" selected="" disabled="">Firm</option>
                                        <?php
                                        if(!empty($firms)) {
                                            foreach ($firms as $row) {
                                                $selected = isset($booking) && $booking->firm_id == $row->firm_id ? 'selected="selected"' : '';
                                                echo '<option ' . $selected . ' value="' . $row->firm_id . '">' . $row->firm_name . '</option>';
                                            }
                                        }
                                        ?>
                                    </select> <i></i> </label>
                            </section>
                            <section >
                                <label>Surgeon</label>
                                <label class="select">
                                    <select name="surgeon" id="surgeon">
                                        <option value="0" selected="" disabled="">Surgeon</option>
                                        <?php
                                        if(!empty($firms)) {
                                            foreach ($firms as $row) {
                                                $selected = isset($booking) && $booking->firm_id == $row->firm_id ? 'selected="selected"' : '';
                                                echo '<option ' . $selected . ' value="' . $row->firm_id . '">' . $row->firm_name . '</option>';
                                            }
                                        }
                                        ?>
                                    </select> <i></i> </label>
                            </section>


                        </fieldset>

                        <footer>
                            <button type="button" class="btn btn-warning" data-dismiss="modal" aria-hidden="true">
                                Close
                            </button>

                            <button type="button" id="download_surgeon_caselog" class="btn btn-danger">
                                <i class="fa fa-download"></i> <i class="fa fa-file-pdf-o"></i> Download
                            </button>
                        </footer>
                    </form>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- Modal -->
<div class="modal fade" id="myModalEditRecordOps" tabindex="-1" role="dialog">
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
                        <h2>Record Post Ops Results </h2>

                    </header>
                    <div class="table-responsive">
                        <div id="admissiondetails"></div>
                    </div>

                    <form id="admission-form" method="POST" action="<?= base_url('booking/edit_post_op') ?>" class="smart-form" novalidate="novalidate">

                        <input type="hidden" name="booking_id" id="booking_id" >
                        <fieldset >

                            <div class="row">
                                <section class="col col-6">
                                    <label>Start Time of Anethesia</label>
                                    <label class="input" > <i class="icon-prepend  fa fa-clock-o"></i>
                                        <input name="anethesia_start" id="anethesia_start" data-format="yy-mm-dd hh:mm:ss" type="text" placeholder="Start Time of Anethesia"></input>
                                        <span class="add-on">
                                            <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                            </i>
                                        </span>
                                    </label>

                                </section>


                                <section class="col col-6">

                                    <label>End Time of Anethesia</label>
                                    <label class="input"> <i class="icon-prepend fa fa-clock-o"></i>
                                        <input type="text" name="anethesia_end" id="anethesia_end" placeholder="End Time of Anethesia" data-format="hh:mm:ss" >
                                    </label>
                                </section>
                            </div>
                            <div class="row">
                                <section class="col col-6">
                                    <label>Start Time of Operation</label>
                                    <label class="input"> <i class="icon-prepend fa fa-clock-o"></i>
                                        <input type="text" name="op_date_start" id="op_date_start" placeholder="Start Time of Operation" >
                                    </label>
                                </section>

                                <section class="col col-6">

                                    <label>End Time of Operation</label>
                                    <label class="input"> <i class="icon-prepend fa fa-clock-o"></i>
                                        <input type="text" name="op_date_end" id="op_date_end" placeholder="End Time of Operation"  >
                                    </label>
                                </section>
                            </div>

                        </fieldset>
                        <fieldset >
                            <div class="row">
                                <section class="col col-6">
                                    <label>Operation Done</label>                                    
                                    <label class="input"> <i class="icon-prepend fa fa-scissors"></i>
                                        <input type="text" name="operation_done" id="operation_done" placeholder="Operation Done"  >
                                    </label>

                                </section>


                                <section class="col col-6">
                                    <label> Primary Surgeon</label>

                                    <label class="select">
                                        <select name="surgeon_uid" id="surgeon_name" >
                                            <option value="0" selected="" disabled="">Lead Surgeon</option>
                                            <?php
                                            if(!empty($leadsurgeon)) {
                                                foreach ($leadsurgeon as $row) {
                                                    $selected = (isset($myuserid) && $myuserid == $row->userid) || $myuserid == $row->userid ? 'selected="selected"' : '';
                                                    echo '<option ' . $selected . ' value="' . $row->userid . '">' . $row->surgeon . '</option>';
                                                }
                                            }
                                            ?>
                                        </select> <i></i> </label>

                                </section>
                            </div>
                            <div class="row">
                                <section class="col col-6" >
                                    <label> Surgeon Assistant(s)</label>

                                    <label class="select">
                                        <select name="surgeon_assistant[]" multiple="" style="width: 100%" id="surgeon_assistant" class="js-example-theme-multiple" >
                                            <optgroup label="Surgeon Assistant">
                                                <?php
                                                if(!empty($leadsurgeon)) {
                                                    foreach ($leadsurgeon as $row) {
                                                        echo '<option  value="' . $row->userid . '">' . $row->surgeon . '</option>';
                                                    }
                                                }
                                                ?>
                                            </optgroup>
                                        </select> <i></i> </label>

                                </section>
                                <section class="col col-6">
                                    <label> Supervisor</label>

                                    <label class="select">
                                        <select name="surgeon_supervisor" id="surgeon_supervisor" >
                                            <option value="" selected="selected" >Supervisor</option>
                                            <?php
                                            foreach ($leadsurgeon as $row) {
                                                echo '<option ' . $selected . ' value="' . $row->userid . '">' . $row->surgeon . '</option>';
                                            }
                                            ?>
                                        </select> <i></i> </label>

                                </section>
                            </div>
                            <section>
                                <label> Procedure Details</label>
                                <label class="textarea"> 										
                                    <textarea rows="10" name="op_notes" id="op_notes" class="summernote" placeholder="Procedure Details"></textarea> 
                                </label>
                            </section>
                        </fieldset>
                        <footer>
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
<div class="modal fade" id="myModalAdmission" tabindex="-1" role="dialog">
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
                        <h2>New Admission </h2>

                    </header>
                    <div class="table-responsive">
                        <div id="admissiondetails"></div>
                    </div>

                    <form id="admission-form" method="POST" action="<?= base_url('booking/add_admission') ?>" class="smart-form" novalidate="novalidate">



                        <fieldset >
                            <section class="col col-6">
                                <input type="hidden" name="booking_id" id="booking_id" >
                                <label>Date of Admission</label>
                                <label class="input"> <i class="icon-prepend fa fa-calendar"></i>

                                    <input type="text" name="admission_date" placeholder="Date of Admission" class="datepicker" data-dateformat='yy-mm-dd' >
                                </label>
                            </section>


                            <section class="col col-6">
                                <label> Ward/Location</label>
                                <label class="select">
                                    <select name="ward">
                                        <option value="0" selected="" disabled="">Ward/Location</option>
                                        <?php
                                        if(!empty($wards)) {
                                            foreach ($wards as $row) {
                                                $selected = isset($booking) && $booking->ward_id == $row->ward_id ? 'selected="selected"' : '';
                                                echo '<option ' . $selected . ' value="' . $row->ward_id . '">' . $row->ward_name . '</option>';
                                            }
                                        }
                                        ?>
                                    </select> <i></i> </label>
                            </section>
                        </fieldset>
                        <fieldset >
                            <section class="col col-6">
                                <label> Admission Notes</label>
                                <label class="textarea"> 										
                                    <textarea rows="3" name="admission_notes" placeholder="admission"></textarea> 
                                </label>
                            </section>
                        </fieldset>
                        <footer>
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
<div class="modal fade" id="myModalTheatreWaitingListPrint" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
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
                        <h2>Waiting List Filter (THEATRE) </h2>

                    </header>

                    <form id="admission-form" method="POST" action="#" class="smart-form" novalidate="novalidate">


                        <fieldset >

                            <section >
                                <label>Theatre</label>
                                <label class="select">
                                    <select name="theatre" id="theatre">
                                        <option value="0" selected="" disabled="">Theatre</option>
                                        <?php
                                        if(!empty($theatre)) {
                                            foreach ($theatre as $row) {
                                                $selected = isset($booking->theatre_id) && $booking->theatre_id == $row->theatre_id ? 'selected="selected"' : '';
                                                echo '<option ' . $selected . ' value="' . $row->theatre_id . '">' . $row->theatre_name . '</option>';
                                            }
                                        }
                                        ?>
                                    </select> <i></i> </label>
                            </section>

                        </fieldset>

                        <footer>
                            <button type="button" class="btn btn-warning" data-dismiss="modal" aria-hidden="true">
                                Close
                            </button>

                            <button type="button" id="download_theatre_waiting_list" class="btn btn-danger">
                                <i class="fa fa-download"></i> <i class="fa fa-file-pdf-o"></i> Download
                            </button>
                        </footer>
                    </form>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal -->
<div class="modal fade" id="myModalProcedureWaitingListPrint" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
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
                        <h2>Waiting List Filter(Procedure) </h2>

                    </header>

                    <form id="admission-form" method="POST" action="#" class="smart-form" novalidate="novalidate">


                        <fieldset >
                            <section >
                                <label>Procedure</label>
                                <label class="select">
                                    <select name="procedure" id="procedure">
                                        <option value="0" selected="" disabled="">Procedure</option>
                                        <?php
                                        if(!empty($procedures)) {
                                            foreach ($procedures as $row) {
                                                $selected = isset($booking_details->procedure_id) && $booking_details->procedure_id == $row->procedure_id ? 'selected="selected"' : '';
                                                echo '<option ' . $selected . ' value="' . $row->procedure_id . '">' . $row->procedure_name . '</option>';
                                            }
                                        }
                                        ?>
                                    </select> <i></i> </label>
                            </section>

                        </fieldset>

                        <footer>
                            <button type="button" class="btn btn-warning" data-dismiss="modal" aria-hidden="true">
                                Close
                            </button>

                            <button type="button" id="download_procedure_waiting_list" class="btn btn-danger">
                                <i class="fa fa-download"></i> <i class="fa fa-file-pdf-o"></i> Download
                            </button>
                        </footer>
                    </form>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="myModalFirmWaitingListPrint" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
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
                        <h2>Waiting List Filter(FIRM) </h2>

                    </header>

                    <form id="admission-form" method="POST" action="#" class="smart-form" novalidate="novalidate">


                        <fieldset >

                            <section >
                                <label>Firm</label>
                                <label class="select">
                                    <select name="firm" id="firm">
                                        <option value="0" selected="" disabled="">Firm</option>
                                        <?php
                                        foreach ($firms as $row) {
                                            $selected = isset($booking->firm_id) && $booking->firm_id == $row->firm_id ? 'selected="selected"' : '';
                                            echo '<option ' . $selected . ' value="' . $row->firm_id . '">' . $row->firm_name . '</option>';
                                        }
                                        ?>
                                    </select> <i></i> </label>
                            </section>

                        </fieldset>

                        <footer>
                            <button type="button" class="btn btn-warning" data-dismiss="modal" aria-hidden="true">
                                Close
                            </button>

                            <button type="button" id="download_firm_waiting_list" class="btn btn-danger">
                                <i class="fa fa-download"></i> <i class="fa fa-file-pdf-o"></i> Download
                            </button>
                        </footer>
                    </form>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- Modal -->
<div class="modal fade" id="myModalSendGeneralSMS" tabindex="-1" role="dialog">
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
                        <h2>Send General Message (SMS) </h2>
                    </header>

                    <div class="table-responsive">
                        <form id="sendgeneralsms"  action="#" class="smart-form" novalidate="novalidate">
                            <div id="alertMessage">
                                <div  class="alert alert-block alert-success">
                                    <a class="close" data-dismiss="alert" href="#">×</a>
                                    <div id="message"></div>
                                </div>
                            </div>
                            <div id="patient_details"></div>
                            <fieldset>
                                <section>
                                    <label class="label">SMS Text</label>
                                    <label class="textarea textarea-resizable textarea-expandable"> 										
                                        <textarea name="sms_message" maxlength="160" rows="4" class="summernote">                            
                                        </textarea> 
                                    </label>
                                    <div class="note">
                                        <strong>Note:</strong> expands on focus.
                                    </div>
                                </section>
                            </fieldset>
                            <footer>
                                <button type="button" class="btn btn-warning" data-dismiss="modal">
                                    Cancel
                                </button>
                                <button type="button" id="send_sms_general" class="btn btn-success">
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
