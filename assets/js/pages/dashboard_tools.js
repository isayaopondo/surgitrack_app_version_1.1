
$(document).ready(function () {
    var jsonPath = SurgiTrack.handleBaseURL();
    // DO NOT REMOVE : GLOBAL FUNCTIONS!
    pageSetUp();

    var date = new Date();
    var now = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
    var hdr = {
        left: 'title',
        center: 'month,agendaWeek,agendaDay',
        right: 'prev,today,next'
    };
    var initDrag = function (e) {
        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end

        var eventObject = {
            title: $.trim(e.children().text()), // use the element's text as the event title
            description: $.trim(e.children('span').attr('data-description')),
            icon: $.trim(e.children('span').attr('data-icon')),
            className: $.trim(e.children('span').attr('class')) // use the element's children as the event class
        };
        // store the Event Object in the DOM element so we can get to it later
        e.data('eventObject', eventObject);
        // make the event draggable using jQuery UI
        e.draggable({
            zIndex: 999,
            revert: true, // will cause the event to go back to its
            revertDuration: 0 //  original position after the drag
        });
    };
    var addEvent = function (title, priority, description, icon) {
        title = title.length === 0 ? "Untitled Event" : title;
        description = description.length === 0 ? "No Description" : description;
        icon = icon.length === 0 ? " " : icon;
        priority = priority.length === 0 ? "label label-default" : priority;
        var html = $('<li><span class="' + priority + '" data-description="' + description + '" data-icon="' +
            icon + '">' + title + '</span></li>').prependTo('ul#external-events').hide().fadeIn();
        $("#event-container").effect("highlight", 800);
        initDrag(html);
    };
    /* initialize the external events
     -----------------------------------------------------------------*/

    $('#external-events > li').each(function () {
        initDrag($(this));
    });
    $('#add-event').click(function () {
        var title = $('#title').val(),
            priority = $('input:radio[name=priority]:checked').val(),
            description = $('#description').val(),
            icon = $('input:radio[name=iconselect]:checked').val();
        addEvent(title, priority, description, icon);
    });
    /* initialize the calendar
     -----------------------------------------------------------------*/

    $('#calendar').fullCalendar({
        header: hdr,
        //defaultDate: '2014-06-12',
        defaultView: 'agendaWeek',
        editable: true,
        droppable: true, // this allows things to be dropped onto the calendar !!!
        businessHours: {
            // days of week. an array of zero-based day of week integers (0=Sunday)
            dow: [0, 1, 2, 3, 4, 5, 6], // Monday - Thursday
            start: '07:00', // a start time (10am in this example)
            end: '19:00', // an end time (6pm in this example)
        },
        minTime: '07:00:00',
        maxTime: '19:00:00',
        drop: function (date, allDay) { // this function is called when something is dropped

            // retrieve the dropped element's stored Event Object
            var originalEventObject = $(this).data('eventObject');
            // we need to copy it, so that multiple events don't have a reference to the same object
            var copiedEventObject = $.extend({}, originalEventObject);
            // assign it the date that was reported
            copiedEventObject.start = date;
            copiedEventObject.allDay = allDay;
            // render the event on the calendar
            // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
            $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
            // is the "remove after drop" checkbox checked?
            if ($('#drop-remove').is(':checked')) {
                // if so, remove the element from the "Draggable Events" list
                $(this).remove();
            }

        },
        select: function (start, end, allDay) {
            var title = prompt('Event Title:');
            if (title) {
                calendar.fullCalendar('renderEvent', {
                        title: title,
                        start: start,
                        end: end,
                        allDay: allDay
                    }, true // make the event "stick"
                );
            }
            calendar.fullCalendar('unselect');
        },
        events: {
            url: jsonPath + "/dashboard/case_calendar_data/",
            type: 'POST',
            data: {
                title: 'procedure_name',
                start: 'surgerydate',
                end: 'end',
                allDay: false,
                url: 'url',
                description: 'folder_number',
                evtcolor: 'event_color'
            },
            error: function () {
                alert('there was an error while fetching events!');
            }

        },
        eventRender: function (event, element, icon) {
            element.css('background-color', event.evtcolor);
            if (!event.description == "") {
                element.find('.fc-title').append("<br/><span class='ultra-light'>" + event.description +
                    "</span>");
            }
            if (!event.icon == "") {
                element.find('.fc-title').append("<i class='air air-top-right fa " + event.icon +
                    " '></i>");
            }

        },
        dayClick: function (date, jsEvent, view) {
            //alert(window.location.href);
            $('#myModal').modal('show');
            var admissionDate = date.format("YYYY-MM-DD");
            $(".modal-body #admission_date").val(admissionDate);

            var surgeryDate = date.format("YYYY-MM-DD HH:mm");

            $('.modal-body #existingpatient').hide();
            $('.modal-body #existingpatient2').hide();

            $(".modal-body #surgerydate").val(surgeryDate);



        },
        windowResize: function (event, ui) {
            $('#calendar').fullCalendar('render');
        },

    });
    /* hide default buttons */
    /*$('.fc-right, .fc-center').hide();
     $('#calendar-buttons #btn-prev').click(function () {
     $('.fc-prev-button').click();
     return false;
     });
     $('#calendar-buttons #btn-next').click(function () {
     $('.fc-next-button').click();
     return false;
     });
     $('#calendar-buttons #btn-today').click(function () {
     $('.fc-today-button').click();
     return false;
     });*/
    $('#mt').click(function () {
        $('#calendar').fullCalendar('changeView', 'month');
    });
    $('#ag').click(function () {
        $('#calendar').fullCalendar('changeView', 'agendaWeek');
    });
    $('#td').click(function () {
        $('#calendar').fullCalendar('changeView', 'agendaDay');
    });

    // Get todays day

// Add 2 weeks

    $('#w').click(function () {
        now.setTime(now.getTime());
        var thisweek = new Date(now.setDate(now.getDate() - now.getDay() + 6));
        // alert(now.getTime());
        $('#calendar').fullCalendar('gotoDate', thisweek);
    });

    //Move calendar focus by 2 week
    $('#tw').click(function () {
        now.setTime(now.getTime() + 14 * 86400000);
        var fortnight = new Date(now.setDate(now.getDate() - now.getDay() + 6));
        //alert(now.getTime());
        $('#calendar').fullCalendar('gotoDate', fortnight);
    });

    //Move calendar focus by 1 Month
    $('#om').click(function () {
        now.setTime(now.getTime() + 30 * 86400000);
        var nextmonth = new Date(now.setDate(now.getDate() - now.getDay() + 6));
        $('#calendar').fullCalendar('gotoDate', nextmonth);
    });
    //Move calendar focus by 3 Month
    $('#tm').click(function () {
        now.setTime(now.getTime() + 90 * 86400000);
        var next3month = new Date(now.setDate(now.getDate() - now.getDay() + 6));
        $('#calendar').fullCalendar('gotoDate', next3month);
    });
    //Move calendar focus by 4 Month
    $('#fm').click(function () {
        now.setTime(now.getTime() + 120 * 86400000);
        var nextmonth = new Date(now.setDate(now.getDate() - now.getDay() + 6));
        //alert(now.getTime());
        $('#calendar').fullCalendar('gotoDate', nextmonth);
    });
    //Move calendar focus by 6 months
    $('#sm').click(function () {
        now.setTime(now.getTime() + 180 * 86400000);
        var next6month = new Date(now.setDate(now.getDate() - now.getDay() + 6));
        $('#calendar').fullCalendar('gotoDate', next6month);
    });
    //Move calendar focus by 1 year
    $('#oy').click(function () {
        now.setTime(now.getTime() + 365 * 86400000);
        var next6month = new Date(now.setDate(now.getDate() - now.getDay() + 6));
        $('#calendar').fullCalendar('gotoDate', next6month);
    });

    $(".js-status-update a").click(function () {
        var selText = $(this).text();
        var $this = $(this);
        $this.parents('.btn-group').find('.dropdown-toggle').html(selText + ' <span class="caret"></span>');
        $this.parents('.dropdown-menu').find('li').removeClass('active');
        $this.parent().addClass('active');
    });

    /*
     * TODO: add a way to add more todo's to list
     */

    // initialize sortable
    $(function () {
        $("#sortable1, #sortable2").sortable({
            handle: '.handle',
            connectWith: ".todo",
            update: countTasks
        }).disableSelection();
    });

    // check and uncheck
    $('.todo .checkbox > input[type="checkbox"]').click(function () {
        var $this = $(this).parent().parent().parent();

        if ($(this).prop('checked')) {
            $this.addClass("complete");

            // remove this if you want to undo a check list once checked
            //$(this).attr("disabled", true);
            $(this).parent().hide();

            // once clicked - add class, copy to memory then remove and add to sortable3
            $this.slideUp(500, function () {
                $this.clone().prependTo("#sortable3").effect("highlight", {}, 800);
                $this.remove();
                countTasks();
            });
        } else {
            // insert undo code here...
        }

    })
    // count tasks
    function countTasks() {

        $('.todo-group-title').each(function () {
            var $this = $(this);
            $this.find(".num-of-tasks").text($this.next().find("li").size());
        });

    }

    /*
     * RUN PAGE GRAPHS
     */

    /* TAB 1: UPDATING CHART */
    // For the demo we use generated data, but normally it would be coming from the server






});

	