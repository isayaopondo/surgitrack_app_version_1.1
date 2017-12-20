$(document).ready(function () {

});

function filter_list_firm(cat, d) {
    var jsonPath = SurgiTrack.handleBaseURL();
    if (cat === "waiting") {

        $('#waitinglist_table').DataTable().clear().destroy();
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
                        "url": jsonPath + "/booking/mywaiting_list_data/",
                        "type": "POST",
                        "data": {firm_id: d}
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
            "order": [[6, 'asc']]
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

        // Apply the filter
        $("#waitinglist_table thead th input[type=text]").on('keyup change', function () {

            table
                    .column($(this).parent().index() + ':visible')
                    .search(this.value)
                    .draw();

        });
    }
    if (cat === "theatre") {
        $('#theatrelist_table').DataTable().clear().destroy();
        var theatrelisttable = $('#theatrelist_table').DataTable({
            "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
                    "t" +
                    "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",

            "autoWidth": true,
            "bDestroy": true,
            "iDisplayLength": 15,
            ajax:
                    {
                        "url": jsonPath + "/booking/mytheatre_list_data/",
                        "type": "POST",
                        "data": {firm_id: d}
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
            "order": [[6, 'asc']],

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
    }
    if (cat === 'admission') {

        $('#admissionlist_table').DataTable().clear().destroy();

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
                        "url": jsonPath + "/booking/myadmission_list_data/",
                        "type": "POST",
                        "data": {firm_id: d}
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
            "order": [[6, 'asc']]
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
    }

    if (cat === 'procedure') {
        $('#procedure_summary_table').DataTable().clear().destroy();

        var procedure_summary_table = $('#procedure_summary_table').DataTable({
            //"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-4 col-xs-12 hidden-xs'T><'col-sm-2 col-xs-12 hidden-xs'<'toolbar'>r>" +
            "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
                    "t" +
                    "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
            "autoWidth": true,
            "bDestroy": true,
            "iDisplayLength": 15,
            ajax: {
                "url": jsonPath + "/booking/procedure_summary_data/",
                "type": "POST",
                "data": {firm_id: d}
            },
            "iDisplayLength": 15,
            "deferLoading": 57,
            "order": [[2, "desc"]],
            "columns": [
                {"width": "50%", "orderable": true, data: "procedure_name"},
                {"width": "30%", "orderable": true, data: "category_name"},
                {"width": "20%", "orderable": true, data: "waiting"}
            ],
            dom: 'Bfrtip'
        });

        // Apply the filter
        $("#procedure_summary_table thead th input[type=text]").on('keyup change', function () {

            procedure_summary_table
                    .column($(this).parent().index() + ':visible')
                    .search(this.value)
                    .draw();

        });

    }
    /* END COLUMN FILTER */
}

function filter_summary_firm(cat, d) {

    var jsonPath = SurgiTrack.handleBaseURL();


    /* END COLUMN FILTER */
}

function admissionlist_format(d) {
    var jsonPath = SurgiTrack.handleBaseURL();
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
            '<td>' + d.bookedby + '</td>' +
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
            '<td><a href="' + jsonPath + '/booking/patient_log/' + d.patient_id + '" style="margin-left:5px;margin-right:5px"  class="btn btn-block btn-info btn-xs pull-right text-align-left" data-toggle="tooltip" data-placement="top" data-original-title="View Patient Log"><i class="fa fa-search"></i> View Patient Log</a></td>' +
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

function theatrelist_format(d) {
    var jsonPath = SurgiTrack.handleBaseURL();
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
            '<td>' + d.bookedby + '</td>' +
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
            '<td><a href="' + jsonPath + '/booking/patient_log/' + d.patient_id + '" style="margin-left:5px;margin-right:5px"  class="btn btn-block btn-info btn-xs pull-right text-align-left" data-toggle="tooltip" data-placement="top" data-original-title="View Patient Log"><i class="fa fa-search"></i> View Patient Log</a></td>' +
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

function waitinglist_format(d) {
    var jsonPath = SurgiTrack.handleBaseURL();
    var side = '';
    if (d.laterality !== 'None' && d.laterality !== "")
    {
        side = '[' + d.laterality + ']';
    }
    // `d` is the original data object for the row
    return '<table class="table table-condensed">' +
            '<tr>' +
            '<td width="50%">' +
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
            '</table>' +
            '</td>' +
            '<td width="50%">' +
            '<table cellpadding="5" cellspacing="0" border="0" class="table table-hover table-condensed">' +
            '<tr>' +
            '<td><b>Anesthesia:</b></td>' +
            '<td>' + d.anesthesia + '</td>' +
            '</tr>' +
            '<tr>' +
            '<td><b>PostOP Bed:</b></td>' +
            '<td>' + d.postopbed + '</td>' +
            '</tr>' +
            '<tr>' +
            '<td style="width:100px"><b>Indication:</b></td>' +
            '<td>' + d.surgery_indication + '</td>' +
            '</tr>' +
            '<tr>' +
            '<td>Action:</td>' +
            '<td><a href="' + jsonPath + '/booking/patient_log/' + d.patient_id + '" style="margin-left:5px"  class="btn btn-primary btn-xs pull-left" data-toggle="tooltip" data-placement="top" data-original-title="View Patient Log"><i class="fa fa-search"></i> View Patient Log</a>' +
            '<a href="' + jsonPath + '/index.php/patients/add_patient/' + d.patient_id + '/' + d.booking_id + '" style="margin-left:5px"  class=" btn btn-info btn-xs rounded pull-right" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil"></i> Edit</a>' +
            '<button style="margin-left:5px;margin-right:5px" class="btn btn-xs btn-danger pull-right" onclick="remove_booking(' + d.booking_id + ');"> <i class="fa fa-remove"></i> Remove Booking </button> ' +
            '</td></tr>' +
            '<tr>' +
            '<td style="width:100px"></td>' +
            '<td>' +
            '<button style="margin-left:5px;margin-right:5px" class="btn btn-xs btn-warning pull-right" onclick="view_mapt(' + d.booking_id + ');"><i class="fa fa-list"></i> MAPT </button> ' +
            '<button style="margin-left:5px;margin-right:5px" class="btn btn-xs btn-success pull-right" onclick="add_to_admission(' + d.booking_id + ');"><i class="fa fa-plus"></i> Add to Admission </button> ' +
            '</td>' +
            '</tr>' +
            '</table>' +
            '</td>' +
            '</tr>' +
            '</table>';
}


function load_group_procedures(d) {
    var jsonPath = SurgiTrack.handleBaseURL();
    $('#terminologies_procedures').DataTable().clear().destroy();

    var procedure_summary_table = $('#terminologies_procedures').DataTable({
        //"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-4 col-xs-12 hidden-xs'T><'col-sm-2 col-xs-12 hidden-xs'<'toolbar'>r>" +
        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
                "t" +
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
        "autoWidth": true,
        "bDestroy": true,
        "iDisplayLength": 15,
        ajax: {
            "url": jsonPath + "/settings/procedure_data/",
            "type": "POST",
            "data": {group: d}
        },
        "iDisplayLength": 15,
        "deferLoading": 57,
        "order": [[2, "desc"]],
        "columns": [
            {"width": "10%", "orderable": true, data: "rpl_code"},
            {"width": "10%", "orderable": true, data: "procedure_fullname"},
            {"width": "10%", "orderable": false, data: "procedure_name"},
            {"width": "10%", "orderable": false, data: "category_name"},
            {"width": "15%", "orderable": true, data: "group_name"},
            {"width": "15%", "orderable": true, data: "subgroup_name"},
            {"width": "15%", "orderable": false, data: "service_fee"}

        ],
        dom: 'Bfrtip'
    });

    // Apply the filter
    $("#terminologies_procedures thead th input[type=text]").on('keyup change', function () {

        procedure_summary_table
                .column($(this).parent().index() + ':visible')
                .search(this.value)
                .draw();

    });
}
function load_subgroup_procedures(d) {
    
    var jsonPath = SurgiTrack.handleBaseURL();
    $('#terminologies_procedures').DataTable().clear().destroy();

    var procedure_summary_table = $('#terminologies_procedures').DataTable({
        //"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-4 col-xs-12 hidden-xs'T><'col-sm-2 col-xs-12 hidden-xs'<'toolbar'>r>" +
        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
                "t" +
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
        "autoWidth": true,
        "bDestroy": true,
        "iDisplayLength": 15,
        ajax: {
            "url": jsonPath + "/settings/procedure_data/",
            "type": "POST",
            "data": {sub_group: d}
        },

        "deferLoading": 57,
        "columns": [
            {"width": "10%", "orderable": true, data: "rpl_code"},
            {"width": "10%", "orderable": true, data: "procedure_fullname"},
            {"width": "10%", "orderable": false, data: "procedure_name"},
            {"width": "10%", "orderable": false, data: "category_name"},
            {"width": "15%", "orderable": true, data: "group_name"},
            {"width": "15%", "orderable": true, data: "subgroup_name"},
            {"width": "15%", "orderable": false, data: "service_fee"}

        ],
        dom: 'Bfrtip'
    });

    // Apply the filter
    $("#terminologies_procedures thead th input[type=text]").on('keyup change', function () {

        procedure_summary_table
                .column($(this).parent().index() + ':visible')
                .search(this.value)
                .draw();

    });
}
