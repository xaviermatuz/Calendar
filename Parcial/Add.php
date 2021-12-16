    <!-- Add Event -->
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
    <!-- /.Add Event modal -->