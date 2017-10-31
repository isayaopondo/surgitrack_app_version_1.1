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
    $('#folder_number').on('keyup', function () {

        $.ajax({
            type: "POST",
            dataType: 'json',
            url: jsonPath + "/booking/ajaxget_suburb_by_postcode/",
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

});

