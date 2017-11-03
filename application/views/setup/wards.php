<!-- widget grid -->
<section id="widget-grid" class="">


    <!-- START ROW -->

    <div class="row">

        <!-- NEW COL START -->
        <article class="col-sm-12 col-md-12 col-lg-5">

            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-deletebutton="false"
                 data-widget-fullscreenbutton="false">

                <header>
                    <span class="widget-icon"> <i class="fa fa-edit"></i> </span>
                    <h2>Add/Edit Wards/Location Details </h2>

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
                        <form id="checkout-form"method="POST" action="<?= base_url('setup/create_wards') ?>" class="smart-form" novalidate="novalidate">
                            <fieldset>
                                <section >
                                    <input class="form-control rounded" type="hidden"  id="ward_id" name="ward_id" value="<?= isset($theatre->theatre_id) ? $theatre->theatre_id : '' ?>">
                                    <input class="form-control rounded" type="hidden"  id="facility" name="facility" value="<?= isset($auth_facilityid) ? $auth_facilityid : '' ?>">

                                    <label>Wards/Location Name </label>
                                    <label for="ward_name" class="input">
                                        <input type="text" name="ward_name" id="ward_name" placeholder="Wards/Location Name" value="<?= isset($wardslocation->ward_name) ? $wardslocation->ward_name : '' ?>">
                                    </label>
                                </section>
                                <section >
                                    <label>Phone Number </label>
                                    <label for="ward_phone" class="input">
                                        <input type="text" name="ward_phone" id="ward_phone" placeholder="Phone Number" value="<?= isset($wardslocation->ward_phone) ? $wardslocation->ward_phone : '' ?>">
                                    </label>
                                </section>
                            </fieldset>
                            <fieldset>
                                <section>
                                    <label>Additional info </label>
                                    <label class="textarea">
                                        <textarea rows="3" name="ward_info" placeholder="Additional info"><?= isset($wardslocation->ward_info) ? $wardslocation->ward_info : '' ?></textarea>
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

                <header>
                    <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                    <h2>Wards/Location </h2>

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

                        <table id="wardstable" class="table table-striped table-bordered" width="100%">

                            <thead>
                            <tr>
                                <th class="hasinput" style="width:30%">
                                    <input type="text" class="form-control" placeholder="Filter Ward/Location" />
                                </th>

                                <th style="width:15%"></th>
                                <th style="width:20%"></th>
                                <th></th>
                            </tr>
                            <tr>
                                <th>Wards/Location Name</th>
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
        </article>
        <!-- END COL -->

    </div>

    <!-- END ROW -->

</section>
<!-- end widget grid -->