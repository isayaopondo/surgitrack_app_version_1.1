<!-- RIBBON -->
<div id="ribbon">

    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>

    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>Home</li><li>Department</li><li>Add/Edit</li>
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

    <!-- row -->
    <div class="row">

        <!-- col -->
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
            <h1 class="page-title txt-color-blueDark">

                <!-- PAGE HEADER -->
                <i class="fa-fw fa fa-plus-square"></i> 
                Department
                <span>>  
                    Add/Edit
                </span>
            </h1>
        </div>
        <!-- end col -->

        <!-- right side of the page with the sparkline graphs -->
        <!-- col -->
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
            <!-- sparks -->
            
            <!-- end sparks -->
        </div>
        <!-- end col -->

    </div>
    <!-- end row -->

    <!-- widget grid -->
    <section id="widget-grid" class="">


        <!-- START ROW -->

        <div class="row">

            <!-- NEW COL START -->
            <div class="col-sm-5 col-md-5 col-lg-5">

                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-deletebutton="false"
                     data-widget-fullscreenbutton="false">

                    <header>
                        <span class="widget-icon"> <i class="fa fa-edit"></i> </span>
                        <h2>Add/Edit Department Details </h2>				

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
                            <section>
                                <div id="infoMessage"><?php echo $message; ?></div>
                            </section>
                            <form id="checkout-form"method="POST" action="<?= base_url('settings/create_departments') ?>" class="smart-form" novalidate="novalidate">
                                <fieldset>
                                        <input class="form-control rounded" type="hidden"  id="department_id" name="department_id" value="<?= isset($department->department_id) ? $department->department_id : '' ?>">
                                    <input class="form-control rounded" type="hidden"  id="facility" name="facility" value="<?= isset($auth_facilityid) ? $auth_facilityid : '' ?>">
                                    <section>
                                        <label for="address2" class="input">
                                            <input type="text" name="department_name" id="department_name" placeholder="Department Name" value="<?= isset($department->department_name) ? $department->department_name : '' ?>">
                                        </label>
                                    </section>
                                    <section >
                                        <label for="address2" class="input">
                                            <input type="text" name="department_phone" id="department_phone" placeholder="Phone Number" value="<?= isset($department->department_phone) ? $department->department_phone : '' ?>">
                                        </label>
                                    </section>
                                </fieldset>
                                <fieldset>
                                    <section>
                                        <label class="textarea"> 										
                                            <textarea rows="3" name="department_info" placeholder="Additional info"><?= isset($department->department_info) ? $department->department_info : '' ?></textarea>
                                        </label>
                                    </section>
                                </fieldset>


                                <footer>
                                    <button type="reset" class="btn btn-warning">
                                        Clear
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        Save
                                    </button>
                                </footer>
                            </form>

                        </div>
                        <!-- end widget content -->

                    </div>
                    <!-- end widget div -->

                </div>
                <!-- end widget -->




            </div>
            <!-- END COL -->

            <!-- NEW COL START -->
            <div class="col-sm-7 col-md-7 col-lg-7">

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
                        <h2>My Departments </h2>

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

                            <table id="departmentstable" class="table table-striped table-bordered" >

                                <thead>
                                    <tr>
                                        <th class="hasinput" style="width:30%">
                                            <input type="text" class="form-control" placeholder="Filter Department" />
                                        </th>

                                        <th style="width:15%"></th>
                                        <th style="width:20%"></th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th>Department Name</th>
                                        <th >Phone</th>
                                        <th >Info</th>
                                        <th></th>
                                    </tr>
                                </thead>

                            </table>

                        </div>
                        <!-- end widget content -->

                    </div>
                    <!-- end widget div -->

                </div>
                <!-- end widget -->
            </div>
            <!-- END COL -->		

        </div>

        <!-- END ROW -->

    </section>
    <!-- end widget grid -->

</div>
<!-- END MAIN CONTENT -->