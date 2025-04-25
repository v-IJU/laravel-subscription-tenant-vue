<div id="add_feedback_modal" class="modal fade popup-modal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Add New Feedback</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{ Form::open(['id' => 'addFeedbackForm', 'enctype' => 'multipart/form-data']) }}
            <div class="modal-body">

                <div class="row">
                    <div class="form-group col-sm-12 mb-3">
                        {{ Form::label('name', __('Customer Name') . ':', ['class' => 'form-label']) }}
                        <span class="required"></span>
                        {{ Form::text('name', null, ['class' => 'form-control', 'required']) }}
                    </div>
                     <div class="form-group col-sm-12 mb-3">
                        {{ Form::label('name', __('Designation') . ':', ['class' => 'form-label']) }}
                        <span class="required"></span>
                        {{ Form::text('designation', null, ['class' => 'form-control', 'required']) }}
                    </div>
                    <div class="form-group col-sm-12 mb-3">
                        {{ Form::label('messsage', __('Message') . ':', ['class' => 'form-label']) }}
                        {{ Form::textarea('message', null, ['class' => 'form-control', 'rows' => '5']) }}
                    </div>
                    <div class="form-group col-sm-12 mb-3">
                        <div>
                            {{ Form::label('pimage', __('Image') . ':', ['class' => 'form-label']) }}
                            <span class="required"></span>
                            <input type="file" name="pimage" class="form-control" />
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>

                <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
            </div>
            {{ Form::close() }}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
