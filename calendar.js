setCookie("vpbx_user_locale", "en_US", 1);
setCookie("tz", "America%2FManagua", 1);
function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
    let expires = "expires=" + d.toGMTString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/" + ";" + "SameSite=Lax;";
}
//Eliminar despues de las pruebas todo lo de arriba
document.addEventListener("DOMContentLoaded", function () {
    //Path to root for ez variable declaration
    var url = "./";
    var localeSelectorEl = document.getElementById("locale-selector"); //Assign from the view to the js controler of the locale selector
    var timeZoneSelectorEl = document.getElementById("time-zone-selector"); //Assign from the view to the js controler of the timezone selector
    var eR_DateLocal = /\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}-\d{2}:\d{2}/; //RegEx used to validate the date on local format with ISO8086 "YYYY-MM-DDTHH:MM:SS-GMT"
    var eR_DateUTC = /\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}Z/; //RegEx used to validate the date on UTC format with ISO8086 "YYYY-MM-DDTHH:MM:SSZ"
    var initialTimeZone = getCookie("tz") != "UTC" ? (initialTimeZone = "local") : (initialTimeZone = "UTC"); //Initial timezone for the calendar to render.
    var calendarEl = document.getElementById("calendar"); //Invoke the Calendar to a variable from the HTML
    //-----Could be improved-----↕
    if (getCookie("Calendar_Locale") != "") {
        var initialLocaleCode = getCookie("Calendar_Locale"); //Initial locale code for the calendar to render, format "xx"
    } else if (getCookie("Calendar_Locale") == "" || typeof getCookie("Calendar_Locale") == "undefined") {
        var initialLocaleCode = getCookie("vpbx_user_locale").split("_")[0]; //Initial locale code for the calendar to render, original format "xx_XX"
    } else {
        var initialLocaleCode = "en"; //Initial locale code to render, fallback if no parameter is present
    }
    //-----Could be improved-----↕

    // Function to hide the URL'S in the table
    function hideurl_Timeout_Interval() {
        const class_div_container = document.querySelector(".fc-view");
        if (class_div_container.classList.contains("fc-daygrid")) {
            try {
                var anchorclass = document.getElementsByClassName("fc-daygrid-event");
                setTimeout(function () {
                    console.log("CALENDAR SCRIPT MY INTERVAL MONTH");
                    for (var en = 0; en < anchorclass.length; en++) {
                        if (anchorclass[en].href != "" && anchorclass[en].href != null) {
                            anchorclass[en].setAttribute("hiddenhref", anchorclass[en].href);
                            anchorclass[en].removeAttribute("href");
                        }
                    }
                    for (let index = 0; index < mas.length; index++) {
                        mas[index].setAttribute("id", "pop"); /* Set the id to more link in table */
                    }
                    if (document.getElementById("pop") != null) {
                        document.getElementById("pop").onclick = popinterval;
                    } else {
                        //CARRY ON DO NOTHING
                    }
                }, 34);
            } catch (err) {
                console.log(err.message); //SPACE TO HANDLE ERRORS
            }
        } else if (class_div_container.classList.contains("fc-timegrid")) {
            var anchorclass = document.getElementsByClassName("fc-timegrid-event");
            setTimeout(function () {
                console.log("CALENDAR SCRIPT MY INTERVAL TIMEGRID");
                for (var en = 0; en < anchorclass.length; en++) {
                    if (anchorclass[en].href != "" && anchorclass[en].href != null) {
                        anchorclass[en].setAttribute("hiddenhref", anchorclass[en].href);
                        anchorclass[en].removeAttribute("href");
                    }
                }
            }, 33);
        } else {
            var listanchorclass = document.getElementsByClassName("fc-event-forced-url");
            setTimeout(function () {
                console.log("CALENDAR SCRIPT MY INTERVAL LIST");
                for (let en = 0; en < listanchorclass.length; en++) {
                    listanchorclass[en].children[2].children[0].setAttribute("hiddenhref", listanchorclass[en].children[2].children[0].getAttribute("href"));
                    listanchorclass[en].children[2].children[0].removeAttribute("href");
                    listanchorclass[en].children[2].children[0].setAttribute("href", "");
                }
            }, 30);
        }
    }

    //Trigguers the Date-Time Picker Box on creation
    $("body").on("click", ".datetimepicker", function () {
        hideurl_Timeout_Interval(); //Call to Timeout function to Hide URL's
        $(this)
            .not(".hasDateTimePicker")
            .datetimepicker({
                controlType: "select",
                changeMonth: true,
                changeYear: true,
                dateFormat: "yy-mm-dd",
                timeFormat: "HH:mm:ss",
                yearRange: "1900:+10",
                showOtherMonths: true,
                selectOtherMonths: true,
                showOn: "focus",
                firstDay: 1,
            })
            .focus(); //We Load the control on focus
    });
    //Trigguers the AddEvent modal to reset on close
    $("#closeDate").on("click", function () {
        $("#createEvent").trigger("reset"); // Remove any form data
        calendar.refetchEvents(); // Refresh calendar
        hideurl_Timeout_Interval(); //Call to Timeout function to Hide URL's
    });
    //Trigguers the EditEvent modal to reset on close
    $("#closeDateEdit").on("click", function () {
        document.getElementById("editEventId").value = ""; // Set Empty value to editEventId
        $("#editEvent").trigger("reset"); // Remove any form data
        calendar.refetchEvents(); // Refresh calendar
        hideurl_Timeout_Interval(); //Call to Timeout function to Hide URL's
    });
    //Delete form and action to button
    $("#deleteEvent").on("click", function () {
        eedid = document.getElementById("editEventId").value; // Set value of editEventId to variable
        $.ajax({
            url: url + "api/delete.php",
            type: "POST",
            data: { id: eedid },
            success: function () {
                $("deleteEvent").removeAttr("data-id"); // If call return succes remove current Id from the view
                calendar.refetchEvents(); // Refresh calendar
                hideurl_Timeout_Interval(); //Call to Timeout function to Hiide URL's
            },
        }); //We set an event to the delete action button and proceed to delete from the db the event
        $("#deleteeventmodal").modal("hide"); //Close Delete Event Modal
        $("#editeventmodal").modal("hide"); //Close Edit Event Modal
        calendar.refetchEvents(); // Refresh calendar
        hideurl_Timeout_Interval(); //Call to Timeout function to Hiide URL's
    });
    //Trigguers the color hexa box
    $(".colorpicker").colorpicker();

    var calendar = new FullCalendar.Calendar(calendarEl, {
        themeSystem: "standard", //Theme selector for the Calendar
        locale: initialLocaleCode, //Language for the Calendar
        height: 768, //fixed Height for the Calendar render
        timeZone: initialTimeZone, //Timezone to use on the Calendar
        initialView: "dayGridMonth", //Initial View
        allDaySlot: false, //Determines if the all-day slot is displayed at the top of the calendar
        selectable: true, //If a cell is clickable
        editable: true, //If an event is editable
        eventResizableFromStart: true,
        headerToolbar: {
            left: "prevYear,prev,next,nextYear today",
            center: "title",
            right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth",
        }, //Controls to show on Calendar Toolbar
        buttonIcons: true, // Show the prev/next text if false, if true show icon arrow
        weekNumbers: true, //Display the week number on months
        weekNumberCalculation: "local", //If ISO is selected, changes the value of firstDay to Monday (ISO8601) else use locale-specific
        navLinks: true, // Can click day/week names to navigate views
        // navLinkDayClick: function (date) {
        //   console.log("day", date.toISOString());
        // },
        dayMaxEvents: true, // Allow "more" link when too many events displaying popup
        nowIndicator: true, //Whether or not to display a marker indicating the current time
        fixedWeekCount: false, //Determines the number of weeks displayed in a month 4,5,6 weeks, if false always 6
        events: url + "api/load.php", //From where we load the events this can be an array, json or a function
        eventTimeFormat: {
            hour: "2-digit",
            minute: "2-digit",
            //hour12: false, //For 24 hours display set this to true
            //timeZoneName: "short",
        }, //How we gonna format and display the events in the labels on the calendar
        //Actions to take on D.A.D
        eventDrop: function (arg) {
            var end = arg.event.end;
            //Set the value and format of Start date
            var start = arg.event.start.toDateString() + " " + arg.event.start.getHours() + ":" + arg.event.start.getMinutes() + ":" + arg.event.start.getSeconds(); // We get from the view the values of start time
            arg.event.end == null //If the end date is null we set the same start date to avoid exceptions
                ? (end = start) // If we didn't found any value for end set the start ones
                : (end = arg.event.end.toDateString() + " " + arg.event.end.getHours() + ":" + arg.event.end.getMinutes() + ":" + arg.event.end.getSeconds()); //Initial timezone for the calendar to render.
            $.ajax({
                url: url + "api/update.php",
                type: "POST",
                data: { id: arg.event.id, start: start, end: end },
            }); //Here we performed an update to the db
            hideurl_Timeout_Interval(); //Call to Timeout function to Hide URL's
        },
        //Actions to take on resize
        eventResize: function (arg) {
            //Set the value and format of Start date
            var start = arg.event.start.toDateString() + " " + arg.event.start.getHours() + ":" + arg.event.start.getMinutes() + ":" + arg.event.start.getSeconds(); // We get from the view the values of start time
            //Set the value and format of End date
            var end = arg.event.end.toDateString() + " " + arg.event.end.getHours() + ":" + arg.event.end.getMinutes() + ":" + arg.event.end.getSeconds(); // We get from the view the values of end time
            $.ajax({
                url: url + "api/update.php",
                type: "POST",
                data: { id: arg.event.id, start: start, end: end },
            }); //Here we performed an update to the db
            hideurl_Timeout_Interval(); //Call to Timeout function to Hide URL's
        },
        //Actions to take on event click
        eventClick: function (arg) {
            arg.jsEvent.preventDefault(); // Don't let the browser navigate
            //If we found the declared url proceed to handle the events
            if (arg.event.url) {
                $("#urlevent").modal("show"); //Show the option modal for url's
                document.getElementById("gourl").onclick = function () {
                    gourl(); //Call to function
                    hideurl_Timeout_Interval(); //Call to Timeout function to Hide URL's
                };
                function gourl() {
                    window.open(arg.event.url); //open in a new tab the url
                    $("#urlevent").modal("hide"); //Hide previous modal
                }
                document.getElementById("editurl").onclick = function () {
                    editurl(); //Call to function
                    //hideurl_Timeout_Interval(); //Call to Timeout function to Hide URL's
                };
                function editurl() {
                    $("#urlevent").modal("hide"); //Hide previous modal
                    var id = arg.event.id; //Id of the event from db
                    $("#editEventId").val(id); //Id to view
                    $("#deleteEvent").attr("data-id", id); //Set id to delete action

                    $.ajax({
                        url: url + "api/getevent.php",
                        type: "POST",
                        dataType: "json",
                        data: { id: id },
                        success: function (data) {
                            $("#editEventTitle").val(data.title);
                            $("#editStartDate").val(data.start);
                            $("#editEndDate").val(data.end);
                            $("#editColor").val(data.color);
                            $("#editTextColor").val(data.textColor);
                            $("#editeventmodal").modal();
                        },
                    }); //Here we fetch from the db
                    calendar.refetchEvents(); // Refresh calendar
                    hideurl_Timeout_Interval(); //Call to Timeout function to Hide URL's
                }
            } else {
                //Classic edit if no URL is found
                var id = arg.event.id; //Id of the event from db
                $("#editEventId").val(id); //Id to view
                $("#deleteEvent").attr("data-id", id); //Set id to delete action

                $.ajax({
                    url: url + "api/getevent.php",
                    type: "POST",
                    dataType: "json",
                    data: { id: id },
                    success: function (data) {
                        $("#editEventTitle").val(data.title);
                        $("#editStartDate").val(data.start);
                        $("#editEndDate").val(data.end);
                        $("#editColor").val(data.color);
                        $("#editTextColor").val(data.textColor);
                        $("#editeventmodal").modal();
                    },
                }); //Here we fetch from the db
                calendar.refetchEvents(); // Refresh calendar
                hideurl_Timeout_Interval(); //Call to Timeout function to Hide URL's
            }
        },
        //Actions to take on single and multi-cell selection on calendar
        select: function (arg) {
            calendar.refetchEvents(); // Refresh Calendar
            var today = new Date(); //We invoke the actual date to a variable
            var time =
                (today.getHours() < 10 ? "0" : "") +
                today.getHours() +
                ":" +
                (today.getMinutes() < 10 ? "0" : "") +
                today.getMinutes() +
                ":" +
                (today.getSeconds() < 10 ? "0" : "") +
                today.getSeconds(); //We invoke the actual time with the validation of the prepend "0" to a variable
            if (eR_DateLocal.test(arg.startStr) && eR_DateLocal.test(arg.endStr)) {
                //Test case for RegEx local ISO8086 String Week/Day View
                var dts = arg.startStr.split("T")[0] + " " + arg.startStr.split("T")[1].split("-", 1); //We get the Second part of the string in Start "HH:MM:SS-GMT" in the first split, then we split the "GMT" result => "YYYY-MM-DD"+"HH:MM:SS"
                var dte = arg.endStr.split("T")[0] + " " + arg.endStr.split("T")[1].split("-", 1); //We get the Second part of the string in End "HH:MM:SS-GMT" in the first split, then we split the "GMT" result => "YYYY-MM-DD"+"HH:MM:SS"
            } else if (eR_DateUTC.test(arg.startStr) && eR_DateUTC.test(arg.endStr)) {
                //Test case for RegEx UTC ISO8086 String Week/Day View
                var dts = arg.startStr.split("T")[0] + " " + arg.startStr.split("T")[1].split("Z", 1); //We get the Second part of the string in Start "HH:MM:SSZ" in the first split, then we split the "Z" result => "YYYY-MM-DD" + "HH:MM:SS"
                var dte = arg.endStr.split("T")[0] + " " + arg.endStr.split("T")[1].split("Z", 1); //We get the Second part of the string in Start "HH:MM:SSZ" in the first split, then we split the "Z" result => "YYYY-MM-DD" + "HH:MM:SS"
            } else {
                //Test case for ISO8086 String UTC/Local Month View
                var dts = arg.startStr + " " + time; //Set the value of the current Date-Time to a variable
                var dte = arg.endStr + " " + "00:00:00"; //Set the value of the current Date-Time to the end of the day to a variable
            }
            document.getElementById("startDate").value = dts; //Set the value of the current Date-Time to StartDate
            document.getElementById("endDate").value = dte; //Set the value of the current Date-Time to the end of the day to EndDate
            $("#addeventmodal").modal("show"); //Call to modal view
            calendar.unselect(); //Diselection of the Calendar Cells
            hideurl_Timeout_Interval(); //Call to Timeout function to Hide URL's
        },
    });

    calendar.render(); //Call to render calendar

    calendar.getAvailableLocaleCodes().forEach(function (localeCode) {
        var optionEl = document.createElement("option"); //We create here the option tag for the control
        optionEl.value = localeCode; //Assign value
        optionEl.selected = localeCode == initialLocaleCode; //Assign initial language code
        optionEl.innerText = localeCode; //Assign text to display
        localeSelectorEl.appendChild(optionEl); //Assign all the values to the selector
    }); // Build the locale selector's options

    localeSelectorEl.addEventListener("change", function () {
        if (this.value) {
            calendar.setOption("locale", this.value); //Change the render based on the options created before
            document.documentElement.setAttribute("lang", this.value); //Call to change the lang tag in the html
            setCookie("Calendar_Locale", this.value, 1);
        }
        hideurl_Timeout_Interval(); //Call to Timeout function to Hide URL's
    }); // When the selected option changes, dynamically change the calendar option Locales

    timeZoneSelectorEl.addEventListener("change", function () {
        calendar.setOption("timeZone", this.value);
        hideurl_Timeout_Interval(); //Call to Timeout function to Hide URL's
    }); // When the timezone selector changes, dynamically change the calendar option TimeZones

    function getCookie(cname) {
        let name = cname + "=";
        let decodedCookie = decodeURIComponent(document.cookie);
        let ca = decodedCookie.split(";");
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == " ") {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    $("#createEvent").submit(function (event) {
        event.preventDefault(); // Stop the form from refreshing the page
        $(".form-group").removeClass("has-error"); // Remove the error class
        $(".help-block").remove(); // Remove the error text

        // Process the form
        $.ajax({
            type: "POST",
            url: url + "api/insert.php",
            data: $(this).serialize(),
            dataType: "json",
            encode: true,
        }).done(function (data) {
            if (data.success) {
                // If Insertion worked
                $("#createEvent").trigger("reset"); // Remove any form data
                $("#addeventmodal").modal("hide"); // Close model
                calendar.refetchEvents(); // Refresh calendar
                hideurl_Timeout_Interval(); //Call to Timeout function to Hide URL's
            } else {
                if (data.errors.start) {
                    // If error exist update the html
                    $("#start-date-group").addClass("has-error"); // Insert the error class
                    $("#start-date-group").append('<div class="help-block">' + data.errors.start + "</div>"); // Insertion of the message error for date to the view
                }
                if (data.errors.end) {
                    // If error exist update the html
                    $("#end-date-group").addClass("has-error"); // Insert the error class
                    $("#end-date-group").append('<div class="help-block">' + data.errors.end + "</div>"); // Insertion of the message error for date to the view
                }
                if (data.errors.title) {
                    // If error exist update the html
                    $("#title-group").addClass("has-error"); // Insert the error class
                    $("#title-group").append('<div class="help-block">' + data.errors.title + "</div>"); // Insertion of the message error for title to the view
                }
                hideurl_Timeout_Interval(); //Call to Timeout function to Hide URL's
            }
        });
    }); //Create Event Submit Handler

    $("#editEvent").submit(function (event) {
        event.preventDefault(); // Stop the form refreshing the page
        $(".form-group").removeClass("has-error"); // Remove the error class
        $(".help-block").remove(); // Remove the error text

        //Form data
        var id = $("#editEventId").val();
        var title = $("#editEventTitle").val();
        var start = $("#editStartDate").val();
        var end = $("#editEndDate").val();
        var color = $("#editColor").val();
        var textColor = $("#editTextColor").val();

        // Process the form
        $.ajax({
            type: "POST",
            url: url + "api/update.php",
            data: {
                id: id,
                title: title,
                start: start,
                end: end,
                color: color,
                text_color: textColor,
            },
            dataType: "json",
            encode: true,
        }).done(function (data) {
            if (data.success) {
                // Insertion worked
                $("#editEvent").trigger("reset"); // Remove any form data
                $("#editeventmodal").modal("hide"); // Close model
                calendar.refetchEvents(); // Refresh calendar
                hideurl_Timeout_Interval(); //Call to Timeout function to Hide URL's
            } else {
                if (data.errors.start) {
                    // If error exist update the html
                    $("#start-date-group").addClass("has-error"); // Insert the error class
                    $("#start-date-group").append('<div class="help-block">' + data.errors.start + "</div>"); // Insertion of the message error for date to the view
                }
                if (data.errors.end) {
                    // If error exist update the html
                    $("#end-date-group").addClass("has-error"); // Insert the error class
                    $("#end-date-group").append('<div class="help-block">' + data.errors.end + "</div>"); // Insertion of the message error for date to the view
                }
                if (data.errors.title) {
                    // If error exist update the html
                    $("#title-group").addClass("has-error"); // Insert the error class
                    $("#title-group").append('<div class="help-block">' + data.errors.title + "</div>"); // Insertion of the message error for title to the view
                }
                hideurl_Timeout_Interval(); //Call to Timeout function to Hide URL's
            }
        });
        return false;
        //
    }); //Edit Event Submit Handler
});

