<header id="header">

    <div id="logo-group">
        <span id="logo"> <img src="<?= base_url() ?>assets/img/logo.png" alt="SurgiTrack"> </span>
    </div>


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
                <div class="well">
                <h3 class="txt-color-red "> <span class="page-title">
                        SELECT A FACILITY TO ACCESS
                    </span></h3>
                    <?php

                    foreach ($facilities as $val) {

                        ?>
                            <div class="well">
                                <a href="<?= base_url('auth/facility_select/'.$val->facility_id) ?>"
                                   class="btn btn-block btn-default btn-success"
                                   type="button">
                                    <i class="fa fa-hospital-o"></i> <?= $val->facility_name ?>
                                </a>
                            </div>


                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>


