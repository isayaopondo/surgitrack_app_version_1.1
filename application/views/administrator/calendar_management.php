<!-- RIBBON -->
<div id="ribbon">

    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>

    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>Home</li><li>Administrator</li><li>Calendar</li>
    </ol>
    <!-- end breadcrumb -->

</div>
<!-- MAIN CONTENT -->
<div id="content">

    <div class="row">


        <div class="col-sm-12 col-md-12 col-lg-9">

            <!-- new widget -->
            <div class="jarviswidget jarviswidget-color-blueDark">


                <header>
                    <span class="widget-icon"> <i class="fa fa-calendar"></i> </span>
                    <h2> Calendar Management </h2>
                    <div class="widget-toolbar">
                        <!-- add: non-hidden - to disable auto hide -->
                        <div class="btn-group">
                            <button class="btn dropdown-toggle btn-xs btn-default" data-toggle="dropdown">
                                Showing <i class="fa fa-caret-down"></i>
                            </button>
                            <ul class="dropdown-menu js-status-update pull-right">
                                <li>
                                    <a href="javascript:void(0);" id="mts">Month</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" id="ags">Week</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" id="tds">Today</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="widget-toolbar">
                        <!-- add: non-hidden - to disable auto hide -->
                        <div class="btn-group">
                            <button class="btn dropdown-toggle btn-xs btn-default" data-toggle="dropdown">
                                Go to <i class="fa fa-caret-down"></i>
                            </button>
                            <ul class="dropdown-menu js-status-update pull-right">
                                <li>
                                    <a href="javascript:void(0);" id="tw">Current Week</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" id="nw">Next 2 Weeks</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" id="nm">Next 2 Months</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" id="sm">6 Months</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </header>

                <!-- widget div-->
                <div>

                    <div class="widget-body no-padding">
                        <!-- content goes here -->
                        <div class="widget-body-toolbar">

                            <div id="calendar-buttons">

                                <div class="btn-group">
                                    <a href="javascript:void(0)" class="btn btn-default btn-xs" id="btn-prev"><i class="fa fa-chevron-left"></i></a>
                                    <a href="javascript:void(0)" class="btn btn-default btn-xs" id="btn-next"><i class="fa fa-chevron-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div id="calendarsettings"></div>

                        <!-- end content -->
                    </div>

                </div>
                <!-- end widget div -->
            </div>
            <!-- end widget -->

        </div>
        <div class="col-sm-12 col-md-12 col-lg-3">

        </div>
    </div>
    <!-- end row -->
</div>
<!-- END MAIN CONTENT -->

<!-- Modal -->
<div class="modal fade" id="myCalendarModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title">
                    <img src="<?= base_url() ?>assets/img/logo.png" width="150" alt="SurgiTrack">
                </h4>
            </div>
            <div class="modal-body no-padding">
                <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-deletebutton="false"
                     data-widget-fullscreenbutton="false">

                    <header>
                        <span class="widget-icon"> <i class="fa fa-clock-o"></i> </span>
                        <h2>Block this Date </h2>

                    </header>

                    <form id="checkout-form" method="POST" action="<?= base_url('administrator/block_calendar_date') ?>" class="smart-form" novalidate="novalidate">

                        <fieldset >
                            <div class="row">
                                <section class="col col-6">
                                <label>Start Date/Time </label>
                                <label class="input"> <i class="icon-prepend fa fa-calendar"></i>
                                    <input type="text" id="blocked_date" name="blocked_date" placeholder=""  data-dateformat='yy-mm-dd hh:mm:ss' >
                                    <input type="hidden" name="block_id" id="block_id"  >
                                </label>
                            </section>
                                <section class="col col-6">
                                <label>End Date/Time </label>
                                <label class="input"> <i class="icon-prepend fa fa-calendar"></i>
                                    <input type="text" id="blocked_enddate" name="blocked_enddate" placeholder=""  data-dateformat='yy-mm-dd hh:mm:ss' >
                                    </label>
                            </section>
                                 </div>
                            <section >
                                <label>Blocking Type </label>
                                <div class="inline-group">
                                    <label class="radio">
                                        <input name="blocked_type" value="0" type="radio">
                                        <i></i>Blocked Day</label>
                                    <label class="radio">
                                        <input name="blocked_type" value="1" type="radio">
                                        <i></i>Special Day</label>
                                </div>
                            </section>
                           <section >
                                <label>Reason Title </label>
                                <label class="input"> <i class="icon-prepend fa fa-newspaper-o"></i>
                                    <input type="text" id="blocked_reason" name="blocked_reason" placeholder=""   >
                                </label>
                            </section>

                            <section>
                                <label>Reason for Blocking</label>
                                <label class="textarea"> 										
                                    <textarea rows="3" id="blocked_reason_details" maxlength="50" name="blocked_reason_details" placeholder="Reason for Blocking"></textarea> 
                                </label>
                            </section>
                        </fieldset>


                        <footer id="existingpatient2">
                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">
                                Close
                            </button>
                            <button type="reset" class="btn btn-warning">
                                Clear
                            </button>
                            <button type="submit" class="btn btn-success">
                                Save
                            </button>
                        </footer>
                    </form>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->