// Function to hide the URL's in the table
function myInterval() {
    console.log("INDEX SCRIPT MY INTERVAL");
    const class_div_container = document.querySelector(".fc-view");
    if (class_div_container.classList.contains("fc-daygrid")) {
        try {
            setTimeout(function () {
                console.log("--HIDEURL DAYGRID-----ENTRA A INDEX HIDEURL|||||||||");
                let anchorclass = document.getElementsByClassName("fc-daygrid-event");
                for (var en = 0; en < anchorclass.length; en++) {
                    if (anchorclass[en].href != "" && anchorclass[en].href != null) {
                        anchorclass[en].setAttribute("hiddenhref", anchorclass[en].href);
                        anchorclass[en].removeAttribute("href");
                    }
                }
                for (let index = 0; index < mas.length; index++) {
                    mas[index].setAttribute("id", "pop"); /* Set the id to more link in table */
                }
                if (document.getElementById("pop") != null) {
                    document.getElementById("pop").onclick = popinterval;
                } else {
                    //CARRY ON NOTHING TO DO HERE
                }
            }, 13);
        } catch (err) {
            console.log(err.message); //SPACE TO HANDLE ERRORS
        }
    } else if (class_div_container.classList.contains("fc-timegrid")) {
        setTimeout(function () {
            console.log("--HIDEURL DAYGRID-----ENTRA A INDEX HIDEURL|||||||||");
            let anchorclass = document.getElementsByClassName("fc-daygrid-event");
            for (var en = 0; en < anchorclass.length; en++) {
                if (anchorclass[en].href != "" && anchorclass[en].href != null) {
                    anchorclass[en].setAttribute("hiddenhref", anchorclass[en].href);
                    //anchorclass[en].removeAttribute("href");
                    anchorclass[en].setAttribute("href", "");
                }
            }
        }, 15);
    } else {
        console.log("--HIDEURL LIST-----ESTA LLAMANDO HIDEURL EVENT");
        let listanchorclass = document.getElementsByClassName("fc-event-forced-url");
        setTimeout(function () {
            for (let en = 0; en < listanchorclass.length; en++) {
                listanchorclass[en].children[2].children[0].setAttribute("hiddenhref", listanchorclass[en].children[2].children[0].getAttribute("href"));
                listanchorclass[en].children[2].children[0].removeAttribute("href");
            }
        }, 13);
    }
}
//FOR THE POPOVER IN DAYVIEW (MONTH)
function popinterval() {
    console.log("LLAMA POP");
    let anchor_Handler_pop = document.getElementsByClassName("fc-daygrid-event");
    setTimeout(function () {
        for (var en = 0; en < anchor_Handler_pop.length; en++) {
            if (anchor_Handler_pop[en].href != "" && anchor_Handler_pop[en].href != null) {
                anchor_Handler_pop[en].setAttribute("hiddenhref", anchor_Handler_pop[en].href);
                anchor_Handler_pop[en].removeAttribute("href");
            }
        }
    }, 15);
}
