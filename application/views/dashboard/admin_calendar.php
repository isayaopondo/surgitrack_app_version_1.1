<!-- RIBBON -->
<div id="ribbon">

    <span class="ribbon-button-alignment">
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
            <i class="fa fa-refresh"></i>
        </span>
    </span>

    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>Home</li><li>Dashboard</li><li>Cases Calendar</li>
    </ol>
    <!-- end breadcrumb -->

    <!-- You can also add more buttons to the
    ribbon for further usability

    Example below:
-->

</div>
<!-- END RIBBON -->

<!-- MAIN CONTENT -->
<div id="content">

    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
            <form class="form-horizontal">


                <div class="well">
                    <div class="input-group">
                        <div class="ui-widget">
                            <input class="form-control" type="text" name="search_text" id="search_text" placeholder="Search by Surname OR Name OR Folder Number ...">
                        </div>
                        <div class="input-group-btn">
                            <button class="btn btn-default btn-primary" type="button">
                                <i class="fa fa-search"></i> Find Patient
                            </button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">

            <div class="well">
                <a href="<?= base_url('patients/add_patient') ?>" class="btn btn-block btn-default btn-danger" type="button">
                    <i class="fa fa-plus-circle"></i> Add Patient
                </a>
            </div>

        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
            <div class="well dashboard-sparks">
                <div class="row ">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 dashboard-spark">
                        <b >  Hrs Needed</b> <br> <span class="txt-color-blue"><i class="fa fa-clock-o"></i>&nbsp;<?= $dashstats['theatre_time'] ?></span>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 dashboard-spark">
                        <b> Patients Waiting </b><br> <span class="txt-color-purple"><i class="fa fa-users"></i>&nbsp;<?= $dashstats['patients_waiting'] ?></span>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 dashboard-spark">
                        <b> Avg Wait (Days)</b><br> <span class="txt-color-greenDark"><i class="fa fa-calendar"></i>&nbsp;<?= number_format($dashstats['avg_wait_time'], 2) ?></span>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <div class="row">


        <div class="col-sm-12 col-md-12 col-lg-7">

            <!-- new widget -->
            <div class="jarviswidget jarviswidget-color-blueDark">


                <header>
                    <span class="widget-icon"> <i class="fa fa-calendar"></i> </span>
                    <h2> My Cases </h2>
                    <div class="widget-toolbar">
                        <!-- add: non-hidden - to disable auto hide -->
                        <div class="btn-group">
                            <button class="btn dropdown-toggle btn-xs btn-default" data-toggle="dropdown">
                                Showing <i class="fa fa-caret-down"></i>
                            </button>
                            <ul class="dropdown-menu js-status-update pull-right">
                                <li>
                                    <a href="javascript:void(0);" id="mt">Month</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" id="ag">Week</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" id="td">Today</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="widget-toolbar">
                        <!-- add: non-hidden - to disable auto hide -->
                        <div class="btn-group">
                            <button class="btn dropdown-toggle btn-xs btn-default" data-toggle="dropdown">
                                Go to <i class="fa fa-caret-down"></i>
                            </button>
                            <ul class="dropdown-menu js-status-update pull-right">
                                <li>
                                    <a href="javascript:void(0);" id="w">Current Week</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" id="tw">Next 2 Weeks</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" id="on">Next 1 Month</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" id="tm">Next 3 Months</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" id="fm">Next 4 Months</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" id="sm">Next 6 Months</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" id="oy">Next 1 Year</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </header>

                <!-- widget div-->
                <div>

                    <div class="widget-body no-padding">
                        <!-- content goes here -->
                        <div class="widget-body-toolbar">

                            <div id="calendar-buttons">

                                <div class="btn-group">
                                    <a href="javascript:void(0)" class="btn btn-default btn-xs" id="btn-prev"><i class="fa fa-chevron-left"></i></a>
                                    <a href="javascript:void(0)" class="btn btn-default btn-xs" id="btn-next"><i class="fa fa-chevron-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div id="calendar"></div>

                        <!-- end content -->
                    </div>

                </div>
                <!-- end widget div -->
            </div>
            <!-- end widget -->

        </div>
        <div class="col-sm-12 col-md-12 col-lg-5">

            <!-- new widget -->
            <div class="jarviswidget jarviswidget-color-blueDark">

                <header>
                    <span class="widget-icon"> <i class="fa fa-calendar"></i> </span>
                    <h2> Waiting List Summary </h2>
                    <div class="widget-toolbar">
                        <div class="btn-group">
                            <button class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-search"></i> Filter By Firms <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <?php
                                    if (!empty($department_firms)) {
                                        foreach ($department_firms as $key) {
                                            echo "<a href=\"#\" onclick=\"filter_list_firm('procedure','" . $key->firm_id . "');\">" . $key->firm_name . "</a>";
                                        }
                                    }
                                    ?>
                                </li>

                            </ul>
                        </div>
                    </div>
                </header>

                <!-- widget div-->
                <div>

                    <div class="widget-body no-padding">
                        <!-- content goes here -->
                        <table id="facility_procedure_summary_table" class="display projects-table table table-striped table-bordered table-hover" width="100%">

                            <thead>

                            <tr>
                                <th data-hide="expand">Procedure</th>
                                <th data-hide="expand">Category</th>
                                <th data-hide="expand">No. of Cases Waiting</th>

                            </tr>
                            </thead>



                        </table>
                        <!-- end content -->
                    </div>

                </div>
                <!-- end widget div -->
            </div>
            <!-- end widget -->

        </div>



    </div>

    <!-- end row -->



</div>
<!-- END MAIN CONTENT -->

