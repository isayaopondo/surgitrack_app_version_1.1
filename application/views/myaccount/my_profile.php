<!-- START @PAGE CONTENT -->
<section id="page-content">
    <!-- Start page header -->
    <div class="header-content">
        <h2><i class="fa fa-bank"></i>Member's Details <span> </span></h2>
        <div class="breadcrumb-wrapper hidden-xs">
            <span class="label">You are here:</span>
            <ol class="breadcrumb">
                <li ><a class="fa fa-home" href="<?= URL ?>"></a> /</li>
                <li class="active"><a  href="<?= URL ?>">Reports</a> /</li>
                <li class="active"><a  href="#">Members View</a></li>
            </ol>
        </div>
    </div><!-- /.header-content -->
    <!--/ End page header -->

    <!-- Start body content -->
    <div class="body-content animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="panel rounded shadow panel-default">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">
                                <?= $pid_details->title_name . ' ' . $pid_details->first_name . ' ' . $pid_details->middle_name . ' ' . $pid_details->surname ?> (<?= $pid_details->serial_no ?>) 
                                <a href="<?= site_url('members/new_members/' . $pid_details->members_id); ?>" title="Edit" ><i class="btn btn-success  fa fa-edit rounded"></i></a>  
                            </h3>
                        </div>

                        <div class="clearfix"></div>
                    </div><!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="panel panel-theme rounded shadow">
                                    <div class="panel-heading">
                                        <div class="pull-left">
                                            <h3 class="panel-title">Person</h3>
                                        </div>
                                        <div class="pull-right">
                                        </div>
                                        <div class="clearfix"></div>
                                    </div><!-- /.panel-heading -->
                                    <div class="panel-body no-padding rounded">
                                        <ul class="list-group no-margin">
                                            <li class="list-group-item"><i class="fa fa-calendar-minus-o "></i> <strong>Serial Number:</strong><?= $pid_details->serial_no ?></li>
                                            <li class="list-group-item"><i class="fa fa-genderless mr-5"></i><strong>Gender:</strong> <?= $pid_details->gender ?></li>
                                        </ul>
                                        
                                    </div><!-- /.panel-body -->
                                </div><!-- /.panel -->
                            </div>
                            <div class="col-md-4">
                                <div class="panel panel-theme rounded shadow">
                                    <div class="panel-heading">
                                        <div class="pull-left">
                                            <h3 class="panel-title">Bank Details</h3>
                                        </div>
                                        <div class="pull-right">
                                        </div>
                                        <div class="clearfix"></div>
                                    </div><!-- /.panel-heading -->
                                    <div class="panel-body no-padding rounded">
                                        <ul class="list-group no-margin">
                                            <li class="list-group-item"><i class="fa fa-money mr-5"></i><strong> Payment Method:</strong> <?= isset($pid_details->payment_method_text) ? $pid_details->payment_method_text : 'None' ?></li>
                                            <li class="list-group-item"><i class="fa fa-bank mr-5"></i> <strong>Bank:</strong> <?= isset($pid_details->bank) ? $pid_details->bank : 'None' ?></li>
                                            <li class="list-group-item"><i class="fa fa-building mr-5"></i> <strong>Branch:</strong>  <?= isset($pid_details->branch) ? $pid_details->bank : 'None' ?></li>
                                            <li class="list-group-item"><i class="fa fa-meanpath mr-5"></i> <strong>Account#:</strong>  <?= isset($pid_details->account) ? $pid_details->account : 'None' ?></li>

                                        </ul>
                                    </div><!-- /.panel-body -->
                                </div><!-- /.panel -->

                            </div>

                            <div class="col-md-4">
                                <div class="panel panel-theme rounded shadow">
                                    <div class="panel-heading">
                                        <div class="pull-left">
                                            <h3 class="panel-title">Contacts</h3>
                                        </div>
                                        <div class="pull-right">
                                        </div>
                                        <div class="clearfix"></div>
                                    </div><!-- /.panel-heading -->
                                    <div class="panel-body no-padding rounded">
                                        <ul class="list-group no-margin">                                            
                                            <li class="list-group-item"><i class="fa fa-phone mr-5"></i><strong>Phone:</strong> <?= $pid_details->mobile ?></li>
                                            <li class="list-group-item"><i class="fa fa-envelope mr-5"></i><strong>Email:</strong> <?= $pid_details->email ?></li>                                            
                                            <li class="list-group-item"><i class="fa fa-facebook mr-5"></i><strong>Facebook:</strong> <?= $pid_details->facebook ?></li>
                                            <li class="list-group-item"><i class="fa fa-skype mr-5"></i><strong>Skype:</strong> <?= $pid_details->skype ?></li>
                                        </ul>
                                    </div><!-- /.panel-body -->
                                </div><!-- /.panel -->
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Start panel with toolbar -->

        <!-- Start sample table -->
        <div class="row">
            <div class="col-md-4 col-sm-6">
                                <div class="panel panel-theme rounded shadow">
                                    <div class="panel-heading">
                                        <div class="pull-left">
                                            <h3 class="panel-title">Next Of Kin</h3>
                                        </div>
                                        <div class="pull-right">
                                        </div>
                                        <div class="clearfix"></div>
                                    </div><!-- /.panel-heading -->
                                    <div class="panel-body no-padding rounded">
                                        <ul class="list-group no-margin">                                            
                                            <li class="list-group-item"><i class="fa fa-phone mr-5"></i><strong>Phone:</strong> <?= $pid_details->mobile ?></li>
                                            <li class="list-group-item"><i class="fa fa-envelope mr-5"></i><strong>Email:</strong> <?= $pid_details->email ?></li>                                            
                                            <li class="list-group-item"><i class="fa fa-facebook mr-5"></i><strong>Facebook:</strong> <?= $pid_details->facebook ?></li>
                                            <li class="list-group-item"><i class="fa fa-skype mr-5"></i><strong>Skype:</strong> <?= $pid_details->skype ?></li>
                                        </ul>
                                    </div><!-- /.panel-body -->
                                </div><!-- /.panel -->
                            </div>
            <div class="col-md-4 col-sm-6">

                <!-- Start button panel -->
                <div class="panel">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Financial Statement</h3>
                        </div>
                        <div class="pull-right">
                            <a href="<?= site_url()?>finance/statements/<?=$pid_details->members_id?>" class="btn btn-sm btn-danger">View All <i class="fa fa-external-link"> </i></a>
                        </div>
                        <div class="clearfix"></div>
                    </div><!-- /.panel-heading -->
                    <div class="panel-body">
                        Financial Contribution Summary
                    </div><!-- /.panel-body -->
                </div><!-- /.panel -->
                <!--/ End button panel -->

            </div>
            <div class="col-md-4 col-sm-6">

                <!-- Start button panel -->
                <div class="panel">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Group Activities</h3>
                        </div>
                        <div class="pull-right">
                            <a href="<?= base_url('members/view/regional_activities/' . $pid_details->members_id) ?>" class="btn btn-sm btn-danger">View All<i class="fa fa-external-link"> </i></a>
                        </div>
                        <div class="clearfix"></div>
                    </div><!-- /.panel-heading -->
                    <div class="panel-body">
                        Regional Activities Summary
                    </div><!-- /.panel-body -->
                </div><!-- /.panel -->
                <!--/ End button panel -->

            </div>
            
        </div>



        <div class="row">
            <div class="col-md-12 col-sm-6">
                <div class="clearfix"></div>
            </div>
        </div>

    </div><!-- /.body-content -->
    <!--/ End body content -->
</section>
<!-- /#page-content -->
<!--/ END PAGE CONTENT -->

