<!-- RIBBON -->
<div id="ribbon">

    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>

    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>Home</li><li>Settings</li><li> RPL Procedures - Consummables</li>
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
                RPL Procedure Codes
                <span>>  
                    Nappi Codes
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
            <article class="col-sm-12 col-md-12 col-lg-4">

                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-deletebutton="false"
                     data-widget-fullscreenbutton="false">

                    <header>
                        <span class="widget-icon"> <i class="fa fa-edit"></i> </span>
                        <h2>Add Consumables to RPL Procedures  </h2>				

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
                            <form id="checkout-form"method="POST" action="<?= base_url('settings/add_rpl_procedurecodes') ?>" class="smart-form" novalidate="novalidate">
                                <fieldset>

                                    <section >
                                        <label>Procedure</label>
                                        <label class="select">
                                            <select name="procedure" id="procedure" disabled="" class="disabled">
                                                <option value="0" selected="" disabled="">Procedure</option>
                                                <?php
                                                foreach ($procedures as $row) {
                                                    $selected = isset($rpl_procedures->procedure_id) && $rpl_procedures->procedure_id == $row->procedure_id ? 'selected="selected"' : '';
                                                    echo '<option ' . $selected . ' value="' . $row->procedure_id . '">' . $row->procedure_name . '</option>';
                                                }
                                                ?>

                                            </select>  <i></i> </label>
                                    </section>
                                    <section>
                                        <label>RPL Code</label>
                                        <label for="rpl_code" class="input">
                                            <input type="text" disabled="" name="rpl_code" id="rpl_code" placeholder="RPL Code" class="disabled" value="<?= isset($rpl_procedures->rpl_code) ? $rpl_procedures->rpl_code : '' ?>">
                                        </label>
                                    </section>
                                    <section >
                                        
                                        <div id="messages"></div>
                                        <input class="form-control rounded" type="hidden"  id="rpl_id" name="rpl_id" value="<?= isset($rpl_procedures->procedure_id) ? $rpl_procedures->procedure_id : '' ?>">
                                        <label>Consumable</label>
                                        <label class="select">
                                            <select name="rpl_nappi_consumables" id="rpl_nappi_consumables"  class="select2">
                                                <optgroup label="Consumables">
                                                    <?php
                                                    foreach ($consumables as $row) {
                                                        $selected = isset($rpl_procedures->consumable_id) && $rpl_procedures->consumable_id == $row->consumable_id ? 'selected="selected"' : '';
                                                        echo '<option ' . $selected . ' value="' . $row->consumable_id . '">' . $row->nappi_code . ' ' . $row->product_name . '</option>';
                                                    }
                                                    ?>
                                                </optgroup>
                                            </select>  <i></i> </label>
                                    </section>
                                </fieldset>

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
            <article class="col-sm-12 col-md-12 col-lg-8">

                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-deletebutton="false"
                     data-widget-fullscreenbutton="false">

                    <header>
                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                        <h2>Consumables </h2>

                    </header>

                    <!-- widget div-->
                    <div>

                        <!-- widget edit box -->
                        <div class="jarviswidget-editbox">
                            <!-- This area used as dropdown edit box -->
<div id="errormessage"></div>
                        </div>
                        <!-- end widget edit box -->

                        <!-- widget content -->
                        <div class="widget-body no-padding">
                           
                            <table id="rpl_nappi_codes" class="table table-striped table-bordered" >

                                <thead>
                                    <tr>
                                        <th class="hasinput" style="width:20%">
                                            <input type="text" class="form-control" placeholder="Filter Product" />
                                        </th>
                                        <th class="hasinput" style="width:10%">
                                            <input type="text" class="form-control" placeholder="Filter  Code" />
                                        </th>
                                        <th style="width:10%"></th>
                                        <th style="width:10%"></th>
                                        <th style="width:10%"></th>
                                        <th style="width:20%"></th>
                                        <th style="width:10%"></th>
                                    </tr>
                                    <tr>
                                        <th data-class="expand">Product Name</th>
                                        <th data-hide="phone">Nappi Code</th>
                                        <th data-hide="phone">Pack</th>
                                        <th data-hide="phone">Price</th>
                                        <th data-hide="phone,tablet">MNF Code</th>
                                        <th data-hide="phone,tablet">Description</th>
                                        <th data-hide="phone,tablet">Action</th>
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