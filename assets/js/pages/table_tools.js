// DO NOT REMOVE : GLOBAL FUNCTIONS!

$(document).ready(function () {
    var jsonPath = SurgiTrack.handleBaseURL();
    pageSetUp();

    /* // DOM Position key index //
     
     l - Length changing (dropdown)
     f - Filtering input (search)
     t - The Table! (datatable)
     i - Information (records)
     p - Pagination (paging)
     r - pRocessing 
     < and > - div elements
     <"#id" and > - div with an id
     <"class" and > - div with a class
     <"#id.class" and > - div with an id and class
     
     Also see: http://legacy.datatables.net/usage/features
     */

    /* BASIC ;*/
    var responsiveHelper_dt_basic = undefined;
    var responsiveHelper_datatable_fixed_column = undefined;
    var responsiveHelper_datatable_col_reorder = undefined;
    var responsiveHelper_datatable_tabletools = undefined;
    var responsiveHelper_booking_procedures = undefined;



    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = decodeURIComponent(window.location.search.substring(1)),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : sParameterName[1];
            }
        }
    };



    var breakpointDefinition = {
        tablet: 1024,
        phone: 480
    };

    var patient_id = $('#patient_id').val();


    $('#audit_trailtable').DataTable({
        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
                "t" +
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
        "autoWidth": true,
        "oLanguage": {
            "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
        },
        "autoWidth": true,
        processing: true,
        serverSide: false,
        ajax: {
            "url": jsonPath + "/users/audit_trail_data_all/",
            "type": "POST"
        },
        "deferLoading": 57,
        "columns": [

            {"width": "5%", "orderable": false, data: "log_id"},
            {"width": "15%", "orderable": true, data: "email"},
            {"width": "25%", "orderable": true, data: "log_date_time"},
            {"width": "35", "orderable": false, data: "log_info"},
            {"width": "25%", "orderable": false, data: "log_action"}

        ],
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5', 'print'
        ]
    });

    if ($('#user_audit_trailtable').length > 0) {
        var userid = $('#userid').val();
        $('#user_audit_trailtable').DataTable({
            "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
                    "t" +
                    "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
            "autoWidth": true,
            "oLanguage": {
                "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
            },
            "autoWidth": true,
            processing: true,
            serverSide: false,
            ajax: {
                "url": jsonPath + "/users/audit_trail_data/",
                "type": "POST",
                data: {userid: userid}
            },
            "deferLoading": 57,
            "columns": [

                {"width": "5%", "orderable": false, data: "log_id"},
                {"width": "25%", "orderable": true, data: "log_date_time"},
                {"width": "35", "orderable": false, data: "log_info"},
                {"width": "25%", "orderable": false, data: "log_action"}

            ],
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5', 'print'
            ]
        });

    }






    /* Formatting function for row details - modify as you need */
    function my_bookings_format(d) {
        // `d` is the original data object for the row
        return '<table  border="0" class="table table-hover table-condensed">' +
                '<tr>' +
                '<td width="50%"><table cellpadding="5" cellspacing="0" border="0" class="table table-hover table-condensed">' +
                '<tr>' +
                '<td style="width:100px">Folder Number:</td>' +
                '<td>' + d.folder_number + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Fullname:</td>' +
                '<td>' + d.surname + ' ' + d.other_names + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Procedure:</td>' +
                '<td>' + d.procedure_name + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Comments:</td>' +
                '<td>' + d.additional_info + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Insurance:</td>' +
                '<td>' + d.insuranceco_name + ' (#:' + d.insurance_number + ')</td>' +
                '</tr>' +
                '</table>' +
                '</td>' +
                '<td width="50%"></td>' +
                '</tr>' +
                '</table>';
    }





    var table = $('#my_bookingstable').DataTable({
        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
                "t" +
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
        "autoWidth": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        ajax:
                {
                    "url": jsonPath + "/theatre/mybooking_data/",
                    "type": "POST"
                },
        "deferLoading": 57,
        "columns": [
            {
                "class": 'details-control',
                "orderable": false,
                "data": null,
                "defaultContent": ''
            },
            {data: "folder_number"},
            {data: "theatre_name"},
            {data: "surname"},
            {data: "dateofbirth"},
            {data: "surgerydate"},
            {data: "priority_name"},
            {
                "width": "20%",
                targets: -1,
                data: 'booking_id',
                render: function (data, type, full, meta) {
                    return   '<a href="' + jsonPath + '/theatre/booking/' + data + '"  class="indicatoritem btn btn-success btn-xs rounded" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil"></i></a> \n\
<a href="' + jsonPath + '/theatre/delete_booking/' + data + '"  class="indicatoritem btn btn-danger btn-xs rounded" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-times"></i></a>';
                }

            }
        ],
        "order": [[1, 'asc']]
    });
    // Add event listener for opening and closing details
    $('#my_bookingstable tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(my_bookings_format(row.data())).show();
            tr.addClass('shown');
        }
    });

    /* Formatting function for row details - modify as you need */
    function waitinglist_format(d) {
        var side = '';
        if (d.laterality !== 'None' && d.laterality !== "")
        {
            side = '[' + d.laterality + ']';
        }
        // `d` is the original data object for the row
        return '<table class="table table-condensed">' +
                '<tr>' +
                '<td width="45%">' +
                '<table cellpadding="5" cellspacing="0" border="0" class="table table-hover table-condensed">' +
                '<tr>' +
                '<td width="30%"><b>Folder Number:</b></td>' +
                '<td>' + d.folder_number + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Fullname:</b></td>' +
                '<td>' + d.surname + ' ' + d.other_names + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Procedure:</b></td>' +
                '<td>' + side + ' ' + d.procedure_name + '</td>' +
                '</tr>' +
                '<tr>' +
                '<tr>' +
                '<td><b>Category:</b></td>' +
                '<td>' + d.category_name + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Current MAPT Score:</b></td>' +
                '<td>' + d.mapt + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Comments:</b></td>' +
                '<td>' + d.additional_info + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Insurance:</b></td>' +
                '<td>' + d.insuranceco_name + ' (#:' + d.insurance_number + ')</td>' +
                '</tr>' +
                '</table>' +
                '</td>' +
                '<td width="45%">' +
                '<table cellpadding="5" cellspacing="0" border="0" class="table table-hover table-condensed">' +
                '<tr>' +
                '<td width="30%"><b>Anesthesia:</b></td>' +
                '<td>' + d.anesthesia + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>PostOP Bed:</b></td>' +
                '<td>' + d.postopbed + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td ><b>Indication:</b></td>' +
                '<td>' + d.surgery_indication + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Booked By:</b></td>' +
                '<td>' + d.bookedby + '</td>' +
                '</tr>' +
                '</table>' +
                '</td>' +
                '<td width="10%">' +
                '<table cellpadding="5" cellspacing="0" border="0" class="table table-hover table-condensed">' +
                '<tr>' +
                '<td><a href="' + jsonPath + '/patients/patient_page/' + d.patient_id + '" style="margin-right:5px;margin-left:5px" class="btn btn-block btn-xs btn-info pull-right text-align-left"><i class="fa fa-search"></i> View Patient</a> </td>' +
                '</tr>' +
                '<tr>' +
                '<td><button style="margin-left:5px;margin-right:5px" class="btn btn-block btn-xs btn-success pull-right text-align-left" onclick="add_to_admission(' + d.booking_id + ');"><i class="fa fa-plus-circle"></i> Add to Admission </button> </td>' +
                '</tr>' +
                '<tr>' +
                '<td><a href="' + jsonPath + '/patients/add_patient/' + d.patient_id + '/' + d.booking_id + '" style="margin-left:5px;margin-right:5px"  class=" btn btn-block btn-info btn-xs pull-right text-align-left" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil"></i> Edit Booking</a></td>' +
                '</tr>' +
                '<tr>' +
                '<td><button style="margin-left:5px;margin-right:5px" class="btn btn-block btn-xs btn-info pull-right text-align-left" onclick="add_mapt(' + d.booking_id + ',' + d.procedure_id + ');"><i class="fa fa-plus"></i> Add MAP Score </button> </td>' +
                '</tr>' +
                '<tr>' +
                '<td><button style="margin-left:5px;margin-right:5px" class="btn btn-block btn-xs btn-warning pull-right text-align-left" onclick="view_mapt(' + d.booking_id + ',' + d.procedure_id + ');"><i class="fa fa-list"></i> View MAP Score</button> </td>' +
                '</tr>' +
                '<tr>' +
                '<td><button style="margin-left:5px;margin-right:5px" class="btn btn-block btn-xs btn-default pull-right text-align-left" onclick="add_comments(' + d.booking_id + ');"><i class="fa fa-comment"></i> Add Comments</button> </td>' +
                '</tr>' +
                '<tr>' +
                '<td><a href="' + jsonPath + '/theatre/patient_log/' + d.patient_id + '" style="margin-left:5px;margin-right:5px"  class="btn btn-block btn-primary btn-xs pull-right text-align-left" data-toggle="tooltip" data-placement="top" data-original-title="View Patient Log"><i class="fa fa-search"></i> View Patient Log</a></td>' +
                '</tr>' +
                '<tr>' +
                '<td ><button style="margin-left:5px;margin-right:5px" class="btn btn-block btn-xs btn-danger pull-right text-align-left" onclick="remove_booking(' + d.booking_id + ');"> <i class="fa fa-remove"></i> Remove Booking </button> ' +
                '</td>' +
                '</tr>' +
                '</table>' +
                '</td>' +
                '</tr>' +
                '</table>';
    }

    var table = $('#waitinglist_table').DataTable({
        //"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-4 col-xs-12 hidden-xs'T><'col-sm-2 col-xs-12 hidden-xs'<'toolbar'>r>" +
        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
                "t" +
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",

        "autoWidth": true,
        "bDestroy": true,
        "iDisplayLength": 15,
        ajax:
                {
                    "url": jsonPath + "/theatre/mywaiting_list_data/",
                    "type": "POST",
                    "data": {patient_id: patient_id}
                },
        "deferLoading": 57,
        "columns": [
            {
                "class": 'details-control',
                "orderable": false,
                "data": null,
                "defaultContent": ''
            },
            {data: "folder_number"},
            {data: "fullname"},
            {data: "age"},
            {data: "procedure_name"},
            {data: "surgery_indication"},
            {data: "priority_name"},
            {data: "booking_date"},
            {data: "leadtime"},
            {data: "mapt"},
            {data: "cpscore"}
        ],
        "order": [[7, 'asc']]
    });
    // Add event listener for opening and closing details
    $('#waitinglist_table tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(waitinglist_format(row.data())).show();
            tr.addClass('shown');
        }
    });

    var searchText = getUrlParameter('procedure');
    if (searchText !== undefined) {
        table.search(searchText).draw();
    }

    // Apply the filter
    $("#waitinglist_table thead th input[type=text]").on('keyup change', function () {

        table
                .column($(this).parent().index() + ':visible')
                .search(this.value)
                .draw();

    });
    /* END COLUMN FILTER */

    /* Formatting function for row details - modify as you need */
    function admissionlist_format(d) {
        var side = '';
        if (d.laterality !== 'None' && d.laterality !== "")
        {
            side = '[' + d.laterality + ']';
        }
        // `d` is the original data object for the row
        return '<table class="table table-condensed">' +
                '<tr>' +
                '<td width="45%">' +
                '<table cellpadding="5" cellspacing="0" border="0" class="table table-hover table-condensed">' +
                '<tr>' +
                '<td style="width:100px"><b>Folder Number:</b></td>' +
                '<td>' + d.folder_number + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Fullname:</b></td>' +
                '<td>' + d.surname + ' ' + d.other_names + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Procedure:</b></td>' +
                '<td>' + side + ' ' + d.procedure_name + '</td>' +
                '</tr>' +
                '<tr>' +
                '<tr>' +
                '<td><b>Category:</b></td>' +
                '<td>' + d.category_name + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Admission Notes:</b></td>' +
                '<td>' + d.admission_notes + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Insurance:</b></td>' +
                '<td>' + d.insuranceco_name + ' (#:' + d.insurance_number + ')</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Booked By:</b></td>' +
                '<td>' + d.bookedby + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Admitted By:</b></td>' +
                '<td>' + d.admittedby + '</td>' +
                '</tr>' +
                '</table>' +
                '</td>' +
                '<td width="45%">' +
                '<table cellpadding="5" cellspacing="0" border="0" class="table table-hover table-condensed">' +
                '<tr>' +
                '<td style="width:100px"><b>Indication:</b></td>' +
                '<td>' + d.surgery_indication + '</td>' +
                '</tr>' +
                '<tr>' +
                '<tr>' +
                '<td><b>Anesthesia:</b></td>' +
                '<td>' + d.anesthesia + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>PostOP Bed:</b></td>' +
                '<td>' + d.postopbed + '</td>' +
                '</tr>' +
                '</table>' +
                '</td>' +
                '<td width="10%">' +
                '<table cellpadding="5" cellspacing="0" border="0" class="table table-hover table-condensed">' +
                '<tr>' +
                '<td><a href="' + jsonPath + '/patients/patient_page/' + d.patient_id + '" style="margin-right:5px;margin-left:5px" class="btn btn-block btn-xs btn-info pull-right text-align-left"><i class="fa fa-search"></i> View Patient</a> </td>' +
                '</tr>' +
                '<tr>' +
                '<td><button style="margin-left:5px;margin-right:5px" class="btn btn-block btn-xs btn-primary pull-right text-align-left" onclick="back_to_waiting(' + d.booking_id + ');"><i class="fa fa-backward"></i> Back to Waiting list </button> </td>' +
                '</tr>' +
                '<tr>' +
                '<td><button style="margin-left:5px;margin-right:5px" class="btn  btn-block btn-xs btn-success pull-right text-align-left" onclick="add_to_theatre(' + d.booking_id + ');"><i class="fa fa-plus-circle"></i> Add to Theatre List </button> </td>' +
                '</tr>' +
                '<tr>' +
                '<td><button style="margin-left:5px;margin-right:5px" class="btn btn-block btn-xs btn-info pull-right text-align-left" onclick="add_mapt(' + d.booking_id + ',' + d.procedure_id + ');"><i class="fa fa-plus"></i> Add MAP Score </button> </td>' +
                '</tr>' +
                '<tr>' +
                '<td><button style="margin-left:5px;margin-right:5px" class="btn btn-block btn-xs btn-warning pull-right text-align-left" onclick="view_mapt(' + d.booking_id + ',' + d.procedure_id + ');"><i class="fa fa-list"></i> View MAP Score</button> </td>' +
                '</tr>' +
                '<tr>' +
                '<td><button style="margin-left:5px;margin-right:5px" class="btn btn-block btn-xs btn-success pull-right text-align-left" onclick="send_message(' + d.booking_id + ');"><i class="fa fa-envelope"></i> Send SMS</button> </td>' +
                '</tr>' +
                '<tr>' +
                '<td><button style="margin-left:5px;margin-right:5px" class="btn btn-block btn-xs btn-default pull-right text-align-left" onclick="add_comments(' + d.booking_id + ');"><i class="fa fa-comment"></i> Add Comments</button> </td>' +
                '</tr>' +
                '<tr>' +
                '<td><a href="' + jsonPath + '/theatre/patient_log/' + d.patient_id + '" style="margin-left:5px;margin-right:5px"  class="btn btn-block btn-info btn-xs pull-right text-align-left" data-toggle="tooltip" data-placement="top" data-original-title="View Patient Log"><i class="fa fa-search"></i> View Patient Log</a></td>' +
                '</tr>' +
                '<tr>' +
                '<td ><button style="margin-left:5px;margin-right:5px" class="btn btn-block btn-xs btn-danger pull-right text-align-left" onclick="remove_booking(' + d.booking_id + ');"> <i class="fa fa-remove"></i> Remove Booking </button> ' +
                '</td>' +
                '</tr>' +
                '</table>' +
                '</td>' +
                '</tr>' +
                '</table>';
    }

    var admissiontable = $('#admissionlist_table').DataTable({
        //"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-4 col-xs-12 hidden-xs'T><'col-sm-2 col-xs-12 hidden-xs'<'toolbar'>r>" +
        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
                "t" +
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",

        "autoWidth": true,
        "bDestroy": true,
        "iDisplayLength": 15,
        ajax:
                {
                    "url": jsonPath + "/theatre/myadmission_list_data/",
                    "type": "POST",
                    "data": {patient_id: patient_id}
                },
        "deferLoading": 57,
        "columns": [
            {
                "class": 'details-control',
                "orderable": false,
                "data": null,
                "defaultContent": ''
            },
            {data: "folder_number"},
            {data: "fullname"},
            {data: "age"},
            {data: "procedure_name"},

            {data: "admission_date"},
            {data: "leadtime"},
            {data: "surgery_indication"},
            {data: "priority_name"},
            {data: "theatre_name"},
        ],
        "order": [[5, 'asc']]
    });
    // Add event listener for opening and closing details
    $('#admissionlist_table tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = admissiontable.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(admissionlist_format(row.data())).show();
            tr.addClass('shown');
        }
    });
    // Apply the filter
    $("#admissionlist_table thead th input[type=text]").on('keyup change', function () {

        admissiontable
                .column($(this).parent().index() + ':visible')
                .search(this.value)
                .draw();

    });

    $('#min, #max').keyup(function () {
        admissiontable
                .column($(this).parent().index() + ':visible')
                .search(this.value)
                .draw();
    });
    /* END COLUMN FILTER */


    /* Formatting function for row details - modify as you need */
    function theatrelist_format(d) {
        var side = '';
        if (d.laterality !== 'None' && d.laterality !== "")
        {
            side = '[' + d.laterality + ']';
        }
        // `d` is the original data object for the row
        return '<table class="table table-condensed">' +
                '<tr>' +
                '<td width="45%">' +
                '<table cellpadding="5" cellspacing="0" border="0" class="table table-hover table-condensed">' +
                '<tr>' +
                '<td style="width:100px"><b>Folder Number:</b></td>' +
                '<td>' + d.folder_number + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Fullname:</b></td>' +
                '<td>' + d.surname + ' ' + d.other_names + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Procedure:</b></td>' +
                '<td>' + side + ' ' + d.procedure_name + '</td>' +
                '</tr>' +
                '<tr>' +
                '<tr>' +
                '<td><b>Category:</b></td>' +
                '<td>' + d.category_name + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Comments:</b></td>' +
                '<td>' + d.additional_info + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Insurance:</b></td>' +
                '<td>' + d.insuranceco_name + ' (#:' + d.insurance_number + ')</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Booked By:</b></td>' +
                '<td>' + d.bookedby + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Admitted By:</b></td>' +
                '<td>' + d.admittedby + '</td>' +
                '</tr>' +
                '</table>' +
                '</td>' +
                '<td width="45%">' +
                '<table cellpadding="5" cellspacing="0" border="0" class="table table-hover table-condensed">' +
                '<tr>' +
                '<td style="width:100px"><b>DOB:</b></td>' +
                '<td>' + d.dateofbirth + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td style="width:100px"><b>Surgery Date</b></td>' +
                '<td>' + d.surgerydate + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td style="width:100px"><b>Lead time:</b></td>' +
                '<td>' + d.leadtime + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td style="width:100px"><b>Priority:</b></td>' +
                '<td>' + d.priority_name + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td style="width:100px"><b>Indication:</b></td>' +
                '<td>' + d.surgery_indication + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Anesthesia:</b></td>' +
                '<td>' + d.anesthesia + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>PostOP Bed:</b></td>' +
                '<td>' + d.postopbed + '</td>' +
                '</tr>' +
                '</table>' +
                '</td>' +
                '<td width="10%">' +
                '<table cellpadding="5" cellspacing="0" border="0" class="table table-hover table-condensed">' +
                '<tr>' +
                '<td><a href="' + jsonPath + '/patients/patient_page/' + d.patient_id + '" style="margin-right:5px;margin-left:5px" class="btn btn-block btn-xs btn-info pull-right text-align-left"><i class="fa fa-search"></i> View Patient</a> </td>' +
                '</tr>' +
                '<tr>' +
                '<td><button style="margin-left:5px;margin-right:5px" class="btn btn-block btn-xs btn-primary pull-right text-align-left" onclick="back_to_waiting(' + d.booking_id + ');"><i class="fa fa-backward"></i> Back to Waiting list </button> </td>' +
                '</tr>' +
                '<tr>' +
                '<td><button style="margin-left:5px;margin-right:5px" class="btn btn-xs btn-block btn-warning pull-right text-align-left" onclick="back_to_admission(' + d.booking_id + ');"> <i class="fa fa-backward"></i> Back to Admission </button>  </td>' +
                '</tr>' +
                '<tr>' +
                '<td><button style="margin-left:5px;margin-right:5px" class="btn btn-xs btn-block btn-success pull-right text-align-left" onclick="record_ops(' + d.booking_id + ');"><i class="fa fa-microphone"></i> Record Operation </button> </td>' +
                '</tr>' +
                '<tr>' +
                '<td><button style="margin-left:5px;margin-right:5px" class="btn btn-block btn-xs btn-info pull-right text-align-left" onclick="add_mapt(' + d.booking_id + ',' + d.procedure_id + ');"><i class="fa fa-plus"></i> Add MAP Score </button> </td>' +
                '</tr>' +
                '<tr>' +
                '<td><button style="margin-left:5px;margin-right:5px" class="btn btn-block btn-xs btn-warning pull-right text-align-left" onclick="view_mapt(' + d.booking_id + ',' + d.procedure_id + ');"><i class="fa fa-list"></i> View MAP Score</button> </td>' +
                '</tr>' +
                '<tr>' +
                '<td><button style="margin-left:5px;margin-right:5px" class="btn btn-block btn-xs btn-default pull-right text-align-left" onclick="add_comments(' + d.booking_id + ');"><i class="fa fa-comment"></i> Add Comments</button> </td>' +
                '</tr>' +
                '<tr>' +
                '<td><a href="' + jsonPath + '/theatre/patient_log/' + d.patient_id + '" style="margin-left:5px;margin-right:5px"  class="btn btn-block btn-info btn-xs pull-right text-align-left" data-toggle="tooltip" data-placement="top" data-original-title="View Patient Log"><i class="fa fa-search"></i> View Patient Log</a></td>' +
                '</tr>' +
                '<tr>' +
                '<td ><button style="margin-left:5px;margin-right:5px" class="btn btn-block btn-xs btn-danger pull-right text-align-left" onclick="remove_booking(' + d.booking_id + ');"> <i class="fa fa-remove"></i> Remove Booking </button> ' +
                '</td>' +
                '</tr>' +
                '</table>' +
                '</td>' +
                '</tr>' +
                '</table>';

    }

    var theatrelisttable = $('#theatrelist_table').DataTable({
        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
                "t" +
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",

        "autoWidth": true,
        "bDestroy": true,
        "iDisplayLength": 15,
        ajax:
                {
                    "url": jsonPath + "/theatre/mytheatre_list_data/",
                    "type": "POST",
                    "data": {patient_id: patient_id}
                },
        "deferLoading": 57,
        "columns": [
            {
                "class": 'details-control',
                "orderable": false,
                "data": null,
                "defaultContent": ''
            },

            {data: "folder_number"},
            {data: "fullname"},

            {data: "age"},
            {data: "gender"},
            {data: "ward_name"},
            {data: "procedure_name"},
            {data: "surgerydate"},
            {data: "slot_name"},
            {data: "theatre_name"},
            {data: "firm_name"},
        ],
        "order": [[7, 'DESC']],

    });
    // Add event listener for opening and closing details
    $('#theatrelist_table tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = theatrelisttable.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(theatrelist_format(row.data())).show();
            tr.addClass('shown');
        }
    });

    // Apply the filter
    $("#theatrelist_table thead th input[type=text]").on('keyup change', function () {

        theatrelisttable
                .column($(this).parent().index() + ':visible')
                .search(this.value)
                .draw();

    });
    /* END COLUMN FILTER */


    var theatreSearchText = getUrlParameter('folder_number');
    if (theatreSearchText !== undefined) {
        theatrelisttable.search(theatreSearchText).draw();

        theatrelisttable.rows().eq(0).each(function (index) {
            //var tr = $(this).closest('tr');
            var row = theatrelisttable.row(index);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                $(row).removeClass('shown');
            } else {
                // Open this row
                row.child(theatrelist_format(row.data())).show();
                $(row).addClass('shown');
            }
        });


    }
