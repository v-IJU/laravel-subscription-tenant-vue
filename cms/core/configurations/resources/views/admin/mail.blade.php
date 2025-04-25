@extends('layouts.master')

@section('title', 'Mail Configuration')
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
            Mail Configurations
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">


                    {{ Form::open(['role' => 'form', 'route' => ['admin_mail_configuration_save'], 'autocomplete' => 'false', 'method' => 'post', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal form-label-left', 'id' => 'module-form', 'novalidate' => 'novalidate']) }}


                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">From Mail <span
                                        class="required">*</span>
                                </label>
                                {{ Form::text('from_mail', @$data->from_mail, [
                                    'id' => 'name',
                                    'class' => 'form-control col-md-7 col-xs-12',
                                    'data-validate-length-range' => '6',
                                    'placeholder' => 'From Mail ',
                                    'required' => 'required',
                                ]) }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Mailer <span
                                        class="required">*</span>
                                </label>
                                {{ Form::select('from_mailer', $mailer, @$data->from_mailer, [
                                    'id' => 'name',
                                    'class' => 'form-control col-md-7 col-xs-12',
                                    'data-validate-length-range' => '6',
                                    'required' => 'required',
                                ]) }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">From Mail Password
                                    <span class="required">*</span>
                                </label>
                                <input type="password" style="display:none;">
                                {{ Form::password('from_mail_password', [
                                    'id' => 'from_mail_password',
                                    'class' => 'form-control col-md-7 col-xs-12',
                                    'data-validate-length-range' => '6',
                                    'placeholder' => 'From Mail Password',
                                    'autocomplete' => 'off',
                                ]) }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">From Mail Name <span
                                        class="required">*</span>
                                </label>
                                {{ Form::text('from_mail_name', @$data->from_mail_name, [
                                    'id' => 'from_mail_name',
                                    'class' => 'form-control col-md-7 col-xs-12',
                                    'data-validate-length-range' => '6',
                                    'placeholder' => 'From Mail Name',
                                    'required' => 'required',
                                ]) }}
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
