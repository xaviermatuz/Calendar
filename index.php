<?php require('config.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset='utf-8' />
    <meta name="description" content="Conference Bridge Pro Addon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href='<?= $dir; ?>favicon.ico'>
    <title>Calendar</title>
    <!-- Styles -->
    <link href='<?= $dir; ?>lib/main.min.css' rel='stylesheet' />
    <link href='<?= $dir; ?>packages/bootstrap/css/bootstrap.min.css' rel='stylesheet' />
    <link href="<?= $dir; ?>packages/jqueryui/custom-theme/jquery-ui-1.10.4.custom.min.css" rel="stylesheet">
    <link href='<?= $dir; ?>packages/datepicker/datepicker.css' rel='stylesheet' />
    <link href='<?= $dir; ?>packages/colorpicker/bootstrap-colorpicker.min.css' rel='stylesheet' />
    <link href='<?= $dir; ?>style.css' rel='stylesheet' />
    <!-- Scripts -->
    <script src='<?= $dir; ?>lib/main.min.js'></script>
    <script src='<?= $dir; ?>packages/jquery/jquery-3.6.0.min.js'></script>
    <script src='<?= $dir; ?>packages/jqueryui/jquery-ui.min.js'></script>
    <script src='<?= $dir; ?>packages/bootstrap/js/bootstrap.min.js'></script>
    <script src='<?= $dir; ?>calendar.js'></script>
</head>

<body>
    <!-- Top bar  -->
    <div id='top'>
        Locales:
        <select id='locale-selector' title="Locales"></select>
        <div class='timezone'>
            Timezone:
            <select id='time-zone-selector' title="Timezone">
                <option value='local' selected>Local</option>
                <option value='UTC'>UTC</option>
            </select>
        </div>
    </div>
    <!-- / .Top bar  -->

    <!-- Add Event -->
    <div class="modal fade" id="addeventmodal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="createEvent" class="form-horizontal" autocomplete="off">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Event</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6">
                                    <div id="title-group" class="form-group">
                                        <label class="control-label" for="title">Event Title</label>
                                        <input type="text" class="form-control" name="title" id="title_event" placeholder="Title Event">
                                        <!-- errors will go here -->
                                    </div>

                                    <div id="start-date-group" class="form-group">
                                        <label class="control-label" for="startDate">Start Date</label>
                                        <input type="text" class="form-control datetimepicker" id="startDate" name="startDate" placeholder="dd-mm-yyyy hh:mm:ss">
                                        <!-- errors will go here -->
                                    </div>

                                    <div id="end-date-group" class="form-group">
                                        <label class="control-label" for="endDate">End Date</label>
                                        <input type="text" class="form-control datetimepicker" id="endDate" name="endDate" placeholder="dd-mm-yyyy hh:mm:ss">
                                        <!-- errors will go here -->
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div id="color-group" class="form-group">
                                        <label class="control-label" for="color">Label Colour</label>
                                        <input type="text" class="form-control colorpicker" name="color" value="#8ebf33">
                                        <!-- errors will go here -->
                                    </div>

                                    <div id="textcolor-group" class="form-group">
                                        <label class="control-label" for="textcolor">Text Colour</label>
                                        <input type="text" class="form-control colorpicker" name="text_color" value="#ffffff">
                                        <!-- errors will go here -->
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeDate">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- Edit Event -->
    <div class="modal fade" id="editeventmodal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editEvent" class="form-horizontal">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Event</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="container-fluid">

                            <input type="hidden" id="editEventId" name="editEventId" value="">

                            <div class="row">
                                <div class="col-md-6">
                                    <div id="edit-title-group" class="form-group">
                                        <label class="control-label" for="editEventTitle">Title</label>
                                        <input type="text" class="form-control" id="editEventTitle" name="editEventTitle">
                                        <!-- errors will go here -->
                                    </div>

                                    <div id="edit-startdate-group" class="form-group">
                                        <label class="control-label" for="editStartDate">Start Date</label>
                                        <input type="text" class="form-control datetimepicker" id="editStartDate" name="editStartDate">
                                        <!-- errors will go here -->
                                    </div>

                                    <div id="edit-enddate-group" class="form-group">
                                        <label class="control-label" for="editEndDate">End Date</label>
                                        <input type="text" class="form-control datetimepicker" id="editEndDate" name="editEndDate">
                                        <!-- errors will go here -->
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div id="edit-color-group" class="form-group">
                                        <label class="control-label" for="editColor">Colour</label>
                                        <input type="text" class="form-control colorpicker" id="editColor" name="editColor" value="#6453e9">
                                        <!-- errors will go here -->
                                    </div>

                                    <div id="edit-textcolor-group" class="form-group">
                                        <label class="control-label" for="editTextColor">Text Colour</label>
                                        <input type="text" class="form-control colorpicker" id="editTextColor" name="editTextColor" value="#ffffff">
                                        <!-- errors will go here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeDateEdit">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteeventmodal" data-id>Delete</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- URL Event -->
    <div class="modal fade" id="urlevent" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">URL Actions</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="container-fluid">
                        <h3>This event contain a link to the desire conference, if you want to visit click go, if you want to edit it click edit</h3>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="gourl">Go</button>
                    <button type="button" class="btn btn-success" id="editurl" data-id>Edit</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- Delete Event -->
    <div class="modal fade" id="deleteeventmodal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Delete Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="container-fluid">
                        <h5 class="modal-title">Are you sure you want to to delete this entry?</h5>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="deleteEvent" data-id>Confirm</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- Container -->
    <div class="container">
        <div id="calendar"></div>
    </div>
    <!-- /.container -->
</body>

<!-- Load Script -->
<script>
    var eles = document.getElementsByClassName('fc-scroller'); //Search for the class contained in Header/Body of the table
    var botones = document.getElementsByClassName('fc-button'); //Search for the button classes
    window.addEventListener('load', function callendarscroll() {
        console.log("INDEX SCRIPT");
        const class_div_container = document.querySelector(".fc-view"); //Search for the main class container
        if (class_div_container.classList.contains("fc-daygrid")) { // Month View
            ch = eles[0].setAttribute("id", "ch"); /* Set the id to the Header table */
            cb = eles[1].setAttribute("id", "cb"); /* Set the id to the Body table */
            // --------
            var T1Obj = document.getElementById("ch"); /* Get the Header table id to var */
            var T2Obj = document.getElementById("cb"); /* Get the Body table id to var */
            if (typeof addEventListener != "undefined") {
                T1Obj.addEventListener('scroll', getScroll); /* Get the function on event to Header */
                T2Obj.addEventListener('scroll', getScroll); /* Get the function on event to Body */
            } else {
                T1Obj.attachEvent('onscroll', getScroll); /* Set the function on event to Header */
                T2Obj.attachEvent('onscroll', getScroll); /* Set the function on event to Body */
            }
        } else if (class_div_container.classList.contains("fc-timegrid")) { // Week and Day View
            ch = eles[0].setAttribute("id", "ch"); /* Set the id to the Header table */
            cb = eles[1].setAttribute("id", "cb"); /* Set the id to the Body table */
            // --------
            var T1Obj = document.getElementById("ch"); /* Get the Header table id to var */
            var T2Obj = document.getElementById("cb"); /* Get the Body table id to var */
            if (typeof addEventListener != "undefined") {
                T1Obj.addEventListener('scroll', getScroll); /* Get the function on event to Header */
                T2Obj.addEventListener('scroll', getScroll); /* Get the function on event to Body */
            } else {
                T1Obj.attachEvent('onscroll', getScroll); /* Set the function on event to Header */
                T2Obj.attachEvent('onscroll', getScroll); /* Set the function on event to Body */
            }
        } else {
            //CARRY ON NOTHING TO DO HERE
        }
        // --------
        b0 = botones[0].setAttribute("id", "b0"); /* Set the id to PrevYear Button */
        b1 = botones[1].setAttribute("id", "b1"); /* Set the id to PrevMonth Button */
        b2 = botones[2].setAttribute("id", "b2"); /* Set the id to NextMonth Button */
        b3 = botones[3].setAttribute("id", "b3"); /* Set the id to NextYear Button */
        b4 = botones[4].setAttribute("id", "b4"); /* Set the id to Today Button */
        b5 = botones[5].setAttribute("id", "b5"); /* Set the id to the Month button */
        b6 = botones[6].setAttribute("id", "b6"); /* Set the id to the Week button */
        b7 = botones[7].setAttribute("id", "b7"); /* Set the id to the Day button */
        b8 = botones[8].setAttribute("id", "b8"); /* Set the id to the List button */
        // --------
        document.getElementById("b5").onclick = callendarscroll; /* Set the onclick event to the Month button */
        document.getElementById("b6").onclick = callendarscroll; /* Set the onclick event to the Week button */
        document.getElementById("b7").onclick = callendarscroll; /* Set the onclick event to the Day button */
        document.getElementById("b8").onclick = callendarscroll; /* Set the onclick event to the List button */
        // -------- Function to set Scroll in both tables in User View
        function getScroll(event) {
            if (event.type === "scroll") {
                /* Get the event type */
                var elem = (event.srcElement) ? event.srcElement : event.target; /* Assign to elem the source value o event if it is the same otherwise the target of the event */
                if (elem.id === "ch") {
                    /* Get the id value of the event */
                    T2Obj.scrollLeft = elem.scrollLeft; /* If the id of the event is table Header we assign the scroll event to the Body */
                } else if (elem.id === "cb") {
                    /* Get the id value of the event */
                    T1Obj.scrollLeft = elem.scrollLeft; /* If the id of the event is table Body we assign the scroll event to the Header */
                }
            }
        }
        // --------        
        if (class_div_container.classList.contains("fc-daygrid")) { // Month View
            console.log(class_div_container);
            // --------
            document.getElementById("b0").onclick = myinterval; /* Set the onclick event to PrevYear Button */
            document.getElementById("b1").onclick = myinterval; /* Set the onclick event to PrevMonth Button */
            document.getElementById("b2").onclick = myinterval; /* Set the onclick event to NextMonth Button */
            document.getElementById("b3").onclick = myinterval; /* Set the onclick event to NextYear Button */
            document.getElementById("b4").onclick = myinterval; /* Set the onclick event to Today Button */
            // --------
            console.log("ESTA LLAMANDO INDEX HIDEURL DAYGRID|||||||||");
            var anchor_Handler = document.getElementsByClassName("fc-daygrid-event");
            setTimeout(function() {
                console.log("ESTA LLAMANDO INDEX HIDEURL DAYGRID-----ENTRA A INDEX HIDEURL|||||||||");
                for (var en = 0; en < anchor_Handler.length; en++) {
                    if (anchor_Handler[en].href != "" && anchor_Handler[en].href != null) {
                        anchor_Handler[en].setAttribute("hiddenhref", anchor_Handler[en].href);
                        anchor_Handler[en].removeAttribute("href");
                    }
                }
            }, 13);
        } else if (class_div_container.classList.contains("fc-timegrid")) { // Week and Day View
            console.log(class_div_container);
            // --------
            document.getElementById("b0").onclick = callendarscroll; /* Set the onclick event to PrevYear Button */
            document.getElementById("b1").onclick = callendarscroll; /* Set the onclick event to PrevMonth Button */
            document.getElementById("b2").onclick = callendarscroll; /* Set the onclick event to NextMonth Button */
            document.getElementById("b3").onclick = callendarscroll; /* Set the onclick event to NextYear Button */
            document.getElementById("b4").onclick = callendarscroll; /* Set the onclick event to Today Button */
            // --------
            console.log("ESTA LLAMANDO INDEX HIDEURL EVENT|||||||||");
            var anchor_Handler = document.getElementsByClassName("fc-timegrid-event");
            setTimeout(function() {
                console.log("ESTA LLAMANDO INDEX HIDEURL TIMEGRID-----ENTRA A INDEX HIDEURL|||||||||");
                for (var en = 0; en < anchor_Handler.length; en++) {
                    if (anchor_Handler[en].href != "" && anchor_Handler[en].href != null) {
                        anchor_Handler[en].setAttribute("hiddenhref", anchor_Handler[en].href);
                        anchor_Handler[en].removeAttribute("href");
                    }
                }
            }, 13);
        } else { // No View
            console.log("ESTA LLAMANDO INDEX HIDEURL EVENT|||||||||");
            let enlaces = document.getElementsByTagName('a')
            setTimeout(function() {
                for (let en = 0; en < enlaces.length; en++) {
                    if (enlaces[en].href != "") {
                        enlaces[en].setAttribute(
                            "hiddenhref",
                            enlaces[en].getAttribute("href")
                        );
                        enlaces[en].setAttribute("href", "");
                        console.log(enlaces[en]);
                    } else {
                        //CARRY ON NOTHING TO DO HERE
                    }
                }
            }, 13);
        }
    })
</script>
<!-- / .Load Script -->

<!-- Myinterval Function Script -->
<script>
    // Function to hide the URL's in the table
    function myinterval() {
        console.log("INDEX SCRIPT MY INTERVAL");
        const class_div_container = document.querySelector(".fc-view");
        console.log(class_div_container);
        if (class_div_container.classList.contains("fc-daygrid")) {
            console.log("ESTA LLAMANDO HIDEURL DAYGRID");
            var anchorclass = document.getElementsByClassName("fc-daygrid-event");
            setTimeout(function() {
                console.log("ESTA LLAMANDO HIDEURL DAYGRID-----ENTRA A INDEX HIDEURL|||||||||");
                var anchorclass = document.getElementsByClassName("fc-daygrid-event");
                for (var en = 0; en < anchorclass.length; en++) {
                    if (anchorclass[en].href != "" && anchorclass[en].href != null) {
                        anchorclass[en].setAttribute("hiddenhref", anchorclass[en].href);
                        anchorclass[en].removeAttribute("href");
                    }
                }
            }, 13);
        } else if (class_div_container.classList.contains("fc-timegrid")) {
            var anchorclass = document.getElementsByClassName("fc-timegrid-event");
            setTimeout(function() {
                console.log("ESTA LLAMANDO HIDEURL DAYGRID-----ENTRA A INDEX HIDEURL|||||||||");
                var anchorclass = document.getElementsByClassName("fc-daygrid-event");
                for (var en = 0; en < anchorclass.length; en++) {
                    if (anchorclass[en].href != "" && anchorclass[en].href != null) {
                        anchorclass[en].setAttribute("hiddenhref", anchorclass[en].href);
                        anchorclass[en].removeAttribute("href");
                    }
                }
            }, 13);
        } else {
            console.log("ESTA LLAMANDO HIDEURL LIST-----ESTA LLAMANDO HIDEURL EVENT");
            let listanchorclass = document.getElementsByClassName("fc-event-forced-url");
            setTimeout(function() {
                for (let en = 0; en < listanchorclass.length; en++) {
                    listanchorclass[en].children[2].children[0].setAttribute(
                        "hiddenhref",
                        listanchorclass[en].children[2].children[0].getAttribute("href")
                    );
                    listanchorclass[en].children[2].children[0].removeAttribute("href");
                }
            }, 13);
        }
    }
</script>
<!-- / .Myinterval Function Load Script -->
<script src='<?= $dir; ?>packages/datepicker/datepicker.js'></script>
<script src='<?= $dir; ?>packages/colorpicker/bootstrap-colorpicker.min.js'></script>
<script src='<?= $dir; ?>lib/locales-all.min.js'></script>

</html>