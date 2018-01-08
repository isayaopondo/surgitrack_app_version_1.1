<header id="header">
                        <!--<span id="logo"></span>-->

    <div id="logo-group">
        <span id="logo"> <img src="<?= base_url() ?>assets/img/logo.png" alt="SurgiTrack"> </span>
    </div>

    <span id="extr-page-header-space"> <span class="hidden-mobile hiddex-xs">Need an account?</span> <a
                href="<?= base_url('auth/login') ?>" class="btn btn-danger">Login</a> </span>

</header>
<div id="main" role="main">

    <!-- MAIN CONTENT -->
    <div id="content" class="container">

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-8 hidden-xs hidden-sm">
                <h1 class="txt-color-red "><span class="login-header-big">SurgiTrack</span>
                </h1>
                <h3 class="txt-color-red "> <span class="page-title">
                       A Surgical Workflow, <br> System
                    </span></h3>
                <div class="hero">

                    <div class="pull-left login-desc-box-l">
                        <h4 class="paragraph-header">It's Okay to be Smart. Experience the simplicity of SurgiTrack,
                            everywhere you go!</h4>

                    </div>

                    <img src="<?= base_url() ?>assets/img/demo/iphoneview.png" class="pull-right display-image" alt=""
                         style="width:210px">

                </div>

            </div>
            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
                <section>
                        <div id="infoMessage"><?php echo $message; ?></div>
                    </section>
                <div class="well no-padding">
                    <form action="<?php echo site_url("auth/forgot_password"); ?>" method="POST"  id="login-form" class="smart-form client-form">
                        <header>
                            Forgot Password
                        </header>

                        <fieldset>

                            <section>
                                <label class="label">Enter your email address</label>
                                <label class="input"> <i class="icon-append fa fa-envelope"></i>
                                    <input type="email" placeholder="Enter email" autocomplete="off" required name="email">
                                    <b class="tooltip tooltip-top-right"><i class="fa fa-envelope txt-color-teal"></i> Please enter email address for password reset</b></label>
                            </section>
                            <section>
                                <span class="timeline-seperator text-center text-primary"> <span class="font-sm">OR</span> 
                            </section>
                            <section>

                                <div class="note">
                                    <a href="<?= base_url('auth/login') ?>">I remembered my password!</a>
                                </div>
                            </section>

                        </fieldset>
                        <footer>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-refresh"></i> Reset Password
                            </button>
                        </footer>
                    </form>

                </div>

                <h5 class="text-center"> - Or sign in using -</h5>

                <ul class="list-inline text-center">
                    <li>
                        <a href="<?= base_url('hauth/login/Facebook') ?>" class="btn btn-primary btn-circle"><i class="fa fa-facebook"></i></a>
                    </li>
                    <li>
                        <a href="<?= base_url('hauth/login/Google') ?>" class="btn btn-danger btn-circle"><i class="fa fa-google"></i></a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="btn btn-warning btn-circle"><i class="fa fa-linkedin"></i></a>
                    </li>
                </ul>

            </div>
        </div>
    </div>

</div>