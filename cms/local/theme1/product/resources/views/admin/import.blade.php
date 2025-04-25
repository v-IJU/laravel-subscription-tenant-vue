@extends('layouts.master')

@section('title', 'Product Import')
@section('style')
    <!-- Datatables -->
    @include('layout::admin.head.list_head')
    <style>
        .table-div table {
            width: 100% !important;
        }
    </style>
@endsection
@section('content')

    @component('components.breadcrumb')
        @slot('li_1')
            Dashboard
        @endslot
        @slot('title')
            Product Import
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">



                    <div class="d-flex flex-column">
                        <div class="card_">
                            {{ Form::open(['route' => 'product.import', 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">School Name:</label><span class="required"></span>
                                            <div>
                                                {{ Form::select('school_name', $schoolNames, @$data->school_id ?? null, [
                                                    'id' => 'school-dropdown',
                                                    'data-class-id' => 'school_class',
                                                    'class' => 'school_select select2 form-control',
                                                    'required' => 'required',
                                                    'placeholder' => 'Select school',
                                                ]) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <div class="mb-3">
                                                <label class="form-label required">School Classes:</label>
                                                <div>
                                                    {{ Form::select('school_class[]', [], @$data->class_id ?? null, [
                                                        'id' => 'class-dropdown',
                                                        'class' => 'select2 form-control',
                                                        'multiple',
                                                        'required' => 'required',
                                                    ]) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <p class="card-text text-danger panel_alert"><i class="fas fa-arrow-right "></i> Read
                                    all
                                    Instructions Carefully </p>
                                <p class="card-text text-danger panel_alert"><i class="fas fa-arrow-right "></i>product
                                    Images upload through filemanager <a target="_blank"
                                        href="{{ route('product.filemanager') }}">File
                                        Manager</a> </p>
                                <p class="card-text text-danger panel_alert"><i class="fas fa-arrow-right"></i>
                                    Sample CSV
                                    file <a href="{{ asset('excel/products.csv') }}" download>Download</a>
                                </p>
                                <p class="card-text text-danger panel_alert"><i class="fas fa-arrow-right"></i>Download the
                                    sample CSV File and fill product Information
                                </p>
                                <p class="card-text text-danger panel_alert"><i class="fas fa-arrow-right"></i>In the Sample
                                    Downloaded Excel there is row size_category give exists category names before product
                                    import please setup all sizecategory before product import
                                </p>
                                <p class="card-text text-danger panel_alert"><i class="fas fa-arrow-right"></i>
                                    Don't Change
                                    or add new header values in dowloaded CSV File </p>


                                <p class="card-text text-danger panel_alert"><i class="fas fa-arrow-right"></i>
                                    Gender : (Male,Female,Any) </p>

                                <div class="item form-group">
                                    <label class="control-label margin__bottom" for="school_name">{{ __('Choose File') }}
                                        <span class="required"></span>
                                    </label>
                                    <div class="feild">
                                        <input type="file" required class="form-control" name="upload_file"
                                            accept=".csv" />
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mt-5">
                                    {{ Form::submit(__('Submit'), ['class' => 'btn btn-primary']) }}
                                    <a href="{{ route('product.index') }}"
                                        class="btn btn-secondary ms-2">{{ __('Cancel') }}</a>
                                </div>

                            </div>

                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->


@endsection

<script type="text/javascript">
    window.filterclasslist = "{{ route('parent.filterclasslist') }}"
</script>
