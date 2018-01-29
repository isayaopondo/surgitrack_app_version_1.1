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

    <span id="extr-page-header-space"> <span class="hidden-mobile hidden-xs"></span> <a
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

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <h5 class="about-heading">About SurgiTrack </h5>
                        <p>
                            SurgiTrack is  a surgical workflow System
                        </p>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <h5 class="about-heading">For Facility Admin</h5>
                        <p>
                            To create a facility account click <a href="https://accounts.surgitrack.co.za">HERE</a>
                        </p>
                    </div>
                </div>

            </div>
            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
                <div class="well ">

                    <?php

                    $showform = 1;

                    if (isset($validation_errors)) {
                        echo '
		<div style="border:1px solid red;">
			<p>
				The following error occurred while changing your password:
			</p>
			
			<ul>
				' . $validation_errors . '
			</ul>
			<p>
				PASSWORD NOT UPDATED
			</p>
		</div>
	';
                    } else {
                        $display_instructions = 1;
                    }

                    if (isset($validation_passed)) {
                        echo '
                            <div style="border:1px solid green;">
                                <p>
                                    
                                    <div class="alert alert-success fade in">
                                                        <button class="close" data-dismiss="alert">
                                                                ×
                                                        </button>
                                                        <i class="fa-fw fa fa-check"></i>
                                                        <strong>Success!</strong> You have successfully changed your password.
                                                </div>
                                </p>
                                <p>
                                    You can now <a href="'.base_url().'auth/login">login</a>
                                </p>
                            </div>
                        ';

                        $showform = 0;
                    }
                    if (isset($recovery_error)) {
                        echo '
		<div style="border:1px solid red;">
			
			<div class="alert alert-danger fade in">
                                    <button class="close" data-dismiss="alert">
                                            ×
                                    </button>
                                    <i class="fa-fw fa fa-check"></i>
                                    <strong>Error!</strong> <p>
				No usable data for account recovery.
			</p>
                            </div>
			<p>
				Account recovery links expire after 
				' . ((int)config_item('recovery_code_expiration') / (60 * 60)) . ' 
				hours.<br />You will need to use the 
				<a href="'.base_url().'auth/recover">Account Recovery</a> form 
				to send yourself a new link.
			</p>
		</div>
	';

                        $showform = 0;
                    }
                    if (isset($disabled)) {
                        echo '
		<div style="border:1px solid red;">
			<p>
				Account recovery is disabled.
			</p>
			<p>
				You have exceeded the maximum login attempts or exceeded the 
				allowed number of password recovery attempts. 
				Please wait ' . ((int)config_item('seconds_on_hold') / 60) . ' 
				minutes, or contact us if you require assistance gaining access to your account.
			</p>
		</div>
	';

                        $showform = 0;
                    }
                    if ($showform == 1) {
                        if (isset($recovery_code, $user_id)) {
                            if (isset($display_instructions)) {
                                echo '<div class="">';
                                if (isset($username)) {
                                    echo '<p>
					Your login user name is <i>' . $username . '</i><br />
					Please write this down, and change your password now:
				</p>';
                                } else {
                                    echo '<p>Please set your password now:</p>';
                                }
                                echo '</div>';
                            }

                            ?>
                            <div id="form">
                                <?php echo form_open('',array('class'=>'smart-form')); ?>
                                <fieldset>
                                    <legend>Set your  password</legend>
                                    <div>
                                        <section>
                                            <label class="input">
                                                <?php
                                                // PASSWORD LABEL AND INPUT ********************************
                                                echo form_label('Password', 'passwd', ['class' => 'form_label']);

                                                $input_data = [
                                                    'name' => 'passwd',
                                                    'id' => 'passwd',
                                                    'class' => 'form_input password',
                                                    'max_length' => config_item('max_chars_for_password')
                                                ];
                                                echo form_password($input_data);
                                                ?>
                                            </label>

                                        </section>
                                    </div>
                                    <div>
                                        <section>
                                            <label class="input">
                                                <?php
                                                // CONFIRM PASSWORD LABEL AND INPUT ******************************
                                                echo form_label('Confirm Password', 'passwd_confirm', ['class' => 'form_label']);

                                                $input_data = [
                                                    'name' => 'passwd_confirm',
                                                    'id' => 'passwd_confirm',
                                                    'class' => 'form_input password',
                                                    'max_length' => config_item('max_chars_for_password')
                                                ];
                                                echo form_password($input_data);
                                                ?>
                                            </label>
                                        </section>
                                    </div>
                                    <div>
                                        <section>
                                            <small>
                                                <b>NOTE: Password MUST be;</b>
                                                <ul>
                                                    <li>At least 8 characters long.</li>
                                                    <li>A mix of Upper Case and Lower Case letters.</li>
                                                    <li>Add Numbers or Special Characters [#,$,%,&...] to make it strong. [Optional] </li>
                                                </ul>
                                            </small>
                                        </section>
                                    </div>
                                </fieldset>
                                <div>
                                    <div>
                                        <footer>

                                            <?php
                                            // RECOVERY CODE *****************************************************************
                                            echo form_hidden('recovery_code', $recovery_code);

                                            // USER ID *****************************************************************
                                            echo form_hidden('user_identification', $user_id);

                                            // SUBMIT BUTTON **************************************************************
                                            $input_data = [
                                                'name' => 'form_submit',
                                                'id' => 'submit_button',
                                                'value' => 'Set Password',
                                                'class'=>"btn btn-primary"
                                            ];
                                            echo form_submit($input_data);
                                            ?>
                                        </footer>
                                    </div>
                                </div>
                                </form>
                            </div>
                            <?php
                        }
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>

</div>