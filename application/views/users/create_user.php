<!-- START @PAGE CONTENT -->
<section id="page-content">

    <!-- Start page header -->
    <div class="header-content">
        <h2><i class="fa fa-users"></i>ICCM Dashboard <span><?php echo lang('create_user_heading'); ?></span></h2>
        <div class="breadcrumb-wrapper hidden-xs">
            <span class="label">You are here:</span>
            <ol class="breadcrumb">
                <li class="active"><?= lang('create_user_subheading') ?></li>
            </ol>
        </div>
    </div><!-- /.header-content -->
    <!--/ End page header -->

    <!-- Start body content -->
    <div class="body-content animated fadeIn">

        <div id="infoMessage"><?php echo $message; ?></div>

        <?php echo form_open("auth/create_user"); ?>

        <p>
            <?php echo lang('create_user_fname_label', 'first_name'); ?> <br />
            <?php echo form_input($first_name); ?>
        </p>

        <p>
            <?php echo lang('create_user_lname_label', 'last_name'); ?> <br />
            <?php echo form_input($last_name); ?>
        </p>

        <?php
        if ($identity_column !== 'email') {
            echo '<p>';
            echo lang('create_user_identity_label', 'identity');
            echo '<br />';
            echo form_error('identity');
            echo form_input($identity);
            echo '</p>';
        }
        ?>

        <p>
            <?php echo lang('create_user_company_label', 'company'); ?> <br />
            <?php echo form_input($company); ?>
        </p>

        <p>
            <?php echo lang('create_user_email_label', 'email'); ?> <br />
            <?php echo form_input($email); ?>
        </p>

        <p>
            <?php echo lang('create_user_phone_label', 'phone'); ?> <br />
            <?php echo form_input($phone); ?>
        </p>

        <p>
            <?php echo lang('create_user_password_label', 'password'); ?> <br />
            <?php echo form_input($password); ?>
        </p>

        <p>
            <?php echo lang('create_user_password_confirm_label', 'password_confirm'); ?> <br />
            <?php echo form_input($password_confirm); ?>
        </p>


        <p><?php echo form_submit('submit', lang('create_user_submit_btn')); ?></p>

        <?php echo form_close(); ?>

    </div><!-- /.body-content -->
    <!--/ End body content -->
</section>
<!-- /#page-content -->
<!--/ END PAGE CONTENT -->