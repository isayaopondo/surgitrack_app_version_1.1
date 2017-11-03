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
                        <form id="procedure-department-form" class="" method="POST" action="<?= base_url('settings/assign_departmental_procedures') ?>"  novalidate="novalidate">
                            <fieldset>
                                <div class="form-group">
                                    <label>Department </label>
                                    <input class="form-control rounded" type="hidden"  id="firm_id" name="firm_id" value="<?= isset($firm->firm_id) ? $firm->firm_id : '' ?>">

                                    <select class="form-control" name="department" style="width:100%">
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
                                    <label>Category</label>
                                    <select class="form-control" name="category" id="procedure_category" style="width:100%">
                                        <option value="0" selected="" >All Category</option>
                                        <?php
                                        foreach ($category as $row) {
                                            $selected = isset($booking->category_id) && $booking->category_id == $row->category_id ? 'selected="selected"' : '';
                                            echo '<option ' . $selected . ' value="' . $row->category_id . '">' . $row->category_name . '</option>';
                                        }
                                        ?>

                                    </select>
                                </div>

                            </fieldset>

                            <select name="procedure_dual[]" id="initializeDuallistbox" multiple="multiple" size="10">
                                <?php
                                foreach ($procedures as $row) {
                                    $selected = isset($rpl_procedures->procedure_id) && $rpl_procedures->procedure_id == $row->procedure_id ? 'selected="selected"' : '';
                                    echo '<option ' . $selected . ' value="' . $row->procedure_id . '">' . $row->procedure_name . '</option>';
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

                        <table id="" class="table table-striped table-bordered" >

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