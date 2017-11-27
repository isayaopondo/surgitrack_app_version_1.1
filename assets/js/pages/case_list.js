/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function () {
    
var jsonPath = SurgiTrack.handleBaseURL();
    /* DO NOT REMOVE : GLOBAL FUNCTIONS!
     *
     * pageSetUp(); WILL CALL THE FOLLOWING FUNCTIONS
     *
     * // activate tooltips
     * $("[rel=tooltip]").tooltip();
     *
     * // activate popovers
     * $("[rel=popover]").popover();
     *
     * // activate popovers with hover states
     * $("[rel=popover-hover]").popover({ trigger: "hover" });
     *
     * // activate inline charts
     * runAllCharts();
     *
     * // setup widgets
     * setup_widgets_desktop();
     *
     * // run form elements
     * runAllForms();
     *
     ********************************
     *
     * pageSetUp() is needed whenever you load a page.
     * It initializes and checks for all basic elements of the page
     * and makes rendering easier.
     *
     */

    pageSetUp();

    /*
     * ALL PAGE RELATED SCRIPTS CAN GO BELOW HERE
     * eg alert("my home function");
     * 
     * var pagefunction = function() {
     *   ...
     * }
     * loadScript("js/plugin/_PLUGIN_NAME_.js", pagefunction);
     * 
     * TO LOAD A SCRIPT:
     * var pagefunction = function (){ 
     *  loadScript(".../plugin.js", run_after_loaded);	
     * }
     * 
     * OR
     * 
     * loadScript(".../plugin.js", run_after_loaded);
     */

    /* Formatting function for row details - modify as you need */
    function format(d) {
        // `d` is the original data object for the row
        return '<table cellpadding="5" cellspacing="0" border="0" class="table table-hover table-condensed">' +
                '<tr>' +
                '<td style="width:100px">Project Title:</td>' +
                '<td>' + d.name + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Deadline:</td>' +
                '<td>' + d.ends + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Extra info:</td>' +
                '<td>And any further details here (images etc)...</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Comments:</td>' +
                '<td>' + d.comments + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Action:</td>' +
                '<td>' + d.action + '</td>' +
                '</tr>' +
                '</table>';
    }

    // clears the variable if left blank
    var table = $('#example').DataTable({
        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>" +
                "t" +
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
        "ajax": jsonPath+"/index.php/assets/data/dataList.json",
        "bDestroy": true,
        "iDisplayLength": 10,
        "oLanguage": {
            "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
        },
        "columns": [
            {
                "class": 'details-control',
                "orderable": false,
                "data": null,
                "defaultContent": ''
            },
            {"data": "name"},
            {"data": "est"},
            {"data": "contacts"},
            {"data": "status"},
            {"data": "target-actual"},
            {"data": "starts"},
            {"data": "ends"},
            {"data": "tracker"},
        ],
        "order": [[1, 'asc']],
        "fnDrawCallback": function (oSettings) {
            runAllCharts()
        }
    });



    // Add event listener for opening and closing details
    $('#example tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(format(row.data())).show();
            tr.addClass('shown');
        }
    });

})