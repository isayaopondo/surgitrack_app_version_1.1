/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {
    var jsonPath = SurgiTrack.handleBaseURL();
    pageSetUp();
    /*
     * BOOTSTRAP DUALLIST BOX
     */

    $('#user_department').on('change', function () {
        if ($('#user_firm').length > 0) {
            $('select#user_firm').html('');
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
                            .appendTo($('select#user_firm'));
                    }
                }

            });
        }

    });

    $('#procedure_dual').bootstrapDualListbox({
        selectedListLabel: 'Selected',
        preserveSelectionOnMove: 'moved',
        moveOnSelect: false,
    });
    var initializeDuallistbox = $('#initializeDuallistbox').bootstrapDualListbox({
        nonSelectedListLabel: 'Non-selected',
        selectedListLabel: 'Selected',
        preserveSelectionOnMove: 'moved',
        moveOnSelect: true,
        setRemoveAllLabel:true,
        bootstrap2compatible : true
        //nonSelectedFilter: 'ion ([7-9]|[1][0-2])'
    });

    $('#procedure_group').on('change', function () {
        if ($('#initializeDuallistbox').length > 0) {
           $('#initializeDuallistbox').empty();
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: jsonPath + "/settings/ajaxget_by_procedure_groups/",
                data: {proceduregroup: $(this).val()},
                success: function (data) {
                    for (var i = 0; i < data.length; i++)
                    {
                        initializeDuallistbox.append('<option value="' + data[i].id + '" selected>'+ data[i].rpl_code + ': ' + data[i].procedure_name + '</option>');
                        initializeDuallistbox.bootstrapDualListbox('setRemoveSelectedLabel',data[i].id);
                    }
                    initializeDuallistbox.bootstrapDualListbox('refresh', true);
                }

            });

        }
    });

});