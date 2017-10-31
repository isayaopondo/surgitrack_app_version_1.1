/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function () {
    var today = new Date();
    var jsonPath = SurgiTrack.handleBaseURL();
    pageSetUp();
    $('#alertMessage').hide();
    $('#toadmissionlist').hide();
    $('#totheatrelist').hide();

    $('#booking_status').on('change', function () {
        var booking_status = $('#booking_status').val();
        if ($('#toadmissionlist').length > 0) {
            if (booking_status !== '0') {
                $('#toadmissionlist').show();
            } else {
                $('#toadmissionlist').hide();
            }

        }
        if ($('#totheatrelist').length > 0) {
            if (booking_status === '2') {
                $('#totheatrelist').show();
            } else {
                $('#totheatrelist').hide();
            }
        }
    });

    check_user_department();
    /*
     * TIMEPICKER
     */
    $('.summernote').summernote({
        height: 100,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'hr']],
            ['view', ['fullscreen', 'codeview', 'help']]

        ]
    });
    //$('#timepicker').timepicker();
    var dateToday = new Date();
    var enddate_today = new Date();
    enddate_today.setHours(23, 59, 59, 999);
    // Date Range Picker

    $('#datetimepicker').datetimepicker({
        format: 'hh:mm:ss'
    });
    $("#blocked_enddate").datetimepicker({
        startView: 'month',
        minView: 'hour',
        format: 'yyyy-mm-dd hh:ii',
        autoclose: true,
        minuteStep: 30

    });
    $("#blocked_date").datetimepicker({
        startView: 'month',
        minView: 'hour',
        format: 'yyyy-mm-dd hh:ii',
        autoclose: true,
        minuteStep: 30

    });

    $("#op_date").datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: "-110:+0",
        dateFormat: 'yy-mm-dd',
        maxDate: dateToday
    });
    //var op_date = $("#op_date").val();
    //var op_date_start = $("#op_date_start").val();


    $("#surgerydate").datetimepicker({
        format: 'yyyy-mm-dd hh:ii',
        //startDate: today,
        autoclose: true,
        minuteStep: 30,
        prevText: '<i class="fa fa-chevron-left"></i>',
        nextText: '<i class="fa fa-chevron-right"></i>'

    });
    /*$("#op_date_start").focus(function () {
     op_date = $("#op_date").val();
     $('#op_date_start').datetimepicker('setHoursDisabled', [0,1,2,3,4,5,6,7,18,19,20,21,22,23]);
     $('#op_date_start').datetimepicker('setStartDate', op_date + " 08:00");
     $('#op_date_start').datetimepicker('setEndDate', op_date + " 17:00");
     });*/

    $("#op_date_start").datetimepicker({
        startView: 'month',
        format: 'yyyy-mm-dd hh:ii',
        endDate: today,
        autoclose: true,
        todayBtn: false,
        minuteStep: 5

    });
    /*$("#op_date_end").focus(function () {
     op_date = $("#op_date").val();
     op_date_start = $("#op_date_start").val();
     $('#op_date_end').datetimepicker('setHoursDisabled', [0,1,2,3,4,5,6,7,18,19,20,21,22,23]);
     $('#op_date_end').datetimepicker('setStartDate', op_date +" "+op_date_start);
     });*/

    $("#op_date_end").datetimepicker({
        startView: 'month',
        format: 'yyyy-mm-dd hh:ii',
        endDate: enddate_today,
        todayBtn: false,
        autoclose: true,
        minuteStep: 5

    });
    /*
     $("#anethesia_start").focus(function () {
     op_date = $("#op_date").val();
     $('#anethesia_start').datetimepicker('setStartDate', op_date + " 08:00");
     $('#anethesia_start').datetimepicker('setEndDate', op_date + " 17:00");
     });*/
    $("#anethesia_start").datetimepicker({
        startView: 'month',
        minView: 'hour',
        format: 'yyyy-mm-dd hh:ii',
        endDate: today,
        autoclose: true,
        minuteStep: 5

    });
    /*$("#anethesia_end").focus(function () {
     op_date = $("#op_date").val();
     $('#anethesia_end').datetimepicker('setEndDate', op_date + " 17:00");
     $('#anethesia_end').datetimepicker('setStartDate', op_date +" "+op_date_start);
     });*/


    $("#anethesia_end").datetimepicker({
        startView: 'month',
        minView: 'hour',
        format: 'yyyy-mm-dd hh:ii',
        endDate: enddate_today,
        autoclose: true,
        minuteStep: 5

    });
    $("#dateofbirths").datetimepicker({
        format: 'yyyy-mm-dd',
        endDate: today,
        autoclose: true,
        minView: 'month'
    });
    $("#dateofbirth").datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: "-110:+0",
        dateFormat: 'yy-mm-dd',
        maxDate: dateToday
    });
    $("#admissiondate").datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: "-110:+0",
        dateFormat: 'yy-mm-dd',
    });
    $("#admission_date").datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: "-110:+0",
        dateFormat: 'yy-mm-dd',
    });

    $("#admission_enddate").datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: "-110:+0",
        dateFormat: 'yy-mm-dd',
    });

    $("#datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: "-110:+0",
        dateFormat: 'yy-mm-dd',
    });
    $("#datepicker2").datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: "-110:+0",
        dateFormat: 'yy-mm-dd',
    });
    $("#surgeon_assistant").select2();
    $(".js-example-theme-multiple").select2({
        theme: "classic",
        tags: true
    });
    $('.select-multiple').multipleSelect();
    /*$(".select2").select2();*/



    $('.tree  .root > ul > li').hide();
    $('.tree li:first').show();
    $('.tree > ul').attr('role', 'tree').find('ul').attr('role', 'group');
    $('.tree').find('li:has(ul)').addClass('parent_li').attr('role', 'treeitem').find(' > span').attr('title', 'Collapse ').on('click', function (e) {
        var children = $(this).parent('li.parent_li').find(' > ul > li');
        if (children.is(':visible')) {
            children.hide('fast');
            $(this).attr('title', 'Expand').find(' > i').removeClass().addClass('fa fa-plus-square ');
        } else {
            children.show('fast');
            $(this).attr('title', 'Collapse').find(' > i').removeClass().addClass('fa fa-minus-square-o fa-warning text-bold');
        }
        e.stopPropagation();
    });
    $(".form_datetime").datetimepicker({
        format: "dd MM yyyy - hh:ii",
        autoclose: true,
    });
    $('#folder_number').on('onblur', function () {
        var foldernumber = $(this).val();
        alert(foldernumber);
    });
    $('#procedure').on('change', function () {
        if ($('#category').length > 0) {
            $('select#category').html('');
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: jsonPath + "/settings/ajaxget_category_by_procedureid/",
                data: {procedure: $(this).val()},
                success: function (data) {
                    for (var i = 0; i < data.length; i++)
                    {
                        $("<option />").val(data[i].category_id)
                                .text(data[i].category_name)
                                .appendTo($('select#category'));
                    }
                }

            });
        }

    });




    $('#procedure_id').on('change', function () {
        if ($('#category_id').length > 0) {
            $('select#category_id').html('');
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: jsonPath + "/settings/ajaxget_category_by_procedureid/",
                data: {procedure: $(this).val()},
                success: function (data) {
                    for (var i = 0; i < data.length; i++)
                    {
                        $("<option />").val(data[i].category_id)
                                .text(data[i].category_name)
                                .appendTo($('select#category_id'));
                    }
                }

            });
        }

    });
    $('#department_facility').on('change', function () {
        if ($('#department').length > 0) {
            $('select#department').html('');
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: jsonPath + "/settings/ajaxget_departments_facility/",
                data: {facility_id: $(this).val()},
                success: function (data) {
                    for (var i = 0; i < data.length; i++)
                    {
                        $("<option />").val(data[i].department_id)
                                .text(data[i].department_name)
                                .appendTo($('select#department'));
                    }
                }

            });
        }

    });
    $('#department_facility1').on('change', function () {
        if ($('#department1').length > 0) {
            $('select#department1').html('');
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: jsonPath + "/settings/ajaxget_departments_facility/",
                data: {facility_id: $(this).val()},
                success: function (data) {
                    for (var i = 0; i < data.length; i++)
                    {
                        $("<option />").val(data[i].department_id)
                                .text(data[i].department_name)
                                .appendTo($('select#department1'));
                    }
                }

            });
        }

    });
    $('#firm_department').on('change', function () {
        if ($('#firm').length > 0) {
            $('select#firm').html('');
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: jsonPath + "/settings/ajaxget_department_firms/",
                data: {department_id: $(this).val()},
                success: function (data) {
                    for (var i = 0; i < data.length; i++)
                    {
                        $("<option />").val(data[i].firm_id)
                                .text(data[i].firm_name)
                                .appendTo($('select#firm'));
                    }
                }

            });
        }

    });
    $('#booking_firms').on('change', function () {
        if ($('#booked_by').length > 0) {
            $('select#booked_by').html('');
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: jsonPath + "/settings/ajaxget_department_firms_surgeon/",
                data: {firm_id: $(this).val()},
                success: function (data) {
                    for (var i = 0; i < data.length; i++)
                    {
                        $("<option />").val(data[i].user_id)
                                .text(data[i].surgeon)
                                .appendTo($('select#booked_by'));
                    }
                }

            });
        }

    });
    //my_consumable_list

    $('#rpl_nappi_consumables').on('change', function () {
        if ($('#rpl_nappi_codes').length > 0) {
            var consumable = $(this).val();
            var rpl_id = $('#rpl_id').val();
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: jsonPath + "/settings/add_rpl_nappi_consumables/",
                data: {consumable_id: consumable, rpl_id: rpl_id},
                success: function (data) {
                    $("#messages").html(data.message);
                    $('#rpl_nappi_codes').DataTable().ajax.reload();
                }

            });
        }

    });
    $('#postal_code').on('keyup', function () {
        $('select#suburb').html('');
        if ($('#suburb').length > 0 && $(this).val().length >= 4) {
            $('select#suburb').html('');
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: jsonPath + "/settings/ajaxget_suburb_by_postcode/",
                data: {postal_code: $(this).val()},
                success: function (data) {
                    for (var i = 0; i < data.length; i++)
                    {
                        $("<option />").val(data[i].suburb_id)
                                .text(data[i].suburb_name)
                                .appendTo($('select#suburb'));
                    }
                }

            });
        }

    });
    $('#folder_number').on('keyup', function () {

        $.ajax({
            type: "POST",
            dataType: 'json',
            url: jsonPath + "/theatre/ajaxget_suburb_by_postcode/",
            data: {postal_code: $(this).val()},
            success: function (data) {
                for (var i = 0; i < data.length; i++)
                {
                    $("<option />").val(data[i].suburb_id)
                            .text(data[i].suburb_name)
                            .appendTo($('select#suburb'));
                }
            }

        });
    });
    $('#download_theatre_list').on('click', function () {
        var surgdate = $('#datepicker2').val();
        var theatre = $('#theatre').val();
        var path = "/theatre/" + theatre + "/" + surgdate;
        bootbox.confirm({
            message: "Generating Theatre list by Theatre, continue?",
            callback: function (result) {
                if (result == true) {
                    // window.location.href=jsonPath + "/theatre/print_theatre_list";
                    window.open(jsonPath + "/theatre/print_theatre_list" + path, '_blank');
                }
            }
        });
    });
    $('#download_firm_list').on('click', function () {
        var surgdate = $('#datepicker').val();
        var firm = $('#byfirmfirm').val();
        var path = "/firm/" + firm + "/" + surgdate;
        bootbox.confirm({
            message: "Generating Theatre list by Firm, continue?",
            callback: function (result) {
                if (result == true) {
                    // window.location.href=jsonPath + "/theatre/print_theatre_list";
                    window.open(jsonPath + "/theatre/print_theatre_list" + path, '_blank');
                }
            }
        });
    });
    $('#download_theatre_waiting_list').on('click', function () {
        var theatre = $('#theatre').val();
        var path = "/theatre/" + theatre
        bootbox.confirm({
            message: "Generating waiting list by Firm, continue?",
            callback: function (result) {
                if (result == true) {
                    // window.location.href=jsonPath + "/theatre/print_theatre_list";
                    window.open(jsonPath + "/theatre/print_waiting_list" + path, '_blank');
                }
            }
        });
    });
    $('#download_procedure_waiting_list').on('click', function () {
        var procedure = $('#procedure').val();
        var path = "/procedure/" + procedure;
        bootbox.confirm({
            message: "Generating waiting list by procedure, continue?",
            callback: function (result) {
                if (result == true) {
                    // window.location.href=jsonPath + "/theatre/print_theatre_list";
                    window.open(jsonPath + "/theatre/print_waiting_list" + path, '_blank');
                }
            }
        });
    });
    $('#download_firm_waiting_list').on('click', function () {
        var firm = $('#firm').val();
        var path = "/firm/" + firm;
        bootbox.confirm({
            message: "Generating waiting list by Firm, continue?",
            callback: function (result) {
                if (result == true) {
                    // window.location.href=jsonPath + "/theatre/print_theatre_list";
                    window.open(jsonPath + "/theatre/print_waiting_list" + path, '_blank');
                }
            }
        });
    });
    $('#download_firm_admission_list').on('click', function () {
        var firm = $('#firm').val();
        var path = "/firm/" + firm;
        bootbox.confirm({
            message: "Generating Admission list by Firm, continue?",
            callback: function (result) {
                if (result == true) {
                    // window.location.href=jsonPath + "/theatre/print_theatre_list";
                    window.open(jsonPath + "/theatre/print_admission_list" + path, '_blank');
                }
            }
        });
    });
    $('#download_date_admission_list').on('click', function () {
        var admissiondate = $('#admissiondate').val();
        var path = "/admissiondate/" + admissiondate;
        bootbox.confirm({
            message: "Generating Admission list by admission date, continue?",
            callback: function (result) {
                if (result == true) {
                    window.open(jsonPath + "/theatre/print_admission_list" + path, '_blank');
                }
            }
        });
    });
    $('#download_multi_admission_list').on('click', function () {
        var admissiondate = $('#admission_date').val();
        var admissionenddate = $('#admission_enddate').val();
        var firm = $('#firm-2').val();

        var path = "/multi/" + admissiondate + "/" + admissionenddate + "/" + firm;
        bootbox.confirm({
            message: "Generating Admission list by filters, continue?",
            callback: function (result) {
                if (result == true) {
                    window.open(jsonPath + "/theatre/print_admission_list" + path, '_blank');
                }
            }
        });
    });
    $('#download_surgeon_caselog').on('click', function () {
        var surgeon = $('#surgeon').val();
        var path = "/surgeon/" + surgeon;
        bootbox.confirm({
            message: "Generating caselog list by Surgeon, continue?",
            callback: function (result) {
                if (result == true) {
                    // window.location.href=jsonPath + "/theatre/print_theatre_list";
                    window.open(jsonPath + "/theatre/print_caselog_list" + path, '_blank');
                }
            }
        });
    });
    $('#add_surgeon_assistants').on('click', function () {
        var booking_id = $('#booking_id').val();
        $('#myModalSurgeonAssistants').modal('show');
        $(".modal-body #booking_id2").val(booking_id);
    });
    $('#download_firm_caselog').on('click', function () {
        var firm = $('#firm').val();
        var path = "/firm/" + firm;
        bootbox.confirm({
            message: "Generating case log by Firm, continue?",
            callback: function (result) {
                if (result == true) {
                    // window.location.href=jsonPath + "/theatre/print_theatre_list";
                    window.open(jsonPath + "/theatre/print_caselog_list" + path, '_blank');
                }
            }
        });
    });
    $('#download_caselog').on('click', function () {

        var theatre = $('#theatre').val();
        var path = "/theatre/" + theatre;
        bootbox.confirm({
            message: "Generating caselog list by theatre, continue?",
            callback: function (result) {
                if (result == true) {
                    // window.location.href=jsonPath + "/theatre/print_theatre_list";
                    window.open(jsonPath + "/theatre/print_caselog_list" + path, '_blank');
                }
            }
        });
    });
    $('#save_booking_procedure').on('click', function () {
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: jsonPath + "/theatre/coding_booking_procedure",
            data: $('#add_booking_procedures').serialize(),
            success: function (data) {
                $("#infoMessage").html('');
                $("#infoMessage").html(data.message);
                $('#booking_procedures').DataTable().ajax.reload();
                $('#myModalAddProcedures').modal('hide');
                //window.open(jsonPath + "/settings/rpl_nappi_consumables/" + data.rpl_id);
            }
        });
    });
    $('#save_add_rpl_consumables').on('click', function () {

        $.ajax({
            dataType: 'json',
            type: "POST",
            url: jsonPath + "/settings/add_rpl_procedurecodes",
            data: $('#rpl-procedure-form').serialize(),
            success: function (data) {
                $("#infoMessage").html('');
                $("#infoMessage").html(data.message);
                $('#rpl_procedurecodes').DataTable().ajax.reload();
                window.open(jsonPath + "/settings/rpl_nappi_consumables/" + data.rpl_id);
            }
        });
    });
    $('#save_rpl_procedurecodes').on('click', function () {

        $.ajax({
            dataType: 'json',
            type: "POST",
            url: jsonPath + "/settings/add_rpl_procedurecodes",
            data: $('#rpl-procedure-form').serialize(),
            success: function (data) {
                $("#infoMessage").html('');
                $("#infoMessage").html(data.message);
                $('#rpl_procedurecodes').DataTable().ajax.reload();
                location.reload();
            }
        });
    });
    $('#procedure').on('change', function () {
        var d = $('#patient_id').val();
        var procedure = $('#procedure').val();
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: jsonPath + "/theatre/check_if_patient_has_open_booking",
            data: {patient_id: d, procedure_id: procedure},
            success: function (data) {
                if (data.success === '0') {
                    bootbox.confirm({
                        message: data.message,
                        callback: function (result) {
                            if (result == true) {
                                window.location.href = jsonPath + '/patients/patient_page/' + d;
                            }
                        }
                    });
                }
            }
        });
    });
    if ($('#folder_number').length > 0) {
        var options = {
            url: function (phrase) {
                return jsonPath + "/patients/search_patients";
            },
            getValue: function (element) {
                return element.folder_number + ': ' + element.surname + ': ' + element.other_names;
            },
            list: {
                match: {
                    enabled: true
                },
                onSelectItemEvent: function () {

                    var patient_id = $("#folder_number").getSelectedItemData().patient_id;
                    //if (patient_id >= 1) {
                    $('#existingpatient').show();
                    $('#existingpatient2').show();
                    //}
                    var folder_number = $("#folder_number").getSelectedItemData().folder_number;
                    var surname = $("#folder_number").getSelectedItemData().surname;
                    var phone = $("#folder_number").getSelectedItemData().phone;
                    var other_names = $("#folder_number").getSelectedItemData().other_names;
                    var insuranceco_id = $("#folder_number").getSelectedItemData().insuranceco_id;
                    var insurance_number = $("#folder_number").getSelectedItemData().insurance_number;
                    var additional_info = $("#folder_number").getSelectedItemData().additional_info;
                    $("#patient_id").val(patient_id).trigger("change");
                    $("#folder_number").val(folder_number).trigger("change");
                    $("#surname").val(surname).trigger("change");
                    $("#phone").val(phone).trigger("change");
                    $("#other_names").val(other_names).trigger("change");
                    $("#insurance").val(insuranceco_id).trigger("change");
                    $("#insurance_number").val(insurance_number).trigger("change");
                    $("#additional_info").html(additional_info).trigger("change");
                    $.ajax({
                        type: "POST",
                        url: jsonPath + "/patients/search_patients_details",
                        data: {patient_id: patient_id},
                        success: function (data) {
                            $("#patientdetails").html(data);
                        }

                    });
                }
            },
            ajaxSettings: {
                dataType: "json",
                method: "POST",
                data: {
                    dataType: "json",
                }
            },
            preparePostData: function (data) {
                data.phrase = $("#folder_number").val();
                data.firm = $('#firm_id').val();
                return data;
            },
            requestDelay: 600
        };
        $("#folder_number").easyAutocomplete(options);
    }

    if ($('#search_text').length > 0) {
        var options = {
            url: function (phrase) {
                return jsonPath + "/patients/search_patient";
            },
            getValue: function (element) {
                return element.folder_number + ': ' + element.surname + ': ' + element.other_names;
            },
            list: {
                match: {
                    enabled: false
                },
                onClickEvent: function () {
                    var patient_id = $("#search_text").getSelectedItemData().patient_id;
                    window.location.href = jsonPath + '/patients/patient_page/' + patient_id;
                },
                onSelectItemEvent: function () {

                }
            },
            ajaxSettings: {
                dataType: "json",
                method: "POST",
                data: {
                    dataType: "json"
                }
            },
            preparePostData: function (data) {
                data.phrase = $("#search_text").val();
                return data;
            },
            requestDelay: 600
        };
        $("#search_text").easyAutocomplete(options);
    }

    $('#cp8').colorpicker({
        colorSelectors: {
            'black': '#000000',
            'white': '#ffffff',
            'red': '#FF0000',
            'default': '#777777',
            'primary': '#337ab7',
            'success': '#5cb85c',
            'info': '#5bc0de',
            'warning': '#f0ad4e',
            'danger': '#d9534f'
        }
    });
    $('#create_mapt').on('click', function () {

        $.ajax({
            dataType: 'json',
            type: "POST",
            url: jsonPath + "/administrator/create_mapt",
            data: $('#create-mapt-form').serialize(),
            beforeSend: function () {
                $("#listsq").css("background", "#FFF url(" + jsonPath + "/assets/img/ajax-loader.gif) no-repeat 165px");
            },
            success: function (data) {
                $("#message").html('');
                $('#alertMessage').show();
                $("#message").text(data.message);
                $('#create-mapt-form')[0].reset();
                $('#mapt_list_table').DataTable().ajax.reload();
            }
        });
    });
    $('#affiliations_users').on('click', function () {
//alert('affiliations_users');

        $.ajax({
            type: "POST",
            url: jsonPath + "/users/create_department",
            data: $('#affiliations').serialize(),
            success: function (data) {
                $('#affiliations_buttons').hide();
                $("#firmdetails").html('');
                $("#firmdetails").html(data);
            }
        });
    });
    $('#save_more_consumable').on('click', function () {
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: jsonPath + "/theatre/add_other_consumables",
            data: $('#add_more_consumables').serialize(),
            success: function (data) {
                $("#message").html(data.message);
                $('#myModalAddOtherConsumables').modal('hide');
                $('#rpl_nappi_codes').empty();
                $('#rpl_nappi_codes').html(data.consumables);
            }
        });
    });
    $('#save_booking_consumables').on('click', function () {

        $.ajax({
            dataType: 'json',
            type: "POST",
            url: jsonPath + "/theatre/save_booking_consumables",
            data: $('#booking-consumables-form').serialize(),
            success: function (data) {
                $("#message").html('');
                $("#message").html(data.message);
                //location.reload();
            }
        });
    });
    $('#add-surgeon-assistants').on('click', function () {

        $.ajax({
            dataType: 'json',
            type: "POST",
            url: jsonPath + "/theatre/add_surgeon_assistants",
            data: $('#form-add-surgeon-assistants').serialize(),
            success: function (data) {
                $("#surg_message").html('');
                $("#surg_message").html(data.message);
                //location.reload();
            }
        });
    });
    $('#add_criteria').on('click', function () {

        $.ajax({
            dataType: 'json',
            type: "POST",
            url: jsonPath + "/administrator/create_mapt_criteria",
            data: $('#criteria-form').serialize(),
            beforeSend: function () {
                $("#listsq").css("background", "#FFF url(" + jsonPath + "/assets/img/ajax-loader.gif) no-repeat 165px");
            },
            success: function (data) {
                $("#message").html('');
                $('#alertMessage').show();
                $("#message").text(data.message);
                $('#criteria-form')[0].reset();
                //$('#mapt_list_table').DataTable().ajax.reload();

            }
        });
    });
    $('#savebookingmapt').on('click', function () {
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: jsonPath + "/theatre/save_booking_mapt",
            data: $('#fill-mapt-form').serialize(),
            beforeSend: function () {
                $("#listsq").css("background", "#FFF url(" + jsonPath + "/assets/img/ajax-loader.gif) no-repeat 165px");
            },
            success: function (data) {
                $("#message").html('');
                $('#alertMessage').show();
                $("#message").text(data.message);
                $('#fill-mapt-form')[0].reset();
                $('#myModalViewMAPT').modal('hide');
                window.location.href = jsonPath + '/patients/patient_page/' + data.patient_id;
            }
        });
    });
    $('#save_comment').on('click', function () {
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: jsonPath + "/theatre/save_comments",
            data: $('#fill-comments').serialize(),
            beforeSend: function () {
                $("#listsq").css("background", "#FFF url(" + jsonPath + "/assets/img/ajax-loader.gif) no-repeat 165px");
            },
            success: function (data) {
                $("#comment_message").html('');
                $('#comment_alertMessage').show();
                $("#comment_message").text(data.message);
                $('#fill-comments')[0].reset();
                setTimeout(function () {
                    $('#fill-comments').removeData('bs.modal');
                    $('#myModalComments').modal('hide');
                }, 1000);
            }
        });
    });
    $('#addconsumable').on('click', function () {
        education_fields();
    });
    $('#removechoice').on('click', function () {
        remove_education_fields($(this).val());
    });
    $('#send_dropbox').on('click', function () {
        var d = $('#booking_id').val();
        bootbox.confirm({
            message: "You are about to send the notes to Dropbox, continue?",
            callback: function (result) {
                if (result == true) {
                    $.ajax({
                        type: "POST",
                        url: jsonPath + "/theatre/send_opnotes_dropbox",
                        data: {booking_id: d},
                        success: function (data) {
                            $("#message").text(data.message);
                        }

                    });
                }
            }
        });
    });
    $('#sendadmissionsms').on('click', function () {

        bootbox.confirm({
            message: "You are about to send SMS Notification, continue?",
            callback: function (result) {
                if (result == true) {
                    $.ajax({
                        dataType: 'json',
                        type: "POST",
                        url: jsonPath + "/theatre/send_admission_sms",
                        data: $('#send-admission-sms').serialize(),
                        beforeSend: function () {
                            $("#listsq").css("background", "#FFF url(" + jsonPath + "/assets/img/ajax-loader.gif) no-repeat 165px");
                        },
                        success: function (data) {
                            $(".modal-body #message").html('');
                            $('.modal-body #alertMessage').show();
                            $(".modal-body #message").html(data.message);
                            $('.modal-body #send-admission-sms')[0].reset();

                            bootbox.confirm({
                                message: data.message,
                                callback: function (result) {
                                    if (result == true) {
                                        $('#myModalAdmissionSMS').modal('hide');
                                    }
                                }
                            });


                        }
                    });
                }
            }
        });
    });
    $('#send_generalsms').on('click', function () {
        var folder_number = $('#folder_number').val();
        $('#myModalSendGeneralSMS').modal('show');
        $.ajax({
            type: "POST",
            url: jsonPath + "/patients/patients_details_by_foldernumber",
            data: {folder_number: folder_number},
            success: function (data) {
                $(".modal-body #patient_details").html(data);
            }

        });
    });

    $('#send_generalsms_patient').on('click', function () {
        var folder_number = $('#folder_number_patient').val();
        $('#myModalSendGeneralSMS').modal('show');
        $.ajax({
            type: "POST",
            url: jsonPath + "/patients/patients_details_by_foldernumber",
            data: {folder_number: folder_number},
            success: function (data) {
                $(".modal-body #patient_details").html(data);
            }

        });
    });
    $('#send_sms_general').on('click', function () {
        bootbox.confirm({
            message: "You are about to send SMS, continue?",
            callback: function (result) {
                if (result == true) {
                    $.ajax({
                        dataType: 'json',
                        type: "POST",
                        url: jsonPath + "/theatre/send_general_sms",
                        data: $('#sendgeneralsms').serialize(),
                        beforeSend: function () {
                            $("#listsq").css("background", "#FFF url(" + jsonPath + "/assets/img/ajax-loader.gif) no-repeat 165px");
                        },
                        success: function (data) {
                            $("#message").html('');
                            $('#alertMessage').show();
                            $("#message").html(data.message);
                            $('#send_generalsms')[0].reset();
                            bootbox.confirm({
                                message: data.message,
                                callback: function (result) {
                                    if (result == true) {
                                        $('#myModalSendGeneralSMS').modal('hide');
                                    }
                                }
                            });
                        }
                    });
                }
            }
        });
    });
    $("#search_text").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: jsonPath + "/patients/search_patient",
                dataType: "jsonp",
                data: {
                    term: request.term
                },
                success: function (data) {
                    response(data);
                }
            });
        },
        minLength: 2,
        select: function (event, ui) {
            log("Selected: " + ui.item.value + " aka " + ui.item.id);
        }
    });
    if ($('#mcqsview').length > 0) {
        $('#mcqsview').hide();
        $("#response_type").change(function () {
            if ($(this).val() === '1') {
                $('#mcqsview').show();
            } else {
                $('#mcqsview').hide();
            }
        });
    }

    $('#addchoice').on('click', function () {
        mapt_elements_fields();
    });



    if ($('#mapt_booking_id').length > 0) {
        var booking_id = $('#mapt_booking_id').val();
        if ((booking_id !== null) && booking_id !== '') {
            bootbox.confirm({
                message: "You have succesfully added the patient to waiting list. Do you want to Add MAP Score for this Patient?",
                callback: function (result) {
                    if (result == true) {
                        var jsonPath = SurgiTrack.handleBaseURL();
                        $('#myModalMAPT').modal('show');
                        $(".modal-body #booking_id").val(booking_id);
                        $.ajax({
                            type: "POST",
                            url: jsonPath + "/patients/search_patients_admission_details",
                            data: {booking_id: booking_id},
                            success: function (data) {
                                $(".modal-body #admissiondetails").html(data);
                            }

                        });
                    }
                }

            });
        }
    }
});
var room = 1;
function mapt_elements_fields() {

    room++;
    var objTo = document.getElementById('mapt_elements_fields')
    var divtest = document.createElement("div");
    divtest.setAttribute("class", "form-group removeclass" + room);
    var rdiv = 'removeclass' + room;
    divtest.innerHTML = '<div class="row"> \n\
            <section class="col col-6">\n\
            <label class="input"> \n\
            <input class="input-xs" type="text"  id="choice" name="options[' + room + '][score_text]" value="" placeholder="Text"> </label> \n\
            </section> \n\
            <section class="col col-4">  \n\
            <label class="input"> \n\
             <input class="input-xs" type="text" maxlength="10" name="options[' + room + '][score_value]" placeholder="Percentage" > </label>\n\
            </section>\n\
            <section class="col col-2">\n\
            <button class="btn btn-xs btn-danger" type="button" id="removechoice" onclick="remove_fields(' + room + ');" value="' + room + '" ><i class="fa fa-minus-square-o"></i> </button> \n\
            </section></div>';
    objTo.appendChild(divtest);
}
function remove_fields(rid) {
    $('.removeclass' + rid).remove();
}

