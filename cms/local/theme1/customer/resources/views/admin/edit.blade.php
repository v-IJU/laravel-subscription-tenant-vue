@extends('layouts.master')

@section('title','customer')
@section('style')


@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            DashBoard
        @endslot
        @slot('title')
            Create customer
        @endslot
    @endcomponent
  <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">


                    @if ($layout == 'create')
                        {{ Form::open(['role' => 'form', 'route' => ['customer.store'], 'method' => 'post', 'enctype' => 'multipart/form-data', 'class' => 'custom-validation form-horizontal form-label-left', 'id' => 'user-form', 'novalidate' => 'novalidate']) }}
                    @elseif($layout == 'edit')
                        {{ Form::open(['role' => 'form', 'route' => ['customer.update', $data->id], 'method' => 'put', 'enctype' => 'multipart/form-data', 'class' => 'custom-validation form-horizontal form-label-left', 'id' => 'user-form', 'novalidate' => 'novalidate']) }}
                    @endif
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">User group</label>
                                {{ Form::select('group', [], @$data->group[0]->id, [
                                    'id' => 'status',
                                    'class' => 'select2 form-control',
                                    'required' => 'required',
                                ]) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <div>
                                    {{ Form::text('name', @$data->name, [
                                        'id' => 'name',
                                        'class' => 'form-control col-md-7 col-xs-12',
                                        'data-validate-length-range' => '6',
                                        'placeholder' => 'both name(s) e.g Jon Doe',
                                        'required' => 'required',
                                    ]) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">User Name</label>
                                <div>
                                    {{ Form::text('username', @$data->username, [
                                        'id' => 'username',
                                        'class' => 'form-control col-md-7 col-xs-12',
                                        'data-validate-length-range' => '6',
                                        'placeholder' => 'User name',
                                        'required' => 'required',
                                    ]) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <div>
                                    {{ Form::email('email', @$data->email, [
                                        'id' => 'email',
                                        'class' => 'form-control col-md-7 col-xs-12',
                                        'placeholder' => 'Email',
                                        'required' => 'required',
                                    ]) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Mobile</label>
                                <div>
                                    {{ Form::number('mobile', @$data->mobile, [
                                        'id' => 'number',
                                        'class' => 'form-control col-md-7 col-xs-12',
                                        'data-validate-length' => '9,15',
                                        'placeholder' => 'Mobile Number',
                                        'required' => 'required',
                                    ]) }}
                                </div>
                            </div>
                        </div>
                       
                       
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Image</label>
                                <div>
                                    <input type="file" name="imagec" class="form-control" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary w-md">Submit</button>
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
