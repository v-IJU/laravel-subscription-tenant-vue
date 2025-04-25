@extends('layouts.master')

@section('title', 'subscription')
@section('style')


@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            DashBoard
        @endslot
        @slot('title')
            Create subscription
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">


                    @if ($layout == 'create')
                        {{ Form::open(['role' => 'form', 'route' => ['subscription.store'], 'method' => 'post', 'enctype' => 'multipart/form-data', 'class' => 'custom-validation form-horizontal form-label-left', 'id' => 'user-form', 'novalidate' => 'novalidate']) }}
                    @elseif($layout == 'edit')
                        {{ Form::open(['role' => 'form', 'route' => ['subscription.update', $data->id], 'method' => 'put', 'enctype' => 'multipart/form-data', 'class' => 'custom-validation form-horizontal form-label-left', 'id' => 'user-form', 'novalidate' => 'novalidate']) }}
                    @endif
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="mb-3">
                                    <label>Price</label>
                                    <input type="number" name="price" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="mb-3">
                                    <label>Currency</label>
                                    <input type="text" name="currency" class="form-control" value="inr" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Frequency</label>
                                <select name="frequency" class="form-control">
                                    <option value="1">Monthly</option>
                                    <option value="2">Yearly</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Trail Period (Days)</label>
                                <input type="number" name="trail_period" class="form-control" value="7" required>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <label>Features</label>
                        @foreach ($modules as $module)
                            <div class="col-md-2 mb-2">
                                <input type="checkbox" name="features[]" value="{{ $module->id }}">
                                {{ $module->name }}
                            </div>
                        @endforeach

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