function check_user_department() {
    var jsonPath = SurgiTrack.handleBaseURL();
    $.ajax({
        type: "POST",
        url: jsonPath + "/users/check_user_department",
        success: function (data) {
            var res = $.parseJSON(data);
            if (res['success'] === '0') {
                $('#myModalAddAffiliations').modal('show');
            }
        }

    });
}

function get_patient_traveldistance(d) {

    var jsonPath = SurgiTrack.handleBaseURL();
    $.ajax({
        type: "POST",
        url: jsonPath + "/patients/calculate_distance/" + d,
        success: function (data) {
            location.reload();
        }

    });
}

function add_to_admission(d) {
    var jsonPath = SurgiTrack.handleBaseURL();
    $('#myModalAdmission').modal('show');
    $(".modal-body #booking_id").val(d);
    $.ajax({
        type: "POST",
        url: jsonPath + "/patients/search_patients_booking_details",
        data: {booking_id: d},
        success: function (data) {
            $(".modal-body #admissiondetails").html(data);
        }

    });
}
function add_to_theatre(d) {
    var jsonPath = SurgiTrack.handleBaseURL();
    $('#myModalTheatre').modal('show');
    $(".modal-body #booking_id").val(d);
    $.ajax({
        type: "POST",
        url: jsonPath + "/patients/search_patients_admission_details",
        data: {booking_id: d},
        success: function (data) {
            $(".modal-body #admissiondetails").html(data);
        }

    });
}
function add_mapt(d, procedure) {
    var jsonPath = SurgiTrack.handleBaseURL();
    $('#myModalMAPT').modal('show');
    $(".modal-body #booking_id").val(d);
    $.ajax({
        type: "POST",
        url: jsonPath + "/patients/search_patients_admission_details",
        data: {booking_id: d, procedure_id: procedure},
        success: function (data) {
            $(".modal-body #admissiondetails").html(data);
        }

    });
}

