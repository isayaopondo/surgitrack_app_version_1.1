<!-- RIBBON -->
<div id="ribbon">

    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>

    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>Home</li><li>Users</li><li>Profile</li>
    </ol>
    <!-- end breadcrumb -->


</div>
<!-- END RIBBON -->

<!-- MAIN CONTENT -->
<div id="content">
    <!-- row -->

    <div class="row">

        <div class="col-sm-12">
            <div class="row">

                <div class="col-sm-12 col-md-12 col-lg-8">
                    <div class="well  well-sm no-margin no-padding">

                        <div class="row">

                            <div class="col-sm-12">
                                <div id="myCarousel" class="carousel fade profile-carousel">
                                    <div class="air air-bottom-right padding-10">
                                        <a href="javascript:void(0);" data-toggle="modal"  data-target="#myModalEditDetails" class="btn txt-color-white bg-color-teal btn-sm"><i class="fa fa-lock"></i> Change Password</a>
                                        <a href="javascript:void(0);" data-toggle="modal"  data-target="#myModalEditDetails" class="btn txt-color-white bg-color-teal btn-sm"><i class="fa fa-pencil"></i> Edit Profile</a>&nbsp; <a href="javascript:void(0);" class="btn txt-color-white bg-color-pinkDark btn-sm"><i class="fa fa-link"></i> Connect</a>
                                    </div>
                                    <div class="air air-top-left padding-10">
                                        <h4 class="txt-color-white font-md"><?= date('M d, Y'); ?></h4>
                                    </div>
                                    <ol class="carousel-indicators">
                                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                                        <li data-target="#myCarousel" data-slide-to="1" class=""></li>
                                        <li data-target="#myCarousel" data-slide-to="2" class=""></li>
                                    </ol>
                                    <div class="carousel-inner">
                                        <!-- Slide 1 -->
                                        <div class="item active">
                                            <img src="<?= base_url() ?>assets/img/demo/s1.jpg" alt="demo user">
                                        </div>
                                        <!-- Slide 2 -->
                                        <div class="item">
                                            <img src="<?= base_url() ?>assets/img/demo/s2.jpg" alt="demo user">
                                        </div>
                                        <!-- Slide 3 -->
                                        <div class="item">
                                            <img src="<?= base_url() ?>assets/img/demo/m3.jpg" alt="demo user">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">

                                <div class="row">

                                    <div class="col-sm-3 profile-pic">

                                        <div class="padding-10">
                                            <h4 class="font-md"><strong><?= isset($user_stats['participated']) ? $user_stats['participated'] : 0 ?></strong>
                                                <br>
                                                <small>Cases Booked</small></h4>
                                            <br>
                                            <h4 class="font-md"><strong><?= isset($user_stats['created']) ? $user_stats['created'] : 0 ?></strong>
                                                <br>
                                                <small>Cases Done</small></h4>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <h1> <?= isset($myprofile->first_name) ? $myprofile->first_name. ' '.$myprofile->last_name : '' ?> <span class="semi-bold"></span>
                                            <br>
                                            <small> <?= isset($myprofile->user_portfolio) ? $myprofile->user_portfolio : '' ?></small></h1>

                                        <ul class="list-unstyled">
                                            <li>
                                                <p class="text-muted">
                                                    <i class="fa fa-phone"></i>&nbsp;&nbsp; <span class="txt-color-darken"><?= $myprofile->phone_number ?></span>
                                                </p>
                                            </li>
                                            <li>
                                                <p class="text-muted">
                                                    <i class="fa fa-envelope"></i>&nbsp;&nbsp;<a href="mailto:<?= $myprofile->email ?>"><?= $myprofile->email ?></a>
                                                </p>
                                            </li>


                                        </ul>
                                        <br>
                                        <p class="font-md">
                                            <i>A little about me...</i>
                                        </p>
                                        <p>
                                            <?= isset($myprofile->more_info) ? $myprofile->more_info : '' ?>
                                        </p>
                                        <br>
                                        <a href="javascript:void(0);" class="btn btn-default btn-xs"><i class="fa fa-envelope-o"></i> Send Message</a>
                                        <br>
                                        <br>

                                    </div>
                                    <div class="col-sm-3">
                                        <h1><small></small></h1>
                                        <ul class="list-inline ">

                                            <li>
                                             </li>
                                        </ul>

                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-4">
                    <section>
                        <div  class="alert alert-info"><?php echo $message; ?></div>
                    </section>
                    <div class="well  padding-10">

                        <h5 class="margin-top-0"><i class="fa fa-hospital-o"></i> Facility   </h5>
                        <div class="panel panel-default">
                            <div class="panel-body status smart-form vote">

                                <ul class="comments">
                                    <?php
                                    foreach ($myfacilities as $row) {
                                        echo '<li> <i class="fa fa-check-square-o "></i> ' . $row->facility_name . '</li>';
                                    }
                                    ?>

                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="well  padding-10">
                        <h5 class="margin-top-0"><i class="fa fa-building"></i> Department   </h5>
                        <div class="panel panel-default">
                            <div class="panel-body status smart-form vote ">

                                <ul class="comments">
                                    <?php
                                    if (isset($mydepartment)) {
                                        echo '<li> <i class="fa fa-check-square-o "></i> ' . $mydepartment->department_name . '</li>';
                                    }
                                    ?>

                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- /well -->
                    <div class="well padding-10">
                        <h5 class="margin-top-0"><i class="success fa fa-users "></i> MY FIRMS/TEAMS   </h5>

                        <div class="panel panel-default">
                            <div class="panel-body status smart-form vote">
                                <div class="comments">
                                    <?php
                                    if (!empty($my_departmentalfirms) && $my_departmentalfirms != '') {
                                        foreach ($my_departmentalfirms as $row) {
                                            $iscurrent = ($row['current_user'] == '1') ? 'checked="checked"' : '';
                                            $approved = ($row['approved'] == '1') ? ' <small>     (Approved) </small>' : ' ';
                                            echo '<div class="radio">
                                        <label>
                                            <input class="radiobox style-3" ' . $iscurrent . ' name="firm" type="radio" onclick="default_firm(\'' . $row['firm_id'] . '\',\'' . $row['user_id'] . '\',\'' . $row['firm_name'] . '\',\'' . $row['department_id'] . '\')">
                                             <span>' . $row['firm_name'] . '  ' . $approved . '</span> 
                                        </label>
                                    </div>';
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /well -->
                </div>
            </div>

        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="myModalEditDetails" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title">
                    <img src="<?= base_url() ?>assets/img/logo.png" width="150" alt="SurgiTrack">
                </h4>
            </div>
            <div class="modal-body no-padding">
                <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-deletebutton="false"
                     data-widget-fullscreenbutton="false">

                    <header>
                        <span class="widget-icon"> <i class="fa fa-user"></i> </span>
                        <h2>Profile Update  </h2>

                    </header>

                    <section>
                        <div id="infoMessage"><?php echo $message; ?></div>
                    </section>
                    <form id="checkout-form" method="POST" action="<?= base_url('index.php/users/update_users') ?>" class="smart-form" novalidate="novalidate">

                        <fieldset>
                            <div class="row">
                                <section class="col col-6">
                                    <label>First Name</label>
                                    <label class="input">
                                        <input type="text" name="first_name" placeholder="First name"  value="<?= isset($myprofile->first_name) ? $myprofile->first_name : '' ?>"myprofile>
                                    </label>
                                </section>
                                <section class="col col-6">
                                    <label>Last Name</label>
                                    <label class="input">
                                        <input type="text" name="last_name" placeholder="Last name" value="<?= isset($myprofile->last_name) ? $myprofile->last_name : '' ?>">
                                    </label>
                                </section>
                            </div>

                            <section>
                                <label>Portfolio</label>
                                <label class="textarea"> 										
                                    <textarea rows="3" name="user_portfolio" placeholder="Portfolio"><?= isset($myprofile->user_portfolio) ? $myprofile->user_portfolio : '' ?></textarea> 
                                </label>
                            </section>
                        </fieldset>
                        <fieldset>
                            <div class="row">
                                <section class="col col-6">
                                    <label>Phone</label>
                                    <label class="input"> <i class="icon-append fa fa-user"></i>
                                        <input type="text" name="phone" placeholder="Phone" value="<?= isset($myprofile->phone) ? $myprofile->phone : '' ?>">
                                        <b class="tooltip tooltip-bottom-right">Needed to enter the portal</b> </label>
                                </section>

                                <section class="col col-6">
                                    <label>Email</label>
                                    <label class="input"> <i class="icon-append fa fa-envelope"></i>
                                        <input type="email" name="email" placeholder="Email address" value="<?= isset($myprofile->email) ? $myprofile->email : '' ?>" readonly="">
                                        <b class="tooltip tooltip-bottom-right">Needed to verify your account</b> </label>
                                </section>

                            </div>

                            <section >
                                <label>More about me..</label>
                                <label class="textarea"> 
                                    <textarea rows="3" name="more_info" placeholder="More about me.."><?= isset($myprofile->more_info) ? $myprofile->more_info : '' ?></textarea> 

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
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->





<!-- Modal -->
<div class="modal fade" id="myModalAddFacilty" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title">
                    <img src="<?= base_url() ?>assets/img/logo.png" width="150" alt="SurgiTrack">
                </h4>
            </div>
            <div class="modal-body no-padding">
                <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-deletebutton="false"
                     data-widget-fullscreenbutton="false">

                    <header>
                        <span class="widget-icon"> <i class="fa fa-user"></i> </span>
                        <h2>Add Facilities  </h2>

                    </header>

                    <section>
                        <div id="infoMessage"><?php echo $message; ?></div>

                    </section>
                    <form id="checkout-form" method="POST" action="<?= base_url('users/create_user_facilities') ?>" class="smart-form" novalidate="novalidate">

                        <fieldset>
                            <section >
                                <input class="form-control rounded" type="hidden"  id="facility_id" name="facility_id" value="<?= isset($facilty->facility_id) ? $facilty->facility_id : '' ?>">
                                <label class="select">
                                    <select name="facility">
                                        <option value="0" selected="" disabled="">Facility</option>
                                        <?php
                                        foreach ($facilities as $row) {
                                            $selected = isset($facilty->facility_id) && $facilty->facility_id == $row->facility_id ? 'selected="selected"' : '';
                                            echo '<option ' . $selected . ' value="' . $row->facility_id . '">' . $row->facility_name . '</option>';
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
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- Modal -->
<div class="modal fade" id="myModalAddFirm" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title">
                    <img src="<?= base_url() ?>assets/img/logo.png" width="150" alt="SurgiTrack">
                </h4>
            </div>
            <div class="modal-body no-padding">
                <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-deletebutton="false"
                     data-widget-fullscreenbutton="false">

                    <header>
                        <span class="widget-icon"> <i class="fa fa-user"></i> </span>
                        <h2>Add Firms  </h2>

                    </header>

                    <section>
                        <div id="infoMessage"><?php echo $message; ?></div>
                    </section>
                    <form id="checkout-form" method="POST" action="<?= base_url('index.php/users/create_firms_users') ?>" class="smart-form" novalidate="novalidate">

                        <fieldset>

                            <section >
                                <input class="form-control rounded" type="hidden"  id="firm_id" name="firm_id" value="<?= isset($firm->firm_id) ? $firm->firm_id : '' ?>">
                                <label class="select">
                                    <select name="department" id="firm_department">
                                        <option value="0" selected="" disabled="">Department</option>
                                        <?php
                                        foreach ($mydepartments as $row) {
                                            $selected = isset($firm->department_id) && $firm->department_id == $row->department_id ? 'selected="selected"' : '';
                                            echo '<option ' . $selected . ' value="' . $row->department_id . '">' . $row->department_name . '</option>';
                                        }
                                        ?>
                                    </select> <i></i> </label>
                            </section>
                            <section >
                                <input class="form-control rounded" type="hidden"  id="firm_id" name="firm_id" value="<?= isset($firm->firm_id) ? $firm->firm_id : '' ?>">
                                <label class="select">
                                    <select name="firm" id="firm">
                                        <option value="0" selected="" disabled="">Firms</option>
                                        <?php
                                        foreach ($myfirms as $row) {
                                            $selected = isset($firm->firm_id) && $firm->firm_id == $row->firm_id ? 'selected="selected"' : '';
                                            echo '<option ' . $selected . ' value="' . $row->firm_id . '">' . $row->firm_name . '</option>';
                                        }
                                        ?>
                                    </select> <i></i> </label>
                            </section>

                            <section >
                                <label class="radio">

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
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="myModalAddDepartment" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title">
                    <img src="<?= base_url() ?>assets/img/logo.png" width="150" alt="SurgiTrack">
                </h4>
            </div>
            <div class="modal-body no-padding">
                <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-deletebutton="false"
                     data-widget-fullscreenbutton="false">

                    <header>
                        <span class="widget-icon"> <i class="fa fa-user"></i> </span>
                        <h2>Add Firms  </h2>

                    </header>

                    <section>
                        <div id="infoMessage"><?php echo $message; ?></div>
                    </section>
                    <form id="create_department" method="POST" action="#" class="smart-form" novalidate="novalidate">

                        <fieldset>

                            <section >
                                <input class="form-control rounded" type="hidden"  id="department_id" name="department_id" value="<?= isset($department->department_id) ? $department->department_id : '' ?>">
                                <label class="select">
                                    <select name="facility" id="department_facility">
                                        <option value="0" selected="" disabled="">Facility</option>
                                        <?php
                                        foreach ($facilities as $row) {
                                            $selected = isset($department->facility_id) && $department->facility_id == $row->facility_id ? 'selected="selected"' : '';
                                            echo '<option ' . $selected . ' value="' . $row->facility_id . '">' . $row->facility_name . '</option>';
                                        }
                                        ?>
                                    </select> <i></i> </label>
                            </section>
                            <section >
                                <label class="select">
                                    <select name="department" id="department">
                                        <option value="0" selected="" disabled="">Department</option>
                                        <?php
                                        foreach ($mydepartments as $row) {
                                            $selected = isset($department->department_id) && $department->department_id == $row->department_id ? 'selected="selected"' : '';
                                            echo '<option ' . $selected . ' value="' . $row->department_id . '">' . $row->department_name . '</option>';
                                        }
                                        ?>
                                    </select> <i></i> </label>
                            </section>

                        </fieldset>

                        <footer>
                            <button type="reset" class="btn btn-warning">
                                Clear
                            </button>
                            <button type="button" class="btn btn-primary" id="create_department_users">
                                Save Affiliation
                            </button>
                        </footer>
                    </form>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="myModalAddAffiliations" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title">
                    <img src="<?= base_url() ?>assets/img/logo.png" width="150" alt="SurgiTrack">
                </h4>
            </div>
            <div class="modal-body no-padding">
                <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-deletebutton="false"
                     data-widget-fullscreenbutton="false">

                    <header>
                        <span class="widget-icon"> <i class="fa fa-user"></i> </span>
                        <h2>Add Firms  </h2>

                    </header>

                    <section>
                        <div id="infoMessage"><?php echo $message; ?></div>
                    </section>
                    <form id="affiliations" method="POST" action="#" class="smart-form" novalidate="novalidate">

                        <fieldset>

                            <section >
                                <input class="form-control rounded" type="hidden"  id="department_id" name="department_id" value="<?= isset($department->department_id) ? $department->department_id : '' ?>">
                                <label class="select">
                                    <select name="facility" id="department_facility1">
                                        <option value="0" selected="" disabled="">Facility</option>
                                        <?php
                                        foreach ($facilities as $row) {
                                            $selected = isset($department->facility_id) && $department->facility_id == $row->facility_id ? 'selected="selected"' : '';
                                            echo '<option ' . $selected . ' value="' . $row->facility_id . '">' . $row->facility_name . '</option>';
                                        }
                                        ?>
                                    </select> <i></i> </label>
                            </section>
                            <section >
                                <label class="select">
                                    <select name="department_id" id="department1">
                                        <option value="0" selected="" disabled="">Department</option>
                                        <?php
                                        foreach ($mydepartments as $row) {
                                            $selected = isset($department->department_id) && $department->department_id == $row->department_id ? 'selected="selected"' : '';
                                            echo '<option ' . $selected . ' value="' . $row->department_id . '">' . $row->department_name . '</option>';
                                        }
                                        ?>
                                    </select> <i></i> </label>
                            </section>

                        </fieldset>

                        <footer id="affiliations_buttons">
                            <button type="reset" class="btn btn-warning">
                                Clear
                            </button>
                            <button type="button" class="btn btn-primary" id="affiliations_users">
                                Save Affiliation
                            </button>
                        </footer>
                    </form>

                    <section>
                        <div id="firmdetails"></div>
                    </section>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->