$(document).ready(function () {
    var today = new Date();
    var jsonPath = SurgiTrack.handleBaseURL();
    pageSetUp();

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

    $('#procedure').on('change', function () {


    });


    $('#procedure').on('change', function () {
        var d = $('#patient_id').val();
        var procedure = $('#procedure').val();
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: jsonPath + "/booking/check_if_patient_has_open_booking",
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
            requestDelay: 100
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


});

