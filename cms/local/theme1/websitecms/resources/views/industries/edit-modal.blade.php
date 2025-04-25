<div id="edit_service_modal" class="modal fade popup-modal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Edit Industry</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{ Form::open(['id' => 'editIndustriesForm','enctype' => 'multipart/form-data']) }}
                <div class="modal-body">

                    <div class="row">
                        <div class="form-group col-sm-12 mb-5">
                            <input type="hidden" name="edit_industry_id" id="edit_industry_id" />
                            {{ Form::label('service_name', __('Industry Name') . ':', ['class' => 'form-label']) }}
                            <span class="required"></span>
                            {{ Form::text('industry_name', null, ['class' => 'form-control', 'required', 'id' => 'edit_industry_name']) }}
                        </div>
                        <div class="form-group col-sm-12 mb-5">
                            {{ Form::label('description', __('Description') . ':', ['class' => 'form-label']) }}
                            {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => '5', 'id' => 'edit_industry_description']) }}
                        </div>
                        <div class="form-group col-sm-12 mb-5">
                            <div>
                                {{ Form::label('image', __('Image') . ':', ['class' => 'form-label']) }}
                                <input type="file" name="image" class="form-control" />
                                <img src="" id="edit_industry_image"
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
