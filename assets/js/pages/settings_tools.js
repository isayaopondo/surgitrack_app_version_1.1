/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {
    var jsonPath = SurgiTrack.handleBaseURL();
    pageSetUp();

    var responsiveHelper_facilities = undefined;
    var responsiveHelper_theatres = undefined;
    var responsiveHelper_departments = undefined;
    var responsiveHelper_firms = undefined;
    var responsiveHelper_wards = undefined;
    var responsiveHelper_suburbs = undefined;
    var responsiveHelper_timeslot = undefined;
    var responsiveHelper_mapt_list = undefined;
    var responsiveHelper_procedures = undefined;
    var responsiveHelper_category = undefined;
    var responsiveHelper_nappi_consumables = undefined;
    var responsiveHelper_insurance = undefined;
    var responsiveHelper_rpl_procedurecodes = undefined;
    var responsiveHelper_rpl_nappi_codes = undefined;
    var responsiveHelper_procedure_subgroup = undefined;
    var responsiveHelper_procedure_groups = undefined;
    var responsiveHelper_terminologies_procedures = undefined;
    var responsiveHelper_procedure_department = undefined;

    var breakpointDefinition = {
        tablet: 1024,
        phone: 480
    };
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

    var facilities = $('#facilitiestable').dataTable({
        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
        "t" +
        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
        "autoWidth": true,
        "oLanguage": {
            "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
        },
        "preDrawCallback": function () {
            // Initialize the responsive datatables helper once.
            if (!responsiveHelper_facilities) {
                responsiveHelper_facilities = new ResponsiveDatatablesHelper($('#facilitiestable'), breakpointDefinition);
            }
        },
        "rowCallback": function (nRow) {
            responsiveHelper_facilities.createExpandIcon(nRow);
        },
        "drawCallback": function (oSettings) {
            responsiveHelper_facilities.respond();
        },
        processing: true,
        serverSide: false,
        ajax: {
            "url": jsonPath + "/settings/facilities_data/",
            "type": "POST"
        },
        "deferLoading": 57,
        "columns": [
            {"width": "30%", "orderable": true, data: "facility_name"},
            {"width": "15%", "orderable": false, data: "facility_town"},
            {"width": "15%", "orderable": false, data: "facility_phone"},
            {"width": "20%", "orderable": false, data: "facility_address"},
            {
                "width": "20%",
                targets: -1,
                data: 'facility_id',
                render: function (data, type, full, meta) {
                    return '<a href="' + jsonPath + '/settings/facilities/' + data + '"  class=" btn btn-success btn-xs rounded" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil"></i></a> \n\
<a href="' + jsonPath + '/settings/delete_facilities/' + data + '"  class=" btn btn-danger btn-xs rounded" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-times"></i></a>';
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

    // Apply the filter
    $("#facilitiestable thead th input[type=text]").on('keyup change', function () {

        facilities
            .column($(this).parent().index() + ':visible')
            .search(this.value)
            .draw();

    });


    var wards = $('#wardstable').dataTable({
        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
        "t" +
        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
        "autoWidth": true,
        "oLanguage": {
            "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
        },
        "preDrawCallback": function () {
            // Initialize the responsive datatables helper once.
            if (!responsiveHelper_wards) {
                responsiveHelper_wards = new ResponsiveDatatablesHelper($('#wardstable'), breakpointDefinition);
            }
        },
        "rowCallback": function (nRow) {
            responsiveHelper_wards.createExpandIcon(nRow);
        },
        "drawCallback": function (oSettings) {
            responsiveHelper_wards.respond();
        },
        processing: true,
        serverSide: false,
        ajax: {
            "url": jsonPath + "/settings/wards_data/",
            "type": "POST"
        },
        "deferLoading": 57,
        "columns": [
            {"width": "30%", "orderable": true, data: "ward_name"},
            {"width": "20%", "orderable": false, data: "ward_phone"},
            {"width": "20%", "orderable": false, data: "ward_info"},
            {
                "width": "10%",
                targets: -1,
                data: 'ward_id',
                render: function (data, type, full, meta) {
                    return '<a href="' + jsonPath + '/settings/wards/' + data + '"  class="indicatoritem btn btn-success btn-xs rounded" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil"></i></a> \n\
<a href="' + jsonPath + '/settings/delete_wards/' + data + '"  class="indicatoritem btn btn-danger btn-xs rounded" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-times"></i></a>';
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

    // Apply the filter
    $("#wardstable thead th input[type=text]").on('keyup change', function () {

        wards
            .column($(this).parent().index() + ':visible')
            .search(this.value)
            .draw();

    });


    var theatres = $('#theatrestable').dataTable({
        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'T>r>" +
        "t" +
        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
        "autoWidth": true,
        "oTableTools": {
            "aButtons": [
                "copy",
                "csv",
                "xls",
                {
                    "sExtends": "pdf",
                    "sTitle": "Surgitrack_PDF",
                    "sPdfMessage": "Surgitrack PDF Export",
                    "sPdfSize": "letter"
                },
                {
                    "sExtends": "print",
                    "sMessage": "Generated by Surgitrack <i>(press Esc to close)</i>"
                }
            ],
            "sSwfPath": "js/plugin/datatables/swf/copy_csv_xls_pdf.swf"
        },
        "oLanguage": {
            "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
        },
        "preDrawCallback": function () {
            // Initialize the responsive datatables helper once.
            if (!responsiveHelper_theatres) {
                responsiveHelper_theatres = new ResponsiveDatatablesHelper($('#theatrestable'), breakpointDefinition);
            }
        },
        "rowCallback": function (nRow) {
            responsiveHelper_theatres.createExpandIcon(nRow);
        },
        "drawCallback": function (oSettings) {
            responsiveHelper_theatres.respond();
        },
        processing: true,
        serverSide: false,
        ajax: {
            "url": jsonPath + "/settings/theatres_data/",
            "type": "POST"
        },
        "deferLoading": 57,
        "columns": [
            {"width": "30%", "orderable": true, data: "theatre_name"},
            {"width": "20%", "orderable": false, data: "theatre_phone"},
            {"width": "20%", "orderable": false, data: "theatre_info"},
            {
                "width": "10%",
                targets: -1,
                data: 'theatre_id',
                render: function (data, type, full, meta) {
                    return '<a href="' + jsonPath + '/settings/theatres/' + data + '"  class="indicatoritem btn btn-success btn-xs rounded" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil"></i></a> \n\
<a href="' + jsonPath + '/settings/delete_theatres/' + data + '"  class="indicatoritem btn btn-danger btn-xs rounded" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-times"></i></a>';
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

    // Apply the filter
    $("#theatrestable thead th input[type=text]").on('keyup change', function () {

        theatres
            .column($(this).parent().index() + ':visible')
            .search(this.value)
            .draw();

    });

    var departments = $('#departmentstable').dataTable({
        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
        "t" +
        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
        "autoWidth": true,
        "oLanguage": {
            "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
        },
        "preDrawCallback": function () {
            // Initialize the responsive datatables helper once.
            if (!responsiveHelper_departments) {
                responsiveHelper_departments = new ResponsiveDatatablesHelper($('#departmentstable'), breakpointDefinition);
            }
        },
        "rowCallback": function (nRow) {
            responsiveHelper_departments.createExpandIcon(nRow);
        },
        "drawCallback": function (oSettings) {
            responsiveHelper_departments.respond();
        },
        processing: true,
        serverSide: false,
        ajax: {
            "url": jsonPath + "/settings/departments_data/",
            "type": "POST"
        },
        "deferLoading": 57,
        "columns": [
            {"width": "30%", "orderable": true, data: "department_name"},
            {"width": "20%", "orderable": false, data: "department_phone"},
            {"width": "20%", "orderable": false, data: "department_info"},
            {
                "width": "10%",
                targets: -1,
                data: 'department_id',
                render: function (data, type, full, meta) {
                    return '<a href="' + jsonPath + '/settings/departments/' + data + '"  class="indicatoritem btn btn-success btn-xs rounded" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil"></i></a> \n\
<a href="' + jsonPath + '/settings/delete_departments/' + data + '"  class="indicatoritem btn btn-danger btn-xs rounded" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-times"></i></a>';
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

    // Apply the filter
    $("#departmentstable thead th input[type=text]").on('keyup change', function () {

        departments
            .column($(this).parent().index() + ':visible')
            .search(this.value)
            .draw();

    });


    var suburbs = $('#suburbstable').DataTable({
        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
        "t" +
        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
        "autoWidth": true,
        "oLanguage": {
            "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
        },
        "preDrawCallback": function () {
            // Initialize the responsive datatables helper once.
            if (!responsiveHelper_suburbs) {
                responsiveHelper_suburbs = new ResponsiveDatatablesHelper($('#suburbstable'), breakpointDefinition);
            }
        },
        "rowCallback": function (nRow) {
            responsiveHelper_suburbs.createExpandIcon(nRow);
        },
        "drawCallback": function (oSettings) {
            responsiveHelper_suburbs.respond();
        },
        processing: true,
        serverSide: false,
        ajax: {
            "url": jsonPath + "/settings/suburbs_data/",
            "type": "POST"
        },
        "deferLoading": 57,
        "columns": [
            {"width": "30%", "orderable": true, data: "suburb_name"},
            {"width": "20%", "orderable": false, data: "city_name"},
            {"width": "20%", "orderable": false, data: "postal_code"},
            {"width": "20%", "orderable": false, data: "street_code"},
            {
                "width": "10%",
                targets: -1,
                data: 'suburb_id',
                render: function (data, type, full, meta) {
                    return '<a href="' + jsonPath + '/settings/suburbs/' + data + '"  class="indicatoritem btn btn-success btn-xs rounded" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil"></i></a> \n\
<a href="' + jsonPath + '/settings/delete_suburbs/' + data + '"  class="indicatoritem btn btn-danger btn-xs rounded" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-times"></i></a>';
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

    // Apply the filter
    $("#suburbstable thead th input[type=text]").on('keyup change', function () {

        suburbs
            .column($(this).parent().index() + ':visible')
            .search(this.value)
            .draw();

    });

    var firms = $('#firmstable').dataTable({
        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
        "t" +
        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
        "autoWidth": true,
        "oLanguage": {
            "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
        },
        "preDrawCallback": function () {
            // Initialize the responsive datatables helper once.
            if (!responsiveHelper_firms) {
                responsiveHelper_firms = new ResponsiveDatatablesHelper($('#firmstable'), breakpointDefinition);
            }
        },
        "rowCallback": function (nRow) {
            responsiveHelper_firms.createExpandIcon(nRow);
        },
        "drawCallback": function (oSettings) {
            responsiveHelper_firms.respond();
        },
        processing: true,
        serverSide: false,
        ajax: {
            "url": jsonPath + "/settings/firms_data/",
            "type": "POST"
        },
        "deferLoading": 57,
        "columns": [
            {"width": "20%", "orderable": true, data: "firm_name"},
            {"width": "20%", "orderable": false, data: "department_name"},
            {"width": "20%", "orderable": false, data: "firm_phone"},
            {"width": "20%", "orderable": false, data: "firm_info"},
            {"width": "10%", "orderable": false, data: "firm_color"},
            {
                "width": "10%",
                targets: -1,
                data: 'firm_id',
                render: function (data, type, full, meta) {
                    return '<a href="' + jsonPath + '/settings/firms/' + data + '"  class="indicatoritem btn btn-success btn-xs rounded" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil"></i></a> \n\
<a href="' + jsonPath + '/settings/delete_firms/' + data + '"  class="indicatoritem btn btn-danger btn-xs rounded" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-times"></i></a>\n\
<button onclick="create_dropbox_folder(' + data + ');"  class="btn btn-primary btn-xs rounded"><i class="fa fa-dropbox"></i></button>';
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

    // Apply the filter
    $("#firmstable thead th input[type=text]").on('keyup change', function () {

        firms
            .column($(this).parent().index() + ':visible')
            .search(this.value)
            .draw();

    });

    var mapt_list = $('#mapt_list_table').DataTable({
        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
        "t" +
        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
        "autoWidth": true,
        "oLanguage": {
            "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
        },
        "preDrawCallback": function () {
            // Initialize the responsive datatables helper once.
            if (!responsiveHelper_mapt_list) {
                responsiveHelper_mapt_list = new ResponsiveDatatablesHelper($('#mapt_list_table'), breakpointDefinition);
            }
        },
        "rowCallback": function (nRow) {
            responsiveHelper_mapt_list.createExpandIcon(nRow);
        },
        "drawCallback": function (oSettings) {
            responsiveHelper_mapt_list.respond();
        },
        processing: true,
        serverSide: false,
        ajax: {
            "url": jsonPath + "/administrator/mapt_list_data/",
            "type": "POST"
        },
        "deferLoading": 57,
        "columns": [
            {
                "width": "30%",
                "orderable": true,
                data: "mapt_name",
                "class": 'mapt-control'
            },
            {"class": 'mapt-control', "width": "25%", "orderable": false, data: "procedure_name"},
            {"class": 'mapt-control', "width": "20%", "orderable": false, data: "department_name"},
            {
                "width": "15%",
                targets: -1,
                data: 'mapt_id',
                render: function (data, type, full, meta) {
                    return '<button title="Delete MAPT" onclick="delete_mapt(' + data + ');"  class=" btn btn-danger btn-xs rounded"><i class="fa fa-minus"></i></a>\n\
                              <button title="Add Criteria" onclick="add_mapt_cretaria(' + data + ');"  class=" btn btn-success btn-xs rounded"><i class="fa fa-plus"></i></a>\n\
                              <button title="View Criteria" onclick="preview_mapt_cretaria(' + data + ');"  class=" btn btn-primary btn-xs rounded"><i class="fa fa-search"></i></a>';
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
    // Apply the filter
    $("#mapt_list_table thead th input[type=text]").on('keyup change', function () {

        mapt_list
            .column($(this).parent().index() + ':visible')
            .search(this.value)
            .draw();
    });

    $('#mapt_list_table tbody').on('click', 'td.mapt-control', function () {
        var tr = $(this).closest('tr');
        var row = mapt_list.row(tr);

        view_mapt_cretaria(row.data());

        //alert( 'You clicked on '+data[0]+'\'s row' );
    });
    var procedures = $('#procedures').dataTable({
        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
        "t" +
        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
        "autoWidth": true,
        "oLanguage": {
            "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
        },
        "preDrawCallback": function () {
            // Initialize the responsive datatables helper once.
            if (!responsiveHelper_procedures) {
                responsiveHelper_procedures = new ResponsiveDatatablesHelper($('#procedures'), breakpointDefinition);
            }
        },
        "rowCallback": function (nRow) {
            responsiveHelper_procedures.createExpandIcon(nRow);
        },
        "drawCallback": function (oSettings) {
            responsiveHelper_procedures.respond();
        },
        processing: true,
        serverSide: false,
        ajax: {
            "url": jsonPath + "/settings/procedure_data/",
            "type": "POST"
        },
        "deferLoading": 57,
        "columns": [
            {"width": "10%", "orderable": true, data: "rpl_code"},
            {"width": "10%", "orderable": true, data: "procedure_fullname"},
            {"width": "10%", "orderable": false, data: "procedure_name"},
            {"width": "10%", "orderable": false, data: "category_name"},
            {"width": "15%", "orderable": true, data: "group_name"},
            {"width": "15%", "orderable": true, data: "subgroup_name"},
            {"width": "15%", "orderable": false, data: "service_fee"},
            {
                "width": "20%",
                targets: -1,
                data: 'procedure_id',
                render: function (data, type, full, meta) {
                    return '<a href="' + jsonPath + '/settings/procedures/' + data + '"  class="indicatoritem btn btn-success btn-xs rounded" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil"></i></a> \n\
\n\<a href="' + jsonPath + '/settings/rpl_nappi_consumables/' + data + '"  class="indicatoritem btn btn-primary btn-xs rounded" data-toggle="tooltip" data-placement="top" data-original-title="Add/View Consumables"><i class="fa fa-plus"></i></a> \n\
<button class="btn btn-danger btn-xs rounded" onclick="delete_procedure(' + data + ')"><i class="fa fa-times"></i></button>';
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

    // Apply the filter
    $("#procedures thead th input[type=text]").on('keyup change', function () {

        procedures
            .column($(this).parent().index() + ':visible')
            .search(this.value)
            .draw();

    });

    var terminologies_procedures = $('#terminologies_procedures').dataTable({
        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
        "t" +
        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
        "autoWidth": true,
        "oLanguage": {
            "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
        },
        "preDrawCallback": function () {
            // Initialize the responsive datatables helper once.
            if (!responsiveHelper_terminologies_procedures) {
                responsiveHelper_terminologies_procedures = new ResponsiveDatatablesHelper($('#terminologies_procedures'), breakpointDefinition);
            }
        },
        "rowCallback": function (nRow) {
            responsiveHelper_terminologies_procedures.createExpandIcon(nRow);
        },
        "drawCallback": function (oSettings) {
            responsiveHelper_terminologies_procedures.respond();
        },
        processing: true,
        serverSide: false,
        ajax: {
            "url": jsonPath + "/settings/procedure_data/",
            "type": "POST"
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
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5', 'print'
        ]
    });

    // Apply the filter
    $("#terminologies_procedures thead th input[type=text]").on('keyup change', function () {

        terminologies_procedures
            .column($(this).parent().index() + ':visible')
            .search(this.value)
            .draw();

    });

    var timeslot = $('#timeslot_table').dataTable({
        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
        "t" +
        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
        "autoWidth": true,
        buttons: [
            'copy', 'excel', 'pdf'
        ],
        "oLanguage": {
            "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
        },
        "preDrawCallback": function () {
            // Initialize the responsive datatables helper once.
            if (!responsiveHelper_timeslot) {
                responsiveHelper_timeslot = new ResponsiveDatatablesHelper($('#timeslot_table'), breakpointDefinition);
            }
        },
        "rowCallback": function (nRow) {
            responsiveHelper_timeslot.createExpandIcon(nRow);
        },
        "drawCallback": function (oSettings) {
            responsiveHelper_timeslot.respond();
        },
        processing: true,
        serverSide: false,
        "iDisplayLength": 20,
        ajax: {
            "url": jsonPath + "/settings/timeslots_data/",
            "type": "POST"
        },
        "deferLoading": 57,
        "columns": [
            {"width": "35%", "orderable": true, data: "slot_name"},
            {"width": "35%", "orderable": true, data: "slot_value"},
            {
                "width": "20%",
                targets: -1,
                data: 'slot_id',
                render: function (data, type, full, meta) {
                    return '<a href="' + jsonPath + '/settings/timeslots/' + data + '"  class="indicatoritem btn btn-success btn-xs rounded" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil"></i></a> \n\
<a href="' + jsonPath + '/settings/delete_timeslots/' + data + '"  class="indicatoritem btn btn-danger btn-xs rounded" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-times"></i></a>';
                }

            }
        ],

    });

    // Apply the filter
    $("#timeslot_table thead th input[type=text]").on('keyup change', function () {

        timeslot
            .column($(this).parent().index() + ':visible')
            .search(this.value)
            .draw();

    });

    var surg_category = $('#surg_category').dataTable({
        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
        "t" +
        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
        "autoWidth": true,
        "oLanguage": {
            "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
        },
        "preDrawCallback": function () {
            // Initialize the responsive datatables helper once.
            if (!responsiveHelper_category) {
                responsiveHelper_category = new ResponsiveDatatablesHelper($('#surg_category'), breakpointDefinition);
            }
        },
        "rowCallback": function (nRow) {
            responsiveHelper_category.createExpandIcon(nRow);
        },
        "drawCallback": function (oSettings) {
            responsiveHelper_category.respond();
        },
        processing: true,
        serverSide: false,
        "iDisplayLength": 5,
        ajax: {
            "url": jsonPath + "/settings/category_data/",
            "type": "POST"
        },
        "deferLoading": 57,
        "columns": [
            {"width": "35%", "orderable": true, data: "category_name"},
            {"width": "50%", "orderable": false, data: "category_description"},
            {
                "width": "20%",
                targets: -1,
                data: 'category_id',
                render: function (data, type, full, meta) {
                    return '<a href="' + jsonPath + '/settings/category/' + data + '"  class="indicatoritem btn btn-success btn-xs rounded" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil"></i></a> \n\
<a href="' + jsonPath + '/settings/delete_category/' + data + '"  class="indicatoritem btn btn-danger btn-xs rounded" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-times"></i></a>';
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

    // Apply the filter
    $("#surg_category thead th input[type=text]").on('keyup change', function () {

        surg_category
            .column($(this).parent().index() + ':visible')
            .search(this.value)
            .draw();

    });

    var procedure_groups = $('#procedure_groups').dataTable({
        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
        "t" +
        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
        "autoWidth": true,
        "oLanguage": {
            "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
        },
        "preDrawCallback": function () {
            // Initialize the responsive datatables helper once.
            if (!responsiveHelper_procedure_groups) {
                responsiveHelper_procedure_groups = new ResponsiveDatatablesHelper($('#procedure_groups'), breakpointDefinition);
            }
        },
        "rowCallback": function (nRow) {
            responsiveHelper_procedure_groups.createExpandIcon(nRow);
        },
        "drawCallback": function (oSettings) {
            responsiveHelper_procedure_groups.respond();
        },
        processing: true,
        serverSide: false,
        "iDisplayLength": 5,
        ajax: {
            "url": jsonPath + "/settings/procedure_groups_data/",
            "type": "POST"
        },
        "deferLoading": 57,
        "columns": [
            {"width": "35%", "orderable": true, data: "group_name"},
            {"width": "50%", "orderable": false, data: "group_description"},
            {
                "width": "20%",
                targets: -1,
                data: 'group_id',
                render: function (data, type, full, meta) {
                    return '<a href="' + jsonPath + '/settings/procedure_groups/' + data + '"  class="indicatoritem btn btn-success btn-xs rounded" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil"></i></a> \n\
<a href="' + jsonPath + '/settings/delete_procedure_groups/' + data + '"  class="indicatoritem btn btn-danger btn-xs rounded" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-times"></i></a>';
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

    // Apply the filter
    $("#procedure_groups thead th input[type=text]").on('keyup change', function () {

        procedure_groups
            .column($(this).parent().index() + ':visible')
            .search(this.value)
            .draw();

    });


    var procedure_subgroup = $('#procedure_subgroup').dataTable({
        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
        "t" +
        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
        "autoWidth": true,
        "oLanguage": {
            "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
        },
        "preDrawCallback": function () {
            // Initialize the responsive datatables helper once.
            if (!responsiveHelper_procedure_subgroup) {
                responsiveHelper_procedure_subgroup = new ResponsiveDatatablesHelper($('#procedure_subgroup'), breakpointDefinition);
            }
        },
        "rowCallback": function (nRow) {
            responsiveHelper_procedure_subgroup.createExpandIcon(nRow);
        },
        "drawCallback": function (oSettings) {
            responsiveHelper_procedure_subgroup.respond();
        },
        processing: true,
        serverSide: false,
        "iDisplayLength": 5,
        ajax: {
            "url": jsonPath + "/settings/procedure_subgroups_data/",
            "type": "POST"
        },
        "deferLoading": 57,
        "columns": [
            {"width": "25%", "orderable": true, data: "subgroup_name"},
            {"width": "25%", "orderable": false, data: "group_name"},
            {"width": "30%", "orderable": false, data: "subgroup_description"},
            {
                "width": "20%",
                targets: -1,
                data: 'subgroup_id',
                render: function (data, type, full, meta) {
                    return '<a href="' + jsonPath + '/settings/procedure_subgroups/' + data + '"  class="indicatoritem btn btn-success btn-xs rounded" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil"></i></a> \n\
<a href="' + jsonPath + '/settings/delete_procedure_subgroups/' + data + '"  class="indicatoritem btn btn-danger btn-xs rounded" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-times"></i></a>';
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

    // Apply the filter
    $("#procedure_subgroup thead th input[type=text]").on('keyup change', function () {

        procedure_subgroup
            .column($(this).parent().index() + ':visible')
            .search(this.value)
            .draw();

    });

    var insurance = $('#insurancetable').dataTable({
        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
        "t" +
        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
        "autoWidth": true,
        "oLanguage": {
            "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
        },
        "preDrawCallback": function () {
            // Initialize the responsive datatables helper once.
            if (!responsiveHelper_insurance) {
                responsiveHelper_insurance = new ResponsiveDatatablesHelper($('#insurancetable'), breakpointDefinition);
            }
        },
        "rowCallback": function (nRow) {
            responsiveHelper_insurance.createExpandIcon(nRow);
        },
        "drawCallback": function (oSettings) {
            responsiveHelper_insurance.respond();
        },
        processing: true,
        serverSide: false,
        ajax: {
            "url": jsonPath + "/settings/insurance_companies_data/",
            "type": "POST"
        },
        "deferLoading": 57,
        "columns": [
            {"width": "30%", "orderable": true, data: "insuranceco_name"},
            {"width": "20%", "orderable": false, data: "insuranceco_phone"},
            {"width": "20%", "orderable": false, data: "insuranceco_email"},
            {
                "width": "10%",
                targets: -1,
                data: 'insuranceco_id',
                render: function (data, type, full, meta) {
                    return '<a href="' + jsonPath + '/settings/insurance_companies/' + data + '"  class="indicatoritem btn btn-success btn-xs rounded" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil"></i></a> \n\
<a href="' + jsonPath + '/settings/delete_insurance_companies/' + data + '"  class="indicatoritem btn btn-danger btn-xs rounded" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-times"></i></a>';
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

    // Apply the filter
    $("#insurancetable thead th input[type=text]").on('keyup change', function () {

        insurance
            .column($(this).parent().index() + ':visible')
            .search(this.value)
            .draw();

    });


    var nappi_consumables = $('#nappi_consumables').dataTable({
        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
        "t" +
        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
        "autoWidth": true,
        "oLanguage": {
            "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
        },
        "preDrawCallback": function () {
            // Initialize the responsive datatables helper once.
            if (!responsiveHelper_nappi_consumables) {
                responsiveHelper_nappi_consumables = new ResponsiveDatatablesHelper($('#nappi_consumables'), breakpointDefinition);
            }
        },
        "rowCallback": function (nRow) {
            responsiveHelper_nappi_consumables.createExpandIcon(nRow);
        },
        "drawCallback": function (oSettings) {
            responsiveHelper_nappi_consumables.respond();
        },
        processing: true,
        serverSide: false,
        ajax: {
            "url": jsonPath + "/settings/nappi_consumables_data/",
            "type": "POST"
        },
        "deferLoading": 57,
        "columns": [
            {"width": "20%", "orderable": true, data: "product_name"},
            {"width": "10%", "orderable": false, data: "nappi_code"},
            {"width": "10%", "orderable": false, data: "pack"},
            {"width": "10%", "orderable": false, data: "price"},
            {"width": "10%", "orderable": false, data: "mnf_code"},
            {"width": "20%", "orderable": false, data: "product_description"},
            {
                "width": "15%",
                targets: -1,
                data: 'consumable_id',
                render: function (data, type, full, meta) {
                    return '<a href="' + jsonPath + '/settings/nappi_consumables/' + data + '"  class="indicatoritem btn btn-success btn-xs rounded" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil"></i></a> \n\
<a href="' + jsonPath + '/settings/delete_nappi_consumables/' + data + '"  class="indicatoritem btn btn-danger btn-xs rounded" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-times"></i></a>';
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

    // Apply the filter
    $("#nappi_consumables thead th input[type=text]").on('keyup change', function () {

        nappi_consumables
            .column($(this).parent().index() + ':visible')
            .search(this.value)
            .draw();

    });


    var rpl_procedurecodes = $('#rpl_procedurecodes').dataTable({
        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
        "t" +
        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
        "autoWidth": true,
        "oLanguage": {
            "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
        },
        "preDrawCallback": function () {
            // Initialize the responsive datatables helper once.
            if (!responsiveHelper_rpl_procedurecodes) {
                responsiveHelper_rpl_procedurecodes = new ResponsiveDatatablesHelper($('#rpl_procedurecodes'), breakpointDefinition);
            }
        },
        "rowCallback": function (nRow) {
            responsiveHelper_rpl_procedurecodes.createExpandIcon(nRow);
        },
        "drawCallback": function (oSettings) {
            responsiveHelper_rpl_procedurecodes.respond();
        },
        processing: true,
        serverSide: false,
        ajax: {
            "url": jsonPath + "/settings/rpl_procedurecodes_data/",
            "type": "POST"
        },
        "deferLoading": 57,
        "columns": [
            {"width": "10%", "orderable": false, data: "rpl_code"},
            {"width": "20%", "orderable": true, data: "procedure_name"},
            {"width": "10%", "orderable": false, data: "service_fee"},
            {"width": "20%", "orderable": false, data: "rpl_decsription"},
            {
                "width": "15%",
                targets: -1,
                data: 'rpl_id',
                render: function (data, type, full, meta) {
                    return '<a href="' + jsonPath + '/settings/rpl_procedures/' + data + '"  class="indicatoritem btn btn-success btn-xs rounded" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil"></i></a> \n\
<a href="' + jsonPath + '/settings/rpl_nappi_consumables/' + data + '"  class="indicatoritem btn btn-primary btn-xs rounded" data-toggle="tooltip" data-placement="top" data-original-title="Add/View Consumables"><i class="fa fa-plus"></i></a> \n\
<a href="' + jsonPath + '/settings/delete_rpl_procedure/' + data + '"  class="indicatoritem btn btn-danger btn-xs rounded" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-times"></i></a>';
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

    // Apply the filter
    $("#rpl_procedurecodes thead th input[type=text]").on('keyup change', function () {

        rpl_procedurecodes
            .column($(this).parent().index() + ':visible')
            .search(this.value)
            .draw();

    });


    var rpl_id = $('#rpl_id').val();
    var rpl_nappi_codes = $('#rpl_nappi_codes').dataTable({
        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
        "t" +
        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
        "autoWidth": true,
        "oLanguage": {
            "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
        },
        "preDrawCallback": function () {
            // Initialize the responsive datatables helper once.
            if (!responsiveHelper_rpl_nappi_codes) {
                responsiveHelper_rpl_nappi_codes = new ResponsiveDatatablesHelper($('#rpl_nappi_codes'), breakpointDefinition);
            }
        },
        "rowCallback": function (nRow) {
            responsiveHelper_rpl_nappi_codes.createExpandIcon(nRow);
        },
        "drawCallback": function (oSettings) {
            responsiveHelper_rpl_nappi_codes.respond();
        },
        processing: true,
        serverSide: false,
        ajax: {
            "url": jsonPath + "/settings/rpl_nappi_codes_data/",
            "type": "POST",
            data: {rpl_id: rpl_id}
        },
        "deferLoading": 57,
        "columns": [
            {"width": "20%", "orderable": true, data: "product_name"},
            {"width": "10%", "orderable": true, data: "nappi_code"},
            {"width": "10%", "orderable": false, data: "pack"},
            {"width": "10%", "orderable": false, data: "price"},
            {"width": "10%", "orderable": false, data: "mnf_code"},
            {"width": "20%", "orderable": false, data: "product_description"},
            {
                "width": "15%",
                targets: -1,
                data: 'id',
                render: function (data, type, full, meta) {
                    return '<a href="#" onclick="remove_rpl_nappi_codes(\'' + data + '\')"  class=" btn btn-danger btn-xs rounded" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-times"></i></a>';
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

    // Apply the filter
    $("#rpl_nappi_codes thead th input[type=text]").on('keyup change', function () {

        rpl_nappi_codes
            .column($(this).parent().index() + ':visible')
            .search(this.value)
            .draw();

    });


    var procedure_department = $('#procedure_department').dataTable({
        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
        "t" +
        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
        "autoWidth": true,
        "oLanguage": {
            "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
        },
        "preDrawCallback": function () {
            // Initialize the responsive datatables helper once.
            if (!responsiveHelper_procedure_department) {
                responsiveHelper_procedure_department = new ResponsiveDatatablesHelper($('#procedure_department'), breakpointDefinition);
            }
        },
        "rowCallback": function (nRow) {
            responsiveHelper_procedure_department.createExpandIcon(nRow);
        },
        "drawCallback": function (oSettings) {
            responsiveHelper_procedure_department.respond();
        },
        processing: true,
        serverSide: false,
        "iDisplayLength": 5,
        ajax: {
            "url": jsonPath + "/settings/procedure_department_data/",
            "type": "POST"
        },
        "deferLoading": 57,
        "columns": [
            {"width": "10%", "orderable": false, data: "department_name"},
            {"width": "10%", "orderable": false, data: "rpl_code"},
            {"width": "10%", "orderable": false, data: "procedure_name"},
            {"width": "15%", "orderable": false, data: "service_fee"},
            {
                "width": "20%",
                targets: -1,
                data: 'procedure_id',
                render: function (data, type, full, meta) {
                    return '<a href="' + jsonPath + '/settings/edit_department_procedure/' + data + '"  class="indicatoritem btn btn-success btn-xs rounded" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil"></i></a> \n\
<a href="#" onclick="delete_department_procedure(' + data + ')"  class="indicatoritem btn btn-danger btn-xs rounded" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-times"></i></a>';
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
    $("#procedure_department thead th input[type=text]").on('keyup change', function () {

        procedure_department
            .column($(this).parent().index() + ':visible')
            .search(this.value)
            .draw();

    });

    $('#department').on('change', function () {
        if ($('#procedure_department').length > 0) {
            var departmentid = $('#department').val();

            $('#procedure_department').DataTable().clear().destroy();


            var procedure_department2 = $('#procedure_department').DataTable({

                "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
                "t" +
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
                "autoWidth": true,
                "bDestroy": true,
                "iDisplayLength": 10,
                ajax: {
                    "url": jsonPath + "/settings/procedure_department_data/",
                    "type": "POST",
                    data: {departmentid: departmentid}
                },
                "iDisplayLength": 15,
                "deferLoading": 57,
                "order": [[2, "desc"]],
                "columns": [
                    {"width": "10%", "orderable": false, data: "department_name"},
                    {"width": "10%", "orderable": false, data: "rpl_code"},
                    {"width": "10%", "orderable": false, data: "procedure_name"},
                    {"width": "15%", "orderable": false, data: "service_fee"},
                    {
                        "width": "20%",
                        targets: -1,
                        data: 'procedure_id',
                        render: function (data, type, full, meta) {
                            return '<a href="' + jsonPath + '/settings/edit_department_procedure/' + data + '"  class="indicatoritem btn btn-success btn-xs rounded" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil"></i></a> \n\
<a href="#" onclick="delete_department_procedure(' + data + ')"  class="indicatoritem btn btn-danger btn-xs rounded" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-times"></i></a>';
                        }

                    }
                ],
                dom: 'Bfrtip'
            });

            // Apply the filter
            $("#procedure_department thead th input[type=text]").on('keyup change', function () {

                procedure_department2
                    .column($(this).parent().index() + ':visible')
                    .search(this.value)
                    .draw();

            });



        }

        $("#procedure_department thead th input[type=text]").on('keyup change', function () {

            procedure_department
                .column($(this).parent().index() + ':visible')
                .search(this.value)
                .draw();

        });
    });
    // Apply the filter


    function view_mapt_cretaria(d) {
        var jsonPath = SurgiTrack.handleBaseURL();
        $('#view_criteria').show();
        $.ajax({
            type: "POST",
            url: jsonPath + "/administrator/view_mapt_criteria",
            data: {mapt_id: d.mapt_id},
            success: function (data) {
                $("#view_criteria").html(data);
            }

        });
    }

})