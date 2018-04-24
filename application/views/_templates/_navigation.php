<!-- #NAVIGATION -->
<!-- Left panel : Navigation area -->
<!-- Note: This width of the aside area can be adjusted through LESS/SASS variables -->
<aside id="left-panel">

    <!-- User info -->
    <div class="login-info">
        <span> <!-- User image size is adjusted inside CSS, it should stay as is --> 

            <a href="<?= base_url('users/profile') ?>" >
                <img src="<?=  base_url('assets/img/avatars/male.png') ?>" alt="me" class="online" />
                <span>
                    <?= $auth_name ?>
                </span>
                <i class="fa fa-angle-down"></i>
            </a> 

        </span>
    </div>
    <!-- end user info -->

    <nav>


        <ul>


            <li class="<?= ($this->router->fetch_class() == 'dashboard' ) && ($this->router->fetch_method() == 'index' ) ? 'active' : '' ?> ">
                <a href="<?= base_url() ?>" title="Dashboard"><i class="fa fa-lg fa-fw fa-home"></i>Home</a>
            </li>

            <?php if ($usergroup == 'admin') { ?>


                <li class="<?= ($this->router->fetch_class() == 'settings' ) ? 'active open' : '' ?>">
                    <a href="#"><i class="fa fa-lg fa-fw fa-cogs"></i><span class="menu-item-parent"> Facility  Settings</span></a>
                    <ul>
                        <li class="<?= ($this->router->fetch_class() == 'settings' ) && ($this->router->fetch_method() == 'departments' ) ? 'active' : '' ?>">
                            <a href="<?= base_url() ?>settings/departments"><i class="fa fa-lg fa-fw fa-hospital-o"></i> Departments</a>
                        </li>
                        <li class="<?= ($this->router->fetch_class() == 'settings' ) && ($this->router->fetch_method() == 'firms' ) ? 'active' : '' ?>">
                            <a href="<?= base_url() ?>settings/firms"><i class="fa fa-lg fa-fw fa-hospital-o"></i> Firms</a>
                        </li>

                        <li class="<?= ($this->router->fetch_class() == 'settings' ) && ($this->router->fetch_method() == 'wards' ) ? 'active' : '' ?>">
                            <a href="<?= base_url() ?>settings/wards"><i class="fa fa-lg fa-fw fa-bed"></i> Wards/Location</a>
                        </li>
                        <li class="<?= ($this->router->fetch_class() == 'settings' ) && ($this->router->fetch_method() == 'theatres' ) ? 'active' : '' ?>">
                            <a href="<?= base_url() ?>settings/theatres"><i class="fa fa-lg fa-fw fa-scissors"></i> Theatres</a>
                        </li>
                        <li class="<?= ($this->router->fetch_class() == 'settings' ) && ($this->router->fetch_method() == 'anaethesia' ) ? 'active' : '' ?>">
                            <a href="<?= base_url() ?>settings/anaethesia"><i class="fa fa-lg fa-fw fa-medkit"></i>Types of Anaethesia </a>
                        </li>
                        <li class="<?= ($this->router->fetch_class() == 'settings' ) && ($this->router->fetch_method() == 'postop_locations' ) ? 'active' : '' ?>">
                            <a href="<?= base_url() ?>settings/postop_locations"><i class="fa fa-lg fa-fw fa-map"></i>Post-Op Locations</a>
                        </li>
                        <li class="<?= ($this->router->fetch_class() == 'settings' ) && ($this->router->fetch_method() == 'suburbs' ) ? 'active' : '' ?>">
                            <a href="<?= base_url() ?>settings/suburbs"><i class="fa fa-lg fa-fw fa-map-marker"></i> Location-Suburbs</a>
                        </li>
                    </ul>
                </li>

                <li class=" <?= ($this->router->fetch_class() == 'users' ) ? 'active' : '' ?>">
                    <a href="#"><i class="fa fa-lg fa-fw fa-users"></i> <span class="menu-item-parent">Users Management</span></a>
                    <ul>
                        <li class="<?= ($this->router->fetch_class() == 'users' ) && ($this->router->fetch_method() == 'index' ) || ($this->router->fetch_method() == 'usersmanage' ) ? 'active' : '' ?>">
                            <a href="<?= base_url() ?>users"><i class="fa fa-lg fa-fw fa-users"></i> Users List</a>
                        </li>



                        <li class="<?= ($this->router->fetch_class() == 'users' ) && ($this->router->fetch_method() == 'audit_trail' ) ? 'active' : '' ?>">
                            <a href="<?= base_url() ?>users/audit_trail"><i class="fa fa-lg fa-fw fa-clock-o"></i> Audit Trail</a>
                        </li>

                    </ul>
                </li>

            <?php } ?>
            <?php if ($usergroup == 'doctor'|| $usergroup == 'nurse') { ?>
                <li class=" <?= ($this->router->fetch_class() == 'patients' ) && ($this->router->fetch_method() == 'lists' ) ? 'active' : '' ?>">
                    <a href="<?= base_url() ?>patients/lists" ><i class="fa fa-lg fa-fw fa-child"></i>Patients List</a>
                </li>
                <li class=" <?= ($this->router->fetch_class() == 'booking') && ($this->router->fetch_method() == 'emergency_list') ? 'active' : '' ?>">
                   <a href="<?= base_url() ?>booking/emergency_list"><i  style=" color:red;" class="fa fa-lg fa-fw fa-ambulance "></i><span style="font-weight:bold; color:red;">Emergency List</span></a>
                </li>
                <li class=" <?= ($this->router->fetch_class() == 'booking') && ($this->router->fetch_method() == 'waiting_list') ? 'active' : '' ?>">
                    <a href="<?= base_url() ?>booking/waiting_list"><i class="fa fa-lg fa-fw fa-clock-o"></i>Elective Waiting
                        List</a>
                </li>
                <li class=" <?= ($this->router->fetch_class() == 'booking') && ($this->router->fetch_method() == 'admission_list') ? 'active' : '' ?>">
                    <a href="<?= base_url() ?>booking/admission_list"><i class="fa fa-lg fa-fw fa-hospital-o"></i>Admission
                        List</a>
                </li>
                <li class="<?= ($this->router->fetch_class() == 'booking') && ($this->router->fetch_method() == 'theatrelists') ? 'active' : '' ?>">
                    <a href="<?= base_url() ?>booking/theatrelists" title="Theatre Lists"><i
                                class="fa fa-lg fa-fw fa-list-alt"></i> Theatre List</a>
                </li>
                <li class="<?= ($this->router->fetch_class() == 'booking') && ($this->router->fetch_method() == 'case_logs') ? 'active' : '' ?>">
                    <a href="<?= base_url() ?>booking/case_logs" title="Case Log "><i
                                class="fa fa-lg fa-fw fa-list"></i> Op Notes</a>
                </li>
                <li class="<?= ($this->router->fetch_class() == 'booking') && ($this->router->fetch_method() == 'discharge_summaries') ? 'active' : '' ?>">
                    <a href="<?= base_url() ?>booking/discharge_summaries" title="Discharge Summaries "><i
                                style="color:green;" class="fa fa-lg fa-fw fa-external-link "></i> <span style="font-weight:bold; color:green;">Discharge Summaries</span></a>
                </li>
                <?php
            }

            if ($usergroup == 'sadmin') { ?>
                <li class="<?= ($this->router->fetch_class() == 'booking' ) && ($this->router->fetch_method() == 'op_coding' ) ? 'active' : '' ?>">
                    <a href="<?= base_url() ?>booking/op_coding" title="Coding "><i class="fa fa-lg fa-fw fa-flask"></i> Patient's Coding</a>
                </li>
               
            <?php }
            
            ?>
            <?php if ($usergroup == 'admin') { ?>
            <li class="<?= ($this->router->fetch_class() == 'theatreTime' ) && ($this->router->fetch_method() == 'calendar_management' ) ? 'active' : '' ?>">
                <a href="<?= base_url() ?>administrator/calendar_management" title="Manage Calendar"><i class="fa fa-lg fa-fw fa-calendar"></i> Calendar Management</a>
            </li>

<li class=" <?= ($this->router->fetch_class() == 'terminologies' ) ? 'active' : '' ?>">
                            <a href="#"><i class="fa fa-lg fa-fw fa-language"></i> Terminologies</a>
                            <ul>

                                <li class="<?= ($this->router->fetch_class() == 'settings' ) && ($this->router->fetch_method() == 'procedures' ) ? 'active' : '' ?>">
                                    <a href="<?= base_url() ?>settings/procedures"><i class="fa fa-lg fa-fw fa-codepen"></i> RPL Codes</a>
                                </li>

                                <li class="<?= ($this->router->fetch_class() == 'settings' ) && ($this->router->fetch_method() == 'procedures_subset' ) ? 'active' : '' ?>">
                                    <a href="<?= base_url() ?>settings/procedures_subset"><i class="fa fa-lg fa-fw fa-codepen"></i> RPL Codes Subset</a>
                                </li>

                                <li class="<?= ($this->router->fetch_class() == 'settings' ) && ($this->router->fetch_method() == 'nappi_consumables' ) ? 'active' : '' ?>">
                                    <a href="<?= base_url() ?>settings/nappi_consumables"><i class="fa fa-lg fa-fw fa-product-hunt"></i> Nappi Codes</a>
                                </li>

                            </ul>
                        </li>






                <li class=" <?= ($this->router->fetch_class() == 'administrator' ) ? 'active' : '' ?>">
                    <a href="#"><i class="fa fa-lg fa-fw fa-th-large"></i> Templates</a>
                    <ul>

                        <li class="<?= ($this->router->fetch_class() == 'theatre' ) && ($this->router->fetch_method() == 'mapt' ) ? 'active' : '' ?>">
                            <a href="<?= base_url() ?>administrator/mapt" title="MAPT Form"><i class="fa fa-lg fa-fw fa-indent"></i> MAPT Templates</a>
                        </li>
                        <li class="<?= ($this->router->fetch_class() == 'theatre' ) && ($this->router->fetch_method() == 'opt_notes' ) ? 'active' : '' ?>">
                            <a href="<?= base_url() ?>administrator/opt_notes_templates" title="Op Notes Templates"><i class="fa fa-lg fa-fw fa-file-text"></i> OPNOTE Templates</a>
                        </li>

                        
                    </ul>
                </li>


                <li class=" <?= ($this->router->fetch_class() == 'analytics' ) ? 'active' : '' ?>">
                    <a href="#"><i class="fa fa-lg fa-fw fa-line-chart"></i> Analytics</a>
                    <ul>
                        <li class="<?= ($this->router->fetch_class() == 'analytics' ) && ($this->router->fetch_method() == 'utilization' ) ? 'active' : '' ?>">
                            <a href="<?= base_url() ?>analytics/utilization"><i class="fa fa-lg fa-fw fa-medkit"></i> Utilization</a>
                        </li>
                        <li class="<?= ($this->router->fetch_class() == 'analytics' ) && ($this->router->fetch_method() == 'procedure' ) ? 'active' : '' ?>">
                            <a href="<?= base_url() ?>analytics/procedure"><i class="fa fa-lg fa-fw fa-rocket"></i> Procedure</a>
                        </li>
                        <li class="<?= ($this->router->fetch_class() == 'analytics' ) && ($this->router->fetch_method() == 'surgeon' ) ? 'active' : '' ?>">
                            <a href="<?= base_url() ?>analytics/surgeon"><i class="fa fa-lg fa-fw fa-user-md"></i> Surgeon</a>
                        </li>
                    </ul>
                </li>

            <?php } ?>


            <?php if ($usergroup == 'superadmin') { ?>

                <li class="<?= ($this->router->fetch_class() == 'settings' ) && ($this->router->fetch_method() == 'facilities' ) ? 'active' : '' ?>">
                    <a href="<?= base_url() ?>settings/facilities"><i class="fa fa-lg fa-fw fa-hospital-o"></i> Facilities</a>
                </li>
                <li class="<?= ($this->router->fetch_class() == 'settings' ) && ($this->router->fetch_method() == 'suburbs' ) ? 'active' : '' ?>">
                    <a href="<?= base_url() ?>settings/suburbs"><i class="fa fa-lg fa-fw fa-map-marker"></i> Location-Suburbs</a>
                </li>

                <li class=" <?= ($this->router->fetch_class() == 'users' ) ? 'active' : '' ?>">
                    <a href="#"><i class="fa fa-lg fa-fw fa-users"></i> <span class="menu-item-parent">Users Management</span></a>
                    <ul>
                        <li class="<?= ($this->router->fetch_class() == 'users' ) && ($this->router->fetch_method() == 'all' )  ? 'active' : '' ?>">
                            <a href="<?= base_url() ?>users/all"><i class="fa fa-lg fa-fw fa-users"></i> Users List</a>
                        </li>



                        <li class="<?= ($this->router->fetch_class() == 'users' ) && ($this->router->fetch_method() == 'audit_trail' ) ? 'active' : '' ?>">
                            <a href="<?= base_url() ?>users/audit_trail"><i class="fa fa-lg fa-fw fa-clock-o"></i> Audit Trail</a>
                        </li>

                    </ul>
                </li>
            <?php } ?>
            <li class="<?= ($this->router->fetch_class() == 'support' ) && ($this->router->fetch_method() == 'help' ) ? 'active' : '' ?>">
                <a href="<?= base_url() ?>support/help" title="Help"><i class="fa fa-lg fa-fw fa-question-circle"></i> Help</a>
            </li>

        </ul>

    </nav>

    <span class="minifyme " data-action="minifyMenu"> <i class="fa fa-arrow-circle-left hit"></i> </span>

</aside>
<!-- END NAVIGATION -->
