<header id="header">

    <div id="logo-group">
        <span id="logo"> <img src="<?= base_url() ?>assets/img/logo.png" alt="SurgiTrack"> </span>
    </div>

    <span id="extr-page-header-space"> <span class="hidden-mobile hidden-xs">Need an account?</span> <a
                href="<?= base_url('auth/register') ?>" class="btn btn-danger">Create account</a> </span>

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

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <h5 class="about-heading">About SurgiTrack - Are you up to date?</h5>
                        <p>
                            Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
                            laudantium, totam rem aperiam, eaque ipsa.
                        </p>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <h5 class="about-heading">Not just your average template!</h5>
                        <p>
                            Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta
                            nobis est eligendi voluptatem accusantium!
                        </p>
                    </div>
                </div>

            </div>
            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
                <div class="well no-padding">
                    <?php
                    defined('BASEPATH') OR exit('No direct script access allowed');

                    if (!isset($on_hold_message)) {
                        ?>

                        <section>
                            <div id="infoMessage"><?= isset($login_error_mesg) ? 'Login Error #' . $this->authentication->login_errors_count . '/' . config_item('max_allowed_attempts') . ': Invalid Username, Email Address, or Password.' : ''; ?>
                                <?= isset($error_message) ? $error_message:''?>
                            </div>
                        </section>
                        <!--<form action="< // $login_url; ?>" method="POST" id="login-form"
                              class="smart-form client-form std-form">-->
                        <?= form_open($login_url, ['class' => 'smart-form client-form std-form']); ?>
                        <header>
                            Login
                        </header>

                        <fieldset>

                            <section>
                                <label class="label">E-mail</label>
                                <label class="input"> <i class="icon-append fa fa-user"></i>
                                    <input type="text" name="login_string" id="login_string" autocomplete="off"
                                           maxlength="255">
                                    <b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i>
                                        Please enter email address/username</b></label>
                            </section>

                            <section>
                                <label class="label">Password</label>
                                <label class="input"> <i class="icon-append fa fa-lock"></i>
                                    <input type="password" name="login_pass" id="login_pass" <?php
                                    if (config_item('max_chars_for_password') > 0)
                                        echo 'maxlength="' . config_item('max_chars_for_password') . '"';
                                    ?> autocomplete="off" readonly="readonly"
                                           onfocus="this.removeAttribute('readonly');">
                                    <b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i>
                                        Enter your password</b> </label>
                                <div class="note">
                                    <a href="<?= base_url('auth/recover') ?>">Forgot password?</a>
                                </div>
                            </section>

                            <section>
                                <?php
                                if (config_item('allow_remember_me')) {
                                    ?>
                                    <label class="checkbox">
                                        <input type="checkbox" name="remember_me" id="remember_me" checked=""
                                               value="yes">
                                        <i></i>Stay signed in</label>
                                    <?php
                                }
                                ?>
                            </section>
                        </fieldset>
                        <footer>
                            <input type="submit" name="submit" value="Login" id="submit_button"
                                   class="btn btn-primary"/>

                        </footer>
                        </form>
                        <?php

                    } else {
                        // EXCESSIVE LOGIN ATTEMPTS ERROR MESSAGE
                        echo '<div style="border:1px solid red; padding: 10px;"> <section>
                                    <p>
                                       <h1>Excessive Login Attempts</h1> 
                                    </p>
                                    <p>
                                        You have exceeded the maximum number of failed login attempts that this website will allow.
                                    <p>
                                    <p>
                                        Your access to login and account recovery has been blocked for <b>' . ((int)config_item('seconds_on_hold') / 60) . ' minutes</b>.
                                    </p>
                                    <p>
                                        Please use the <a href="' . base_url() . '/auth/recover">Account Recovery</a> after ' . ((int)config_item('seconds_on_hold') / 60) . ' minutes has passed,  or administrator if you require assistance gaining access to your account.
                                    </p>
                                </section></div>
                            ';
                    } ?>

                </div>

                <h5 class="text-center"> - Or sign in using -</h5>

                <ul class="list-inline text-center">
                    <li>
                        <a href="<?= base_url('hauth/login/Facebook') ?>" class="btn btn-primary btn-circle"><i
                                    class="fa fa-facebook"></i></a>
                    </li>
                    <li>
                        <a href="<?= base_url('hauth/login/Google') ?>" class="btn btn-danger btn-circle"><i
                                    class="fa fa-google"></i></a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="btn btn-warning btn-circle"><i class="fa fa-linkedin"></i></a>
                    </li>
                </ul>
                <div class="list-inline text-center">

                </div>
            </div>
        </div>
    </div>

</div>
