<!-- RIBBON -->
<div id="ribbon">

    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>

    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>Home</li><li>Theatre</li><li>Waiting List</li>
    </ol>
    <!-- end breadcrumb -->

    <span class="ribbon-button-alignment pull-right">
        <span id="default_firm" style="font-size:large;  background-color:  <?=$default_firm_color;?>;" class="label " data-title="search"> <i class="fa-grid"></i><?=$default_firm?></span>
    </span>
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



    <!-- widget grid -->
    <section id="widget-grid" class="">
        <!-- START ROW -->

        <div class="row">
            <!-- NEW COL START -->
            <article class="col-sm-12 col-md-12 ">

                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-deletebutton="false"
                     data-widget-fullscreenbutton="false">
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
                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                        <h2>Current Theatre Lists </h2>
                        <div class="widget-toolbar">
                            <!-- add: non-hidden - to disable auto hide -->
                            <div class="btn-group">
                                <button class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-search"></i> Filter By Firms <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <?php
                                        foreach ($department_firms as $key) {
                                            echo "<a href=\"#\" onclick=\"filter_list_firm('theatre','" . $key->firm_id . "');\">" . $key->firm_name . "</a>";
                                        }
                                        ?>
                                    </li>

                                </ul>
                            </div>
                            <div class="btn-group">
                                <button class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-print"></i> Print Theatre List <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="#" onclick="print_theatre_list();">Full List</a>
                                    </li>

                                    <li class="divider"></li>
                                    <li>
                                        <a href="javascript:void(0);"onclick="firm_theatre_list_print();">Per Firm</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="theatre_list_print();">Per Theatre</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </header>

                    <!-- widget div-->
                    <div>

                        <!-- widget edit box -->
                        <div class="jarviswidget-editbox">
                            <!-- This area used as dropdown edit box -->

                        </div>
                        <!-- end widget edit box -->

                        <!-- widget content -->
                        <div class="widget-body no-padding">

                            <table id="theatrelist_table" class="display projects-table table table-striped table-bordered table-hover" width="100%">

                                <thead>
                                    <tr>
                                        <th style="width:4%"></th>
                                        <th class="hasinput" style="width:10%">
                                            <input type="text" class="form-control" placeholder="Folder" />
                                        </th>
                                        <th class="hasinput" style="width:18%">
                                            <input class="form-control" placeholder="Name" type="text">

                                        </th>
                                        <th class="hasinput " style="width:7%" >
                                            <input  type="text" class="form-control" placeholder="Age" />
                                        </th>
                                        <th class="hasinput" style="width:4%">
                                            <input type="text" class="form-control" placeholder="Gender" />
                                        </th>



                                        <th class="hasinput " style="width:10%" >
                                            <input type="text" class="form-control" placeholder="Ward" />
                                        </th>

                                        <th class="hasinput" style="width:10%">
                                            <input type="text" class="form-control" placeholder="Operation" />
                                        </th>
                                        <th class="hasinput icon-addon" >
                                            <input id="dateselect_filter" type="text" placeholder=" Date" class="form-control datepicker" data-dateformat="yy-mm-dd"/>
                                            <label for="dateselect_filter" class="glyphicon glyphicon-calendar no-margin padding-top-15" rel="tooltip" title="" data-original-title="Filter Date"></label>
                                        </th>
                                        <th class="hasinput" style="width:10%">
                                            <input type="text" class="form-control" placeholder="Time" />
                                        </th>
                                        <th class="hasinput" style="width:20%">
                                            <input type="text" class="form-control" placeholder="Theatre" />
                                        </th>
                                        <th class="hasinput" style="width:10%">
                                            <input type="text" class="form-control" placeholder="Firm" />
                                        </th>


                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th data-class="expand">Folder</th> 
                                        <th>Name</th>
                                        <th data-hide="expand">Age(Yrs)</th>                                      
                                        <th data-hide="expand">Gender</th>

                                        <th data-hide="expand">Ward</th>
                                        <th data-hide="expand">Operation</th>
                                        <th data-hide="expand">Surgery date</th>
                                        <th data-hide="expand">Time</th>
                                        <th data-hide="expand">Theatre</th>
                                        <th data-hide="expand">Firm</th>

                                    </tr>
                                </thead>



                            </table>

                        </div>
                        <!-- end widget content -->

                    </div>
                    <!-- end widget div -->

                </div>
                <!-- end widget -->
            </article>
            <!-- END COL -->		

        </div>

        <!-- END ROW -->

    </section>
    <!-- end widget grid -->



