<!-- row -->
<section id="widget-grid" class="">

    <!-- row -->
    <div class="row">

        <!-- NEW COL START -->
        <article class="col-sm-12 col-md-12 col-lg-4">

            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-deletebutton="false"
                 data-widget-fullscreenbutton="false">

                <header>
                    <span class="widget-icon"> <i class="fa fa-edit"></i> </span>
                    <h2>Add/Edit Users Details </h2>

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
                        <form id="checkout-form"method="POST" action="<?= base_url('setup/create_user') ?>" class="smart-form" novalidate="novalidate">
                            <fieldset>
                                <section >
                                    <input class="form-control rounded" type="hidden"  id="user_id" name="user_id" value="<?= isset($user->user_id) ? $user->user_id : '' ?>">
                                    <input class="form-control rounded" type="hidden"  id="facility" name="facility" value="<?= isset($auth_facilityid) ? $auth_facilityid : '' ?>">
                                    <label>First Name </label>
                                    <label for="address2" class="input">
                                        <input type="text" name="first_name" id="first_name" placeholder="First Name" value="<?= isset($user->first_name) ? $user->first_name : '' ?>">
                                    </label>
                                </section>
                                <section >
                                    <label>Last Name</label>
                                    <label for="address2" class="input">
                                        <input type="text" name="last_name" id="last_name" placeholder="Last name" value="<?= isset($user->last_name) ? $user->last_name : '' ?>">
                                    </label>
                                </section>
                                <section >
                                    <label>Phone Number</label>
                                    <label for="address2" class="input">
                                        <input type="text" name="phone_number" id="phone_number" placeholder="Phone Number" value="<?= isset($user->phone_number) ? $user->phone_number : '' ?>">
                                    </label>
                                </section>
                                <section >
                                    <label>Email</label>
                                    <label for="address2" class="input">
                                        <input type="text" name="email" id="email" placeholder="Email" value="<?= isset($user->email) ? $user->email : '' ?>">
                                    </label>
                                </section>
                                <section >
                                    <label>Department </label>

                                    <label class="select">
                                        <select name="department" id="user_department">
                                            <option value="0" selected="" disabled="">Department</option>
                                            <?php
                                            foreach ($departments as $row) {
                                                $selected = isset($user->department_id) && $user->department_id == $row->department_id ? 'selected="selected"' : '';
                                                echo '<option ' . $selected . ' value="' . $row->department_id . '">' . $row->department_name . '</option>';
                                            }
                                            ?>
                                        </select> <i></i> </label>
                                </section>
                                <section >
                                    <label>Firm </label>
                                    <label class="select">
                                        <select name="firm" id="user_firm">
                                            <option value="0" selected="" disabled="">Firms</option>

                                        </select> <i></i> </label>
                                </section>
                                <section >
                                    <label>Role</label>
                                    <label class="select">
                                        <select name="auth_level">
                                            <option value="0" selected="" disabled="">Role</option>
                                            <?php
                                            foreach ($roles as $key=>$value) {
                                                $selected = isset($user->auth_level) && $user->auth_level == $key ? 'selected="selected"' : '';
                                                echo '<option ' . $selected . ' value="' . $key . '">' . strtoupper($value) . '</option>';
                                            }
                                            ?>
                                        </select> <i></i> </label>
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
        <!-- NEW WIDGET START -->
        <article class="col-sm-8 col-md-8 col-lg-8">
            <!-- new widget -->
            <div class="jarviswidget jarviswidget-color-blueDark">

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
                                    . ' <td>'.strtoupper($roles[$row->auth_level]). '</td>'
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
