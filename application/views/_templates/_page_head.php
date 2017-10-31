<body class="pace-done smart-style-3 fixed-header fixed-navigation fixed-ribbon">
    <!--<body class="pace-done smart-style-3 fixed-header fixed-navigation fixed-ribbon menu-on-top">-->


    <!-- #HEADER -->
    <header id="header">
        <div id="logo-group">

            <!-- PLACE YOUR LOGO HERE -->
            <span id="logo"> <img src="<?= base_url() ?>assets/img/logo-pale.png" alt="SurgiTrack"> </span>
            <!-- END LOGO PLACEHOLDER -->

            <!-- Note: The activity badge color changes when clicked and resets the number to 0
                     Suggestion: You may want to set a flag when this happens to tick off all checked messages / notifications -->
            <span id="activity" class="activity-dropdown"> <i class="fa fa-user"></i> <b class="badge"> 21 </b> </span>

            <!-- AJAX-DROPDOWN : control this dropdown height, look and feel from the LESS variable file -->
            <div class="ajax-dropdown">

                <!-- the ID links are fetched via AJAX to the ajax container "ajax-notifications" -->
                <div class="btn-group btn-group-justified" data-toggle="buttons">
                    <label class="btn btn-default">
                        <input type="radio" name="activity" id="ajax/notify/mail">
                        Msgs (14) </label>
                    <label class="btn btn-default">
                        <input type="radio" name="activity" id="ajax/notify/notifications">
                        notify (3) </label>
                    <label class="btn btn-default">
                        <input type="radio" name="activity" id="ajax/notify/tasks">
                        Tasks (4) </label>
                </div>

                <!-- notification content -->
                <div class="ajax-notifications custom-scroll">

                    <div class="alert alert-transparent">
                        <h4>Click a button to show messages here</h4>
                        This blank page message helps protect your privacy, or you can show the first message here automatically.
                    </div>

                    <i class="fa fa-lock fa-4x fa-border"></i>

                </div>
                <!-- end notification content -->

                <!-- footer: refresh area -->
                <span> Last updated on: 12/12/2013 9:43AM
                    <button type="button" data-loading-text="<i class='fa fa-refresh fa-spin'></i> Loading..." class="btn btn-xs btn-default pull-right">
                        <i class="fa fa-refresh"></i>
                    </button> </span>
                <!-- end footer -->

            </div>
            <!-- END AJAX-DROPDOWN -->
        </div>

        <!-- #PROJECTS: projects dropdown -->
        <!--<div class="project-context hidden-xs">

            <span class="label">Notification:</span>
            <span class="project-selector dropdown-toggle" data-toggle="dropdown">Recent Notifications <i class="fa fa-angle-down"></i></span>
