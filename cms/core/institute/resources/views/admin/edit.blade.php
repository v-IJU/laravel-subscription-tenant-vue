@extends('layouts.master')

@section('title', 'institute')
@section('style')


@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            DashBoard
        @endslot
        @slot('title')
            Create institute
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">


                    @if ($layout == 'create')
                        {{ Form::open(['role' => 'form', 'route' => ['institute.store'], 'method' => 'post', 'enctype' => 'multipart/form-data', 'class' => 'custom-validation form-horizontal form-label-left', 'id' => 'user-form', 'novalidate' => 'novalidate']) }}
                    @elseif($layout == 'edit')
                        {{ Form::open(['role' => 'form', 'route' => ['institute.update', $data->id], 'method' => 'put', 'enctype' => 'multipart/form-data', 'class' => 'custom-validation form-horizontal form-label-left', 'id' => 'user-form', 'novalidate' => 'novalidate']) }}
                    @endif
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Institute Name</label>
                                <input type="text" name="institute_name" class="form-control" required>
                            </div>
                        </div>






                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Subscription Plan</label>
                                <select name="subscription_plan_id" class="form-control">
                                    @foreach ($plans as $plan)
                                        <option value="{{ $plan->id }}">{{ $plan->name }} - ${{ $plan->price }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary w-md mt-3">Submit</button>
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