</div>
<!-- END MAIN CONTENT -->

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

                    <form id="admission-form" method="POST" action="<?= base_url('index.php/booking/add_admission') ?>" class="smart-form" novalidate="novalidate">


                        <fieldset >
                            <section class="col col-6">
                                <input type="hidden" name="booking_id" id="booking_id" >
                                <label>Date of Admission</label>
                                <label class="input"> <i class="icon-prepend fa fa-calendar"></i>

                                    <input type="text" name="admission_date" placeholder="Date of Admission" class="datepicker" data-dateformat='yy-mm-dd' >
                                </label>
                            </section>


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

                    <form id="admission-form" method="POST" action="<?= base_url('index.php/booking/add_admission') ?>" class="smart-form" novalidate="novalidate">


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
                                            foreach ($leadsurgeon as $row) {
                                                $selected = (isset($myuserid) && $myuserid == $row->userid ) || $myuserid == $row->userid ? 'selected="selected"' : '';
                                                echo '<option ' . $selected . ' value="' . $row->userid . '">' . $row->surgeon . '</option>';
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
                                                foreach ($leadsurgeon as $row) {
                                                    echo '<option  value="' . $row->userid . '">' . $row->surgeon . '</option>';
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
                                        foreach ($leadsurgeon as $row) {
                                            $selected = (isset($myuserid) && $myuserid == $row->userid ) || $myuserid == $row->userid ? 'selected="selected"' : '';
                                            echo '<option ' . $selected . ' value="' . $row->userid . '">' . $row->surgeon . '</option>';
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
                                        foreach ($leadsurgeon as $row) {
                                            $selected = (isset($myuserid) && $myuserid == $row->userid ) || $myuserid == $row->userid ? 'selected="selected"' : '';
                                            echo '<option ' . $selected . ' value="' . $row->userid . '">' . $row->surgeon . '</option>';
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
                                        foreach ($leadsurgeon as $row) {
                                            $selected = (isset($myuserid) && $myuserid == $row->userid ) || $myuserid == $row->userid ? 'selected="selected"' : '';
                                            echo '<option ' . $selected . ' value="' . $row->userid . '">' . $row->surgeon . '</option>';
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
                                        foreach ($theatre as $row) {
                                            $selected = isset($booking->theatre_id) && $booking->theatre_id == $row->theatre_id ? 'selected="selected"' : '';
                                            echo '<option ' . $selected . ' value="' . $row->theatre_id . '">' . $row->theatre_name . '</option>';
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
                                        <select name="firm" id="byfirm">
                                            <option value="0" selected="" disabled="">Firm</option>
                                            <?php
                                            foreach ($firms as $row) {
                                                $selected = isset($booking->firm_id) && $booking->firm_id == $row->firm_id ? 'selected="selected"' : '';
                                                echo '<option ' . $selected . ' value="' . $row->firm_id . '">' . $row->firm_name . '</option>';
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
<!--
<label class="select">
                                        <select name="procedure" id="procedure">
                                            <option value="0" selected="" disabled="">Procedure</option>
<?php
/* foreach ($procedures as $row) {
  $selected = isset($booking_details->procedure_id) && $booking_details->procedure_id == $row->procedure_id ? 'selected="selected"' : '';
  echo '<option ' . $selected . ' value="' . $row->procedure_id . '">' . $row->procedure_name . '</option>';
  } */
?>

                                        </select> <i></i> </label>-->