<div id="edit_aboutusshop_modal" class="modal fade popup-modal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{ Form::open(['id' => 'editaboutusshopForm','method' => 'POST','enctype' => 'multipart/form-data']) }}

                <div class="modal-body">

                    <div class="row">
                        <div class="form-group col-sm-12 mb-2">
                            <input type="hidden" name="edit_aboutusshop_id" id="edit_aboutusshop_id" />
                            {{ Form::label('edit_category', __('Category') . ':', ['class' => 'form-label']) }}
                            <span class="required"></span>
                            {{ Form::text('edit_category', null, ['class' => 'form-control', 'required', 'id' => 'edit_category']) }}
                        </div>
                         <div class="form-group col-sm-12 mb-2">
                            {{ Form::label('edit_title', __('Title') . ':', ['class' => 'form-label']) }}
                            {{ Form::text('edit_title', null, ['class' => 'form-control', 'required', 'id' => 'edit_title']) }}
                        </div>
                        <div class="form-group col-sm-12 mb-2">
                            {{ Form::label('edit_description', __('Description') . ':', ['class' => 'form-label']) }}
                            {{ Form::textarea('edit_description', null, ['class' => 'form-control', 'rows' => '3', 'id' => 'edit_description']) }}
                        </div>
                        <div class="form-group col-sm-12 mb-2">
                            <div>
                                {{ Form::label('pimage', __('Image') . ':', ['class' => 'form-label']) }}
                                <input type="file" name="pimage" class="form-control" />
                                <img src="" id="edit_image"
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
