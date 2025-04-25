<div id="edit_associator_modal" class="modal fade popup-modal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Edit Associator</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{ Form::open(['id' => 'editAssociatorForm','method' => 'POST','enctype' => 'multipart/form-data']) }}

                <div class="modal-body">

                    <div class="row">
                        <div class="form-group col-sm-12 mb-2">
                            <input type="hidden" name="edit_associator_id" id="edit_associator_id" />
                        </div>
                        <div class="form-group col-sm-12 mb-2">
                            <div>
                                {{ Form::label('pimage', __('Image') . ':', ['class' => 'form-label']) }}
                                <input type="file" name="pimage" class="form-control" />
                                <img src="" id="edit_associator_image"
                                width="100px" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>

                    <button type="submit" class="btn btn-primary waves-effect waves-light">Update</button>
                </div>
            {{ Form::close() }}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
