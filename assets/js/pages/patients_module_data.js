// DO NOT REMOVE : GLOBAL FUNCTIONS!

$(document).ready(function () {
    var jsonPath = SurgiTrack.handleBaseURL();
    pageSetUp();

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

    function patient_redirect(d) {
        window.location.href = jsonPath + '/patients/patient_page/' + d.patient_id;
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
                '<td><a href="' + jsonPath + '/booking/patient_coding/' + d.booking_id + '" style="margin-left:5px;margin-right:5px"  class="btn btn-block btn-danger btn-xs pull-right text-align-left" data-toggle="tooltip" data-placement="top" data-original-title="Patient Coding"><i class="fa fa-flask"></i> Patient Coding</a></td>' +
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
                    "url": jsonPath + "/booking/mypatients_booking_list_data/" + patient_id,
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
            '<td><a href="' + jsonPath + '/booking/patient_log/' + d.patient_id + '" style="margin-left:5px;margin-right:5px"  class="btn btn-block btn-info btn-xs pull-right text-align-left" data-toggle="tooltip" data-placement="top" data-original-title="View Patient Log"><i class="fa fa-search"></i> View Patient Log</a></td>' +
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


    /* END PATIENTS MODULE DATA */

});