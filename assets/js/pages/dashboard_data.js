$(document).ready(function () {
    var jsonPath = SurgiTrack.handleBaseURL();
    pageSetUp();
    "use strict";

    var responsiveHelper_procedure_summary = undefined;
    var responsiveHelper_fac_procedure_summary = undefined;
    var breakpointDefinition = {
        tablet: 1024,
        phone: 480
    };
    /*
     * PAGE RELATED SCRIPTS
     */

    var procedure_summary = $('#procedure_summary_table').dataTable({
        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
        "t" +
        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
        "autoWidth": true,
        "oLanguage": {
            "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
        },
        "preDrawCallback": function () {
            // Initialize the responsive datatables helper once.
            if (!responsiveHelper_procedure_summary) {
                responsiveHelper_procedure_summary = new ResponsiveDatatablesHelper($('#procedure_summary_table'), breakpointDefinition);
            }
        },
        "rowCallback": function (nRow) {
            responsiveHelper_procedure_summary.createExpandIcon(nRow);
        },
        "drawCallback": function (oSettings) {
            responsiveHelper_procedure_summary.respond();
        },
        processing: true,
        serverSide: false,
        ajax: {
            "url": jsonPath + "/booking/procedure_summary_data/",
            "type": "POST"
        },
        "iDisplayLength": 15,
        "deferLoading": 57,
        "order": [[2, "desc"]],
        "columns": [
            {"width": "50%",
                "orderable": true,
                data: "procedure_name",
                render: function (data, type, full, meta) {
                    return   ' <a href="' + jsonPath + '/booking/waiting_list/?procedure=' + data + '"><i class="fa fa-view"></i>'+ data +'</a>';
                }
            },
            {"width": "30%", "orderable": true, data: "category_name"},
            {"width": "20%", "orderable": true, data: "waiting"}
        ],
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5', 'print'
        ]
    });

    // Apply the filter
    $("#procedure_summary_table thead th input[type=text]").on('keyup change', function () {

        procedure_summary
            .column($(this).parent().index() + ':visible')
            .search(this.value)
            .draw();

    });


    var facility_procedure_summary = $('#facility_procedure_summary_table').dataTable({
        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
        "t" +
        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
        "autoWidth": true,
        "oLanguage": {
            "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
        },
        "preDrawCallback": function () {
            // Initialize the responsive datatables helper once.
            if (!responsiveHelper_fac_procedure_summary) {
                responsiveHelper_fac_procedure_summary = new ResponsiveDatatablesHelper($('#facility_procedure_summary_table'), breakpointDefinition);
            }
        },
        "rowCallback": function (nRow) {
            responsiveHelper_fac_procedure_summary.createExpandIcon(nRow);
        },
        "drawCallback": function (oSettings) {
            responsiveHelper_fac_procedure_summary.respond();
        },
        processing: true,
        serverSide: false,
        ajax: {
            "url": jsonPath + "/booking/facility_procedure_summary_data/",
            "type": "POST"
        },
        "iDisplayLength": 15,
        "deferLoading": 57,
        "order": [[2, "desc"]],
        "columns": [
            {"width": "50%",
                "orderable": true,
                data: "procedure_name",
                render: function (data, type, full, meta) {
                    return   ' <a href="' + jsonPath + '/booking/waiting_list/?procedure=' + data + '"><i class="fa fa-view"></i>'+ data +'</a>';
                }
            },
            {"width": "30%", "orderable": true, data: "category_name"},
            {"width": "20%", "orderable": true, data: "waiting"}
        ],
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5', 'print'
        ]
    });

    // Apply the filter
    $("#facility_procedure_summary_table thead th input[type=text]").on('keyup change', function () {

        facility_procedure_summary
            .column($(this).parent().index() + ':visible')
            .search(this.value)
            .draw();

    });


});