
// DO NOT REMOVE : GLOBAL FUNCTIONS!

$(document).ready(function () {
    var jsonPath = SurgiTrack.handleBaseURL();
    pageSetUp();
    "use strict";
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




    $('#calendarsettings').fullCalendar({
        header: hdr,
        //defaultDate: '2014-06-12',
        defaultView: 'month',
        editable: true,
        droppable: true, // this allows things to be dropped onto the calendar !!!
        businessHours: {
            // days of week. an array of zero-based day of week integers (0=Sunday)
            dow: [0, 1, 2, 3, 4, 5, 6], // Monday - Thursday
            start: '07:00', // a start time 
            end: '19:00', // an end time 
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
            $('#calendarsettings').fullCalendar('renderEvent', copiedEventObject, true);
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
            url: jsonPath + "/administrator/calendar_blocking_data/",
            type: 'POST',
            data: {
                title: 'blockedreason',
                start: 'blocked_date',
                end: 'end',
                allDay: true,
                description: 'blockedreason',
                evtcolor: 'blockedcolor'
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

                        $('#myCalendarModal').modal('show');
                        var blocked_date = date.format();
                        $(".modal-body #blocked_date").val(blocked_date);
                        
            /*bootbox.confirm({
                message: "Do you want to block this date?",
                callback: function (result) {
                    if (result == true) {
                        //alert(window.location.href);
                       
                    }
                }
            });*/


        },
        windowResize: function (event, ui) {
            $('#calendarsettings').fullCalendar('render');
        },

    });

    $('#mts').click(function () {
        $('#calendarsettings').fullCalendar('changeView', 'month');
    });
    $('#ags').click(function () {
        $('#calendarsettings').fullCalendar('changeView', 'agendaWeek');
    });
    $('#tds').click(function () {
        $('#calendarsettings').fullCalendar('changeView', 'agendaDay');
    });
});