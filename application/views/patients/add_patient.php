<!-- RIBBON -->
<div id="ribbon">

    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>Home</li>
        <li>Patients</li>
        <li>Add</li>
    </ol>
    <!-- end breadcrumb -->

    <!-- You can also add more buttons to the
    ribbon for further usability

    Example below:
    -->
    <span class="ribbon-button-alignment pull-right">
        <span id="search" class="btn btn-ribbon hidden-xs" data-title="search"><i
                    class="fa fa-table"></i> Change Grid</span>
        <span id="add" class="btn btn-ribbon hidden-xs" data-title="add"><i class="fa fa-plus"></i> Add</span>
        <span id="search" class="btn btn-ribbon" data-title="search"><i class="fa fa-search"></i> <span
                    class="hidden-mobile">Search</span></span>
    </span>

</div>
<!-- END RIBBON -->

<!-- MAIN CONTENT -->
<div id="content">

    <div class="row">
        <!-- NEW WIDGET START -->
        <article class="col-sm-12 col-md-12 col-lg-12">

            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget " id="wid-id-3" data-widget-colorbutton="false" data-widget-editbutton="false"
                 data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false"
                 data-widget-custombutton="false" data-widget-sortable="false">

                <header>
                    <span class="widget-icon"> <i class="fa fa-list-alt"></i> </span>
                    <h2>Patients Details: </h2>
                    <?php
                    if (!empty($patient_details)) {
                        ?>
                        <a href="<?= base_url('patients/patient_page/' . $patient_details->patient_id.'?st='.$st) ?>"
                           style="margin:5px;margin-left:5px;"
                           class="btn  btn-xs btn-danger pull-right text-align-left"><i class="fa fa-arrow-left"></i> Go
                            to Patient's Page</a>
                    <?php } ?>
                    <a href="<?= base_url('patients/lists') ?>" style="margin:5px;margin-left:5px;"
                       class="btn  btn-xs btn-primary pull-right text-align-left"><i class="fa fa-arrow-left"></i> Go to
                        Patients List</a>
                </header>

                <!-- widget div-->


                <!-- widget content -->
                <div class="widget-body">
                    <span class="patients-display"> <h2> <b><?= isset($patient_details->folder_number) ? $patient_details->folder_number . ':' : '' ?></b> <b><?= isset($patient_details->surname) ? $patient_details->surname . ',' : '' ?></b> <?= isset($patient_details->other_names) ? $patient_details->other_names : '' ?>
                            <span class="pull-right"><?= isset($patient_details->phone) ? $patient_details->phone : '' ?></span></h2></span>

                    <hr class="simple">
                    <ul id="myTab1" class="nav nav-tabs bordered">
                        <li class="dropdown pull-left">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"><i
                                        class="fa fa-lg fa-gear"></i> <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="#s3" data-toggle="tab"><i class="fa  fa-link"></i> Go to Patient Page </a>
                                </li>
                                <li>
                                    <a href="#s4" data-toggle="tab"><i class="fa  fa-send-o"></i> Send Notification</a>
                                </li>
                                <li>
                                    <a href="#s4" data-toggle="tab"><i class="fa  fa-remove"></i> Delete Patient</a>
                                </li>

                            </ul>
                        </li>
                        <li class="<?= isset($patient_details->folder_number) ? '' : 'active' ?> ">
                            <a href="#s1" data-toggle="tab"><i class="fa fa-fw fa-lg fa-user"></i> Patient Details</a>
                        </li>
                        <?php if (isset($patient_details->folder_number)) {
                            ?>
                            <li class="<?= isset($patient_details->folder_number) ? 'active' : '' ?> ">
                                <a href="#s2" data-toggle="tab"><i class="fa fa-fw fa-lg fa-clock-o"></i>Add New booking
                                    to Waiting list</a>
                            </li>

                        <?php } ?>

                        <li class="pull-right">
                            <a href="javascript:void(0);">
                                <div class="sparkline txt-color-pinkDark text-align-right" data-sparkline-height="18px"
                                     data-sparkline-width="90px" data-sparkline-barwidth="7">
                                    5,10,6,7,4,3
                                </div>
                            </a>
                        </li>
                    </ul>

                    <div id="myTabContent1" class="tab-content padding-10">
                        <div class="tab-pane fade <?= isset($patient_details->folder_number) ? '' : 'in active' ?>"
                             id="s1">

                            <form id="checkout-form" method="POST"
                                  action="<?= base_url('patients/create_new_patient/' . $patient_id.'/'.$st) ?>"
                                  class="smart-form" novalidate="novalidate">
                                <input type="hidden" name="patient_id" id="patient_id"
                                       value="<?= isset($patient_id) ? $patient_id : '' ?>">
                                <fieldset>
                                    <div class="row">
                                        <section class="col col-4">
                                            <label>Folder Number</label>
                                            <label for="folder_number" class="input">
                                                <input type="text" name="folder_number" id="folder_number"
                                                       placeholder="Folder Number"
                                                       value="<?= isset($patient_details->folder_number) ? $patient_details->folder_number : '' ?>">
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label>Surname</label>
                                            <label class="input"><i class="icon-prepend fa fa-user"></i>
                                                <input type="text" name="surname" placeholder="Surname"
                                                       value="<?= isset($patient_details->surname) ? $patient_details->surname : '' ?>">
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label>First Name(s)</label>
                                            <label class="input"><i class="icon-prepend fa fa-user"></i>
                                                <input type="text" name="other_names" placeholder="Other names"
                                                       value="<?= isset($patient_details->other_names) ? $patient_details->other_names : '' ?>">
                                            </label>
                                        </section>
                                    </div>
                                    <div class="row">
                                        <section class="col col-4">
                                            <label>Gender</label>
                                            <label class="select">
                                                <select name="gender">
                                                    <option value="0" selected="" disabled="">Gender</option>
                                                    <option <?= isset($patient_details->gender) && $patient_details->gender == '1' ? 'selected="selected"' : '' ?>
                                                            value="1">Male
                                                    </option>
                                                    <option <?= isset($patient_details->gender) && $patient_details->gender == '2' ? 'selected="selected"' : '' ?>
                                                            value="2">Female
                                                    </option>
                                                </select> <i></i> </label>
                                        </section>

                                        <section class="col col-4">
                                            <label>Date of Birth (yyyy-mm-dd)</label>
                                            <label class="input"> <i class="icon-prepend fa fa-calendar"></i>
                                                <input type="text" name="dateofbirth" id="dateofbirth"
                                                       class="form-control" placeholder="Date of Birth"
                                                       data-dateformat='yy-mm-dd'
                                                       value="<?= isset($patient_details->dateofbirth) ? $patient_details->dateofbirth : '' ?>">

                                            </label>
                                        </section>


                                        <section class="col col-4">
                                            <label>Phone 1</label>
                                            <label class="input"> <i class="icon-prepend fa fa-phone"></i>
                                                <input type="tel" name="phone" placeholder="Phone"
                                                       data-mask="(999) 999-9999"
                                                       value="<?= isset($patient_details->phone) ? $patient_details->phone : '' ?>">
                                            </label>
                                        </section>
                                    </div>
                                    <div class="row">


                                        <section class="col col-4">
                                            <label>Phone 2</label>
                                            <label class="input"> <i class="icon-prepend fa fa-phone"></i>
                                                <input type="tel" name="phone2" placeholder="Phone"
                                                       data-mask="(999) 999-9999"
                                                       value="<?= isset($patient_details->phone2) ? $patient_details->phone2 : '' ?>">
                                            </label>
                                        </section>
                                        <!--  <section class="col col-4">
                                            <label>Phone 3</label>
                                            <label class="input"> <i class="icon-prepend fa fa-phone"></i>
                                                <input type="tel" name="phone3" placeholder="Phone" data-mask="(999) 999-9999" value="<?php // isset($patient_details->phone3) ? $patient_details->phone3 : ''    ?>">
                                            </label>
                                        </section>
                                        -->

                                        <section class="col col-4">
                                            <label>Post Code</label>
                                            <label class="input"> <i class="icon-prepend fa fa-map-marker"></i>
                                                <input type="text" name="postal_code" id="postal_code"
                                                       placeholder="Post Code" maxlength="5" minlength="4"
                                                       value='<?= isset($patient_details->postal_code) ? $patient_details->postal_code : '' ?>'>
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label>Suburb</label>
                                            <label class="select">
                                                <select name="suburb" id="suburb">
                                                    <?php
                                                    if (isset($patient_details->suburb_name)) {
                                                        echo '<option selected="selected" value="' . $patient_details->suburb_id . ' ">' . $patient_details->suburb_name . ' </option>';
                                                    }
                                                    ?>
                                                </select> <i></i> </label>
                                        </section>
                                    </div>
                                </fieldset>


                                <footer>

                                    <button type="reset" class="btn btn-warning">
                                        Clear
                                    </button>
                                    <button type="submit" class="btn btn-success">
                                        Save and Proceed
                                    </button>
                                    <?php
                                    if (!empty($patient_details)) {
                                        ?>
                                        <a href="<?= base_url('patients/patient_page/' . $patient_details->patient_id) ?>"
                                           class="btn  btn-danger text-align-left"> Close</a>
                                    <?php } else { ?>
                                        <a href="<?= base_url('patients/lists') ?>"
                                           class="btn   btn-danger  text-align-left"><i class="fa fa-arrow-left"></i>
                                            Close</a>
                                    <?php } ?>
                                </footer>
                            </form>
                        </div>
                        <div class="tab-pane fade <?= isset($patient_details->folder_number) ? 'in active' : '' ?>"
                             id="s2">
                            <?php
                            if ($auth_role != 'admin') {
                                ?>
                                <form id="book-form" method="POST" action="<?= base_url('booking/create_booking/') ?>"
                                      class="smart-form">
                                    <div id="infoMessage"><?= $message; ?></div>
                                    <fieldset>
                                        <div class="row">
                                            <section class="col col-3">
                                                <label>Surgery Type</label>
                                                <label class="select">
                                                    <select name="surgery_type" id="surgery_type">
                                                        <option value="" <?= empty($st)? 'selected':'';?>>Unspecified</option>
                                                        <option value="1" <?= $st=="emergency"?'selected':'';?>>Emergency</option>
                                                        <option value="2">Elective</option>
                                                    </select> <i></i> </label>
                                            </section>
                                            <section class="col col-3">
                                                <label>Side</label>
                                                <label class="select">
                                                    <select name="laterality" id="laterality" required="required">
                                                        <option value="None">None</option>
                                                        <option value="Left">Left</option>
                                                        <option value="Right">Right</option>
                                                        <option value="Bilateral">Bilateral</option>
                                                    </select> <i></i> </label>
                                            </section>

                                            <section class="col col-3">
                                                <input type="hidden" name="patient_id" id="patient_id"
                                                       value="<?= $patient_id ?>">
                                                <input type="hidden" name="booking_id" id="booking_id"
                                                       value="<?= isset($booking_details->booking_id) ? $booking_details->booking_id : '' ?>">
                                                <label>Procedure</label>
                                                <label class="select">
                                                    <select name="procedure" id="procedure" required="required">
                                                        <option value="0" selected="" disabled="">Procedure</option>
                                                        <?php
                                                        if (!empty($procedures)) {
                                                            foreach ($procedures as $row) {
                                                                $selected = isset($booking_details->procedure_id) && $booking_details->procedure_id == $row->procedure_id ? 'selected="selected"' : '';
                                                                echo '<option ' . $selected . ' value="' . $row->procedure_id . '">' . $row->procedure_name . '</option>';
                                                            }
                                                        }
                                                        ?>

                                                    </select> <i></i> </label>
                                            </section>
                                            <section class="col col-3">
                                                <label>Category</label>
                                                <label class="select">
                                                    <select name="category" id="category">
                                                        <?php
                                                        if (isset($booking_details->category_id)) {
                                                            echo '<option selected="selected" value="' . $booking_details->category_id . '">' . $booking_details->category_name . '</option>';
                                                        }
                                                        ?>
                                                    </select> <i></i> </label>
                                            </section>





                                        </div>

                                        <div class="row">
                                            <section class="col col-3">
                                                <label>Theatre</label>
                                                <label class="select">
                                                    <select name="theatre">
                                                        <option value="0" selected="" disabled="">Theatre</option>
                                                        <?php
                                                        if (!empty($theatre)) {
                                                            foreach ($theatre as $row) {
                                                                $selected = isset($booking_details->theatre_id) && $booking_details->theatre_id == $row->theatre_id ? 'selected="selected"' : '';
                                                                echo '<option ' . $selected . ' value="' . $row->theatre_id . '">' . $row->theatre_name . '</option>';
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
                                                        if (!empty($firms)) {
                                                            foreach ($firms as $row) {
                                                                $selected = (isset($booking_details->firm_id) && $booking_details->firm_id == $row->firm_id) || $myfirm == $row->firm_id ? 'selected="selected"' : '';
                                                                echo '<option ' . $selected . ' value="' . $row->firm_id . '">' . $row->firm_name . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select> <i></i> </label>
                                            </section>
                                            <section class="col col-3">
                                                <label>Date of Booking</label>
                                                <label class="input"> <i class="icon-prepend fa fa-calendar"></i>
                                                    <input type="text" name="booking_date" required="required"
                                                           placeholder="Date of Booking" class="datepicker"
                                                           data-dateformat='yy-mm-dd'
                                                           value='<?= isset($booking_details->booking_date) ? $booking_details->booking_date : date('Y-m-d') ?>'>
                                                </label>
                                            </section>
                                            <section class="col col-3">
                                                <label>Estimated Duration of Surgery</label>
                                                <label class="select">
                                                    <select name="duration">
                                                        <option value="0" selected="" disabled="">Duration</option>
                                                        <?php
                                                        if (!empty($slots)) {
                                                            foreach ($slots as $row) {
                                                                $selected = isset($booking_details->slot_id) && $booking_details->slot_id == $row->slot_id ? 'selected="selected"' : '';
                                                                echo '<option ' . $selected . ' value="' . $row->slot_id . '">' . $row->slot_name . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select> <i></i> </label>
                                            </section>
                                        </div>

                                        <div class="row">
                                            <section class="col col-3">
                                                <label>ANESTHESIA</label>
                                                <label class="select">
                                                    <select name="anesthesia" id="anesthesia">
                                                        <option value="Local">Local</option>
                                                        <option value="Local with screening">Local with screening
                                                        </option>
                                                        <option value="GA only">GA only</option>
                                                        <option value="GA with screening">GA with screening</option>
                                                        <option value="Spinal">Spinal</option>
                                                    </select> <i></i> </label>
                                            </section>
                                            <section class="col col-3">
                                                <label>POSTOP BED</label>
                                                <label class="select">
                                                    <select name="postopbed" id="postopbed">
                                                        <option value="ward">Ward</option>
                                                        <option value="PACU">PACU</option>
                                                        <option value="ICU">ICU</option>
                                                        <option value="clinic">Clinic</option>
                                                    </select> <i></i> </label>
                                            </section>

                                            <section class="col col-3">
                                                <label>Booked By</label>
                                                <label class="select">
                                                    <select name="booked_by" required="required" id="booked_by">
                                                        <option value="0" selected="" disabled="">Booked By</option>
                                                        <?php
                                                        if (!empty($bookedby)) {
                                                            foreach ($bookedby as $row) {
                                                                $selected = (isset($myuserid) && $myuserid == $row->userid) || $myuserid == $row->userid ? 'selected="selected"' : '';
                                                                echo '<option ' . $selected . ' value="' . $row->userid . '">' . $row->surgeon . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select> <i></i> </label>
                                            </section>
                                            <section class="col col-3" id="wardslist">
                                                <label> Ward/Location</label>
                                                <label class="select">
                                                    <select name="ward">
                                                        <option value="0" selected="" disabled="">Ward/Location</option>
                                                        <?php
                                                        foreach ($wards as $row) {
                                                            $selected = isset($booking->ward_id) && $booking->ward_id == $row->ward_id ? 'selected="selected"' : '';
                                                            echo '<option ' . $selected . ' value="' . $row->ward_id . '">' . $row->ward_name . '</option>';
                                                        }
                                                        ?>
                                                    </select> <i></i> </label>
                                            </section>
                                        </div>

                                        <section>
                                            <label> Indication for Surgery</label>
                                            <label class="textarea">
                                            <textarea rows="3" name="surgery_indication"
                                                      placeholder="Indication for Surgery" class="summernote"><?= isset($booking_details->surgery_indication) ? $booking_details->surgery_indication : '' ?>
                                            </textarea>
                                            </label>
                                        </section>
                                    </fieldset>
                                    <footer>

                                        <button type="reset" class="btn btn-warning">
                                            Clear
                                        </button>
                                        <button type="submit" class="btn btn-success">
                                            Save
                                        </button>
                                        <?php
                                        if (!empty($patient_details)) {
                                            ?>
                                            <a href="<?= base_url('patients/patient_page/' . $patient_details->patient_id) ?>"
                                               class="btn  btn-danger text-align-left"> Close</a>
                                        <?php } else { ?>
                                            <a href="<?= base_url('patients/lists') ?>"
                                               class="btn   btn-danger  text-align-left"><i
                                                        class="fa fa-arrow-left"></i> Close</a>
                                        <?php } ?>
                                    </footer>
                                </form>
                                <br>

                            <?php } else{?>

                                <div class="alert alert-warning fade in">
                                    <button class="close" data-dismiss="alert">
                                        ×
                                    </button>
                                    <i class="fa-fw fa fa-times"></i>
                                    <strong>Warning!:</strong> You have no rights to book an operation? Contact the administrator!
                                </div

                            <?php } ?>

                        </div>
                        <div class="tab-pane fade" id="s6">
                            <form id="admission-form" method="POST" action="<?= base_url('booking/create_booking') ?>"
                                  class="smart-form" novalidate="novalidate">

                                <fieldset>

                                    <section class="col col-6">
                                        <label>Date of Admission</label>
                                        <label class="input"> <i class="icon-prepend fa fa-calendar"></i>
                                            <input type="text" name="admission_date" placeholder="Date of Admission"
                                                   class="datepicker" data-dateformat='yy-mm-dd'>
                                        </label>
                                    </section>


                                    <section class="col col-6">
                                        <label> Admission Notes</label>
                                        <label class="textarea">
                                            <textarea rows="3" name="admission_notes"
                                                      placeholder="admission"></textarea>
                                        </label>
                                    </section>
                                </fieldset>
                                <footer>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                            aria-hidden="true">
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
                        <div class="tab-pane fade" id="s7">
                            <form id="admission-form" method="POST"
                                  action="<?= base_url('booking/create_booking') ?>" class="smart-form"
                                  novalidate="novalidate">

                                <fieldset>
                                    <div class="row">
                                        <section class="col col-6">
                                            <label>Date of Surgery</label>
                                            <label class="input"> <i class="icon-prepend fa fa-calendar"></i>
                                                <input type="text" name="surgery_date" placeholder="Date of Surgery"
                                                       class="datepicker" data-dateformat='yy-mm-dd' value="">
                                            </label>
                                        </section>

                                        <section class="col col-6">
                                            <label>Theatre</label>
                                            <label class="select">
                                                <select name="theatre" disabled="disabled">

                                                </select> <i></i> </label>
                                        </section>
                                    </div>
                                    <section>
                                        <label> Surgery Notes</label>
                                        <label class="textarea">
                                            <textarea rows="3" name="sugery_notes"
                                                      placeholder="Surgery Notes"></textarea>
                                        </label>
                                    </section>

                                </fieldset>
                                <footer>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                            aria-hidden="true">
                                        Close
                                    </button>
                                    <button type="reset" class="btn btn-warning">
                                        Clear
                                    </button>
                                    <button type="submit" class="btn btn-success">
                                        Add to Theatre List
                                    </button>
                                </footer>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="s8"></div>

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
                <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false"
                     data-widget-custombutton="false" data-widget-deletebutton="false"
                     data-widget-fullscreenbutton="false">

                    <header>
                        <span class="widget-icon"> <i class="fa fa-clock-o"></i> </span>
                        <h2>New Admission </h2>

                    </header>
                    <div class="table-responsive">
                        <div id="admissiondetails"></div>
                    </div>

                    <form id="admission-form" method="POST" action="<?= base_url('booking/add_admission') ?>"
                          class="smart-form" novalidate="novalidate">


                        <fieldset>
                            <section class="col col-6">
                                <input type="hidden" name="booking_id" id="booking_id">
                                <label>Date of Admission</label>
                                <label class="input"> <i class="icon-prepend fa fa-calendar"></i>

                                    <input type="text" name="admission_date" placeholder="Date of Admission"
                                           class="datepicker" data-dateformat='yy-mm-dd'>
                                </label>
                            </section>


                            <section class="col col-6">
                                <label> Ward/Location</label>
                                <label class="select">
                                    <select name="ward">
                                        <option value="0" selected="" disabled="">Ward/Location</option>
                                        <?php
                                        if (!empty($wards)) {
                                            foreach ($wards as $row) {
                                                $selected = isset($booking->ward_id) && $booking->ward_id == $row->ward_id ? 'selected="selected"' : '';
                                                echo '<option ' . $selected . ' value="' . $row->ward_id . '">' . $row->ward_name . '</option>';
                                            }
                                        }
                                        ?>
                                    </select> <i></i> </label>
                            </section>
                        </fieldset>
                        <fieldset>
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
                <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false"
                     data-widget-custombutton="false" data-widget-deletebutton="false"
                     data-widget-fullscreenbutton="false">

                    <header>
                        <span class="widget-icon"> <i class="fa fa-clock-o"></i> </span>
                        <h2>New Admission </h2>

                    </header>
                    <div class="table-responsive">
                        <div id="admissiondetails"></div>
                    </div>

                    <form id="admission-form" method="POST"
                          action="<?= base_url('booking/add_theatre_list') ?>" class="smart-form"
                          novalidate="novalidate">

                        <fieldset>
                            <div class="row">
                                <section class="col col-6">
                                    <input type="hidden" name="booking_id" id="booking_id">
                                    <label>Date of Surgery</label>
                                    <label class="input"> <i class="icon-prepend fa fa-calendar"></i>
                                        <input type="text" name="surgery_date" placeholder="Date of Surgery"
                                               class="datepicker" data-dateformat='yy-mm-dd'>
                                    </label>
                                </section>

                                <section class="col col-6">
                                    <label>Theatre</label>
                                    <label class="select">
                                        <select name="theatre" id="theatre" disabled="disabled">

                                        </select> <i></i> </label>
                                </section>
                            </div>
                            <section>
                                <label> Surgery Notes</label>
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
