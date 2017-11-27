<!-- RIBBON -->
<div id="ribbon">



    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>Home</li><li>Users</li><li>Change Password</li>
    </ol>
    <!-- end breadcrumb -->


</div>
<!-- END RIBBON -->

<!-- MAIN CONTENT -->
<div id="content">
    <!-- row -->
    <section id="widget-grid" class="">

        <!-- row -->
        <div class="row">

            <!-- NEW WIDGET START -->
            <article class="col-sm-12 col-md-12 col-lg-12">
                <!-- new widget -->
                <div class="jarviswidget jarviswidget-color-blueDark">

                    <header>
                        <span class="widget-icon"> <i class="fa fa-lock"></i> </span>
                        <h2>Change Password </h2>
                        <div class="widget-toolbar">
                            <!-- add: non-hidden - to disable auto hide -->

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
                            <div class="row">


                                <div class="col-md-3">
                                </div>
                                    <div class="col-md-6">
                                    <div class="well no-padding">
                                        <section>
                                            <div id="infoMessage"><?php echo $message; ?></div>
                                        </section>
                                        <form action="<?php echo site_url("users/password_change"); ?>" method="POST" id="login-form" class="smart-form client-form">
                                            <header>
                                                Change Password
                                            </header>
                                            <fieldset>
                                                <section>
                                                    <label class="label">CurrentPassword</label>
                                                    <label class="input"> <i class="icon-append fa fa-lock"></i>
                                                        <input type="password" name="old_password">
                                                        <b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> Enter your new password</b> </label>
                                                </section>
                                                <section>
                                                    <label class="label">New Password</label>
                                                    <label class="input"> <i class="icon-append fa fa-lock"></i>
                                                        <input type="password" name="new_password">
                                                        <b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> Enter your new password</b> </label>
                                                </section>
                                                <section>
                                                    <label class="label">Confirm Password</label>
                                                    <label class="input"> <i class="icon-append fa fa-lock"></i>
                                                        <input type="password" name="new_confirm_password">
                                                        <b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> Confirm your password</b> </label>
                                                     </section>
                                            </fieldset>
                                            <footer>
                                                <button type="submit" class="btn btn-primary">
                                                    Change Password
                                                </button>
                                            </footer>
                                        </form>


                                    </div>

                                </div>
                                <div class="col-md-3">
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </article>

        </div>

        <!-- end row -->
    </section>


</div>
<!-- END MAIN CONTENT -->