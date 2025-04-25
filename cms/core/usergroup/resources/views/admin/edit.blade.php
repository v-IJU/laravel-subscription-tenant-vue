@extends('layouts.master')

@section('title', 'user group')
@section('style')


@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            DashBoard
        @endslot
        @slot('title')
            {{ $layout == 'create' ? 'Create' : 'Edit' }} Group
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    @if ($layout == 'create')
                        {{ Form::open(['role' => 'form', 'route' => ['usergroup.store'], 'method' => 'post', 'enctype' => 'multipart/form-data', 'class' => 'custom-validation form-horizontal form-label-left', 'id' => 'user-form']) }}
                    @elseif($layout == 'edit')
                        {{ Form::open(['role' => 'form', 'route' => ['usergroup.update', $data->id], 'method' => 'put', 'enctype' => 'multipart/form-data', 'class' => 'custom-validation form-horizontal form-label-left', 'id' => 'user-form']) }}
                    @endif
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Group Name <span class="required text-danger">*</span></label>
                                <div>
                                    {{ Form::text('group', @$data->group, [
                                        'id' => 'group',
                                        'class' => 'form-control col-md-7 col-xs-12',
                                        'placeholder' => 'Group Name',
                                        'required' => 'required',
                                    ]) }}
                                </div>
                            </div>
                        </div>

                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary w-md">Submit</button>
                        <a href="{{ route('usergroup.index') }}" class="btn btn-light w-md">Back</a>
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
