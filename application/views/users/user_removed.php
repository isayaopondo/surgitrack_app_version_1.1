<div class="col-sm-4 col-md-4 col-lg-4">
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
                        <h2>Add New User </h2>

                    </header>
                    <div class="widget-body">

                        <div id="infoMessage"><?php echo $message; ?></div>
                        <form action="<?= site_url('users/create_user') ?>" id="add_edit_user_form" class="smart-form" method="POST">
                            <fieldset>
                                <div class="row">
                                    <section class="col col-6">                                       
                                        <input class="form-control rounded" type="hidden" name="userid" id="userid"
                                               value="<?= isset($view->user_id)?$view->user_id:'' ?>"> 
                                        <label class="control-label">First Name</label>
                                        <label for="first_name" class="input">
                                            <input class="form-control rounded" name="first_name" id="first_name"
                                                   value="<?= isset($view->first_name)?$view->first_name:''  ?>" type="text" placeholder="First Name">
                                        </label>
                                    </section>
                                    <section class="col col-6">
                                        <label class="control-label">Last Name</label>
                                        <label for="last_name" class="input">
                                            <input class="form-control rounded" name="last_name" id="last_name"
                                                   value="<?= isset($view->last_name)?$view->last_name:'' ?>" type="text" placeholder="Last Name">
                                        </label>
                                    </section>
                                </div>
                                <div class="row">
                                    <section class="col col-6"> 
                                        <label class="control-label">Email</label>
                                        <label for="last_name" class="input">
                                            <input class="form-control rounded" name="email" id="email"
                                                   value="<?= isset($view->email)?$view->email:'' ?>" type="text" placeholder="Email ">
                                        </label>
                                    </section>
                                    <section class="col col-6">
                                        <label class="control-label">Phone</label>
                                        <label for="last_name" class="input">
                                            <input class="form-control rounded" name="phone" id="phone"
                                                   value="<?= isset($view->phone)?$view->phone:'' ?>" type="text" placeholder="Phone Number">
                                        </label>
                                    </section>
                                </div>

                               


                                <div class="row">
                                     <section class="col col-6"> 
                                    <label class="control-label">User name</label>
                                    <label for="user_name" class="input">
                                        <input class="form-control rounded" name="user_name" id="user_name"
                                               value="<?= isset($view->user_name)?$view->user_name:'' ?>" type="text" placeholder="User name ">
                                    </label>
                                </section>
                                    <section class="col col-6">
                                        <label class="control-label">Password</label>
                                        <label for="last_name" class="input">
                                            <input class="form-control rounded" name="password" id="password" <?= isset($view->password)? 'disabled="disabled"':'' ?>
                                                   value="<?= isset($view->password)?$view->password:'' ?>" type="text" placeholder="PassCode">
                                        </label>
                                    </section>
                                </div>
                                <div class="row">
                                    <section class="col col-6">
                                        <label >User Group</label>
                                        <label  class="select">
                                            <select  name="user_group" id="user_group">
                                                <option value="0" selected="" disabled="">- Choose user group -</option>
                                                <?php
                                                foreach ($usergroups as $row) {
                                                    $selected = isset($view_group->group_id) && $view_group->group_id == $row->group_id ? 'selected="selected"' : '';
                                                    echo '<option ' . $selected . ' value="' . $row->group_id . '">' . $row->description . ' (' . $row->name . ')' . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </label>
                                    </section>

                                
                                    <section class="col col-6">
                                        <label class="control-label">Facility</label>
                                        <input class="form-control rounded" type="hidden"  id="department_id" name="department_id" value="<?= isset($department->department_id) ? $department->department_id : '' ?>">
                                        <label class="select">
                                            <select name="facility">
                                                <option value="0" selected="" disabled="">Facility</option>
                                                <?php
                                                foreach ($facilities as $row) {
                                                    $selected = isset($view->facility_id) && $view->facility_id == $row->facility_id ? 'selected="selected"' : '';
                                                    echo '<option ' . $selected . ' value="' . $row->facility_id . '">' . $row->facility_name . '</option>';
                                                }
                                                ?>
                                            </select> <i></i> </label>
                                    </section>
                                    </div>
                                <div class="row">
                                    <section class="col col-6">
                                        <label class="control-label">Department</label>
                                        <label for="department" class="select">
                                            <select  name="department" id="department">
                                                <option value=""> Department </option>
                                                <?php
                                                foreach ($departments as $row) {
                                                    $selected = isset($view->department_id) && $view->department_id  == $row->department_id ? 'selected="selected"' : '';
                                                    echo '<option ' . $selected . ' value="' . $row->department_id . '">' . $row->department_name . ' </option>';
                                                }
                                                ?>
                                            </select>
                                        </label>
                                    </section>
                                    <section class="col col-6">
                                   <label>Firm</label>
                                    <label class="select">
                                        <select name="firm" id="firm">
                                            <option value="0" selected="" disabled="">Firm</option>
                                            <?php
                                            foreach ($firms as $row) {
                                                $selected = isset($booking->firm_id) && $booking->firm_id == $row->firm_id ? 'selected="selected"' : '';
                                                echo '<option ' . $selected . ' value="' . $row->firm_id . '">' . $row->firm_name . '</option>';
                                            }
                                            ?>
                                        </select> <i></i> </label>
                                </section>

                                </div>
                            </fieldset>


                            <footer>
                                <button type="reset" class="btn btn-danger">
                                    Clear
                                </button>
                                <button type="submit" class="btn btn-success" name="create_user"
                                        value="Create_User">
                                    Save
                                </button>
                            </footer>
                        </form>

                    </div>
                </div>
            </div>


<div class="modal fade" id="modalAddUser" tabindex="-1" role="dialog">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title">
                    <img src="<?= base_url() ?>assets/img/logo.png" width="150" alt="SurgiTrack">
                </h4>
            </div>
            <div class="modal-body ">

                <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-deletebutton="false"
                     data-widget-fullscreenbutton="false">

                    <header>
                        <span class="widget-icon"> <i class="fa fa-bank"></i> </span>
                        <h2>Add New User </h2>

                    </header>

                    <div>

                        <!-- widget edit box -->
                        <div class="jarviswidget-editbox">
                            <!-- This area used as dropdown edit box -->

                        </div>
                        <!-- end widget edit box -->

                        <!-- widget content -->

                        <div id="infoMessage"><?php echo $message; ?></div>
                        <form action="<?= site_url('users/create_user') ?>" id="add_edit_form" class="smart-form" method="POST">
                            <fieldset>
                                <div class="row">
                                    <section class="col col-6">                                       
                                        <input class="form-control rounded" type="hidden" name="userid" id="userid"
                                               value="<?= set_value('user_id') ?>"> 
                                        <label class="control-label">First Name</label>
                                        <label for="first_name" class="input">
                                            <input class="form-control rounded" name="first_name" id="first_name"
                                                   value="<?= set_value('first_name') ?>" type="text" placeholder="First Name">
                                        </label>
                                    </section>
                                    <section class="col col-6">
                                        <label class="control-label">Last Name</label>
                                        <label for="last_name" class="input">
                                            <input class="form-control rounded" name="last_name" id="last_name"
                                                   value="<?= set_value('last_name') ?>" type="text" placeholder="Last Name">
                                        </label>
                                    </section>
                                </div>
                                <div class="row">
                                    <section class="col col-6"> 
                                        <label class="control-label">Email</label>
                                        <label for="last_name" class="input">
                                            <input class="form-control rounded" name="email" id="email"
                                                   value="<?= set_value('email') ?>" type="text" placeholder="Email ">
                                        </label>
                                    </section>
                                    <section class="col col-6">
                                        <label class="control-label">Phone</label>
                                        <label for="last_name" class="input">
                                            <input class="form-control rounded" name="phone" id="phone"
                                                   value="<?= set_value('phone') ?>" type="text" placeholder="Phone Number">
                                        </label>
                                    </section>
                                </div>

                                <section > 
                                    <label class="control-label">User name</label>
                                    <label for="user_name" class="input">
                                        <input class="form-control rounded" name="user_name" id="user_name"
                                               value="<?= set_value('user_name') ?>" type="text" placeholder="User name ">
                                    </label>
                                </section>


                                <div class="row">
                                    <section class="col col-6">
                                        <label class="control-label">Password</label>
                                        <label for="last_name" class="input">
                                            <input class="form-control rounded" name="password" id="password"
                                                   value="<?= set_value('password') ?>" type="text" placeholder="PassCode">
                                        </label>
                                    </section>
                                    <section class="col col-6">
                                        <label class="control-label">User Group</label>
                                        <label for="user_group" class="select">
                                            <select  name="user_group" id="user_group">
                                                <option value="">- Choose user group -</option>
                                                <?php
                                                foreach ($usergroups as $row) {
                                                    $selected = set_value('user_group') == $row->group_id ? 'selected="selected"' : '';
                                                    echo '<option ' . $selected . ' value="' . $row->group_id . '">' . $row->description . ' (' . $row->name . ')' . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </label>
                                    </section>

                                </div>
                                <section >
                                    <label class="control-label">Department</label>
                                    <label for="department" class="select">
                                        <select  name="department" id="department">
                                            <option value="">- Choose department -</option>
                                            <?php
                                            foreach ($departments as $row) {
                                                $selected = set_value('department') == $row->department_id ? 'selected="selected"' : '';
                                                echo '<option ' . $selected . ' value="' . $row->department_id . '">' . $row->department_name . ' </option>';
                                            }
                                            ?>
                                        </select>
                                    </label>
                                </section>
                            </fieldset>


                            <footer>
                                <button type="reset" class="btn btn-danger">
                                    Clear
                                </button>
                                <button type="submit" class="btn btn-success" name="create_user"
                                        value="Create_User">
                                    Save
                                </button>
                            </footer>
                        </form>


                    </div>
                </div>
            </div>


        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
