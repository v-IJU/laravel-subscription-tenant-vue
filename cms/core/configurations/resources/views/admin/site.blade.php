@extends('layouts.master')

@section('title', 'site configuration')
@section('style')
    {!! Cms::style('theme/vendors/switchery/dist/switchery.min.css') !!}
    {!! Cms::style('theme/vendors/select2/select2.css') !!}
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            DashBoard
        @endslot
        @slot('title')
            Site Configurations
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">

                    {{ Form::open(['role' => 'form', 'route' => ['admin_site_configuration_save'], 'method' => 'post', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal form-label-left', 'id' => 'module-form', 'novalidate' => 'novalidate']) }}

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" for="name">Site Name <span
                                        class="required"></span>
                                </label>
                                {{ Form::text('site_name', @$data->site_name, [
                                    'id' => 'site_name',
                                    'class' => 'form-control col-md-7 col-xs-12',
                                    'data-validate-length-range' => '6',
                                    'placeholder' => 'site name ',
                                    'required' => 'required',
                                ]) }}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="control-label col-md-6 col-sm-3 col-xs-12" for="contact_phone">Contact Number <span
                                        class="required"></span>
                                </label>
                                {{ Form::text('contact_no', @$data->contact_no, [
                                    'id' => 'contact_no',
                                    'class' => 'form-control col-md-7 col-xs-12',
                                    'data-validate-length-range' => '6',
                                    'placeholder' => 'contact number ',
                                    'required' => 'required',
                                ]) }}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="control-label col-md-6 col-sm-3 col-xs-12" for="name">Contact Email <span
                                        class="required"></span>
                                </label>
                                {{ Form::text('contact_email', @$data->contact_email, [
                                    'id' => 'contact_email',
                                    'class' => 'form-control col-md-7 col-xs-12',
                                    'data-validate-length-range' => '6',
                                    'placeholder' => 'contact email ',
                                    'required' => 'required',
                                ]) }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" for="name">Time Zone <span
                                        class="required"></span>
                                </label>
                                {{ Form::select('selected_timezone', @$timezone, @$data->selected_timezone ?? 'Asia/Kolkata', [
                                    'id' => 'selected-timezone',
                                    'class' => 'form-control col-md-7 col-xs-12',
                                    'required' => 'required',
                                    'placeholder' => 'Select'
                                ]) }}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="control-label col-md-6 col-sm-3 col-xs-12" for="name">Currency Symbol
                                    <span class="required"></span>
                                </label>
                                {{ Form::select('selected_currency', @$currency, @$data->selected_currency, [
                                    'id' => 'site-currency',
                                    'class' => 'select2 form-control',
                                    'required' => 'required',
                                    'placeholder' => 'Select'
                                ]) }}
                            </div>
                        </div>

                        <div class="col-md-4">                             
                            <div class="mb-3">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" for="name">Address 1<span class="required"></span>
                                </label>
                                {{ Form::text('address1', @$data->address1, [
                                'id' => 'address1',
                                'class' => 'form-control col-md-7 col-xs-12',
                                'data-validate-length-range' => '6',
                                'placeholder' => 'Address 1 ',
                                'required' => 'required',
                            ]) }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" for="name">Address 2<span class="required"></span>
                                </label>
                                {{ Form::text('address2', @$data->address2, [
                                'id' => 'address2',
                                'class' => 'form-control col-md-7 col-xs-12',
                                'data-validate-length-range' => '6',
                                'placeholder' => 'Address 2 ',                                
                            ]) }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">City </label><span class="required"></span>
                                <div>
                                    {{ Form::text('city', @$data->city, [
                                        'id' => 'city',
                                        'class' => 'form-control col-md-7 col-xs-12',
                                        'data-validate-length-range' => '20',
                                        'placeholder' => 'City',
                                        'required' => 'required',
                                    ]) }}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Zipcode </label><span class="required"></span>
                                <div>
                                    {{ Form::text('zip', @$data->zip, [
                                        'id' => 'zip',
                                        'class' => 'form-control col-md-7 col-xs-12',
                                        'data-validate-length-range' => '20',
                                        'placeholder' => 'Zip code',
                                        'required' => 'required',
                                    ]) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">GST Tin No </label><span class="required"></span>
                                <div>
                                    {{ Form::text('tin', @$data->tin, [
                                        'id' => 'tin',
                                        'class' => 'form-control col-md-7 col-xs-12',
                                        'data-validate-length-range' => '20',
                                        'placeholder' => 'GST Tin number',
                                        'required' => 'required',
                                    ]) }}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Site Logo</label>
                                <div>
                                    <input type="file" name="site_logo" class="form-control" />
                                    <input type="hidden" name="old_site_image" value="{{ @$data->site_logo }}" />
                                    @if (@$data->site_logo)
                                        <img src="{{ @$data->site_logo }}" width="100px" />
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Site Icon</label>
                                <div>
                                    <input type="file" name="site_icon" class="form-control" />
                                    <input type="hidden" name="old_site_icon" value="{{ @$data->site_icon }}" />
                                    @if (@$data->site_icon)
                                        <img src="{{ @$data->site_icon }}" width="100px" />
                                    @endif

                                </div>
                            </div>
                        </div>


                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary w-md">Submit</button>
                    </div>

                </div>








                {{ Form::close() }}

            </div>
        </div>
    </div>


    </div>
@endsection


@section('script')
    <script src="{{ URL::asset('build/libs/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>

@endsection
