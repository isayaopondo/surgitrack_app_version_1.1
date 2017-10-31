<!-- RIBBON -->
<div id="ribbon">

    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>

    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>Home</li><li>Theatre</li><li>Patients Coding</li>
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
                        <h2>Patient Coding </h2>
                        <div class="widget-toolbar">
                            <!-- add: non-hidden - to disable auto hide -->

                            <div class="btn-group">
                                <button class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-print"></i> Print Operation Logs <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="#" onclick="print_operation_log();">Full List</a>
                                    </li>

                                    <li class="divider"></li>
                                    <li>
                                        <a href="javascript:void(0);"onclick="firm_operation_log_print();">Per Firm</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="surgeon_operation_log_print();">Per Surgeon</a>
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

                            <table id="opcoding_table" class="display projects-table table table-striped table-bordered table-hover" width="100%">
                                <thead>
                                    <tr>
                                        <th style="width:4%"></th>

                                        <th class="hasinput" style="width:10%">
                                            <input type="text" class="form-control" placeholder="Folder" />
                                        </th>
                                        <th class="hasinput" style="width:18%">
                                            <input class="form-control" placeholder="Surname" type="text">

                                        </th>
                                        <th class="hasinput " style="width:4%" >
                                            <input  type="text" class="form-control" placeholder="Age" />
                                        </th>
                                        <th class="hasinput" style="width:7%">
                                            <input type="text" class="form-control" placeholder="Gender" />
                                        </th>

                                        <th class="hasinput icon-addon" >
                                            <input id="dateselect_filter" type="text" placeholder=" Date" class="form-control datepicker" data-dateformat="yy-mm-dd"/>
                                            <label for="dateselect_filter" class="glyphicon glyphicon-calendar no-margin padding-top-15" rel="tooltip" title="" data-original-title="Filter Date"></label>
                                        </th>
                                        <th class="hasinput" style="width:10%">
                                            <input type="text" class="form-control" placeholder="Operation" />
                                        </th>
                                        <th class="hasinput" style="width:20%">
                                            <input type="text" class="form-control" placeholder="Theatre" />
                                        </th>
                                        <th class="hasinput" style="width:10%">
                                            <input type="text" class="form-control" placeholder="Surgeon" />
                                        </th>


                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th>Surname</th>
                                        <th data-class="expand">Folder</th>                                        
                                        <th data-hide="expand">Age</th>
                                        <th data-class="expand">Gender</th>
                                        <th data-hide="expand" >Operation date</th>
                                        <th data-hide="expand">Procedure</th>
                                        <th data-hide="expand" >Theatre</th>
                                        <th data-hide="expand">Surgeon</th>
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

                    <form id="admission-form" method="POST" action="<?= base_url('theatre/add_admission') ?>" class="smart-form" novalidate="novalidate">


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
                                        foreach ($theatre as $row) {
                                            $selected = isset($booking->theatre_id) && $booking->theatre_id == $row->theatre_id ? 'selected="selected"' : '';
                                            echo '<option ' . $selected . ' value="' . $row->theatre_id . '">' . $row->theatre_name . '</option>';
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
                                        foreach ($firms as $row) {
                                            $selected = isset($booking->firm_id) && $booking->firm_id == $row->firm_id ? 'selected="selected"' : '';
                                            echo '<option ' . $selected . ' value="' . $row->firm_id . '">' . $row->firm_name . '</option>';
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

                    <form id="admission-form" method="POST" action="<?= base_url('theatre/edit_post_op') ?>" class="smart-form" novalidate="novalidate">

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
                                    <label>Procedure Done</label>
                                    <label class="input"> <i class="icon-prepend fa fa-clock-o"></i>
                                        <input type="text" name="operation_done" id="operation_done" placeholder="Operation Done"  >
                                    </label>
                                </section>

                                <section class="col col-6">
                                    <label> Lead Surgeon</label>
                                    
                                            <label class="select">
                                                <select name="surgeon_uid" id="surgeon_name" >
                                                     <option value="0" selected="" disabled="">Lead Surgeon</option>
                                                    <?php
                                                    foreach ($leadsurgeon as $row) {
                                                        $selected = (isset($myuserid) && $myuserid == $row->userid ) ||$myuserid  == $row->userid? 'selected="selected"' : '';
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
