<!-- RIBBON -->
<div id="ribbon">

    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>

    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>Home</li><li>Settings</li><li> RPL Procedures</li>
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
                <i class="fa-fw fa fa-flask"></i> 
                RPL
                <span>>  
                    Procedure Codes
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

                    <header>
                        <span class="widget-icon"> <i class="fa fa-edit"></i> </span>
                        <h2>Add/Edit RPL Procedure Codes </h2>				

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
                            <form id="rpl-procedure-form"method="POST" action="#" class="smart-form" novalidate="novalidate">
                                <fieldset>
                                    <section >
                                        <label>Category</label>
                                        <label class="select">
                                            <select name="category">
                                                <option value="0" selected="" disabled="">Category</option>
                                                <?php
                                                foreach ($category as $row) {
                                                    $selected = isset($booking->category_id) && $booking->category_id == $row->category_id ? 'selected="selected"' : '';
                                                    echo '<option ' . $selected . ' value="' . $row->category_id . '">' . $row->category_name . '</option>';
                                                }
                                                ?>

                                            </select> <i></i> </label>
                                    </section>
                                    <section >
                                        <input class="form-control rounded" type="hidden"  id="rpl_id" name="rpl_id" value="<?= isset($rpl_procedures->rpl_id) ? $rpl_procedures->rpl_id : '' ?>">
                                        <label>Procedure</label>
                                        <label class="select">
                                            <select name="procedure" id="procedure">
                                                <option value="0" selected="" disabled="">Procedure</option>
                                                <?php
                                                foreach ($procedures as $row) {
                                                    $selected = isset($rpl_procedures->procedure_id) && $rpl_procedures->procedure_id == $row->procedure_id ? 'selected="selected"' : '';
                                                    echo '<option ' . $selected . ' value="' . $row->procedure_id . '">' . $row->procedure_name . '</option>';
                                                }
                                                ?>

                                            </select>  <i></i> </label>
                                    </section>
                                    <section >
                                        <label>RPL Code</label>
                                        <label for="rpl_code" class="input">
                                            <input type="text" name="rpl_code" id="rpl_code" placeholder="RPL Code" value="<?= isset($rpl_procedures->rpl_code) ? $rpl_procedures->rpl_code : '' ?>">
                                        </label>
                                    </section>
                                    
                                    <section >
                                        <label>Service Fee</label>
                                        <label for="service_fee" class="input">
                                            <input type="text" name="service_fee" id="service_fee" placeholder="Service Fee" value="<?= isset($rpl_procedures->service_fee) ? $rpl_procedures->service_fee : '' ?>">
                                        </label>
                                    </section>

                                </fieldset>
                                <fieldset>
                                    <section>
                                        <label>Description</label>
                                        <label class="textarea"> 										
                                            <textarea rows="3" name="rpl_description" placeholder="Description"><?= isset($rpl_procedures->rpl_decsription) ? $rpl_procedures->rpl_decsription : '' ?></textarea> 
                                        </label>
                                    </section>
                                </fieldset>


                                <footer>
                                    <button type="reset" class="btn btn-warning">
                                        Clear
                                    </button>
                                    <button type="button" name="save_rpl_procedurecodes" id="save_rpl_procedurecodes" class="btn btn-primary">
                                        Save
                                    </button>
                                    <button type="button" name="save_add_rpl_consumables" id="save_add_rpl_consumables" class="btn btn-success">
                                        Save & Add Consumables
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
                        <h2>RPL CODES </h2>

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

                            <table id="rpl_procedurecodes" class="table table-striped table-bordered" >

                                <thead>
                                    <tr>
                                         <th class="hasinput" style="width:15%">
                                            <input type="text" class="form-control" placeholder="Filter RPL Codes" />
                                        </th>
                                        <th class="hasinput" style="width:25%">
                                            <input type="text" class="form-control" placeholder="Filter Procedures" />
                                        </th>                                       
                                        <th style="width:15%"></th>
                                        <th style="width:30%"></th>
                                        <th style="width:15%"></th>
                                    </tr>
                                    <tr>
                                        <th >RPL Code</th>
                                        <th >Procedure</th>                                        
                                         <th >Service Fee</th>
                                        <th >Description</th>
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