function add_comments(d) {
    var jsonPath = SurgiTrack.handleBaseURL();
    $('#comment_alertMessage').hide();
    $('#myModalComments').modal('show');
    $.ajax({
        type: "POST",
        url: jsonPath + "/patients/patients_booking_summary",
        data: {booking_id: d},
        success: function (data) {
            $(".modal-body #booking_id").val(d);
            $(".modal-body #admissiondetails").html(data);
        }

    });
}

function add_consumables(d) {
    var jsonPath = SurgiTrack.handleBaseURL();
    $('#consumables_alertMessage').hide();
    $('#myModalConsumables').modal('show');
    $.ajax({
        type: "POST",
        url: jsonPath + "/patients/patients_booking_summary",
        data: {booking_id: d},
        success: function (data) {
            $(".modal-body #booking_id").val(d);
            $(".modal-body #admissiondetails").html(data);
        }

    });
    $.ajax({
        type: "POST",
        url: jsonPath + "/patients/patients_booking_summary",
        data: {booking_id: d},
        success: function (data) {
            $(".modal-body #procedure_template").html(data);
        }

    });
}




function send_message(d) {
    var jsonPath = SurgiTrack.handleBaseURL();
    $('#alertMessage').hide();
    $('#myModalAdmissionSMS').modal('show');
    $(".modal-body #booking_id").val(d);
    $.ajax({
        type: "POST",
        url: jsonPath + "/patients/patients_admission_details",
        data: {booking_id: d},
        success: function (data) {
            $('.modal-body #alertMessage').hide();
            $(".modal-body #admissiondetails").html(data);
        }

    });
}

