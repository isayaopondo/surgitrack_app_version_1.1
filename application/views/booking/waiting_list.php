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
                        <h2>Current Waiting Lists </h2>
                        <div class="widget-toolbar">
                            <!-- add: non-hidden - to disable auto hide -->

                            <div class="btn-group">
                                <button class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-search"></i> Filter By Firms <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <?php
                                        if (!empty($department_firms)) {
                                            foreach ($department_firms as $key) {
                                                echo "<a href=\"#\" onclick=\"filter_list_firm('waiting','" . $key->firm_id . "');\">" . $key->firm_name . "</a>";
                                            }
                                        }
                                        ?>
                                    </li>

                                </ul>
                            </div>

                            <div class="btn-group">
                                <button class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-print"></i> Print Waiting List <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="#" onclick="print_waiting_list();">Full List</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="javascript:void(0);"onclick="procedure_waiting_list_print();">Per Procedure</a>
                                    </li>

                                    <li class="divider"></li>
                                    <li>
                                        <a href="javascript:void(0);"onclick="firm_waiting_list_print();">Per Location</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);"onclick="firm_waiting_list_print();">Per Firm</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="theatre_waiting_list_print();">Per Theatre</a>
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

                            <table id="waitinglist_table" class="display projects-table table table-striped table-bordered table-hover" width="100%">

                                <thead>
                                    <tr>
                                        <th></th>
                                        <th class="hasinput" style="width:8%">
                                            <input type="text" class="form-control" placeholder="Folder" />
                                        </th>
                                        <th class="hasinput" style="width:10%">
                                            <input class="form-control" placeholder=" Surname" type="text">
                                        </th>
                                        <th class="hasinput " style="width:5%" >
                                            <input  type="text" class="form-control" placeholder=" Age" />
                                        </th>

                                        <th class="hasinput" style="width:10%">
                                            <input type="text" class="form-control" placeholder=" Procedure" />
                                        </th>
                                        <th class="hasinput" style="width:15%">
                                            <input type="text" class="form-control" placeholder=" Indication" />
                                        </th>


                                        <th class="hasinput icon-addon" >
                                            <input id="dateselect_filter" type="text" placeholder="Filter Date" class="form-control datepicker" data-dateformat="yy-mm-dd">
                                        </th>
                                        <th class="hasinput" style="width:8%">
                                            <input type="text" class="form-control" placeholder=" Lead time" />
                                        </th>
                                        <th class="hasinput" style="width:10%">
                                            <input type="text" class="form-control" placeholder=" MAP" />
                                        </th>
                                        <th class="hasinput" style="width:10%">
                                            <input type="text" class="form-control" placeholder=" CP" />
                                        </th>

                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th data-class="expand">Folder</th>
                                        <th>Name</th>
                                        <th data-hide="expand">Age(Yrs)</th>                                        
                                        <th data-hide="expand">Procedure</th>
                                        <th data-hide="expand">Indication</th>
                                        <th data-hide="expand" >Booking date</th>
                                        <th data-hide="expand">Lead Time(Days)</th>


                                        <th data-class="expand">MAP Score</th>
                                        <th data-class="expand">CP Score</th>

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
                                        foreach ($wards as $row) {
                                            $selected = isset($booking->ward_id) && $booking->ward_id == $row->ward_id ? 'selected="selected"' : '';
                                            echo '<option ' . $selected . ' value="' . $row->ward_id . '">' . $row->ward_name . '</option>';
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
                                        foreach ($procedures as $row) {
                                            $selected = isset($booking_details->procedure_id) && $booking_details->procedure_id == $row->procedure_id ? 'selected="selected"' : '';
                                            echo '<option ' . $selected . ' value="' . $row->procedure_id . '">' . $row->procedure_name . '</option>';
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