<!-- RIBBON -->
<div id="ribbon">

    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>

    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>Home</li><li>Settings</li><li>Procedure Categories</li>
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
                <i class="fa-fw fa fa-plus-square"></i> 
                Settings
                <span>>  
                    Procedure Categories
                </span>
            </h1>
        </div>
        <!-- end col -->

        <!-- right side of the page with the sparkline graphs -->
        <!-- col -->
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
            <!-- sparks -->
            
            <!-- end sparks -->
        </div>
        <!-- end col -->

    </div>
    <!-- end row -->

    <!-- widget grid -->
    <section id="widget-grid" class="">


        <!-- START ROW -->

        <div class="row">

            <!-- NEW COL START -->
            <article class="col-sm-12 col-md-12 col-lg-6">

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
                        <h2>Add/Edit Procedure Category Details </h2>				

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

                            <form id="checkout-form" method="POST" action="<?= base_url('settings/create_category')?>" class="smart-form" novalidate="novalidate">
                                <fieldset>

                                    <section>
                                           <input class="form-control rounded" type="hidden"  id="procedure_id" name="procedure_id" value="<?=isset($category->category_id)?$category->category_id:''?>">
                                        <label for="address2" class="input">
                                            <input type="text" name="category_name" id="procedure_name" placeholder="Category Name" value="<?=isset($category->category_name)?$category->category_name:''?>">
                                        </label>
                                    </section>

                                </fieldset>
                                <fieldset>
                                    <section>
                                        <label class="textarea"> 										
                                            <textarea rows="3" name="category_description" placeholder="Additional info"><?=isset($category->category_description)?$category->category_description:''?></textarea> 
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
            <article class="col-sm-12 col-md-12 col-lg-6">

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
                        <h2>Procedure Category List </h2>

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

                            <table id="surg_category" class="table table-striped table-bordered" width="100%">

                                <thead>
                                    <tr>
                                        <th class="hasinput" style="width:30%">
                                            <input type="text" class="form-control" placeholder="Filter Category" />
                                        </th>
                                        <th class="hasinput" style="width:50%">
                                        </th>
                                        <th></th> 
                                    </tr>
                                    <tr>
                                        <th>Category</th>
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