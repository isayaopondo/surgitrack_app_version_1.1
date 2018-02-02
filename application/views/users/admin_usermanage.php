<!-- RIBBON -->
<div id="ribbon">



    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>Home</li><li>Users</li><li>Management</li>
    </ol>
    <!-- end breadcrumb -->

    <!-- You can also add more buttons to the
    ribbon for further usability

    Example below:
    -->
    <span class="ribbon-button-alignment pull-right">
        <span id="search" class="btn btn-ribbon hidden-xs" data-title="search"><i class="fa fa-table"></i> Change Grid</span>
        <span id="add" class="btn btn-ribbon hidden-xs" data-title="add"><i class="fa fa-plus"></i> Add</span>
        <span id="search" class="btn btn-ribbon" data-title="search"><i class="fa fa-search"></i> <span class="hidden-mobile">Search</span></span>
    </span>

</div>
<!-- END RIBBON -->

<!-- MAIN CONTENT -->
<div id="content">
    <!-- row -->
    <section id="widget-grid" class="">

        <!-- row -->
        <div class="row">

            <!-- NEW WIDGET START -->
            <article class="col-sm-12 col-md-12 col-lg-12">
                <!-- new widget -->
                <div class="jarviswidget jarviswidget-color-orange">

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
                        <span class="widget-icon"> <i class="fa fa-users"></i> </span>
                        <h2>Users Management :
                                <span class="text-right text-strong"><?= $users->first_name . ' ' . $users->last_name ?></span>
                           </h2>
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

                        <div class="widget-body">
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="panel rounded shadow panel-default">
                                        <div class="panel-heading">
                                            <div class="pull-left">
                                                <h3 class="panel-title">User Statistics </h3>
                                            </div>
                                            <div class="pull-right">
                                            </div>
                                            <div class="clearfix"></div>
                                        </div><!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <div class="real-estate-quick-view shadow">

                                                <div class="media">
                                                    <div class="media-body">

                                                        <table class="table table-condensed">
                                                            <tbody>
                                                            <tr>
                                                                <td class="text-left">Role</td>
                                                                <td class="text-right"><?= strtoupper($roles[$users->auth_level]) ?></td>
                                                                <td class="text-left"></td>
                                                                <td class="text-left"></td>
                                                                <td class="text-left">User Status</td>
                                                                <td class="text-right"><?= $users->banned == 0 ? "Active" : "Not Active" ?></td>
                                                            </tr>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="panel rounded shadow panel-default">

                                        <div class="panel-body">
                                            <div class="form-group">
                                                <div class="col-sm-12">

                                                    <table class="table table-condensed">
                                                        <thead>
                                                        <tr>
                                                            <td class="text-left">Facility</td>
                                                            <td class="text-left">Role</td>
                                                            <td class="text-left">Current?</td>
                                                            <td class="text-left">Action</td>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $i = 0;

                                                            foreach ($myfacilities as $key) {
                                                                if ($key->current_user == '1') {
                                                                    echo '<tr>';
                                                                    echo '<td>';
                                                                    echo $key->facility_name;
                                                                    echo '</td>';
                                                                    echo '<td>';
                                                                    echo strtoupper($roles[$key->auth_level]);
                                                                    echo '</td>';
                                                                    echo '<td>';
                                                                    echo $key->current_user == '1'? 'Yes' :'No';
                                                                    echo '</td>';
                                                                    echo '<td>';
                                                                    echo '<a href="' . site_url('users/user_facility_unlink/' . $key->user_id) . '" class="btn btn-warning btn-xs rounded" data-toggle="tooltip" data-placement="top" data-original-title="Remove User"><i class="fa fa-unlink"></i></a>';
                                                                    echo '</td>';
                                                                    echo '</tr>';
                                                                }
                                                            }
                                                            ?>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="panel rounded shadow panel-default">
                                        <div class="panel-heading">
                                            <div class="pull-left">
                                                <h3 class="panel-title">User Log </h3>
                                            </div>
                                            <div class="pull-right">
                                            </div>
                                            <div class="clearfix"></div>
                                        </div><!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <!-- Start sample table -->
                                            <table class="table table-striped table-primary"  id="user_audit_trailtable" >

                                                <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Date</th>
                                                    <th>Description</th>
                                                    <th>Type</th>
                                                </tr>
                                                </thead>

                                            </table>

                                            <!--/ End sample table -->


                                            <!--/ End datatable -->
                                        </div><!-- /.panel-body -->
                                    </div><!-- /.panel -->
                                </div>

                            </div>


                        </div>

                    </div>
                </div>
            </article>

        </div>

        <!-- end row -->
    </section>


</div>
<!-- END MAIN CONTENT -->