function view_mapt(d, procedure) {
    var jsonPath = SurgiTrack.handleBaseURL();
    $('#myModalViewMAPT').modal('show');
    $(".modal-body #booking_id").val(d);
    $.ajax({
        type: "POST",
        url: jsonPath + "/patients/view_patient_mapt",
        data: {booking_id: d, procedure_id: procedure},
        success: function (data) {
            $(".modal-body #patient_mapt").html(data);
        }

    });
}
function view_opnotes(d) {
    var jsonPath = SurgiTrack.handleBaseURL();
    $('#myModalViewOpNotes').modal('show');
    $.ajax({
        dataType: 'json',
        type: "POST",
        url: jsonPath + "/patients/preview_op_notes_pdf",
        data: {booking_id: d},
        success: function (data) {
            $(".modal-body #booking_id").val(d);
            $(".modal-body #patient_opnotes").html(data.file_iframe);
        }

    });
}
function view_mylogbook_opnotes(d) {
    var jsonPath = SurgiTrack.handleBaseURL();
    $('#myModalViewLogbookOpNotes').modal('show');
    $.ajax({
        dataType: 'json',
        type: "POST",
        url: jsonPath + "/patients/preview_op_notes_pdf",
        data: {booking_id: d},
        success: function (data) {
            $(".modal-body #booking_id").val(d);
            $(".modal-body #patient_opnotes").html(data.file_iframe);
        }

    });
}


