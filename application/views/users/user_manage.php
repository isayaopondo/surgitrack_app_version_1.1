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
                <div class="jarviswidget jarviswidget-color-blueDark">

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
                        <h2>Users Management </h2>
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

                                <div class="col-md-4">
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
                                                        <h3 class="media-heading">
                                                            <span class="text-right text-strong"><?= $users->first_name . ' ' . $users->last_name ?></span>
                                                        </h3>
                                                        <table class="table table-condensed">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="text-left">Role</td>
                                                                    <td class="text-right"><?= $users->description ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-left">User Status</td>
                                                                    <td class="text-right"><?= $users->active == 1 ? "Active" : "Not Active" ?></td>
                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="panel rounded shadow panel-default">
                                        <div class="panel-heading">
                                            <div class="pull-left">
                                                <h3 class="panel-title">User Details</h3>
                                            </div>
                                            <div class="pull-right">
                                            </div>
                                            <div class="clearfix"></div>
                                        </div><!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-7">
                                                    <div class="inner-all">
                                                        <ul class="list-unstyled">
                                                            <li class="text-left">
                                                                <h4 class="text-capitalize"><?= $users->first_name . ' ' . $users->last_name ?></h4>
                                                                <p class="text-muted text-capitalize"><?= $users->name ?></p>
                                                            </li>


                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-sm-5">
                                                    <div class="inner-all">
                                                        
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="panel rounded shadow panel-default">
                                        <div class="panel-heading">
                                            <div class="pull-left">
                                                <h3 class="panel-title"> AFFILIATIONS </h3>
                                            </div>
                                            <div class="pull-right">
                                            </div>
                                            <div class="clearfix"></div>
                                        </div><!-- /.panel-heading -->
                                        <div class="panel-body">
                                                    <div class="form-group">                                                    
                                                    <div class="col-sm-12">
                                    
                                                        <?php
                                                        $i = 0;

                                                        foreach ($mydepartments as $key) {
                                                            if ($key->current_user == '1') {
                                                                echo '<div class="well">';
                                                                 echo '<label class="text-center"> <b>Facility:</b> ' . $key->facility_name . ' </label>';
                                                                
                                                                echo '<label class="text-center"> <b>Department:</b> ' . $key->department_name . ' </label>';
                                                                if ($key->approved == '0') {
                                                                    echo '<button onclick="approve_department(\'' . $users->first_name . ' ' . $users->last_name. '\',\'' . $key->user_id . '\',\'' . $key->department_id . '\',\'' . $key->department_name . '\');" class="btn btn-success btn-block">Approve Department</button>';
                                                                } else {
                                                                    echo '<button onclick="delink_department(\'' . $users->first_name . ' ' . $users->last_name . '\',\'' . $key->user_id . '\',\'' . $key->department_id . '\',\'' . $key->department_name . '\');" class="btn btn-danger btn-block">Remove from Department</button>';
                                                                }
                                                                echo '</div>';
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-8">
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
                                <div class="col-md-4">
                                    <div class="panel rounded shadow panel-default">
                                        <div class="panel-heading">
                                            <div class="pull-left">
                                                <h3 class="panel-title">Firms </h3>
                                            </div>
                                            <div class="pull-right">
                                            </div>
                                            <div class="clearfix"></div>
                                        </div><!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <!-- Start sample table -->
                                            <table class="table table-striped table-primary"  id="gendatatable" >
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Firm</th>
                                                        <th>Current Firms</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 0;

                                                    foreach ($myfirms as $key) {
                                                        $iscurrent = ($key['current_user'] == '1') ? 'Yes' : 'No';
                                                        if ($key['approved'] == '0') {
                                                                    $button= '<button onclick="approve_firm(\'' . $users->first_name . ' ' . $users->last_name. '\',\'' . $key['user_id'] . '\',\'' . $key['firm_id'] . '\',\'' . $key['firm_name'] . '\');" class="btn btn-success btn-block">Approve</button>';
                                                                } else {
                                                                    $button= '<button onclick="delink_firm(\'' . $users->first_name . ' ' . $users->last_name . '\',\'' . $key['user_id'] . '\',\'' . $key['firm_id'] . '\',\'' . $key['firm_name'] . '\');" class="btn btn-danger btn-block">Remove</button>';
                                                                }
                                                        $i++;
                                                        echo '<tr>
                                                                    <th>' . $i . '</th>
                                                                    <th>' . $key['firm_name'] . '</th>
                                                                    <th>' . $iscurrent . '</th>
                                                                </tr>';
                                                    }
                                                    ?>

                                                </tbody>

                                            </table>

                                            <!--/ End sample table -->


                                            <!--/ End datatable -->
                                        </div><!--/.panel-body -->
                                    </div><!--/.panel -->
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

<!-- Modal -->
<!-- Modal -->
<div class="modal fade bs-example-modal-multiple" id="myModal" tabindex="-1" role="dialog">
    <div class="modal-dialog ">
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
                        <h2>Assign Firm</h2>

                    </header>
                    <form id="checkout-form" method="POST" action="<?= base_url('users/assign_units') ?>" class="smart-form" novalidate="novalidate">

                        <fieldset>

                            <section >
                                <label>Facility</label>
                                <label class="select">
                                    <select name="facility">
                                        <option value="0" selected="" disabled="">Facility</option>
                                        <?php
                                        foreach ($facilities as $row) {
                                            $selected = isset($department->facility_id) && $department->facility_id == $row->facility_id ? 'selected="selected"' : '';
                                            echo '<option ' . $selected . ' value="' . $row->facility_id . '">' . $row->facility_name . '</option>';
                                        }
                                        ?>
                                    </select> <i></i> </label>
                            </section>
                            <section >
                                <label>Department</label>
                                <label class="select">
                                    <select name="department">
                                        <option value="0" selected="" disabled="">Department</option>
                                        <?php
                                        foreach ($departments as $row) {
                                            $selected = isset($firm->department_id) && $firm->department_id == $row->department_id ? 'selected="selected"' : '';
                                            echo '<option ' . $selected . ' value="' . $row->department_id . '">' . $row->department_name . '</option>';
                                        }
                                        ?>
                                    </select> <i></i> </label>
                            </section>
                            <section >
                                <label>Firm</label>
                                <label class="select">
                                    <select name="firm">
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


<!-- Unassign Modal -->

<!-- Start photo viewer modal element -->
<div class="modal fade user_unassign bs-example-modal-unassignunit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="pull-left">
                    <h3 class="panel-title"> Un-Assign Units</h3>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <form  action="<?= site_url('users/user_unassign_unit') ?>" method="post"   data-backdrop="false">
                    <div class="form-body">


                        <div class="form-group">
                            <input class="form-control rounded" type="hidden" name="userid" id="userid" value="<?= $users->user_id ?>" >
                        </div><!-- /.form-group -->
                        <div class="form-group">
                            <input class="form-control rounded" name="userlevel" type="hidden" id="userlevel" value="<?= $users->user_group ?>" >
                        </div><!-- /.form-group -->

                        <div id="scounty1">
                            <div class="form-group">
                                <label class="control-label">Assigned Units</label>
                                <select name="unit_id" id="unit_id" class="form-control input-sm mb-15">
                                    <option value="">- Choose Unit -</option>
                                    <?php
                                    foreach ($assigned_unit as $row) {
                                        $selected = set_value('unit_id') == $row->unit_id ? 'selected="selected"' : '';
                                        echo '<option ' . $selected . ' value="' . $row->unit_id . '">' . $row->unit_name . '</option>';
                                    }
                                    ?>
                                </select>
                            </div><!-- /.form-group -->
                        </div>

                    </div><!-- /.form-body -->
                    <div class="form-footer">
                        <div class="pull-right">
                            <button class="btn btn-success" type="submit">Un assign</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

                        </div>
                        <div class="clearfix"></div>
                    </div><!-- /.form-footer -->
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--/ End photo viewer modal element -->