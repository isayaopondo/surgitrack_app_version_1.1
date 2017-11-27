<!-- START @PAGE CONTENT -->
<section id="page-content">

    <!-- Start page header -->
    <div class="header-content">
        <h2><i class="fa fa-users"></i><?php echo lang('create_group_heading'); ?><span></span></h2>
        <div class="breadcrumb-wrapper hidden-xs">
            <span class="label">You are here:</span>
            <ol class="breadcrumb">
                <li class="active"><?php echo lang('create_group_subheading'); ?></li>
            </ol>
        </div>
    </div><!-- /.header-content -->
    <!--/ End page header -->

    <!-- Start body content -->
    <div class="body-content animated fadeIn">
        <div id="infoMessage"><?php echo $message; ?></div>

        <?php echo form_open("auth/create_group"); ?>

        <p>
            <?php echo lang('create_group_name_label', 'group_name'); ?> <br />
            <?php echo form_input($group_name); ?>
        </p>

        <p>
            <?php echo lang('create_group_desc_label', 'description'); ?> <br />
            <?php echo form_input($description); ?>
        </p>

        <p><?php echo form_submit('submit', lang('create_group_submit_btn')); ?></p>

        <?php echo form_close(); ?>

    </div>
</section>