function view_opnotes_(d) {
    var jsonPath = SurgiTrack.handleBaseURL();
    window.open(jsonPath + "/patients/preview_op_notes_pdf?booking_id=" + d, '_blank');
}

function opnotes_drobox(d) {
    var jsonPath = SurgiTrack.handleBaseURL();
    bootbox.confirm({
        message: "You are about to send the notes to Dropbox, continue?",
        callback: function (result) {
            if (result == true) {
                $.ajax({
                    type: "POST",
                    url: jsonPath + "/theatre/send_opnotes_dropbox",
                    data: {booking_id: d},
                    success: function (data) {
                        $("#message").text(data.message);
                    }

                });
            }
        }
    });
}

function create_dropbox_folder(d) {
    var jsonPath = SurgiTrack.handleBaseURL();
    bootbox.confirm({
        message: "You are about to create a Dropbox folder for this firm, continue?",
        callback: function (result) {
            if (result == true) {
                $.ajax({
                    dataType: 'json',
                    type: "POST",
                    url: jsonPath + "/settings/create_dropbox_firm_folder",
                    data: {firm_id: d},
                    success: function (data) {
                        $("#message").text(data.message);
                    }

                });
            }
        }
    });
}


function view_patient_scores(d, procedure, scoredate) {
    var jsonPath = SurgiTrack.handleBaseURL();
    $.ajax({
        type: "POST",
        url: jsonPath + "/patients/view_patient_scores",
        data: {mapt_score_id: d, procedure_id: procedure, scoredate: scoredate},
        success: function (data) {
            $("#patient_scores").html(data);
        }

    });
}



