<!-- RIBBON -->
<div id="ribbon">

    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>

    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>Home</li><li>Theatre</li><li>Admission List</li>
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
                        <h2>Current Admission Lists </h2>
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
                                                echo "<a href=\"#\" onclick=\"filter_list_firm('admission','" . $key->firm_id . "');\">" . $key->firm_name . "</a>";
                                            }
                                        }
                                        ?>
                                    </li>

                                </ul>
                            </div>
                            <div class="btn-group">

                                <button class="btn btn-default btn-xs " onclick="multi_admission_list_print();" >
                                    <i class="fa fa-print"></i> Print Admission List 
                                </button>

                                <!--<button class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-print"></i> Print Admission List <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="#" onclick="print_admission_list();">Full List</a>
                                    </li>
                                    <li class="divider"></li>

                                    <li>
                                        <a href="javascript:void(0);"onclick="firm_admission_list_print();">By Firm</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="date_admission_list_print();">By Date</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="multi_admission_list_print();">By Multi-Factor</a>
                                    </li>
                                    
                                </ul>-->
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

                            <table id="admissionlist_table" class="display projects-table table table-striped table-bordered table-hover" width="100%">

                                <thead>
                                    <tr>
                                        <th></th>
                                        <th class="hasinput" style="width:10%">
                                            <input type="text" class="form-control" placeholder="Folder" />
                                        </th>
                                        <th class="hasinput" style="width:10%">
                                            <input class="form-control" placeholder="Surname" type="text">
                                        </th>
                                        <th class="hasinput " style="width:10%" >
                                            <input  type="text" class="form-control" placeholder=" Age" />
                                        </th>
                                        <th class="hasinput" style="width:10%">
                                            <input type="text" class="form-control" placeholder="Procedure" />
                                        </th>


                                        <th class="hasinput icon-addon" >
                                            <input id="dateselect_filter" type="text" placeholder=" Date" class="form-control datepicker" data-dateformat="yy-mm-dd"/>
                                            <label for="dateselect_filter" class="glyphicon glyphicon-calendar no-margin padding-top-15" rel="tooltip" title="" data-original-title="Filter Date"></label>
                                        </th>
                                        <th class="hasinput " style="width:8%">
                                            <input type="text" class="form-control" id="min" placeholder="Time" />
                                        </th>
                                        <th class="hasinput " style="width:15%">
                                            <input type="text" class="form-control" placeholder="Indication" />
                                        </th>
                                        <th class="hasinput" style="width:8%">
                                            <input type="text" class="form-control" placeholder=" Priotity" />
                                        </th>
                                        <th class="hasinput" style="width:17%">
                                            <input type="text" class="form-control" placeholder="Theatre" />
                                        </th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th data-class="expand">Folder</th>
                                        <th>Surname</th>
                                        <th data-hide="expand">Age(Yrs)</th>
                                        <th data-hide="expand">Procedure</th>

                                        <th data-hide="expand" >Admission date</th>
                                        <th data-hide="expand">Lead Time(Days)</th>
                                        <th data-hide="expand">Indication</th>
                                        <th data-hide="expand">Priority</th>
                                        <th data-class="expand">Theatre</th>
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
                                    <label>Theatre</label>
                                    <label class="select">
                                        <select name="theatre" id="theatre" >
                                            <option value="0" selected="" disabled="">Theatre</option>
                                            <?php
                                            foreach ($theatre as $row) {
                                                echo '<option  value="' . $row->theatre_id . '">' . $row->theatre_name . '</option>';
                                            }
                                            ?>
                                        </select> <i></i> </label>
                                </section>
                                <section class="col col-6">
                                    <input type="hidden" name="booking_id" id="booking_id" >
                                    <label>Date of Surgery</label>
                                    <label class="input"> <i class="icon-prepend fa fa-calendar"></i>
                                        <input type="text" name="surgery_date" id="surgerydate" placeholder="Date of Surgery"  data-dateformat='yy-mm-dd' >
                                    </label>
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
                                        foreach ($fdepartment_firms as $row) {
                                            echo '<option  value="' . $row->firm_id . '">' . $row->firm_name . '</option>';
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
                                        foreach ($department_firms as $row) {
                                            echo '<option  value="' . $row->firm_id . '">  ' . $row->firm_name . '</option>';
                                        }
                                        ?>
                                    </select> <i></i> </label>
                            </section>
                            

                            <section >
                                <label>Admission Start Date  </label>
                                <label class="input"> <i class="icon-prepend fa fa-calendar"></i>
                                    <input type="text" name="admissiondate" id="admission_date" class="form-control"  placeholder="Date of Admission" data-dateformat='yy-mm-dd' value='<?= date('Y-m-d') ?>' >

                                </label>
                            </section>
                            
                            <section >
                                <label>Admission End Date </label>
                                <label class="input"> <i class="icon-prepend fa fa-calendar"></i>
                                    <input type="text" name="admissionenddate" id="admission_enddate" class="form-control"  placeholder="Date of Admission" data-dateformat='yy-mm-dd' value='<?= date('Y-m-d') ?>' >

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
