<!-- RIBBON -->
<div id="ribbon">

    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>

    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>Home</li><li>Theatre</li><li>My Logbook</li>
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
                        <h2>My Logbook </h2>
                        <div class="widget-toolbar">
                            <!-- add: non-hidden - to disable auto hide -->


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

                            <table id="mylogbook_table" class="display projects-table table table-striped table-bordered table-hover" width="100%">
                                <thead>
                                    <tr>

                                        <th class="hasinput" style="width:10%">
                                            <input type="text" class="form-control" placeholder="Folder" />
                                        </th>
                                        <th class="hasinput" style="width:13%">
                                            <input class="form-control" placeholder="Surname" type="text">

                                        </th>
                                        <th class="hasinput " style="width:6%" >
                                            <input  type="text" class="form-control" placeholder="Age" />
                                        </th>
                                        <th class="hasinput" style="width:7%">
                                            <input type="text" class="form-control" placeholder="Gender" />
                                        </th>

                                        <th class="hasinput icon-addon" >
                                            <input id="dateselect_filter" type="text" placeholder=" Date" class="form-control datepicker" data-dateformat="yy-mm-dd"/>
                                            <label for="dateselect_filter" class="glyphicon glyphicon-calendar no-margin padding-top-15" rel="tooltip" title="" data-original-title="Filter Date"></label>
                                        </th>
                                        <th class="hasinput" style="width:20%">
                                            <input type="text" class="form-control" placeholder="Operation" />
                                        </th>
                                        <th class="hasinput" style="width:15%">
                                            <input type="text" class="form-control" placeholder="Theatre" />
                                        </th>
                                        <th class="hasinput" style="width:8%">
                                            <input type="text" class="form-control" placeholder="Role" />
                                        </th>

                                        <th class="hasinput" style="width:10%">
                                            </th>
                                    </tr>
                                    <tr>
                                        <th data-class="expand">Folder</th>   
                                        <th>Surname</th>                                                                             
                                        <th data-hide="expand">Age</th>
                                        <th data-class="expand">Gender</th>
                                        <th data-hide="expand" >Operation date</th>
                                        <th data-hide="expand">Operation</th>
                                        <th data-hide="expand" >Theatre</th>
                                        <th data-hide="expand">Role</th>
                                        <th ></th>
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
<div class="modal fade" id="myModalViewLogbookOpNotes" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close " data-dismiss="modal" aria-hidden="true">
                    &times;  Close
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
                        <div class="table-responsive">
                            <div id="patient_opnotes" ></div>
                        </div>
                     
                </div>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->