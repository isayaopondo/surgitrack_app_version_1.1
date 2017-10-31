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

    $('#procedure_category').on('change', function () {
        if ($('#initializeDuallistbox').length > 0) {
           $('#initializeDuallistbox').empty();
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: jsonPath + "/settings/ajaxget_by_procedure_category/",
                data: {category: $(this).val()},
                success: function (data) {
                    for (var i = 0; i < data.length; i++)
                    {
                        initializeDuallistbox.append('<option value="' + data[i].procedure_id + '" selected>' + data[i].procedure_name + '</option>');
                        initializeDuallistbox.bootstrapDualListbox('setRemoveSelectedLabel',data[i].procedure_id);
                    }
                    initializeDuallistbox.bootstrapDualListbox('refresh', true);
                }

            });

        }
    });

});