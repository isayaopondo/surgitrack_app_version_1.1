<!-- RIBBON -->
<div id="ribbon">

    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh" rel="tooltip"
              data-placement="bottom"
              data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings."
              data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>

    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>Home</li>
        <li>Settings</li>
        <li>Procedures</li>
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
            <article class="col-sm-12 col-md-12 col-lg-12">

                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false"
                     data-widget-custombutton="false" data-widget-deletebutton="false"
                     data-widget-fullscreenbutton="false">

                    <header>
                        <span class="widget-icon"> <i class="fa fa-edit"></i> </span>
                        <h2>Add/Edit Procedure Details </h2>

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

                            <form id="checkout-form" method="POST" action="<?= base_url('settings/create_facility_procedure') ?>"
                                  class="smart-form" novalidate="novalidate">
                                <input class="form-control rounded" type="hidden" id="procedure_id" name="procedure_id"
                                       value="<?= isset($procedure->procedure_id) ? $procedure->procedure_id : '' ?>">
                                <fieldset>
                                    <div class="row">
                                        <section class="col col-4">
                                            <label>Procedure Group</label>
                                            <label class="select">
                                                <select name="group_id" id="group_id">
                                                    <option value="0" selected="" disabled="">Procedure Group</option>
                                                    <?php
                                                    foreach ($procedure_groups as $row) {
                                                        $selected = isset($procedure->group_id) && $procedure->group_id == $row->id ? 'selected="selected"' : '';
                                                        echo '<option ' . $selected . ' value="' . $row->id . '">' . $row->group_name . '</option>';
                                                    }
                                                    ?>

                                                </select> <i></i> </label>
                                        </section>
                                        <section class="col col-4">
                                            <label>Sub Group</label>
                                            <label class="select">
                                                <select name="sub_group_id" id="sub_group_id">
                                                    <option value="0" selected="" disabled="">Sub group</option>
                                                    <?php
                                                    foreach ($procedure_subgroups as $row) {
                                                        $selected = isset($procedure->subgroup_id) && $procedure->subgroup_id == $row->id ? 'selected="selected"' : '';
                                                        echo '<option ' . $selected . ' value="' . $row->id . '">' . $row->sub_group_name . '</option>';
                                                    }
                                                    ?>

                                                </select> <i></i> </label>
                                        </section>

                                        <section class="col col-4">
                                            <label>Category</label>
                                            <label class="select">
                                                <select name="category" id="category">
                                                    <option value="0" selected="" disabled="">Category</option>
                                                    <?php
                                                    foreach ($category as $row) {
                                                        $selected = isset($procedure->category_id) && $procedure->category_id == $row->category_id ? 'selected="selected"' : '';
                                                        echo '<option ' . $selected . ' value="' . $row->category_id . '">' . $row->category_name . '</option>';
                                                    }
                                                    ?>

                                                </select> <i></i> </label>
                                        </section>
                                    </div>
                                    <div class="row">
                                        <section class="col col-6">

                                            <label>Procedure Name</label>
                                            <label for="address2" class="input">
                                                <input type="text" name="procedure_name" id="procedure_name"
                                                       placeholder="Procedure  Name"
                                                       value="<?= isset($procedure->procedure_name) ? $procedure->procedure_name : '' ?>">
                                            </label>
                                        </section>

                                        <section class="col col-6">
                                            <label>Procedure Alias Name</label>
                                            <label for="address2" class="input">
                                                <input type="text" name="alias_name" id="alias_name"
                                                       placeholder="Alias Name"
                                                       value="<?= isset($procedure->alias_name) ? $procedure->alias_name : '' ?>">
                                            </label>
                                        </section>
                                    </div>
                                    <div class="row">
                                        <section class="col col-6">
                                       <label>RPL Code</label>
                                        <label for="rpl_code" class="input">
                                            <input type="text" name="rpl_code" id="rpl_code" placeholder="RPL Code"
                                                   value="<?= isset($procedure->rpl_code) ? $procedure->rpl_code : '' ?>">
                                        </label>
                                    </section>

                                        <section class="col col-6">
                                        <label>Service Fee</label>
                                        <label for="service_fee" class="input">
                                            <input type="text" name="service_fee" id="service_fee"
                                                   placeholder="Service Fee"
                                                   value="<?= isset($procedure->service_fee) ? $procedure->service_fee : '' ?>">
                                        </label>
                                    </section>
                                    </div>

                                    <div class="row">
                                        <section class="col col-6">
                                            <label>Department</label>
                                            <label class="select">
                                                <select class="form-control" id="department"  name="department" style="width:100%">
                                                    <option value="0" selected="" disabled="">Department</option>
                                                    <?php
                                                    foreach ($departments as $row) {
                                                        $selected = isset($procedure->department_id) && $procedure->department_id == $row->department_id ? 'selected="selected"' : '';
                                                        echo '<option ' . $selected . ' value="' . $row->department_id . '">' . $row->department_name . '</option>';
                                                    }
                                                    ?>
                                                </select>  <i></i> </label>
                                        </section>
                                        <section class="col col-6">
                                            <label>Version</label>
                                            <label class="select">
                                                <select name="sub_group_id" id="sub_group_id">
                                                    <option value="0" selected="" disabled="">Version</option>
                                                    <?php
                                                    foreach ($procedure_subgroups as $row) {
                                                        $selected = isset($procedure->subgroup_id) && $procedure->subgroup_id == $row->subgroup_id ? 'selected="selected"' : '';
                                                        echo '<option ' . $selected . ' value="' . $row->subgroup_id . '">' . $row->subgroup_name . '</option>';
                                                    }
                                                    ?>

                                                </select> <i></i> </label>
                                        </section>


                                    </div>
                                    <section>
                                        <label>Procedure Description</label>
                                        <label class="textarea">
                                            <textarea rows="3" name="procedure_description"
                                                      placeholder="Additional info"><?= isset($procedure->procedure_description) ? $procedure->procedure_description : '' ?></textarea>
                                        </label>
                                    </section>

                                </fieldset>

                                <footer>
                                    <button type="reset" class="btn btn-warning">
                                        Clear
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i> Save
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


        </div>

        <!-- END ROW -->

    </section>
    <!-- end widget grid -->

</div>
<!-- END MAIN CONTENT -->