function delete_mapt(d) {
    var jsonPath = SurgiTrack.handleBaseURL();
    bootbox.confirm({
        message: "You are about to delete a MAPT, continue?",
        callback: function (result) {
            if (result == true) {
                $.ajax({
                    dataType: 'json',
                    type: "POST",
                    url: jsonPath + "/theatre/delete_mapt",
                    data: {mapt_id: d},
                    success: function (data) {
                        $("#message").text(data.message);
                        $('#mapt_list_table').DataTable().ajax.reload();
                    }

                });
            }
        }
    });
}
function remove_booking_procedure(procedure_id, booking_id) {
    var jsonPath = SurgiTrack.handleBaseURL();
    bootbox.confirm({
        message: "You are about to delete a Procedure, continue?",
        callback: function (result) {
            if (result == true) {
                $.ajax({
                    dataType: 'json',
                    type: "POST",
                    url: jsonPath + "/theatre/remove_booking_procedure",
                    data: {procedure_id: procedure_id, booking_id: booking_id},
                    success: function (data) {
                        $("#message").html(data.message);
                        $('#booking_procedures').DataTable().ajax.reload();
                    }

                });
            }
        }
    });
}





function add_procedure_consumables(procedure_id, booking_id) {
    var jsonPath = SurgiTrack.handleBaseURL();
    bootbox.confirm({
        message: "You are about to add Counsumables associated with this Procedure, continue?",
        callback: function (result) {
            if (result == true) {
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: jsonPath + "/theatre/add_procedure_consumables",
                    data: {procedure_id: procedure_id, booking_id: booking_id},
                    success: function (data) {
                        $("#message").html(data.message);
                        $('#rpl_nappi_codes').empty();
                        $('#rpl_nappi_codes').html(data.consumables);
                    }

                });
            }
        }
    });
}



function delete_patient(d) {
    var jsonPath = SurgiTrack.handleBaseURL();
    bootbox.confirm({
        message: "You are about to delete a this Patients Records, continue?",
        callback: function (result) {
            if (result == true) {
                $.ajax({
                    dataType: 'json',
                    type: "POST",
                    url: jsonPath + "/patients/remove_patients",
                    data: {patient_id: d},
                    success: function (data) {
                        $("#message").text(data.message);
                        $('#patientlist_table').DataTable().ajax.reload();
                    }

                });
            }
        }
    });
}



function remove_rpl_nappi_codes(d) {
    var jsonPath = SurgiTrack.handleBaseURL();
    bootbox.confirm({
        message: "You are about to remove this Consumable, continue?",
        callback: function (result) {
            if (result == true) {
                $.ajax({
                    dataType: 'json',
                    type: "POST",
                    url: jsonPath + "/settings/remove_rpl_nappi_codes",
                    data: {rpl_nappi_id: d},
                    success: function (data) {
                        $("#message").html(data.message);
                        $('#rpl_nappi_codes').DataTable().ajax.reload();
                    }

                });
            }
        }
    });
}

