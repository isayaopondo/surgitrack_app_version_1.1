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
                <i class="fa-fw fa fa-flask"></i> 
                NAPPI Codes
                <span> 
                    Product/Consumable 
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
            <article class="col-sm-12 col-md-12 col-lg-3">

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
                                <div id="infoMessage"><?= $message ?></div>
                            </section>
                            <form id="checkout-form"method="POST" action="<?= base_url('settings/add_nappi_consumable') ?>" class="smart-form" novalidate="novalidate">
                                <fieldset>
                                   <section>
                                        <label>Product Name</label>
                                        <input type="hidden" name="consumable_id" id="consumable_id" class="form-control " value="<?= !empty($nappi_consumable) ? $nappi_consumable->consumable_id : '' ?>" >
                                        <label for="product_name" class="input">
                                            <input type="text" name="product_name" id="product_name" placeholder="Product Name" value="<?=isset($nappi_consumable->product_name)?$nappi_consumable->product_name:''?>">
                                        </label>
                                    </section>
                                    <section>
                                        <label>Pack</label>
                                        <label for="pack" class="input">
                                            <input type="text" name="pack" id="pack" placeholder="Pack" value="<?=isset($nappi_consumable->pack)?$nappi_consumable->pack:''?>">
                                        </label>
                                    </section>
                                    <section>
                                        <label>Nappi Code</label>
                                        <label for="nappi_code" class="input">
                                            <input type="text" name="nappi_code" id="nappi_code" placeholder="Nappi Code" value="<?=isset($nappi_consumable->nappi_code)?$nappi_consumable->nappi_code:''?>">
                                        </label>
                                    </section>
                                    <section>
                                        <label>Price</label>
                                        <label for="slot_name" class="input">
                                            <input type="text" name="price" id="price" placeholder="Unit Price" value="<?=isset($nappi_consumable->price)?$nappi_consumable->price:''?>">
                                        </label>
                                    </section>
                                    <section>
                                        <label>MNF Code</label>
                                        <label for="mnf_code" class="input">
                                            <input type="text" name="mnf_code" id="mnf_code" placeholder="MNF code" value="<?=isset($nappi_consumable->mnf_code)?$nappi_consumable->mnf_code:''?>">
                                        </label>
                                    </section>
                                   
                                </fieldset>
                                <fieldset>
                                    <section>
                                        <label>Description</label>
                                        <label class="textarea"> 										
                                            <textarea rows="3" name="product_description" placeholder="Description "><?= isset($nappi_consumable->product_description) ? $nappi_consumable->product_description : '' ?></textarea> 
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
            <article class="col-sm-12 col-md-12 col-lg-9">

                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-deletebutton="false"
                     data-widget-fullscreenbutton="false">
                   
                    <header>
                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                        <h2>NAPPI CODES </h2>

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

                            <table id="nappi_consumables" class="table table-striped table-bordered" >

                                <thead>
                                    <tr>
                                        <th class="hasinput" style="width:30%">
                                            <input type="text" class="form-control" placeholder="Filter Product" />
                                        </th>
                                        <th class="hasinput" style="width:10%">
                                            <input type="text" class="form-control" placeholder="Filter  Code" />
                                        </th>
                                        <th style="width:15%"></th>
                                        <th style="width:20%"></th>
                                        <th></th>
                                        <th></th>
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