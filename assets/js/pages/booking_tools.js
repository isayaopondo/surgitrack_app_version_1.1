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
    $('#savebookingmapt').on('click', function () {
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: jsonPath + "/booking/save_booking_mapt",
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
            url: jsonPath + "/booking/save_comments",
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

    $('#send_dropbox').on('click', function () {
        var d = $('#booking_id').val();
        bootbox.confirm({
            message: "You are about to send the notes to Dropbox, continue?",
            callback: function (result) {
                if (result == true) {
                    $.ajax({
                        type: "POST",
                        url: jsonPath + "/booking/send_opnotes_dropbox",
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
                        url: jsonPath + "/booking/send_admission_sms",
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
                        url: jsonPath + "/booking/send_general_sms",
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

});

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
        url: jsonPath + "/patients/search_patients_admission_details_with_mapt",
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
                    url: jsonPath + "/booking/send_opnotes_dropbox",
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
                    url: jsonPath + "/booking/delete_mapt",
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
                    url: jsonPath + "/booking/remove_booking_procedure",
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
        message: "You are about to add Consumables associated with this Procedure, continue?",
        callback: function (result) {
            if (result == true) {
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: jsonPath + "/booking/add_procedure_consumables",
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
                    url: jsonPath + "/booking/remove_unused_consumable",
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
                    url: jsonPath + "/booking/back_to_admission",
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
                    url: jsonPath + "/booking/back_to_waiting",
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
                    url: jsonPath + "/booking/remove_booking",
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
                window.open(jsonPath + "/booking/print_full_theatre_list", '_blank');
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
                window.open(jsonPath + "/booking/print_waiting_list", '_blank');
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
                window.open(jsonPath + "/booking/print_admission_list", '_blank');
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