function remove_unused_consumable(d, e) {
    var jsonPath = SurgiTrack.handleBaseURL();
    bootbox.confirm({
        message: "You are about to remove this Consumable, continue?",
        callback: function (result) {
            if (result == true) {
                $.ajax({
                    dataType: 'json',
                    type: "POST",
                    url: jsonPath + "/theatre/remove_unused_consumable",
                    data: {booking_consumable_id: d, booking_id: e},
                    success: function (data) {
                        $("#message").html(data.message);
                        $('#rpl_nappi_codes').empty();
                        $('#rpl_nappi_codes').html(data.consumables);
                    }

                });
            }
        }
    });
}

function view_patients_coding(d) {
    var jsonPath = SurgiTrack.handleBaseURL();
    $('#myModalViewPatientsCoding').modal('show');
    $.ajax({
        dataType: 'json',
        type: "POST",
        url: jsonPath + "/patients/preview_patients_coding_pdf",
        data: {booking_id: d},
        success: function (data) {
            $(".modal-body #booking_id").val(d);
            $(".modal-body #patient_opnotes").html(data.file_iframe);
        }

    });
}

function delete_procedure(d) {
    var jsonPath = SurgiTrack.handleBaseURL();
    bootbox.confirm({
        message: "You are about to delete a procedure, continue?",
        callback: function (result) {
            if (result == true) {
                $.ajax({
                    type: "POST",
                    url: jsonPath + "/settings/delete_procedure",
                    data: {procedure_id: d},
                    success: function (data) {
                        $("#pmessage").html('');
                        $('#palertMessage').show();
                        $("#pmessage").text(data.message);
                        $('#procedures').DataTable().ajax.reload();
                    }

                });
            }
        }
    });
}

function add_mapt_cretaria(d) {
    var jsonPath = SurgiTrack.handleBaseURL();
    $('#myModalMAPTCriteria').modal('show');
    $(".modal-body #mapt_id").val(d);
    $.ajax({
        type: "POST",
        url: jsonPath + "/administrator/search_mapt_details",
        data: {mapt_id: d},
        success: function (data) {
            $(".modal-body #maptdetails").html(data);
        }

    });
}

function preview_mapt_cretaria(d) {
    var jsonPath = SurgiTrack.handleBaseURL();
    $('#view_criteria').show();
    $.ajax({
        type: "POST",
        url: jsonPath + "/administrator/mapt_entry_form",
        data: {mapt_id: d},
        success: function (data) {
            $("#view_criteria_form").html(data);
        }
    });
}

function record_ops(d) {
    var jsonPath = SurgiTrack.handleBaseURL();
    $('#myModalRecordOps').modal('show');
    $(".modal-body #booking_id").val(d);
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: jsonPath + "/patients/caselog_patients_details",
        data: {booking_id: d},
        success: function (data) {
            $(".modal-body #admissiondetails").html(data.header);
        }

    });
}

function edit_optnotes(d) {
    var jsonPath = SurgiTrack.handleBaseURL();
    $('#myModalEditRecordOps').modal('show');
    $(".modal-body #booking_id").val(d);
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: jsonPath + "/patients/caselog_patients_details",
        data: {booking_id: d},
        success: function (data) {
            var assistants = data.surgeon_assistant;
            $(".modal-body #booking_id").val(d);
            $(".modal-body #admissiondetails").html(data.header);
            $(".modal-body #op_notes").summernote('code', data.opnotes);
            $(".modal-body #op_date_end").val(data.op_date_end);
            $(".modal-body #op_date_start").val(data.op_date_start);
            $(".modal-body #anethesia_start").val(data.anethesia_start);
            $(".modal-body #anethesia_end").val(data.anethesia_end);
            $(".modal-body #operation_done").val(data.operation_done);
            $(".modal-body #surgeon_supervisor").val(data.surgeon_supervisor);
            $(".modal-body #surgeon_uid").val(data.surgeon_uid);


            //Find a solution to display on multiple Select2
            //
            //$(".modal-body #surgeon_assistant").select2("val", assistants);            
            //$(".modal-body #surgeon_assistant").val(data.surgeon_assistant.split(','));
            $('.modal-body #surgeon_assistant option').filter(function () {
                return assistants.indexOf($(this).val()) > -1; //Options text exists in array
            }).prop('selected', true); //Set selected
            //$("#strings").val(["Test", "Prof", "Off"]);
        }

    });
}



function remove_from_theatre(d) {
    var jsonPath = SurgiTrack.handleBaseURL();
    $('#myModalRemoveTheatre').modal('show');
    $(".modal-body #booking_id").val(d);
    $.ajax({
        type: "POST",
        url: jsonPath + "/patients/search_patients_admission_details",
        data: {booking_id: d},
        success: function (data) {
            $(".modal-body #admissiondetails").html(data);
        }

    });
}
function remove_department(user, department) {
    var jsonPath = SurgiTrack.handleBaseURL();
    bootbox.confirm({
        message: "You are about to quit the department, continue?",
        callback: function (result) {
            if (result == true) {
                $.ajax({
                    type: "POST",
                    url: jsonPath + "/users/remove_department",
                    data: {user: user, department: department},
                    success: function (data) {
                        location.reload();
                    }

                });
            }
        }
    });
}

function back_to_admission(d) {
    var jsonPath = SurgiTrack.handleBaseURL();
    bootbox.confirm({
        message: "You are about to return the patient to admission list, continue?",
        callback: function (result) {
            if (result == true) {
                $.ajax({
                    type: "POST",
                    url: jsonPath + "/theatre/back_to_admission",
                    data: {booking_id: d},
                    success: function (data) {
                        refresh();
                    }

                });
            }
        }
    });
}
function back_to_waiting(d) {
    var jsonPath = SurgiTrack.handleBaseURL();
    bootbox.confirm({
        message: "You are about to return the patient to waiting list, continue?",
        callback: function (result) {
            if (result == true) {
                $.ajax({
                    type: "POST",
                    url: jsonPath + "/theatre/back_to_waiting",
                    data: {booking_id: d},
                    success: function (data) {
                        refresh();
                    }

                });
            }
        }
    });
}

function remove_booking(d) {
    var jsonPath = SurgiTrack.handleBaseURL();
    bootbox.confirm({
        message: "You are about to remove/delete this booking, continue?",
        callback: function (result) {
            if (result == true) {
                $.ajax({
                    type: "POST",
                    url: jsonPath + "/theatre/remove_booking",
                    data: {booking_id: d},
                    success: function (data) {
                        refresh();

                    }

                });
            }
        }
    });
}


function refresh() {

    if ($('#theatrelist_table').length > 0) {
        $('#theatrelist_table').DataTable().ajax.reload();
    }

    if ($('#admissionlist_table').length > 0) {
        $('#admissionlist_table').DataTable().ajax.reload();
    }

    if ($('#waitinglist_table').length > 0) {
        $('#waitinglist_table').DataTable().ajax.reload();
    }

    if ($('#patientwaitinglist_table').length > 0) {
        $('#patientwaitinglist_table').DataTable().ajax.reload();
    }

}


