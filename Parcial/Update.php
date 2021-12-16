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
    <!-- /.Edit Event modal -->