//case_log_table

    /* Formatting function for row details - modify as you need */
    function caseloglist_format(d) {
        // `d` is the original data object for the row
        return '<table class="table table-condensed">' +
                '<tr>' +
                '<td width="45%">' +
                '<table cellpadding="5" cellspacing="0" border="0" class="table table-hover table-condensed">' +
                '<tr>' +
                '<td width="35%"><b>Folder Number:</b></td>' +
                '<td>' + d.folder_number + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Fullname:</b></td>' +
                '<td>' + d.surname + ' ' + d.other_names + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Phone Number:</b></td>' +
                '<td>' + d.phone + ' </td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Booked Procedure:</b></td>' +
                '<td>' + d.procedure_name + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Operation Done:</b></td>' +
                '<td>' + d.operation_done + '</td>' +
                '</tr>' +
                '<tr>' +
                '<tr>' +
                '<td><b>Category:</b></td>' +
                '<td>' + d.category_name + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Comments:</b></td>' +
                '<td>' + d.additional_info + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Booked By:</b></td>' +
                '<td>' + d.bookedby + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Admitted By:</b></td>' +
                '<td>' + d.admittedby + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Primary Surgeon:</b></td>' +
                '<td>' + d.primary_surgeon + '</td>' +
                '</tr>' +
                '</table>' +
                '</td>' +
                '<td width="45%">' +
                '<table cellpadding="5" cellspacing="0" border="0" class="table table-hover table-condensed">' +
                '<tr>' +
                '<td style="width:100px"><b>DOB:</b></td>' +
                '<td>' + d.dateofbirth + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td style="width:100px"><b>Booking Date</b></td>' +
                '<td>' + d.booking_date + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td style="width:100px"><b>Lead time:</b></td>' +
                '<td>' + d.leadtime + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td style="width:100px"><b>Surgery Duration:</b></td>' +
                '<td>' + d.surgery_time + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td style="width:100px"><b>Priority:</b></td>' +
                '<td>' + d.priority_name + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td style="width:100px"><b>Indication:</b></td>' +
                '<td>' + d.surgery_indication + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Anesthesia:</b></td>' +
                '<td>' + d.anesthesia + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>PostOP Bed:</b></td>' +
                '<td>' + d.postopbed + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Surgeon Assistants</b></td>' +
                '<td>' + d.assistant_surgeon + '</td>' +
                '</tr>' +
                '</table>' +
                '</td>' +
                '<td width="10%">' +
                '<table cellpadding="5" cellspacing="0" border="0" class="table table-hover table-condensed">' +
                '<tr>' +
                '<td><a href="' + jsonPath + '/patients/patient_page/' + d.patient_id + '" style="margin-right:5px;margin-left:5px" class="btn btn-block btn-xs btn-info pull-right text-align-left"><i class="fa fa-search"></i> View Patient</a> </td>' +
                '</tr>' +
                '<tr>' +
                '<td><button style="margin-left:5px;margin-right:5px" class="btn  btn-block btn-xs btn-success pull-right text-align-left" onclick="view_opnotes(' + d.booking_id + ');"><i class="fa fa-file"></i> View OP Notes </button> </td>' +
                '</tr>' +
                '<tr>' +
                '<td><button style="margin-left:5px;margin-right:5px" class="btn btn-block btn-xs btn-primary pull-right text-align-left" onclick="edit_optnotes(' + d.booking_id + ');"> <i class="fa fa-pencil"></i> Edit OP Notes </button> </td>' +
                '</tr>' +
                '<tr>' +
                '<td><button style="margin-left:5px;margin-right:5px" class="btn btn-block btn-xs btn-warning pull-right text-align-left" onclick="view_mapt(' + d.booking_id + ',' + d.procedure_id + ');"><i class="fa fa-list"></i> View MAP Score</button> </td>' +
                '</tr>' +
                '<tr>' +
                '<td><button style="margin-left:5px;margin-right:5px" class="btn btn-block btn-xs btn-default pull-right text-align-left" onclick="add_comments(' + d.booking_id + ');"><i class="fa fa-comment"></i> Add Comments</button> </td>' +
                '</tr>' +
                '<tr>' +
                '<td><a href="' + jsonPath + '/theatre/patient_coding/' + d.booking_id + '" style="margin-left:5px;margin-right:5px"  class="btn btn-block btn-danger btn-xs pull-right text-align-left" data-toggle="tooltip" data-placement="top" data-original-title="Patient Coding"><i class="fa fa-flask"></i> Patient Coding</a></td>' +
                '</tr>' +
                '<tr>' +
                '<td><a href="' + jsonPath + '/theatre/patient_log/' + d.patient_id + '" style="margin-left:5px;margin-right:5px"  class="btn btn-block btn-info btn-xs pull-right text-align-left" data-toggle="tooltip" data-placement="top" data-original-title="View Patient Log"><i class="fa fa-search"></i> View Patient Log</a></td>' +
                '</tr>' +
                '</table>' +
                '</td>' +
                '</tr>' +
                '</table>';

    }

    var caseloglisttable = $("#caselog_table").DataTable({
        //"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>r>" +
        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
                "t" +
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
        "autoWidth": true,
        "bDestroy": true,
        "iDisplayLength": 15,
        ajax:
                {
                    "url": jsonPath + "/theatre/mycaselog_list_data/",
                    "type": "POST",
                    "data": {patient_id: patient_id}
                },
        "deferLoading": 57,
        "columns": [
            {
                "class": 'details-control',
                "orderable": false,
                "data": null,
                "defaultContent": ''
            },
            {data: "folder_number"},
            {data: "fullname"},
            {data: "age"},
            {data: "gender"},
            {data: "operationdate"},
            {data: "operation_done"},
            {data: "theatre_name"},
            {data: "primary_surgeon"}
        ],
        "order": [[5, 'desc']]
    });
    // Add event listener for opening and closing details
    $('#caselog_table tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = caseloglisttable.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(caseloglist_format(row.data())).show();
            tr.addClass('shown');
        }
    });

    // Apply the filter
    $("#caselog_table thead th input[type=text]").on('keyup change', function () {

        caseloglisttable
                .column($(this).parent().index() + ':visible')
                .search(this.value)
                .draw();

    });


    /* Formatting function for row details - modify as you need */
    function opcodingtable_format(d) {
        // `d` is the original data object for the row
        return '<table class="table table-condensed">' +
                '<tr>' +
                '<td width="45%">' +
                '<table cellpadding="5" cellspacing="0" border="0" class="table table-hover table-condensed">' +
                '<tr>' +
                '<td width="35%"><b>Folder Number:</b></td>' +
                '<td>' + d.folder_number + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Fullname:</b></td>' +
                '<td>' + d.surname + ' ' + d.other_names + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Booked Procedure:</b></td>' +
                '<td>' + d.procedure_name + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Operation Done:</b></td>' +
                '<td>' + d.operation_done + '</td>' +
                '</tr>' +
                '<tr>' +
                '<tr>' +
                '<td><b>Category:</b></td>' +
                '<td>' + d.category_name + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Comments:</b></td>' +
                '<td>' + d.additional_info + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Insurance:</b></td>' +
                '<td>' + d.insuranceco_name + ' (#:' + d.insurance_number + ')</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Booked By:</b></td>' +
                '<td>' + d.bookedby + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Admitted By:</b></td>' +
                '<td>' + d.admittedby + '</td>' +
                '</tr>' +
                '</table>' +
                '</td>' +
                '<td width="45%">' +
                '<table cellpadding="5" cellspacing="0" border="0" class="table table-hover table-condensed">' +
                '<tr>' +
                '<td style="width:100px"><b>DOB:</b></td>' +
                '<td>' + d.dateofbirth + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td style="width:100px"><b>Booking Date</b></td>' +
                '<td>' + d.booking_date + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td style="width:100px"><b>Lead time:</b></td>' +
                '<td>' + d.leadtime + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td style="width:100px"><b>Surgery Duration:</b></td>' +
                '<td>' + d.surgery_time + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td style="width:100px"><b>Priority:</b></td>' +
                '<td>' + d.priority_name + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td style="width:100px"><b>Indication:</b></td>' +
                '<td>' + d.surgery_indication + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Anesthesia:</b></td>' +
                '<td>' + d.anesthesia + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>PostOP Bed:</b></td>' +
                '<td>' + d.postopbed + '</td>' +
                '</tr>' +
                '</table>' +
                '</td>' +
                '<td width="10%">' +
                '<table cellpadding="5" cellspacing="0" border="0" class="table table-hover table-condensed">' +
                '<tr>' +
                '<td><a href="' + jsonPath + '/patients/patient_page/' + d.patient_id + '" style="margin-right:5px;margin-left:5px" class="btn btn-block btn-xs btn-info pull-right text-align-left"><i class="fa fa-search"></i> View Patient</a> </td>' +
                '</tr>' +
                '<tr>' +
                '<td><a href="' + jsonPath + '/theatre/patient_coding/' + d.booking_id + '" style="margin-left:5px;margin-right:5px" class="btn btn-block btn-xs btn-danger pull-right text-align-left" ><i class="fa fa-flask"></i> Add Code & Consumables</a> </td>' +
                '</tr>' +
                '<tr>' +
                '<td><a href="' + jsonPath + '/theatre/patient_coding/' + d.booking_id + '" style="margin-left:5px;margin-right:5px"  class="btn btn-block btn-info btn-xs pull-right text-align-left" data-toggle="tooltip" data-placement="top" data-original-title="View Patient Log"><i class="fa fa-search"></i> View Patient Coding</a></td>' +
                '</tr>' +
                '</table>' +
                '</td>' +
                '</tr>' +
                '</table>';

    }


    var mylogbooktable = $("#mylogbook_table").DataTable({
        //"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>r>" +
       // "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
        //        "t" +
        //        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'T>r>" +
                "t" +
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
        "autoWidth": true,
        "bDestroy": true,
        "iDisplayLength": 15,
        ajax:
                {
                    "url": jsonPath + "/theatre/mylogbook_data/",
                    "type": "POST",
                    "data": {patient_id: patient_id}
                },
        "deferLoading": 57,
        "columns": [

            {data: "folder_number"},
            {data: "fullname"},
            {data: "age"},
            {data: "gender"},
            {data: "operationdate"},
            {data: "operation_done"},
            {data: "theatre_name"},
            {data: "op_role"},
            {
                targets: -1,
                data: 'booking_id',
                render: function (data, type, full, meta) {
                    return   '<button style="margin-left:5px;margin-right:5px" class="btn  btn-block btn-xs btn-success pull-right text-align-left" onclick="view_mylogbook_opnotes(' + data + ');"><i class="fa fa-file"></i> OP Notes </button>';
                }

            }
        ],
        "order": [[4, 'desc']],
        "oTableTools": {
            "aButtons": [
                "copy",
                "csv",
                "xls",
                {
                    "sExtends": "pdf",
                    "sTitle": "MyLogBook_PDF",
                    "sPdfMessage": "MyLogBookn PDF Export",
                    "sPdfSize": "letter"
                },
                {
                    "sExtends": "print",
                    "sMessage": "Generated by Surgitrack <i>(press Esc to close)</i>"
                }
            ],
            "sSwfPath": jsonPath+"assets/js/plugin/datatables/swf/copy_csv_xls_pdf.swf"
        },
    });


    // Apply the filter
    $("#mylogbooktable thead th input[type=text]").on('keyup change', function () {

        mylogbooktable
                .column($(this).parent().index() + ':visible')
                .search(this.value)
                .draw();

    });


    $('#mylogbooktable tbody').on('click', 'td', function () {

        var tr = $(this).closest('tr');
        var row = mylogbooktable.row(tr);
        if (row.child.isShown()) {
            row.child(view_booking_notes(row.data())).show();
        } else {
            row.child(view_booking_notes(row.data())).show();
        }

    });

    var opcodingtable = $("#opcoding_table").DataTable({
        //"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>r>" +
        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
                "t" +
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
        "autoWidth": true,
        "bDestroy": true,
        "iDisplayLength": 15,
        ajax:
                {
                    "url": jsonPath + "/theatre/mycaselog_list_data/",
                    "type": "POST",
                    "data": {patient_id: patient_id}
                },
        "deferLoading": 57,
        "columns": [
            {
                "class": 'details-control',
                "orderable": false,
                "data": null,
                "defaultContent": ''
            },
            {data: "folder_number"},
            {data: "fullname"},
            {data: "age"},
            {data: "gender"},
            {data: "operationdate"},
            {data: "procedure_name"},
            {data: "theatre_name"},
            {data: "surgeon_name"},
        ],
        "order": [[6, 'asc']]
    });
    // Add event listener for opening and closing details
    $('#opcoding_table tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = opcodingtable.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(opcodingtable_format(row.data())).show();
            tr.addClass('shown');
        }
    });

    // Apply the filter
    $("#opcoding_table thead th input[type=text]").on('keyup change', function () {

        opcodingtable
                .column($(this).parent().index() + ':visible')
                .search(this.value)
                .draw();

    });

    /* Formatting function for row details - modify as you need */
    function patientwaitinglist_format(d) {
        // `d` is the original data object for the row

        var buttons = '';
        if (d.booking_status === '0') {
            buttons = '<tr>' +
                    '<td><button style="margin-left:5px;margin-right:5px" class="btn btn-block btn-xs btn-success pull-right text-align-left" onclick="add_to_admission(' + d.booking_id + ');"><i class="fa fa-plus-circle"></i> Add to Admission </button> </td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td><a href="' + jsonPath + '/patients/add_patient/' + d.patient_id + '/' + d.booking_id + '" style="margin-left:5px;margin-right:5px"  class=" btn btn-block btn-info btn-xs pull-right text-align-left" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil"></i> Edit Booking</a></td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td><button style="margin-left:5px;margin-right:5px" class="btn btn-block btn-xs btn-info pull-right text-align-left" onclick="add_mapt(' + d.booking_id + ',' + d.procedure_id + ');"><i class="fa fa-plus"></i> Add MAP Score </button> </td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td><button style="margin-left:5px;margin-right:5px" class="btn btn-block btn-xs btn-warning pull-right text-align-left" onclick="view_mapt(' + d.booking_id + ',' + d.procedure_id + ');"><i class="fa fa-list"></i> View MAP Score</button> </td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td><button style="margin-left:5px;margin-right:5px" class="btn btn-block btn-xs btn-default pull-right text-align-left" onclick="add_comments(' + d.booking_id + ');"><i class="fa fa-comment"></i> Add Comments</button> </td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td ><button style="margin-left:5px;margin-right:5px" class="btn btn-block btn-xs btn-danger pull-right text-align-left" onclick="remove_booking(' + d.booking_id + ');"> <i class="fa fa-remove"></i> Remove Booking </button> ' +
                    '</td>' +
                    '</tr>';
        } else if (d.booking_status === '1') {
            buttons = '<tr>' +
                    '<td><button style="margin-left:5px;margin-right:5px" class="btn btn-block btn-xs btn-primary pull-right text-align-left" onclick="back_to_waiting(' + d.booking_id + ');"><i class="fa fa-backward"></i> Back to Waiting list </button> </td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td><button style="margin-left:5px;margin-right:5px" class="btn  btn-block btn-xs btn-success pull-right text-align-left" onclick="add_to_theatre(' + d.booking_id + ');"><i class="fa fa-plus-circle"></i> Add to Theatre List </button> </td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td><button style="margin-left:5px;margin-right:5px" class="btn btn-block btn-xs btn-info pull-right text-align-left" onclick="add_mapt(' + d.booking_id + ',' + d.procedure_id + ');"><i class="fa fa-plus"></i> Add MAP Score </button> </td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td><button style="margin-left:5px;margin-right:5px" class="btn btn-block btn-xs btn-warning pull-right text-align-left" onclick="view_mapt(' + d.booking_id + ',' + d.procedure_id + ');"><i class="fa fa-list"></i> View MAP Score</button> </td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td><button style="margin-left:5px;margin-right:5px" class="btn btn-block btn-xs btn-success pull-right text-align-left" onclick="send_message(' + d.booking_id + ');"><i class="fa fa-envelope"></i> Send SMS</button> </td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td><button style="margin-left:5px;margin-right:5px" class="btn btn-block btn-xs btn-default pull-right text-align-left" onclick="add_comments(' + d.booking_id + ');"><i class="fa fa-comment"></i> Add Comments</button> </td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td ><button style="margin-left:5px;margin-right:5px" class="btn btn-block btn-xs btn-danger pull-right text-align-left" onclick="remove_booking(' + d.booking_id + ');"> <i class="fa fa-remove"></i> Remove Booking </button> ' +
                    '</td>' +
                    '</tr>';
        } else if (d.booking_status === '2') {
            buttons = '<tr>' +
                    '<td><button style="margin-left:5px;margin-right:5px" class="btn btn-block btn-xs btn-primary pull-right text-align-left" onclick="back_to_waiting(' + d.booking_id + ');"><i class="fa fa-backward"></i> Back to Waiting list </button> </td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td><button style="margin-left:5px;margin-right:5px" class="btn btn-xs btn-block btn-warning pull-right text-align-left" onclick="back_to_admission(' + d.booking_id + ');"> <i class="fa fa-backward"></i> Back to Admission </button>  </td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td><button style="margin-left:5px;margin-right:5px" class="btn btn-xs btn-block btn-success pull-right text-align-left" onclick="record_ops(' + d.booking_id + ');"><i class="fa fa-microphone"></i> Record Operation </button> </td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td><button style="margin-left:5px;margin-right:5px" class="btn btn-block btn-xs btn-info pull-right text-align-left" onclick="add_mapt(' + d.booking_id + ',' + d.procedure_id + ');"><i class="fa fa-plus"></i> Add MAP Score </button> </td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td><button style="margin-left:5px;margin-right:5px" class="btn btn-block btn-xs btn-warning pull-right text-align-left" onclick="view_mapt(' + d.booking_id + ',' + d.procedure_id + ');"><i class="fa fa-list"></i> View MAP Score</button> </td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td><button style="margin-left:5px;margin-right:5px" class="btn btn-block btn-xs btn-default pull-right text-align-left" onclick="add_comments(' + d.booking_id + ');"><i class="fa fa-comment"></i> Add Comments</button> </td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td ><button style="margin-left:5px;margin-right:5px" class="btn btn-block btn-xs btn-danger pull-right text-align-left" onclick="remove_booking(' + d.booking_id + ');"> <i class="fa fa-remove"></i> Remove Booking </button> ' +
                    '</td>' +
                    '</tr>';
        } else if (d.booking_status === '3') {
            buttons = '<tr>' +
                    '<td><a href="' + jsonPath + '/patients/patient_page/' + d.patient_id + '" style="margin-right:5px;margin-left:5px" class="btn btn-block btn-xs btn-info pull-right text-align-left"><i class="fa fa-search"></i> View Patient</a> </td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td><button style="margin-left:5px;margin-right:5px" class="btn  btn-block btn-xs btn-success pull-right text-align-left" onclick="view_opnotes(' + d.booking_id + ');"><i class="fa fa-file"></i> View OP Notes </button> </td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td><button style="margin-left:5px;margin-right:5px" class="btn btn-block btn-xs btn-primary pull-right text-align-left" onclick="edit_optnotes(' + d.booking_id + ');"> <i class="fa fa-pencil"></i> Edit OP Notes </button> </td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td><button style="margin-left:5px;margin-right:5px" class="btn btn-block btn-xs btn-warning pull-right text-align-left" onclick="view_mapt(' + d.booking_id + ',' + d.procedure_id + ');"><i class="fa fa-list"></i> View MAP Score</button> </td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td><button style="margin-left:5px;margin-right:5px" class="btn btn-block btn-xs btn-default pull-right text-align-left" onclick="add_comments(' + d.booking_id + ');"><i class="fa fa-comment"></i> Add Comments</button> </td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td><a href="' + jsonPath + '/theatre/patient_coding/' + d.booking_id + '" style="margin-left:5px;margin-right:5px"  class="btn btn-block btn-danger btn-xs pull-right text-align-left" data-toggle="tooltip" data-placement="top" data-original-title="Patient Coding"><i class="fa fa-flask"></i> Patient Coding</a></td>' +
                    '</tr>';
        } else if (d.booking_status === '4') {
            buttons = '<tr>' +
                    '<td><button style="margin-left:5px;margin-right:5px" class="btn  btn-block btn-xs btn-success pull-right text-align-left" onclick="view_opnotes(' + d.booking_id + ');"><i class="fa fa-file"></i> View OP Notes </button> </td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td><button style="margin-left:5px;margin-right:5px" class="btn btn-block btn-xs btn-primary pull-right text-align-left" onclick="edit_optnotes(' + d.booking_id + ');"> <i class="fa fa-pencil"></i> Edit OP Notes </button> </td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td><button style="margin-left:5px;margin-right:5px" class="btn btn-block btn-xs btn-warning pull-right text-align-left" onclick="view_mapt(' + d.booking_id + ',' + d.procedure_id + ');"><i class="fa fa-list"></i> View MAP Score</button> </td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td><button style="margin-left:5px;margin-right:5px" class="btn btn-block btn-xs btn-default pull-right text-align-left" onclick="add_comments(' + d.booking_id + ');"><i class="fa fa-comment"></i> Add Comments</button> </td>' +
                    '</tr>';
        }

        return '<table class="table table-condensed">' +
                '<tr>' +
                '<td width="45%">' +
                '<table cellpadding="5" cellspacing="0" border="0" class="table table-hover table-condensed">' +
                '<tr>' +
                '<td width="35%"><b>Folder Number:</b></td>' +
                '<td>' + d.folder_number + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Fullname:</b></td>' +
                '<td>' + d.surname + ' ' + d.other_names + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Booked Procedure:</b></td>' +
                '<td>' + d.procedure_name + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Operation Done:</b></td>' +
                '<td>' + d.operation_done + '</td>' +
                '</tr>' +
                '<tr>' +
                '<tr>' +
                '<td><b>Category:</b></td>' +
                '<td>' + d.category_name + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Comments:</b></td>' +
                '<td>' + d.additional_info + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Insurance:</b></td>' +
                '<td>' + d.insuranceco_name + ' (#:' + d.insurance_number + ')</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Booked By:</b></td>' +
                '<td>' + d.bookedby + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Admitted By:</b></td>' +
                '<td>' + d.bookedby + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Primary Surgeon:</b></td>' +
                '<td>' + d.primary_surgeon + '</td>' +
                '</tr>' +
                '</table>' +
                '</td>' +
                '<td width="45%">' +
                '<table cellpadding="5" cellspacing="0" border="0" class="table table-hover table-condensed">' +
                '<tr>' +
                '<td style="width:100px"><b>DOB:</b></td>' +
                '<td>' + d.dateofbirth + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td style="width:100px"><b>Booking Date</b></td>' +
                '<td>' + d.booking_date + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td style="width:100px"><b>Lead time:</b></td>' +
                '<td>' + d.leadtime + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td style="width:100px"><b>Surgery Duration:</b></td>' +
                '<td>' + d.surgery_time + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td style="width:100px"><b>Priority:</b></td>' +
                '<td>' + d.priority_name + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td style="width:100px"><b>Indication:</b></td>' +
                '<td>' + d.surgery_indication + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Anesthesia:</b></td>' +
                '<td>' + d.anesthesia + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>PostOP Bed:</b></td>' +
                '<td>' + d.postopbed + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><b>Surgeon Assistants</b></td>' +
                '<td>' + d.assistant_surgeon + '</td>' +
                '</tr>' +
                '</table>' +
                '</td>' +
                '<td width="10%">' +
                '<table cellpadding="5" cellspacing="0" border="0" class="table table-hover table-condensed">' +
                buttons +
                '</table>' +
                '</td>' +
                '</tr>' +
                '</table>';

    }

    if ($('#patient_id').length > 0 && $('#patient_id').val() != '') {
        var patient_id = $('#patient_id').val();
        var mydepartmentid = $('#mydepartmentid').val();

        var patientwaitinglist = $('#patientwaitinglist_table').DataTable({
            "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
                    "t" +
                    "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
            "autoWidth": true,
            "bDestroy": true,
            "iDisplayLength": 15,
            ajax:
                    {
                        "url": jsonPath + "/theatre/mypatients_booking_list_data/" + patient_id,
                        "type": "POST"
                    },
            "deferLoading": 57,
            "columns": [
                {
                    "class": 'details-control',
                    "orderable": false,
                    "data": null,
                    "defaultContent": ''
                },
                {data: "booking_date"},
                {data: "procedure_name"},
                {data: "leadtime"},
                {data: "theatre_name"},
                {data: "status_name"},
                {data:"department_name"}
            ],
            "order": [[3, 'asc']]
        });
        // Add event listener for opening and closing details
        $('#patientwaitinglist_table tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = patientwaitinglist.row(tr);

            if ((row.data().department_id) === mydepartmentid) {
                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    // Open this row
                    row.child(patientwaitinglist_format(row.data())).show();
                    tr.addClass('shown');

                }
            }else{
               tr.addClass('blocked'); 
            }

        });
    } else
    {
        $('#patientwaitinglist_table').DataTable();
    }

    /* Formatting function for row details - modify as you need */
    function patientlist_format(d) {
        // `d` is the original data object for the row
        return '<table cellpadding="5" cellspacing="0" border="0" class="table table-hover table-condensed">' +
                '<tr>' +
                '<td style="width:80%">' +
                '<table cellpadding="5" cellspacing="0" border="0" class="table table-hover table-condensed">' +
                '<tr>' +
                '<td style="width:100px"><b>Notes:</b></td>' +
                '<td>' + d.additional_info + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td style="width:100px"><b>Email:</b></td>' +
                '<td>' + d.email + '</td>' +
                '</tr>' +
                '</table>' +
                '</td>' +
                '<td width="10%">' +
                '<table cellpadding="5" cellspacing="0" border="0" class="table table-hover table-condensed">' +
                '<tr>' +
                '<td><a href="' + jsonPath + '/patients/patient_page/' + d.patient_id + '" style="margin-right:5px;margin-left:5px" class="btn btn-block btn-xs btn-info pull-right text-align-left"><i class="fa fa-search"></i> View Patient</a> </td>' +
                '</tr>' +
                '<tr>' +
                '<td><a href="' + jsonPath + '/patients/add_patient/' + d.patient_id + '#s1" style="margin-right:5px;margin-left:5px" class="btn btn-block btn-warning btn-xs pull-right text-align-left" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil"></i> Edit</a> </td>' +
                '</tr>' +
                '<tr>' +
                '<td><a href="' + jsonPath + '/patients/add_patient/' + d.patient_id + '#s2" style="margin-left:5px;margin-right:5px"  class="btn btn-xs btn-block btn-success pull-right"> <i class="fa fa-plus-circle"></i> Book for Surgery</a> </td>' +
                '</tr>' +
                '</table>' +
                '</td>' +
                '<td width="10%">' +
                '<table cellpadding="5" cellspacing="0" border="0" class="table table-hover table-condensed">' +
                '<tr>' +
                '<td><button style="margin-left:5px;margin-right:5px" class="btn btn-block btn-xs btn-default pull-right text-align-left" onclick="add_comments(' + d.patient_id + ');"><i class="fa fa-comment"></i> Add Comments</button> </td>' +
                '</tr>' +
                '<tr>' +
                '<td><a href="' + jsonPath + '/theatre/patient_log/' + d.patient_id + '" style="margin-left:5px;margin-right:5px"  class="btn btn-block btn-info btn-xs pull-right text-align-left" data-toggle="tooltip" data-placement="top" data-original-title="View Patient Log"><i class="fa fa-search"></i> View Patient Log</a></td>' +
                '</tr>' +
                '<tr>' +
                '<td><button class="btn btn-block btn-xs btn-danger pull-right text-align-left" style="margin-left:5px;margin-right:5px" onclick="delete_patient(' + d.patient_id + ');"><i class="fa fa-trash"></i> Delete Patient</button>  ' +
                '</td></tr>' +
                '</table>' +
                '</td>' +
                '</tr>' +
                '</table>';
    }
    function patient_redirect(d) {
        window.location.href = jsonPath + '/patients/patient_page/' + d.patient_id;
        //$("#s2").addClass("active");+ '#s2'
        //alert(d.patient_id);        
    }

    var patienttable = $('#patientlist_table').DataTable({
        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
                "t" +
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
        "autoWidth": true,
        "bDestroy": true,
        "iDisplayLength": 15,
        ajax:
                {
                    "url": jsonPath + "/patients/mypatient_list_data/",
                    "type": "POST"
                },
        "deferLoading": 57,
        "columns": [
            {data: "folder_number"},
            {data: "fullname"},
            {data: "dateofbirth"},
            {data: "gender"},
            {data: "phone"}
        ],
        "order": [[1, 'asc']]
    });
    // Add event listener for opening and closing details
    /*$('#patientlist_table tbody').on('click', 'td.details-control', function () {
     var tr = $(this).closest('tr');
     var row = patienttable.row(tr);
     
     if (row.child.isShown()) {
     // This row is already open - close it
     row.child.hide();
     tr.removeClass('shown');
     } else {
     // Open this row
     row.child(patientlist_format(row.data())).show();
     tr.addClass('shown');
     }
     });*/

    // Add event listener for opening and closing details
    $('#patientlist_table tbody').on('click', 'td', function () {

        var tr = $(this).closest('tr');
        var row = patienttable.row(tr);
        if (row.child.isShown()) {
            row.child(patient_redirect(row.data())).show();
        } else {
            row.child(patient_redirect(row.data())).show();
        }

    });


    // Apply the filter
    // $("#my_bookingstable thead th input[type=text]").on('keyup change', function () {

    ////    my_bookings
    //          .column($(this).parent().index() + ':visible')
    //        .search(this.value)
    //      .draw();

    //});

    if ($('#booking_id').length > 0) {
        var booking = $('#booking_id').val();
        $('#booking_procedures').dataTable({
            "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
                    "t" +
                    "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
            "autoWidth": true,
            "oLanguage": {
                "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
            },
            "preDrawCallback": function () {
                // Initialize the responsive datatables helper once.
                if (!responsiveHelper_booking_procedures) {
                    responsiveHelper_booking_procedures = new ResponsiveDatatablesHelper($('#booking_procedures'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow) {
                responsiveHelper_booking_procedures.createExpandIcon(nRow);
            },
            "drawCallback": function (oSettings) {
                responsiveHelper_booking_procedures.respond();
            },
            processing: true,
            serverSide: false,
            ajax: {
                "url": jsonPath + "/theatre/booking_procedures_data/",
                "type": "POST",
                data: {booking_id: booking}
            },
            "deferLoading": 57,
            "columns": [
                {"width": "20%", "orderable": true, data: "rpl_code"},
                {"width": "50%", "orderable": false, data: "procedure_name"},
                {"width": "15%", "orderable": false, data: "service_fee"},
                {
                    "width": "15%",
                    targets: -1,
                    data: 'procedure_id',
                    render: function (data, type, full, meta) {
                        return   '<button class="btn btn-xs btn-success pull-left text-align-left" title="Add Consumables"  onclick="add_procedure_consumables(\'' + data + '\',\'' + booking + '\');"><i class="fa fa-plus"></i> </button>  \n\
                                    <button class="btn btn-xs btn-danger  text-align-left" title="Remove this Procedure"  onclick="remove_booking_procedure(\'' + data + '\',\'' + booking + '\');"><i class="fa fa-remove"></i> </button>';
                    }

                }
            ],
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5', 'print'
            ]
        });
    }

    ////////////==============================///////////

    $('#rpl_nappi_codess').DataTable({
        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
                "t" +
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
        "autoWidth": true,
        "oLanguage": {
            "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
        },
        "preDrawCallback": function () {
            // Initialize the responsive datatables helper once.
            if (!responsiveHelper_dt_basic) {
                responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#rpl_nappi_codes'), breakpointDefinition);
            }
        },
        "rowCallback": function (nRow) {
            responsiveHelper_dt_basic.createExpandIcon(nRow);
        },
        "drawCallback": function (oSettings) {
            responsiveHelper_dt_basic.respond();
        }
    });

    $('#dt_basic').dataTable({
        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>" +
                "t" +
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
        "autoWidth": true,
        "oLanguage": {
            "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
        },
        "preDrawCallback": function () {
            // Initialize the responsive datatables helper once.
            if (!responsiveHelper_dt_basic) {
                responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
            }
        },
        "rowCallback": function (nRow) {
            responsiveHelper_dt_basic.createExpandIcon(nRow);
        },
        "drawCallback": function (oSettings) {
            responsiveHelper_dt_basic.respond();
        }
    });

    /* END BASIC */

    /* COLUMN FILTER  */
    var otable = $('#datatable_fixed_column').DataTable({
        //"bFilter": false,
        //"bInfo": false,
        //"bLengthChange": false
        //"bAutoWidth": false,
        //"bPaginate": false,
        //"bStateSave": true // saves sort state using localStorage
        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
                "t" +
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
        "autoWidth": true,
        "oLanguage": {
            "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
        },
        "preDrawCallback": function () {
            // Initialize the responsive datatables helper once.
            if (!responsiveHelper_datatable_fixed_column) {
                responsiveHelper_datatable_fixed_column = new ResponsiveDatatablesHelper($('#datatable_fixed_column'), breakpointDefinition);
            }
        },
        "rowCallback": function (nRow) {
            responsiveHelper_datatable_fixed_column.createExpandIcon(nRow);
        },
        "drawCallback": function (oSettings) {
            responsiveHelper_datatable_fixed_column.respond();
        }

    });

    // custom toolbar
    $("div.toolbar").html('<div class="text-right"><img src="' + jsonPath + '/assets/img/logo.png" alt="Surgitrack" style="width: 111px; margin-top: 3px; margin-right: 10px;"></div>');

    // Apply the filter
    $("#datatable_fixed_column thead th input[type=text]").on('keyup change', function () {

        otable
                .column($(this).parent().index() + ':visible')
                .search(this.value)
                .draw();

    });
    /* END COLUMN FILTER */

    /* COLUMN SHOW - HIDE */
    $('#datatable_col_reorder').dataTable({
        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'C>r>" +
                "t" +
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
        "autoWidth": true,
        "oLanguage": {
            "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
        },
        "preDrawCallback": function () {
            // Initialize the responsive datatables helper once.
            if (!responsiveHelper_datatable_col_reorder) {
                responsiveHelper_datatable_col_reorder = new ResponsiveDatatablesHelper($('#datatable_col_reorder'), breakpointDefinition);
            }
        },
        "rowCallback": function (nRow) {
            responsiveHelper_datatable_col_reorder.createExpandIcon(nRow);
        },
        "drawCallback": function (oSettings) {
            responsiveHelper_datatable_col_reorder.respond();
        }
    });

    /* END COLUMN SHOW - HIDE */

    /* TABLETOOLS */
    $('#datatable_tabletools').DataTable({
        // Tabletools options: 
        //   https://datatables.net/extensions/tabletools/button_options
        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'T>r>" +
                "t" +
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
        "oLanguage": {
            "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
        },

        "autoWidth": true,
        "preDrawCallback": function () {
            // Initialize the responsive datatables helper once.
            if (!responsiveHelper_datatable_tabletools) {
                responsiveHelper_datatable_tabletools = new ResponsiveDatatablesHelper($('#datatable_tabletools'), breakpointDefinition);
            }
        },
        "rowCallback": function (nRow) {
            responsiveHelper_datatable_tabletools.createExpandIcon(nRow);
        },
        "drawCallback": function (oSettings) {
            responsiveHelper_datatable_tabletools.respond();
        },
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5', 'print'
        ]
    });


    /*$('#rpl_nappi_codes').DataTable();*/

    /* END TABLETOOLS */

});


function view_booking_notes(d) {
    //  view_opnotes(d.booking_id );
    alert(d.booking_id);
    // var jsonPath = SurgiTrack.handleBaseURL();
    $('#myModalViewOpNotes').modal('show');
    $.ajax({
        dataType: 'json',
        type: "POST",
        url: jsonPath + "/patients/preview_op_notes_pdf",
        data: {booking_id: d.booking_id},
        success: function (data) {
            $(".modal-body #booking_id").val(d.booking_id);
            $(".modal-body #patient_opnotes").html(data.file_iframe);
        }

    });
}