-->
            <!-- Suggestion: populate this list with fetch and push technique -->
        <!--<ul class="dropdown-menu">
             <li>
                 <a href="javascript:void(0);">Online - attaching integration with the </a>
             </li>
             <li>
                 <a href="javascript:void(0);">Notes on pipeline upgradee</a>
             </li>
             <li>
                 <a href="javascript:void(0);">Assesment Report for merchant account</a>
             </li>
             <li class="divider"></li>
             <li>
                 <a href="javascript:void(0);"><i class="fa fa-power-off"></i> Clear</a>
             </li>
         </ul>-->
         <!-- end dropdown-menu-->

        <!-- </div>-->
        <div class="btn-header transparent ">
            <h4 class="page-title txt-color-white" style="padding-left:20px"> <?= $auth_facilityname;?></h4>
        </div>
        <div class="btn-header transparent ">
            <h5 class="page-title txt-color-white">&nbsp; <?= !empty($auth_departmentname) && $auth_departmentname!="none"? ': '. $auth_departmentname:''?></h5>
        </div>

        <!-- end projects dropdown -->

        <!-- #TOGGLE LAYOUT BUTTONS -->
        <!-- pulled right: nav area -->
        <div class="pull-right">

            <!-- collapse menu button -->
            <div id="hide-menu" class="btn-header pull-right">
                <span> <a href="javascript:void(0);" data-action="toggleMenu" title="Collapse Menu"><i class="fa fa-reorder"></i></a> </span>
            </div>
            <!-- end collapse menu -->

            <!-- #MOBILE -->
            
            <!-- Top menu profile link : this shows only when top menu is active -->
            <ul id="mobile-profile-img" class="pull-right header-dropdown-list padding-5">
                <li class="">
                    <a href="#" class="dropdown-toggle no-margin userdropdown" data-toggle="dropdown"> 
                        <img src="<?= isset($_SESSION["profilephoto"]) && $_SESSION["profilephoto"]!='' ? $_SESSION["profilephoto"]  : base_url('assets/img/avatars/male.png') ?>" alt="me" class="online" /> 
                    </a>
                    <ul class="dropdown-menu pull-right">
                        <li>
                            <a href="<?= base_url('users/profile') ?>" class="padding-10 padding-top-0 padding-bottom-0"> <i class="fa fa-user"></i> <u>P</u>rofile</a>
                        </li>
                         <li class="divider"></li>
                        <li>
                            <a href="<?= base_url('theatre/my_logbook') ?>" class="padding-10 padding-top-0 padding-bottom-0"> <i class="fa fa-list-ol"></i> <u>M</u>y log book</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="<?= base_url('auth/logout') ?>" class="padding-10 padding-top-5 padding-bottom-5" data-action="userLogout"><i class="fa fa-sign-out fa-lg"></i> <strong><u>L</u>ogout</strong></a>
                        </li>
                    </ul>
                </li>
            </ul>

           
                <!-- Top menu profile link : this shows only when top menu is active -->
                <ul id="main-profile-img" class="transparent pull-right">
                <li class="header-dropdown-list hidden-xs padding-5">
                    <a href="#" class="dropdown-toggle no-margin userdropdown" data-toggle="dropdown"> 
                        <img src="<?= isset($_SESSION["profilephoto"]) && $_SESSION["profilephoto"]!='' ? $_SESSION["profilephoto"]  : base_url('assets/img/avatars/male.png') ?>" alt="me" class="online" /> 
                    </a>
                    <ul class="dropdown-menu pull-right">
                        <li>
                            <a href="<?= base_url('users/profile') ?>" class="padding-10 padding-top-0 padding-bottom-0"> <i class="fa fa-user"></i> <u>P</u>rofile</a>
                        </li>
                         <li class="divider"></li>
                        <li>
                            <a href="<?= base_url('theatre/my_logbook') ?>" class="padding-10 padding-top-0 padding-bottom-0"> <i class="fa fa-list-ol"></i> <u>M</u>y log book</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="<?= base_url('users/profile') ?>" class="padding-10 padding-top-0 padding-bottom-0"> <i class="fa fa-lock"></i> <u>C</u>hange Password</a>
                        </li>
                        
                        <li class="divider"></li>
                        <li>
                            <a href="<?= base_url('auth/logout') ?>" class="padding-10 padding-top-5 padding-bottom-5" data-action="userLogout"><i class="fa fa-sign-out fa-lg"></i> <strong><u>L</u>ogout</strong></a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- end logout button -->
            <div id="booking-mobile" class="btn-header transparent pull-right ">
                <span> <a href="javascript:void(0)" data-toggle="modal"  data-target="#myModal" title="Booking"><i class="fa fa-plus"></i></a> </span>
            </div>
            <!-- search mobile button (this is hidden till mobile view port) -->
            <div id="search-mobile" class="btn-header transparent pull-right">
                <span> <a href="javascript:void(0)" title="Search"><i class="fa fa-search"></i></a> </span>
            </div>
            <!-- end search mobile button -->

            <!-- #SEARCH -->
            <!-- input: search field -->
            <form action="#ajax/search" class="header-search pull-right">
                <input id="search-fld" type="text" name="param" placeholder="Find reports and more">
                <button type="submit">
                    <i class="fa fa-search"></i>
                </button>
                <a href="javascript:void(0);" id="cancel-search-js" title="Cancel Search"><i class="fa fa-times"></i></a>
            </form>
            <!-- end input: search field -->

            <!-- fullscreen button -->
            <div id="fullscreen" class="btn-header transparent pull-right">
                <span> <a href="javascript:void(0);" data-action="launchFullscreen" title="Full Screen"><i class="fa fa-arrows-alt"></i></a> </span>
            </div>
            <!-- end fullscreen button -->

          

        </div>
        <!-- end pulled right: nav area -->

    </header>
    <!-- END HEADER -->