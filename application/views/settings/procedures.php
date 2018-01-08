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
            <article class="col-sm-12 col-md-12 col-lg-12">

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