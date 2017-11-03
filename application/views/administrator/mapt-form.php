<!-- RIBBON -->
<div id="ribbon">

    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>

    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>Home</li><li>Theatre</li><li>MAPT</li>
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
            <article class="col-sm-12 col-md-12 col-lg-6">

                <p class="alert alert-info">
                    <i class="fa fa-info-circle"></i> You can predefine a new <strong>Multi-Attribute Prioritisation Tool</strong> 
                    for each category, procedure and condition by filling the MAPT form.  </p>

                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget jarviswidget-color-greenDark" id="wid-id-18" data-widget-colorbutton="false" data-widget-editbutton="false">

                    <header>
                        <h2><strong>Current</strong> <i>MAPT LIST</i></h2>
                        <div class="widget-toolbar">
                            <button class="btn btn-default" data-toggle="modal" data-target="#myModal">
                                <i class="fa fa-plus-circle"></i> <span class="hidden-mobile">Add New MAPT</span>
                            </button>
                        </div>
                    </header>

                    <!-- widget div-->
                    <div>

                        <!-- widget edit box -->
                        <div class="jarviswidget-editbox">
                            <!-- This area used as dropdown edit box -->
                            <input class="form-control" type="text">
                            <span class="note"><i class="fa fa-check text-success"></i> Change title to update and save instantly!</span>

                        </div>
                        <!-- end widget edit box -->

                        <!-- widget content -->
                        <div class="widget-body no-padding"> 
                            <div class="table-responsive" >
                                <table class="table table-bordered table-hover " id="mapt_list_table">
                                    <thead>
                                        <tr>
                                            <th><i class="fa fa-list-alt text-warning"></i> MAPT NAME</th>
                                            <th>PROCEDURE <i class="text-danger"></i></th>
                                            <th>DEPARTMENT</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                </table>

                            </div>



                        </div>
                        <!-- end widget content -->

                    </div>
                    <!-- end widget div -->

                </div>
                <!-- end widget -->
            </article>

            <article class="col-sm-12 col-md-6 ">

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
                        <h2>Multi-Attribute Prioritisation Tool </h2>

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

                            <div class="row">

                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div id="view_criteria">

                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div id="view_criteria_form">

                                    </div>
                                </div>
                            </div>
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
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">ADD MAPT</h4>
            </div>
            <form id="create-mapt-form"  action="#"  novalidate="novalidate">
                <input class="form-control "  id="mapt_id" name="mapt_id"  type="hidden">
                <div class="modal-body">
                    <div id="alertMessage">
                        <div  class="alert alert-block alert-success">
                            <a class="close" data-dismiss="alert" href="#">×</a>
                            <div id="message"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <input type="text" class="form-control" name="mapt_name" id="mapt_name" placeholder="Title" required />
                            </div>

                        </div>
                        <div class="col-md-2">
                            <div id="listsq"></div>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Procedure</label>
                                <select class="form-control" name="procedure_id" id="procedure_id">
                                    <option value="0" selected="" disabled="">Procedure</option>
                                    <?php
                                    foreach ($procedures as $row) {
                                        $selected = isset($booking_details->procedure_id) && $booking_details->procedure_id == $row->procedure_id ? 'selected="selected"' : '';
                                        echo '<option ' . $selected . ' value="' . $row->procedure_id . '">' . $row->procedure_name . '</option>';
                                    }
                                    ?>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Category</label>
                                <select class="form-control" name="category_id" id="category_id" >
                                    <?php
                                    if (isset($booking_details->category_id)) {
                                        echo '<option selected="selected" value="' . $booking_details->category_id . '">' . $booking_details->category_name . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="category"> Department</label>
                                <select class="form-control" name="department_id" id="department_id">
                                    <?php
                                    foreach ($departments as $row) {
                                        $selected = isset($departments->department_id) && $departments->department_id == $row->department_id ? 'selected="selected"' : '';
                                        echo '<option ' . $selected . ' value="' . $row->department_id . '">' . $row->department_name . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tags"> Tags</label>
                                <input type="text" class="form-control" name="keywords"  id="keywords" placeholder="Keywords" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea class="form-control" placeholder="Notes" id="notes" name="notes" rows="5" required></textarea>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button" id="create_mapt" class="btn btn-success">
                        Save MAPT
                    </button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal -->
<div class="modal fade" id="myModalMAPTCriteria" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
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
                        <h2>MAPT Criteria </h2>

                    </header>
                    <div class="table-responsive">
                        <div id="maptdetails"></div>
                    </div>

                    <form id="criteria-form" method="POST" action="#" class="smart-form" novalidate="novalidate">
                        <input type="hidden" name="mapt_id" id="mapt_id" >
                        <input type="hidden" name="criteria_id" id="criteria_id" >
                        <article class="col-sm-12 col-md-12 col-lg-6 ">
                            <header>New Criteria</header>
                            <div class="well">                              
                                <fieldset >
                                    <section >
                                        <label>Criteria Name</label>
                                        <label class="input"> <i class="icon-prepend fa fa-list-alt"></i>
                                            <input type="text" name="criteria_name" id="criteria_name" placeholder="Criteria Name"   >
                                        </label>
                                    </section>

                                    <section >
                                        <label>Weight <small>(Percentage)</small></label>
                                        <label class="input"> <i class="icon-prepend fa fa-diamond"></i>
                                            <input type="text" name="criteria_weight" id="criteria_weight" placeholder="Weight"   >
                                        </label>
                                    </section>

                                    <section>
                                        <label> AdditionalNotes</label>
                                        <label class="textarea"> 										
                                            <textarea rows="3" name="additional_info" placeholder="additional Info"></textarea> 
                                        </label>
                                    </section>

                                    <section id="criteria_elements">
                                        <label>Criteria Scores</label>
                                        <div class="clear"></div>

                                        <div id="mapt_elements_fields">
                                        </div>

                                        <div >
                                            <button class="btn btn-md btn-block btn-success " type="button" id="addchoice" ><i class="fa fa-plus-square-o "></i> Add Score</button>
                                        </div>

                                    </section>

                                </fieldset>
                                <footer>
                                    <button type="button" id="add_criteria" class="btn btn-success">
                                        Save
                                    </button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">
                                        Close
                                    </button>
                                    <button type="reset" class="btn btn-warning">
                                        Clear
                                    </button>

                                </footer>
                            </div>
                        </article>
                        <article class="col-sm-12 col-md-12 col-lg-6 ">
                            <header>Existing Criteria</header>
                            <div id="existing_mapt_criteria">
                            </div>
                        </article>


                    </form>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->