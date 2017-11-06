<!-- RIBBON -->
<div id="ribbon">

    <span class="ribbon-button-alignment">
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
            <i class="fa fa-refresh"></i>
        </span>
    </span>

    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>Home</li><li>Dashboard</li>
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


        <div class="col-sm-12 col-md-12 col-lg-7">

            <!-- new widget -->
            <div class="jarviswidget jarviswidget-color-blueDark">


                <header>
                    <span class="widget-icon"> <i class="fa fa-calendar"></i> </span>
                    <h2> Patients' Map </h2>
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

                    </div>
                </header>

                <!-- widget div-->
                <div>

                    <div class="widget-body no-padding">
                        <!--<div id="patients_map"></div>-->
                        <div id="map"></div>
                        <script>
                            function initMap() {
                                var uluru = {lat: -25.363, lng: 131.044};
                                var map = new google.maps.Map(document.getElementById('map'), {
                                    zoom: 4,
                                    center: uluru
                                });
                                var marker = new google.maps.Marker({
                                    position: uluru,
                                    map: map
                                });
                            }
                        </script>
                        <script async defer
                                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDox6REYw0WJWz0ohp9B16D_bkBdxvCkGY&callback=initMap">
                        </script>

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

