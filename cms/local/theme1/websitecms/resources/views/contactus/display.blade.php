@extends('layouts.master')

@section('title') @lang('translation.Blog_Details') @endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') Contact us @endslot
@slot('title') Form Details @endslot
@endcomponent

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="pt-3">
                    <div class="row justify-content-center">
                         <div class="d-flex justify-content-end">
                            <div class="flex-shrink-0">
                                <a href="{{ route("contactus.index") }}" class="btn btn-info waves-effect waves-light">Back</a>
                            </div>
                        </div>
                        <div class="col-xl-8">
                            <div>
                                <div class="text-center">
                                    <p class="text-muted mb-2">Subject: </p>
                                    <h4>{{ $data->subject }}</h4>
                                    <p class="text-muted mb-4"><i class="mdi mdi-calendar me-1"></i> {{ \Carbon\Carbon::parse($data->created_at)->format('d F Y') }}</p>
                                </div>

                                <hr>
                                <div class="text-center">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="mt-4 mt-sm-0">
                                                <p class="text-muted mb-2">Name</p>
                                                <h5 class="font-size-15">{{ $data->first_name ." ". $data->last_name }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="mt-4 mt-sm-0">
                                                <p class="text-muted mb-2">Email ID</p>
                                                <h5 class="font-size-15">{{ $data->email }} </h5>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="mt-4 mt-sm-0">
                                                <p class="text-muted mb-2">Mobile Number</p>
                                                <h5 class="font-size-15"> {{ $data->phone }} </h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>

                                <div class="mt-4">
                                    <div class="text-muted font-size-14">

                                        <blockquote class="p-4 border-light border rounded mb-4">
                                            <div class="d-flex">
                                                <div>
                                                    <p class="mb-0"> {{ $data->description }}</p>
                                                </div>
                                            </div>

                                        </blockquote>

                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
    </div>
    <!-- end col -->
</div>
<!-- end row -->

@endsection
