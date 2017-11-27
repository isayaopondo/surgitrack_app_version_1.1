<!-- RIBBON -->
<div id="ribbon">

    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>

    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>Home</li><li>Settings</li><li>Procedures</li>
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
            <article class="col-sm-12 col-md-12 col-lg-3">

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

                            <form id="checkout-form" method="POST" action="<?= base_url('settings/create_procedure') ?>" class="smart-form" novalidate="novalidate">
                                <input class="form-control rounded" type="hidden"  id="procedure_id" name="procedure_id" value="<?= isset($procedure->procedure_id) ? $procedure->procedure_id : '' ?>">
                                <fieldset>
                                    <section >
                                        <label>Procedure Group</label>
                                        <label class="select">
                                            <select name="group_id" id="group_id">
                                                <option value="0" selected="" disabled="">Procedure Group</option>
                                                <?php
                                                foreach ($procedure_groups as $row) {
                                                    $selected = isset($procedure->group_id) && $procedure->group_id == $row->group_id ? 'selected="selected"' : '';
                                                    echo '<option ' . $selected . ' value="' . $row->group_id . '">' . $row->group_name . '</option>';
                                                }
                                                ?>

                                            </select> <i></i> </label>
                                    </section>
                                    <section >
                                        <label>Sub Group</label>
                                        <label class="select">
                                            <select name="sub_group_id" id="sub_group_id">
                                                <option value="0" selected="" disabled="">Sub group</option>
                                                <?php
                                                foreach ($procedure_subgroups as $row) {
                                                    $selected = isset($procedure->subgroup_id) && $procedure->subgroup_id == $row->subgroup_id ? 'selected="selected"' : '';
                                                    echo '<option ' . $selected . ' value="' . $row->subgroup_id . '">' . $row->subgroup_name . '</option>';
                                                }
                                                ?>

                                            </select> <i></i> </label>
                                    </section>

                                    <section >
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
                                    <section>
                                        <label>Procedure Full Name</label>
                                        <label for="address2" class="input">
                                            <input type="text" name="procedure_fullname" id="procedure_fullname" placeholder="Full  Name" value="<?= isset($procedure->procedure_fullname) ? $procedure->procedure_fullname : '' ?>">
                                        </label>
                                    </section>

                                    <section>
                                        <label>Procedure Short Name</label>
                                        <label for="address2" class="input">
                                            <input type="text" name="procedure_name" id="procedure_name" placeholder="Short Name" value="<?= isset($procedure->procedure_name) ? $procedure->procedure_name : '' ?>">
                                        </label>
                                    </section>

                                    <section >
                                        <label>RPL Code</label>
                                        <label for="rpl_code" class="input">
                                            <input type="text" name="rpl_code" id="rpl_code" placeholder="RPL Code" value="<?= isset($procedure->rpl_code) ? $procedure->rpl_code : '' ?>">
                                        </label>
                                    </section>

                                    <section >
                                        <label>Service Fee</label>
                                        <label for="service_fee" class="input">
                                            <input type="text" name="service_fee" id="service_fee" placeholder="Service Fee" value="<?= isset($procedure->service_fee) ? $procedure->service_fee : '' ?>">
                                        </label>
                                    </section>
                                    <section>
                                        <label>Procedure Description</label>
                                        <label class="textarea"> 										
                                            <textarea rows="3" name="procedure_description" placeholder="Additional info"><?= isset($procedure->procedure_description) ? $procedure->procedure_description : '' ?></textarea> 
                                        </label>
                                    </section>

                                </fieldset>

                                <footer>
                                    <button type="reset" class="btn btn-warning">
                                        Clear
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save" ></i>   Save
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
            <article class="col-sm-12 col-md-12 col-lg-9">

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
                        <h2>Procedure List </h2>

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

                            <table id="procedures" class="table table-striped table-bordered" width="100%">

                                <thead>
                                    <tr>
                                        <th class="hasinput" style="width:10%">
                                            <input type="text" class="form-control" placeholder="Filter RPL Code" />
                                        </th>
                                        <th class="hasinput" style="width:20%">
                                            <input type="text" class="form-control" placeholder="Filter Full Name" />
                                        </th>
                                        <th class="hasinput" style="width:20%">
                                            <input type="text" class="form-control" placeholder="Filter Short Title" />
                                        </th>
                                        <th class="hasinput" style="width:10%">
                                            <input type="text" class="form-control" placeholder="Filter Category" />
                                        </th>
                                        <th class="hasinput" style="width:10%">
                                            <input type="text" class="form-control" placeholder="Filter Group" />
                                        </th>
                                        <th class="hasinput" style="width:10%">
                                            <input type="text" class="form-control" placeholder="Filter Subgroup" />
                                        </th>
                                        <th class="hasinput" style="width:5%"> </th>
                                        <th style="width:15%"></th> 
                                    </tr>
                                    <tr>
                                        <th>RPL Code</th>
                                        <th>Full Name</th>
                                        <th>Short Name</th>
                                        <th>Category</th>
                                        <th>Group</th>
                                        <th >Sub Group</th> 
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