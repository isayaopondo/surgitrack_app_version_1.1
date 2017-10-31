<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Community Auth - Recover Form View
 *
 * Community Auth is an open source authentication application for CodeIgniter 3
 *
 * @package     Community Auth
 * @author      Robert B Gottier
 * @copyright   Copyright (c) 2011 - 2017, Robert B Gottier. (http://brianswebdesign.com/)
 * @license     BSD - http://www.opensource.org/licenses/BSD-3-Clause
 * @link        http://community-auth.com
 */
?>

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
                        Department of Urology, <br> Tygerberg Hospital
                    </span></h3>
                <div class="hero">

                    <div class="pull-left login-desc-box-l">
                        <h4 class="paragraph-header">It's Okay to be Smart. Experience the simplicity of SurgiTrack,
                            everywhere you go!</h4>
                        <div class="login-app-icons">
                            <a href="javascript:void(0);" class="btn btn-danger btn-sm">Frontend Template</a>
                            <a href="javascript:void(0);" class="btn btn-danger btn-sm">Find out more</a>
                        </div>
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
                        <h1 style="padding-left: 15px;">Account Recovery</h1>
                   <hr>
                    <?php
                    if (isset($disabled)) {
                        echo '
                                <div style="padding: 10px;">
                                    <p>
                                       <b>Account Recovery is Disabled.</b> 
                                    </p>
                                    <p>
                                        If you have exceeded the maximum login attempts, or exceeded
                                        the allowed number of password recovery attempts, account recovery 
                                        will be disabled for a short period of time. 
                                        Please wait ' . ((int)config_item('seconds_on_hold') / 60) . ' 
                                        minutes, or contact us if you require assistance gaining access to your account.
                                    </p>
                                </div>
                            ';
                    } else if (isset($banned)) {
                        echo '
                            <div style="padding: 10px;">
                                <p>
                                   <b>Account Locked.</b> 
                                </p>
                                <p>
                                    You have attempted to use the password recovery system using 
                                    an email address that belongs to an account that has been 
                                    purposely denied access to the authenticated areas of this website. 
                                    If you feel this is an error, you may contact us  
                                    to make an inquiry regarding the status of the account.
                                </p>
                            </div>
                        ';
                    } else if (isset($confirmation)) {
                        echo '
                                <div style="padding: 15px;">
                                    <p>
                                        Congratulations, you have created an account recovery link.
                                    </p>
                                    <p>
                                        <b>Please note</b>: The account recovery link would normally be placed in an email, 
                                        and you would not see it here on the screen. This is to limit the code in the 
                                        Examples controller, and keep your focus on learning Community Auth, but give you 
                                        an idea of how to implement account recovery. <b>When you do end up writing code to send 
                                        the recovery link to an email address, you will want to delete it from this view, 
                                        delete these instructions, and instead have a simple message similar to the following</b>:
                                    </p>
                                    <p>
                                        "We have sent you an email with instructions on how 
                                        to recover your account."
                                    </p>
                                    <p>
                                        This is the account recovery link:
                                    </p>
                                    <p>' . $special_link . '</p>
                                </div>
                            ';
                    } else if (isset($no_match)) {
                        echo '
                    <div  style="padding: 15px;">
                        <p class="feedback_header">
                            Supplied email did not match any record.
                        </p>
                    </div>
                ';

                        $show_form = 1;
                    } else {
                        echo '
                            <div  style="padding: 15px;">
                                <p>
                                    If you\'ve forgotten your password and/or username, 
                                    enter the email address used for your account, 
                                    and we will send you an e-mail 
                                    with instructions on how to access your account.
                                </p>
                            </div>
                        ';

                        $show_form = 1;
                    }
                    if (isset($show_form)) {
                        ?>

                        <form action="<?php echo base_url(); ?>" method="POST" id="login-form"
                              class="smart-form client-form">
                            <div>
                                <fieldset>
                                    <legend>Enter your account's email address:</legend>
                                    <div>
                                        <section>
                                            <label class="input"> <i class="icon-append fa fa-envelope"></i>
                                                <input type="text" name="email" id="email" autocomplete="off"
                                                       maxlength="255">
                                                <b class="tooltip tooltip-top-right"><i
                                                            class="fa fa-user txt-color-teal"></i>
                                                    Please enter email address</b></label>
                                        </section>


                                    </div>
                                </fieldset>
                                <footer>
                                    <input type="submit" name="submit" value="Send Email" id="submit_button"
                                           class="btn btn-primary"/>

                                </footer>

                            </div>
                        </form>

                        <?php
                    }
                    /* End of file recover_form.php */
                    /* Location: /community_auth/views/examples/recover_form.php */
                    ?>

                </div>
            </div>
        </div>
    </div>

</div>
