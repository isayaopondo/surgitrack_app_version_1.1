<!-- RIBBON -->
<div id="ribbon">



    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>Home</li><li>Users</li><li>Groups</li>
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
                        <h2>Users List </h2>
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
                            <h3 class="panel-title">Add/Edit Group</h3>
                        </div>
                        <div class="pull-right">
                            <button class="btn btn-sm" data-action="refresh" data-container="body" data-toggle="tooltip" data-placement="top" data-title="Refresh"><i class="fa fa-refresh"></i></button>
                            <button class="btn btn-sm" data-action="collapse" data-container="body" data-toggle="tooltip" data-placement="top" data-title="Collapse"><i class="fa fa-angle-up"></i></button>
                            <button class="btn btn-sm" data-action="remove" data-container="body" data-toggle="tooltip" data-placement="top" data-title="Remove"><i class="fa fa-times"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div><!-- /.panel-heading -->
                    <div class="panel-body">

                        <form action="<?= site_url('users/create_group') ?>" method="post"  id="add_edit_form" data-backdrop="false">
                            <div class="form-body">

                                <div class="form-group">
                                    <label class="control-label">Name</label>
                                    <input class="form-control rounded" type="text" placeholder="Group Name" name="group_name">
                                </div><!-- /.form-group -->
                                <div class="form-group">
                                    <label class="control-label">Groups Description</label>
                                    <textarea class="form-control rounded" rows="2" placeholder="Group Description" name="description"></textarea>
                                </div><!-- /.form-group -->
                               
                                <div class="form-group">
                                    <label>Bank Assignable</label>
                                </div>
                                <div class="form-group">
                                    <div class="rdio rdio-theme rounded radio-inline">
                                        <input id="radio-type-rounded_yes" type="radio" name="assign_transunit" value="Yes">
                                        <label for="radio-type-rounded_yes">Yes</label>
                                    </div>
                                    <div class="rdio rdio-theme rounded radio-inline">
                                        <input id="radio-type-rounded_no" type="radio" name="assign_transunit" value="No">
                                        <label for="radio-type-rounded_no">No</label>
                                    </div>
                                </div><!-- /.form-group -->

                            </div><!-- /.form-body -->
                            <div class="form-footer">
                                <div class="pull-right">
                                    <button class="btn btn-danger mr-5" >Cancel</button>
                                    <button class="btn btn-success" type="submit" >Submit</button>

                                </div>
                                <div class="clearfix"></div>
                            </div><!-- /.form-footer -->
                        </form>

                    </div>
                </div>
            </div>



            <div class="col-md-8">
                <div class="panel rounded shadow panel-default">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">User Groups</h3>
                        </div>
                        <div class="pull-right">
                            <button class="btn btn-sm" data-action="refresh" data-container="body" data-toggle="tooltip" data-placement="top" data-title="Refresh"><i class="fa fa-refresh"></i></button>
                            <button class="btn btn-sm" data-action="collapse" data-container="body" data-toggle="tooltip" data-placement="top" data-title="Collapse"><i class="fa fa-angle-up"></i></button>
                            <button class="btn btn-sm" data-action="remove" data-container="body" data-toggle="tooltip" data-placement="top" data-title="Remove"><i class="fa fa-times"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div><!-- /.panel-heading -->
                    <div class="panel-body">
                        <!-- Start sample table -->
                        <div class="table-responsive rounded mb-20">
                            <table class="table table-striped table-theme">
                                <thead>
                                    <tr>
                                        <th class="text-center border-right">No.</th>
                                        <th>Groups Name</th>
                                        <th>Groups Description</th>
                                        <th>Units Assignable</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $i = 1;
                                    foreach ($levels as $level):
                                        ?>
                                        <tr>
                                            <td class="text-center border-right"><?= $i ?></td>
                                            <td class="text-center border-right"><?= $level->name ?></td>
                                            <td class="text-center border-right"><?= $level->description ?></td>
                                            <td class="text-center border-right"><?= $level->assign_transunit ?></td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="#" class="btn btn-success btn-xs rounded"   data-placement="top" data-original-title="Edit" ><i class="fa fa-eye" ></i></a>
                                                    <a href="#" class="btn btn-primary btn-xs rounded" data-toggle="tooltip" data-placement="top" data-original-title="Edit" id="#" ><i class="fa fa-pencil" ></i></a>
                                                    <a href="#" class="btn btn-danger btn-xs rounded" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-times"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                        $i++;
                                    endforeach;
                                    ?>
                                </tbody>

                            </table>
                        </div><!-- /.table-responsive -->
                        <!--/ End sample table -->


                        <!--/ End datatable -->
                    </div><!-- /.panel-body -->
                </div><!-- /.panel -->
            </div>
            <div class="col-md-3">
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