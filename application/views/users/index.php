<!-- RIBBON -->
<div id="ribbon">

    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>Home</li><li>Users</li><li>List</li>
    </ol>
    <!-- end breadcrumb -->

    <!-- You can also add more buttons to the
    ribbon for further usability

    Example below:
    -->
    <span class="ribbon-button-alignment pull-right">
        <span id="search" class="btn btn-ribbon hidden-xs" data-title="search"><i class="fa fa-table"></i> Change Grid</span>
        <span id="add" class="btn btn-ribbon hidden-xs" data-title="add"><i class="fa fa-plus"></i> Add</span>
        <span id="search" class="btn btn-ribbon" data-title="search"><i class="fa fa-search"></i> <span class="hidden-mobile">Search</span></span>
    </span> 

</div>
<!-- END RIBBON -->

<!-- MAIN CONTENT -->
<div id="content">
    <!-- row -->
    <section id="widget-grid" class="">

        <!-- row -->
        <div class="row">

            <!-- NEW WIDGET START -->
            <article class="col-sm-8 col-md-8 col-lg-12">
                <!-- new widget -->
                <div class="jarviswidget jarviswidget-color-blueDark">

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
                        <span class="widget-icon"> <i class="fa fa-users"></i> </span>
                        <h2>Users List </h2>
                        <div class="widget-toolbar">
                            <!-- add: non-hidden - to disable auto hide -->
                            <!--<div class="btn-group">
                                <button data-toggle="modal" href="#modalAddUser" class="btn btn-success pull-right " >
                                    <i class="fa fa-user"></i>     New User 
                                </button>
                            </div>-->
                        </div>
                    </header>

                    <!-- widget div-->
                    <div>
                        <!-- widget edit box -->
                        <div class="jarviswidget-editbox">
                            <!-- This area used as dropdown edit box -->

                        </div>
                        <!-- end widget edit box -->

                        <div class="widget-body">
                            <table class="display projects-table table table-striped  table-hover" width="100%" id="datatable_tabletools">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th style="width:20%;">Name</th>
                                        <th>Email</th>
                                        <th>Department</th>
                                        <th>Level/Role</th>
                                        <th style="width:15%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $c = 0;
                                    foreach ($users as $row) {
                                        $c++;
                                        echo '<tr>'
                                        . ' <td>' . $c . '</td>'
                                        . ' <td>' . $row->first_name . ' ' . $row->last_name . '</td>'
                                        . ' <td>' . $row->email . '</td>'
                                        . ' <td>' . $row->department_name . '</td>'
                                        . ' <td>' . $row->description . ' (' . $row->name . ') </td>'
                                        . '<td>
                                            <div class="btn-group">
                                            <a href="' . site_url("users/usersmanage/" . $row->user_id) . '" class="btn btn-success btn-xs rounded" data-toggle="tooltip" data-placement="top" data-original-title="View detail"><i class="fa fa-eye"></i></a>
                                            <a href="' . site_url('users/index/' . $row->user_id) . '" class="btn btn-primary btn-xs rounded add_edit" data-toggle="tooltip" data-placement="top" data-original-title="Edit" id="' . $row->user_id . '"><i class="fa fa-pencil"></i></a>
                                            <a href="' . site_url('users/delete_user/' . $row->user_id) . '" class="btn btn-danger btn-xs rounded" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-times"></i></a>
                                            </div>
                                            </td>'
                                        . ' </tr>';
                                    }
                                    ?>

                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </article>
            

        </div>

        <!-- end row -->
    </section>


</div>
<!-- END MAIN CONTENT -->


