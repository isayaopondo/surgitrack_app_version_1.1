<!-- RIBBON -->
<div id="ribbon">

    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>

    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>Home</li><li>Settings</li><li> RPL Codes</li>
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
                 <i class="fa-fw fa fa-codepen"></i>
                RPL
                <span>>
                    Codes
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
                <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-2" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false">
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
                        <h2>Add/Edit  Procedure By Department </h2>

                    </header>

                    <!-- widget div-->
                    <div>

                        <!-- widget edit box -->
                        <div class="jarviswidget-editbox">
                            <!-- This area used as dropdown edit box -->

                        </div>
                        <!-- end widget edit box -->

                        <!-- widget content -->
                        <div class="widget-body">
                            <?=$message?>
                            <div id="message"></div>

                            <form id="procedure-department-form" class="" method="POST" action="<?= base_url('settings/assign_departmental_procedures') ?>"  novalidate="novalidate">
                                <fieldset>
                                    <div class="form-group">

                                                <label>Department </label>
                                                <input class="form-control rounded" type="hidden"  id="firm_id" name="firm_id" value="<?= isset($firm->firm_id) ? $firm->firm_id : '' ?>">

                                                <select class="form-control" id="department"  name="department" style="width:100%">
                                                    <option value="0" selected="" disabled="">Department</option>
                                                    <?php

                                                    foreach ($departments as $row) {
                                                        $selected = isset($firm->department_id) && $firm->department_id == $row->department_id ? 'selected="selected"' : '';
                                                        echo '<option ' . $selected . ' value="' . $row->department_id . '">' . $row->department_name . '</option>';
                                                    }
                                                    ?>
                                                </select> 
                                            </div>
                                        
                                            <div class="form-group">
                                                <label>Procedure Groups</label>
                                                <select class="form-control" name="procedure_group" id="procedure_group" style="width:100%">
                                                    <option value="0" selected="" >All Groups </option>
                                                    <?php
                                                    foreach ($procedure_groups as $row) {

                                                    echo '<option ' . $selected . ' value="' . $row->id . '">' . $row->group_name . '</option>';
                                                    }
                                                    ?>

                                                </select>
                                            </div>
                                    <?php
                                    /*foreach ($procedure_groups as $row) {

                                        echo '<option  value="' . $row->id . '">' . $row->group_name . '</option>';
                                    }*/
                                    ?>
                                        
                                </fieldset>

                                <select name="procedure_dual[]" id="initializeDuallistbox" multiple="multiple" size="10">
                                    <?php
                                    foreach ($procedures as $row) {
                                        $selected = isset($rpl_procedures->procedure_id) && $rpl_procedures->procedure_id == $row->id ? 'selected="selected"' : '';
                                        echo '<option ' . $selected . ' value="' . $row->id . '">' . $row->rpl_code . ':' . $row->procedure_name . '</option>';
                                    }
                                    ?>

                                </select>
                                <hr>
                                <footer>
                                    <button type="reset" class="btn btn-warning">
                                        Clear
                                    </button>
                                    <button type="submit"  class="btn btn-primary">
                                        <i class="fa fa-save" ></i>   Save
                                    </button>
                                </footer>
                                <!--<button type="submit" class="btn btn-success btn-block">Submit data</button>-->
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
                        <h2>Departmental Procedures </h2>

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

                            <table id="procedure_department" class="table table-striped table-bordered" >

                                <thead>
                                    <tr>
                                        <th class="hasinput" style="width:15%">
                                            <input type="text" class="form-control" placeholder="Department" />
                                        </th>
                                        <th class="hasinput" style="width:15%">
                                            <input type="text" class="form-control" placeholder="RPL Codes" />
                                        </th>
                                        <th class="hasinput" style="width:25%">
                                            <input type="text" class="form-control" placeholder="Procedures" />
                                        </th>                                       
                                        <th style="width:15%"></th>
                                        <th style="width:15%"></th>
                                    </tr>
                                    <tr>
                                        <th >Department</th>
                                        <th >RPL Code</th>
                                        <th >Procedure</th>                                        
                                        <th >Service Fee</th>
                                        
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