<!-- RIBBON -->
<div id="ribbon">

    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>

    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>Home</li><li>Firm</li><li>Add/Edit</li>
    </ol>
    <!-- end breadcrumb -->
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
                Firm
                <span>>  
                    Add/Edit
                </span>
            </h1>
        </div>
        <!-- end col -->

        <!-- right side of the page with the sparkline graphs -->
        <!-- col -->
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">

        </div>
        <!-- end col -->

    </div>
    <!-- end row -->

    <!-- widget grid -->
    <section id="widget-grid" class="">


        <!-- START ROW -->

        <div class="row">

            <!-- NEW COL START -->
            <article class="col-sm-12 col-md-12 col-lg-5">

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
                        <span class="widget-icon"> <i class="fa fa-edit"></i> </span>
                        <h2>Add/Edit Firm Details </h2>				

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
                            <form id="checkout-form"method="POST" action="<?= base_url('settings/create_firms') ?>" class="smart-form" novalidate="novalidate">
                                <fieldset>
                                    <section >
                                        <label>Department </label>
                                        <input class="form-control rounded" type="hidden"  id="firm_id" name="firm_id" value="<?= isset($firm->firm_id) ? $firm->firm_id : '' ?>">
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
                                    <section>
                                        <label>Firm Name </label>
                                        <label for="address2" class="input">
                                            <input type="text" name="firm_name" id="firm_name" placeholder="Firm Name" value="<?= isset($firm->firm_name) ? $firm->firm_name : '' ?>">
                                        </label>
                                    </section>
                                    <section >
                                        <label>Firm Phone </label>
                                        <label for="address2" class="input">
                                            <input type="text" name="firm_phone" id="firm_phone" placeholder="Phone Number" value="<?= isset($firm->firm_phone) ? $firm->firm_phone : '' ?>">
                                        </label>
                                    </section>
                                    <section>
                                        <label>Firm Color </label>
                                        <lable id="cp8" data-format="alias" class="input-group colorpicker-component"> 
                                            <input type="text" name="firm_color" id="firm_color" value="<?= isset($firm->firm_color) ? $firm->firm_color : '' ?>" class="form-control" /> 
                                            <span class="input-group-addon"><i></i></span> 
                                        </lable>
                                    </section>
                                </fieldset>
                                <fieldset>
                                    <section>
                                        <label>Description </label>
                                        <label class="textarea"> 										
                                            <textarea rows="3" name="firm_info" placeholder="Additional info"><?= isset($firm->firm_info) ? $department->firm_info : '' ?></textarea> 
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




            </article>
            <!-- END COL -->

            <!-- NEW COL START -->
            <article class="col-sm-12 col-md-12 col-lg-7">

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
                        <h2>Firms </h2>

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

                            <table id="firmstable" class="table table-striped table-bordered" width="100%">

                                <thead>
                                    <tr>
                                        <th class="hasinput" style="width:20%">
                                            <input type="text" class="form-control" placeholder="Filter Firm" />
                                        </th>
                                        <th class="hasinput" style="width:15%">
                                            <input type="text" class="form-control" placeholder="Filter Department" />
                                        </th>
                                        <th style="width:15%"></th>
                                        <th style="width:20%"></th>
                                        <th style="width:10%"></th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th>Firm Name</th>
                                        <th >Department</th>
                                        <th >Phone</th>
                                        <th >Info</th>
                                        <th> Color</th>
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
            </article>
            <!-- END COL -->		

        </div>

        <!-- END ROW -->

    </section>
    <!-- end widget grid -->

</div>
<!-- END MAIN CONTENT -->