function approve_department(user, userid, department, departmentname) {
    var jsonPath = SurgiTrack.handleBaseURL();
    bootbox.confirm({
        message: "You are about to approve a <b>\"" + user + "\"</b> to access <b>\"" + departmentname + "\"</b> Department, continue?",
        callback: function (result) {
            if (result == true) {
                $.ajax({
                    type: "POST",
                    url: jsonPath + "/users/approve_department",
                    data: {userid: userid, department: department},
                    success: function (data) {
                        //
                        alert(data);
                        location.reload();
                    }

                });
            }
        }
    });
}



function delink_department(user, userid, department, departmentname) {
    var jsonPath = SurgiTrack.handleBaseURL();
    bootbox.confirm({
        message: "You are about to remove/delink <b>\"" + user + "\"</b> from " + departmentname + " Department, continue?",
        callback: function (result) {
            if (result == true) {
                $.ajax({
                    type: "POST",
                    url: jsonPath + "/users/delink_department",
                    data: {userid: userid, department: department},
                    success: function (data) {
                        alert(data);
                        location.reload();
                    }

                });
            }
        }
    });
}




function default_firm(firm, userid, firmname, department) {
    var jsonPath = SurgiTrack.handleBaseURL();
    bootbox.confirm({
        message: "You are about to set  <b>\"" + firmname + "\"</b> as your default firm, continue?",
        callback: function (result) {
            if (result == true) {
                $.ajax({
                    type: "POST",
                    url: jsonPath + "/users/default_firm",
                    data: {userid: userid, firm: firm, department: department},
                    success: function (data) {
                        alert(data);
                        //location.reload();
                        window.location.replace(jsonPath);
                        //window.open(jsonPath );
                    }

                });
            }
        }
    });
}
function approve_firm(user, userid, firm, firmname) {
    var jsonPath = SurgiTrack.handleBaseURL();
    bootbox.confirm({
        message: "You are about to approve a <b>\"" + user + "\"</b> to access <b>\"" + firmname + "\"</b> Department, continue?",
        callback: function (result) {
            if (result == true) {
                $.ajax({
                    type: "POST",
                    url: jsonPath + "/users/approve_firm",
                    data: {userid: userid, firm: firm},
                    success: function (data) {
                        //
                        alert(data);
                        location.reload();
                    }

                });
            }
        }
    });
}



function delink_firm(user, userid, firm, firmname) {
    var jsonPath = SurgiTrack.handleBaseURL();
    bootbox.confirm({
        message: "You are about to remove/delink <b>\"" + user + "\"</b> from " + firmname + " Department, continue?",
        callback: function (result) {
            if (result == true) {
                $.ajax({
                    type: "POST",
                    url: jsonPath + "/users/delink_firm",
                    data: {userid: userid, firm: firm},
                    success: function (data) {
                        alert(data);
                        location.reload();
                    }

                });
            }
        }
    });
}

function print_theatre_list(d) {
    var jsonPath = SurgiTrack.handleBaseURL();
    bootbox.confirm({
        message: "Generating Theatre list, continue?",
        callback: function (result) {
            if (result == true) {
                // window.location.href=jsonPath + "/theatre/print_theatre_list";
                window.open(jsonPath + "/theatre/print_full_theatre_list", '_blank');
            }
        }
    });
}

function theatre_list_print() {
    $('#myModalTheatreListPrint').modal('show');
}

function firm_theatre_list_print() {
    $('#myModalFirmTheatreListPrint').modal('show');
}

function print_waiting_list() {
    var jsonPath = SurgiTrack.handleBaseURL();
    bootbox.confirm({
        message: "Generating Current Waiting list, continue?",
        callback: function (result) {
            if (result == true) {
                // window.location.href=jsonPath + "/theatre/print_theatre_list";
                window.open(jsonPath + "/theatre/print_waiting_list", '_blank');
            }
        }
    });
}
function procedure_waiting_list_print() {
    $('#myModalProcedureWaitingListPrint').modal('show');
}
function firm_waiting_list_print() {
    $('#myModalFirmWaitingListPrint').modal('show');
}
function theatre_waiting_list_print() {
    $('#myModalTheatreWaitingListPrint').modal('show');
}

function print_operation_log() {
    $('#myModalfullCaselogListPrint').modal('show');
}
function firm_operation_log_print() {
    $('#myModalFirmcaselogListPrint').modal('show');
}
function surgeon_operation_log_print() {
    $('#myModalsurgeonCaselogListPrint').modal('show');
}


function print_admission_list() {
    var jsonPath = SurgiTrack.handleBaseURL();
    bootbox.confirm({
        message: "Generating Current Admission list, continue?",
        callback: function (result) {
            if (result == true) {
                window.open(jsonPath + "/theatre/print_admission_list", '_blank');
            }
        }
    });
}
function date_admission_list_print() {
    $('#myModalDateAdmissionListPrint').modal('show');
}
function firm_admission_list_print() {
    $('#myModalFirmAdmissionListPrint').modal('show');
}
function multi_admission_list_print() {
    $('#myModalMultiAdmissionListPrint').modal('show');
}


var room = 1;
function education_fields() {

    var jsonPath = SurgiTrack.handleBaseURL();
    $.getJSON(jsonPath + "/settings/get_myprocedure/", {ajax: true}, function (j) {

        var options = '';
        for (var i = 0; i < j.length; i++) {
            options += '<option value="' + j[i].procedure_id + '">' + j[i].procedure_name + '</option>';
        }
        $("select#item" + room).html(options);
    })

    //$("#consumables_list" + room).append(select);

    room++;
    var objTo = document.getElementById('education_fields');
    var divtest = document.createElement("div");
    divtest.setAttribute("class", "form-group removeclass" + room);
    var rdiv = 'removeclass' + room;
    divtest.innerHTML = '<div class="row"> \n\
            <section class="col col-6">  \n\
            <label class="input"> <select class="" name="item[' + room + ']" id="item' + room + '" >\n\
            <option value=""></option>\n\
           </select> </label>\n\
            <p class="note"><strong>Item</strong> </p>\n\
            </section>\n\
            <section class="col col-4">\n\
            <label class="input"> \n\
            <input class="input-xs" type="text"  id="quantity" name="options[' + room + '][text]" value="" placeholder="Quantity"> </label> \n\
            <p class="note"><strong>Quantity</strong> </p>\n\
            </section> \n\
            <section class="col col-2">\n\
            <button class="btn btn-xs btn-danger" type="button" id="removechoice" onclick="remove_fields(' + room + ');" value="' + room + '" ><i class="fa fa-minus-square-o"></i> </button> \n\
            </section>\n\
        </div>';
    objTo.appendChild(divtest);
}
function remove_fields(rid) {
    $('.removeclass' + rid).remove();
}








