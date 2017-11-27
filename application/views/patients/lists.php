<!-- RIBBON -->
<div id="ribbon">

    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li><i class="fa fa-home"></i>Home</li><li>Patients</li><li>List</li>
    </ol>
    <!-- end breadcrumb -->
    <span class="ribbon-button-alignment pull-right">
        <span id="default_firm" style="font-size:large;  background-color:  <?=$default_firm_color;?>;" class="label " data-title="search"> <i class="fa-grid"></i><?=$default_firm?></span>
    </span>

</div>
<!-- END RIBBON -->



<!-- MAIN CONTENT -->
<div id="content">



    <!-- widget grid -->
    <section id="widget-grid" class="">
        <!-- START ROW -->
        <div class="row">
            <article class="col-sm-12 col-md-10 ">
                <div class="well">
                    <div class="input-group">
                        <div class="ui-widget">
                        <input class="form-control" type="text" name="search_text" id="search_text" placeholder="Search Patient Name, Folder Number, Phone Number...">
                        </div>
                        <div class="input-group-btn">
                            <button class="btn btn-default btn-primary" type="button">
                                <i class="fa fa-search"></i> Find Patient 
                            </button>
                        </div>
                    </div>
                </div>
            </article>
            <article class="col-sm-12 col-md-2 ">
                <div class="well">
                    <a href="<?= base_url('patients/add_patient') ?>" class="btn btn-block btn-default btn-danger" type="button">
                        <i class="fa fa-plus-circle"></i> Add Patient
                    </a>
                </div>
            </article>
        </div>
        <div class="row">
            <div id="message"><?= $message; ?></div>
            <!-- NEW COL START -->
            <article class="col-sm-12 col-md-12 ">

                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-deletebutton="false"
                     data-widget-fullscreenbutton="false">

                    <header>
                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                        <h2>Patients List </h2>

                    </header>

                    <!-- widget div-->
                    <div>

                        

                        <!-- widget content -->
                        <div class="widget-body no-padding">

                            <table id="patientlist_table" class="display projects-table table table-striped table-bordered table-hover" width="100%">
                                <thead>
                                    <tr>
                                        <th data-class="expand">Folder No.</th>
                                        <th>Name</th>
                                        <th data-hide="expand">DOB</th>
                                        <th>Gender</th>
                                        <th>Phone</th>
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