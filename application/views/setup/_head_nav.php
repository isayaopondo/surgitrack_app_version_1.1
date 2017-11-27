<!-- MAIN CONTENT -->
<div id="content">
    <!-- row -->
    <div class="row">

        <!-- col -->
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
            <h1 class="page-title txt-color-blueDark">

                <!-- PAGE HEADER -->
                <i class="fa-fw fa fa-hospital-o"></i>
                Initial Setup
                <span>>
                    Facility
                </span>
            </h1>

        </div>
        <!-- end col -->

        <!-- right side of the page with the sparkline graphs -->
        <!-- col -->
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">

        </div>
        <!-- end col -->

    </div>
    <!-- end row -->


    <div class="row">

        <div class="col-sm-2">
            <!-- /well -->
            <div class="well padding-10">
                <h5 class="margin-top-0"><i class="fa fa-list"></i> SETUP STEPS</h5>
                <div class="row">

                    <div class="col-lg-12">

                        <nav>
                            <ul>
                                <li class="<?= ($this->router->fetch_class() == 'setup' ) && ($this->router->fetch_method() == 'my_setup' ) ? 'active' : '' ?>">
                                    <a href="<?= base_url() ?>setup/my_setup" title="Summary"><i class="fa fa-lg fa-fw fa-home"></i>General <?=$sstats['sstatus']?></a>
                                </li>
                                <li class="<?= ($this->router->fetch_class() == 'setup' ) && ($this->router->fetch_method() == 'departments' ) ? 'active' : '' ?>">
                                    <a href="<?= base_url() ?>setup/departments" title="Departments"><i class="fa fa-lg fa-fw fa-hospital-o"></i>Departments <?=$sstats['sdepartments']?></a>
                                </li>
                                <li class="<?= ($this->router->fetch_class() == 'setup' ) && ($this->router->fetch_method() == 'firms' ) ? 'active' : '' ?>">
                                    <a href="<?= base_url() ?>setup/firms" ><i class="fa fa-lg fa-fw fa-hospital-o"></i>Firms <?=$sstats['sfirms']?></a>
                                </li>
                                <li class="<?= ($this->router->fetch_class() == 'setup' ) && ($this->router->fetch_method() == 'wards' ) ? 'active' : '' ?>">
                                    <a href="<?= base_url() ?>setup/wards"><i class="fa fa-lg fa-fw fa-bed"></i> Wards/Location <?=$sstats['swards']?></a>
                                </li>
                                <li class="<?= ($this->router->fetch_class() == 'setup' ) && ($this->router->fetch_method() == 'theatres' ) ? 'active' : '' ?>">
                                    <a href="<?= base_url() ?>setup/theatres"><i class="fa fa-lg fa-fw fa-scissors"></i> Theatres <?=$sstats['stheatres']?></a>
                                <li class="<?= ($this->router->fetch_class() == 'setup' ) && ($this->router->fetch_method() == 'procedures' ) ? 'active' : '' ?>">
                                    <a href="<?= base_url() ?>setup/procedures" ><i class="fa fa-lg fa-fw fa-list-alt"></i> Procedures <?=$sstats['sprocedures']?></a>
                                </li>
                                <li class="<?= ($this->router->fetch_class() == 'setup' ) && ($this->router->fetch_method() == 'users' ) ? 'active' : '' ?> ">
                                    <a href="<?= base_url() ?>setup/users" ><i class="fa fa-lg fa-fw fa-users"></i>Invite Users <?=$sstats['susers']?></a>
                                </li>

                                </li>

                            </ul>
                        </nav>

                    </div>


                </div>

            </div>
            <!-- /well -->

        </div>

        <div class="col-sm-10">
            <div class="well">