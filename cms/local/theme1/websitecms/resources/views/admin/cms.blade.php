@extends('layouts.master')

@section('title', 'websitecms')
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
            Website Cms
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-12">


            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#home1" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">Home</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#aboutus1" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block">About Us</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#services1" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                    <span class="d-none d-sm-block">Services</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#industires1" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">Industries</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#associator1" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">Associator</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#feedback1" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">Feed Back</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#contactus1" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">Contact Us</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#contactinfo1" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">Contact Info</span>
                                </a>
                            </li>

                        </ul>

                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="home1" role="tabpanel">
                                <div class="col-sm-12">
                                    {{ Form::open(['role' => 'form', 'route' => ['websitecms.update', 1], 'method' => 'put', 'enctype' => 'multipart/form-data', 'class' => 'custom-validation form-horizontal form-label-left', 'id' => 'user-form', 'novalidate' => 'novalidate']) }}

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Home Page Title</label>
                                                {{ Form::text('home_page_title', @$frontSettings['home_page_title'], [
                                                    'id' => 'home_page_title',
                                                    'class' => 'form-control col-md-7 col-xs-12',
                                                    'placeholder' => 'both name(s)',
                                                    'required' => 'required',
                                                ]) }}
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Image</label>
                                                <div>
                                                    <input type="file" name="home_page_image" class="form-control" />

                                                    <img src="{{ asset(@$frontSettings['home_page_image']) }}"
                                                        width="100px" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Home Page Description</label>
                                                {{ Form::textarea('home_page_description', @$frontSettings['home_page_description'], [
                                                    'class' => 'form-control col-md-7 col-xs-12',
                                                    'rows' => 3,
                                                    'name' => 'home_page_description',
                                                    'id' => 'home_page_description',
                                                ]) }}


                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <button type="submit" class="btn btn-primary w-md">Save Home Page</button>
                                    </div>
                                    {{ Form::close() }}
                                </div>
                            </div>
                            <div class="tab-pane" id="aboutus1" role="tabpanel">
                                <div class="col-sm-12">
                                    {{ Form::open(['role' => 'form', 'route' => ['websitecms.update', 2], 'method' => 'put', 'enctype' => 'multipart/form-data', 'class' => 'custom-validation form-horizontal form-label-left', 'id' => 'user-form', 'novalidate' => 'novalidate']) }}

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">About Us Banner Title</label>
                                                {{ Form::text('about_us_banner_title', @$frontSettings['about_us_banner_title'], [
                                                    'id' => 'about_us_banner_title',
                                                    'class' => 'form-control col-md-7 col-xs-12',
                                                    'placeholder' => 'both name(s)',
                                                    'required' => 'required',
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">About Us Banner Description</label>
                                                {{ Form::textarea('about_us_banner_description', @$frontSettings['about_us_banner_description'], [
                                                    'class' => 'form-control col-md-7 col-xs-12',
                                                    'rows' => 3,
                                                    'name' => 'about_us_banner_description',
                                                    'id' => 'about_us_banner_description',
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Banner Image</label>
                                                <div>
                                                    <input type="file" name="about_us_banner_image"
                                                        class="form-control" />

                                                    <img src="{{ asset(@$frontSettings['about_us_banner_image']) }}"
                                                        width="100px" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">About us</label>
                                                {{ Form::text('about_us', @$frontSettings['about_us'], [
                                                    'id' => 'about_us',
                                                    'class' => 'form-control col-md-7 col-xs-12',
                                                    'placeholder' => 'both name(s)',
                                                    'required' => 'required',
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">About Us Title</label>
                                                {{ Form::text('about_us_title', @$frontSettings['about_us_title'], [
                                                    'id' => 'about_us_title',
                                                    'class' => 'form-control col-md-7 col-xs-12',
                                                    'placeholder' => 'both name(s)',
                                                    'required' => 'required',
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Section 1 Title</label>
                                                {{ Form::text('about_us_section1_title', @$frontSettings['about_us_section1_title'], [
                                                    'id' => 'about_us_section1_title',
                                                    'class' => 'form-control col-md-7 col-xs-12',
                                                    'placeholder' => 'both name(s)',
                                                    'required' => 'required',
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Section 1 Description</label>
                                                {{ Form::textarea('about_us_section1_description', @$frontSettings['about_us_section1_description'], [
                                                    'class' => 'form-control col-md-7 col-xs-12',
                                                    'rows' => 3,
                                                    'name' => 'about_us_section1_description',
                                                    'id' => 'about_us_section1_description',
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Section 1 Image</label>
                                                <div>
                                                    <input type="file" name="about_us_section1_image"
                                                        class="form-control" />

                                                    <img src="{{ asset(@$frontSettings['about_us_section1_image']) }}"
                                                        width="100px" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Section 2 Title</label>
                                                {{ Form::text('about_us_section2_title', @$frontSettings['about_us_section2_title'], [
                                                    'id' => 'about_us_section2_title',
                                                    'class' => 'form-control col-md-7 col-xs-12',
                                                    'placeholder' => 'both name(s)',
                                                    'required' => 'required',
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Section 2 Description</label>
                                                {{ Form::textarea('about_us_section2_description', @$frontSettings['about_us_section2_description'], [
                                                    'class' => 'form-control col-md-7 col-xs-12',
                                                    'rows' => 3,
                                                    'name' => 'about_us_section2_description',
                                                    'id' => 'about_us_section2_description',
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Section 2 Image</label>
                                                <div>
                                                    <input type="file" name="about_us_section2_image"
                                                        class="form-control" />

                                                    <img src="{{ asset(@$frontSettings['about_us_section2_image']) }}"
                                                        width="100px" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Section 3 </label>
                                                {{ Form::text('about_us_section3', @$frontSettings['about_us_section3'], [
                                                    'id' => 'about_us_section3',
                                                    'class' => 'form-control col-md-7 col-xs-12',
                                                    'placeholder' => 'both name(s)',
                                                    'required' => 'required',
                                                ]) }}
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Section 3 Title</label>
                                                {{ Form::text('about_us_section3_title', @$frontSettings['about_us_section3_title'], [
                                                    'id' => 'about_us_section3_title',
                                                    'class' => 'form-control col-md-7 col-xs-12',
                                                    'placeholder' => 'both name(s)',
                                                    'required' => 'required',
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Section 3 Description</label>
                                                {{ Form::textarea('about_us_section3_description', @$frontSettings['about_us_section3_description'], [
                                                    'class' => 'form-control col-md-7 col-xs-12',
                                                    'rows' => 3,
                                                    'id' => 'about_us_section3_description',
                                                ]) }}
                                            </div>
                                        </div>



                                    </div>

                                    <div>
                                        <button type="submit" class="btn btn-primary w-md">Save About Us Page</button>
                                    </div>
                                    {{ Form::close() }}
                                </div>
                            </div>
                            <div class="tab-pane" id="services1" role="tabpanel">
                                {{ Form::open(['role' => 'form', 'route' => ['websitecms.update', 3], 'method' => 'put', 'enctype' => 'multipart/form-data', 'class' => 'custom-validation form-horizontal form-label-left', 'id' => 'user-form', 'novalidate' => 'novalidate']) }}
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Services Banner Title</label>
                                                {{ Form::text('services_banner_title', @$frontSettings['services_banner_title'], [
                                                    'id' => 'services_banner_title',
                                                    'class' => 'form-control col-md-7 col-xs-12',
                                                    'placeholder' => 'both name(s)',
                                                    'required' => 'required',
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Services Banner Description</label>
                                                {{ Form::textarea('services_banner_description', @$frontSettings['services_banner_description'], [
                                                    'class' => 'form-control col-md-7 col-xs-12',
                                                    'rows' => 3,
                                                    'name' => 'services_banner_description',
                                                    'id' => 'services_banner_description',
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Banner Image</label>
                                                <div>
                                                    <input type="file" name="services_banner_image"
                                                        class="form-control" />

                                                    <img src="{{ asset(@$frontSettings['services_banner_image']) }}"
                                                        width="100px" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Services</label>
                                                {{ Form::text('services', @$frontSettings['services'], [
                                                    'id' => 'services',
                                                    'class' => 'form-control col-md-7 col-xs-12',
                                                    'placeholder' => 'both name(s)',
                                                    'required' => 'required',
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Services Title</label>
                                                {{ Form::text('services_title', @$frontSettings['services_title'], [
                                                    'id' => 'services_title',
                                                    'class' => 'form-control col-md-7 col-xs-12',
                                                    'placeholder' => 'both name(s)',
                                                    'required' => 'required',
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Services Description</label>
                                                {{ Form::textarea('services_description', @$frontSettings['services_description'], [
                                                    'class' => 'form-control col-md-7 col-xs-12',
                                                    'rows' => 3,
                                                    'name' => 'services_description',
                                                    'id' => 'services_description',
                                                ]) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-primary w-md">Save Services Page</button>
                                    </div>
                               {{ Form::close() }}
                            </div>
                            <div class="tab-pane" id="industires1" role="tabpanel">
                                {{ Form::open(['role' => 'form', 'route' => ['websitecms.update', 4], 'method' => 'put', 'enctype' => 'multipart/form-data', 'class' => 'custom-validation form-horizontal form-label-left', 'id' => 'user-form', 'novalidate' => 'novalidate']) }}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Industries</label>
                                                {{ Form::text('industries', @$frontSettings['industries'], [
                                                    'id' => 'industries',
                                                    'class' => 'form-control col-md-7 col-xs-12',
                                                    'placeholder' => 'both name(s)',
                                                    'required' => 'required',
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Industries Title</label>
                                                {{ Form::text('industries_title', @$frontSettings['industries_title'], [
                                                    'id' => 'industries_title',
                                                    'class' => 'form-control col-md-7 col-xs-12',
                                                    'placeholder' => 'both name(s)',
                                                    'required' => 'required',
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Industries Description</label>
                                                {{ Form::textarea('industries_description', @$frontSettings['industries_description'], [
                                                    'class' => 'form-control col-md-7 col-xs-12',
                                                    'rows' => 3,
                                                    'name' => 'industries_description',
                                                    'id' => 'industries_description',
                                                ]) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-primary w-md">Save Industries Page</button>
                                    </div>
                                {{ Form::close() }}
                            </div>
                            <div class="tab-pane" id="associator1" role="tabpanel">
                                {{ Form::open(['role' => 'form', 'route' => ['websitecms.update', 5], 'method' => 'put', 'enctype' => 'multipart/form-data', 'class' => 'custom-validation form-horizontal form-label-left', 'id' => 'user-form', 'novalidate' => 'novalidate']) }}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Associator</label>
                                                {{ Form::text('associator', @$frontSettings['associator'], [
                                                    'id' => 'associator',
                                                    'class' => 'form-control col-md-7 col-xs-12',
                                                    'placeholder' => 'both name(s)',
                                                    'required' => 'required',
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Associator Title</label>
                                                {{ Form::text('associator_title', @$frontSettings['associator_title'], [
                                                    'id' => 'associator_title',
                                                    'class' => 'form-control col-md-7 col-xs-12',
                                                    'placeholder' => 'both name(s)',
                                                    'required' => 'required',
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Associator Description</label>
                                                {{ Form::textarea('associator_description', @$frontSettings['associator_description'], [
                                                    'class' => 'form-control col-md-7 col-xs-12',
                                                    'rows' => 3,
                                                    'name' => 'associator_description',
                                                    'id' => 'associator_description',
                                                ]) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-primary w-md">Save Associator Page</button>
                                    </div>
                                {{ Form::close() }}
                            </div>
                            <div class="tab-pane" id="feedback1" role="tabpanel">
                                {{ Form::open(['role' => 'form', 'route' => ['websitecms.update', 6], 'method' => 'put', 'enctype' => 'multipart/form-data', 'class' => 'custom-validation form-horizontal form-label-left', 'id' => 'user-form', 'novalidate' => 'novalidate']) }}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Feedback</label>
                                                {{ Form::text('feedback', @$frontSettings['feedback'], [
                                                    'id' => 'feedback',
                                                    'class' => 'form-control col-md-7 col-xs-12',
                                                    'placeholder' => 'both name(s)',
                                                    'required' => 'required',
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Feedback Title</label>
                                                {{ Form::text('feedback_title', @$frontSettings['feedback_title'], [
                                                    'id' => 'feedback_title',
                                                    'class' => 'form-control col-md-7 col-xs-12',
                                                    'placeholder' => 'both name(s)',
                                                    'required' => 'required',
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Feedback Description</label>
                                                {{ Form::textarea('feedback_description', @$frontSettings['feedback_description'], [
                                                    'class' => 'form-control col-md-7 col-xs-12',
                                                    'rows' => 3,
                                                    'name' => 'feedback_description',
                                                    'id' => 'feedback_description',
                                                ]) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-primary w-md">Save Feedback Page</button>
                                    </div>
                                {{ Form::close() }}
                            </div>
                            <div class="tab-pane" id="contactus1" role="tabpanel">
                                {{ Form::open(['role' => 'form', 'route' => ['websitecms.update', 7], 'method' => 'put', 'enctype' => 'multipart/form-data', 'class' => 'custom-validation form-horizontal form-label-left', 'id' => 'user-form', 'novalidate' => 'novalidate']) }}
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Contact us Banner Title</label>
                                                {{ Form::text('contactus_banner_title', @$frontSettings['contactus_banner_title'], [
                                                    'id' => 'contactus_banner_title',
                                                    'class' => 'form-control col-md-7 col-xs-12',
                                                    'placeholder' => 'enter title',
                                                    'required' => 'required',
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Contact us Banner Description</label>
                                                {{ Form::textarea('contactus_banner_description', @$frontSettings['contactus_banner_description'], [
                                                    'class' => 'form-control col-md-7 col-xs-12',
                                                    'rows' => 3,
                                                    'name' => 'contactus_banner_description',
                                                    'id' => 'contactus_banner_description',
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Contact us Banner Image</label>
                                                <div>
                                                    <input type="file" name="contactus_banner_image"
                                                        class="form-control" />

                                                    <img src="{{ asset(@$frontSettings['contactus_banner_image']) }}"
                                                        width="100px" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Section 1 Title</label>
                                                    {{ Form::text('contactus_section1_title', @$frontSettings['contactus_section1_title'], [
                                                        'id' => 'contactus_section1_title',
                                                        'class' => 'form-control col-md-7 col-xs-12',
                                                        'placeholder' => 'enter title',
                                                        'required' => 'required',
                                                    ]) }}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Section 1 Description</label>
                                                    {{ Form::textarea('contactus_section1_description', @$frontSettings['contactus_section1_description'], [
                                                        'class' => 'form-control col-md-7 col-xs-12',
                                                        'rows' => 3,
                                                        'id' => 'contactus_section1_description',
                                                    ]) }}
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Section 2 Title</label>
                                                    {{ Form::text('contactus_section2_title', @$frontSettings['contactus_section2_title'], [
                                                        'id' => 'contactus_section2_title',
                                                        'class' => 'form-control col-md-7 col-xs-12',
                                                        'placeholder' => 'enter title',
                                                        'required' => 'required',
                                                    ]) }}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Section 2 Description</label>
                                                    {{ Form::textarea('contactus_section2_description', @$frontSettings['contactus_section2_description'], [
                                                        'class' => 'form-control col-md-7 col-xs-12',
                                                        'rows' => 3,
                                                        'id' => 'contactus_section2_description',
                                                    ]) }}
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Section 3 Title</label>
                                                    {{ Form::text('contactus_section3_title', @$frontSettings['contactus_section3_title'], [
                                                        'id' => 'contactus_section3_title',
                                                        'class' => 'form-control col-md-7 col-xs-12',
                                                        'placeholder' => 'enter title',
                                                        'required' => 'required',
                                                    ]) }}
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Section 3 sub title</label>
                                                    {{ Form::text('contactus_section3_subtitle', @$frontSettings['contactus_section3_subtitle'], [
                                                        'id' => 'contactus_section3_subtitle',
                                                        'class' => 'form-control col-md-7 col-xs-12',
                                                        'placeholder' => 'enter title',
                                                        'required' => 'required',
                                                    ]) }}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Section 3 Description</label>
                                                    {{ Form::textarea('contactus_section3_description', @$frontSettings['contactus_section3_description'], [
                                                        'class' => 'form-control col-md-7 col-xs-12',
                                                        'rows' => 3,
                                                        'id' => 'contactus_section3_description',
                                                    ]) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-primary w-md">Save Contactus Page</button>
                                    </div>
                               {{ Form::close() }}
                            </div>
                            <div class="tab-pane" id="contactinfo1" role="tabpanel">
                                {{ Form::open(['role' => 'form', 'route' => ['websitecms.update', 8], 'method' => 'put', 'enctype' => 'multipart/form-data', 'class' => 'custom-validation form-horizontal form-label-left', 'id' => 'user-form', 'novalidate' => 'novalidate']) }}

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Address 1</label>
                                                {{ Form::textarea('address_1', @$frontSettings['address_1'], [
                                                    'class' => 'form-control col-md-7 col-xs-12',
                                                    'rows' => 4,
                                                    'id' => 'address_1',
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Address 2</label>
                                                {{ Form::textarea('address_2', @$frontSettings['address_2'], [
                                                    'class' => 'form-control col-md-7 col-xs-12',
                                                    'rows' => 4,
                                                    'id' => 'address_2',
                                                ]) }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Phone Number 1</label>
                                                {{ Form::text('phone_number_1', @$frontSettings['phone_number_1'], [
                                                    'id' => 'phone_number_1',
                                                    'class' => 'form-control col-md-7 col-xs-12',
                                                    'placeholder' => 'enter phone number',
                                                    'required' => 'required',
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Phone Number 2</label>
                                                {{ Form::text('phone_number_2', @$frontSettings['phone_number_2'], [
                                                    'id' => 'phone_number_2',
                                                    'class' => 'form-control col-md-7 col-xs-12',
                                                    'placeholder' => 'enter phone number',
                                                    'required' => 'required',
                                                ]) }}
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Working Hours </label>
                                                {{ Form::text('working_hrs', @$frontSettings['working_hrs'], [
                                                    'id' => 'working_hrs',
                                                    'class' => 'form-control col-md-7 col-xs-12',
                                                    'placeholder' => 'enter working hours',
                                                    'required' => 'required',
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Map URL </label>
                                                {{ Form::textarea('map_embed_url', @$frontSettings['map_embed_url'], [
                                                    'class' => 'form-control col-md-7 col-xs-12',
                                                    'rows' => 4,
                                                    'id' => 'map_embed_url',
                                                ]) }}
                                            </div>
                                        </div>
                                    </div>


                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label">Facebook URL </label>
                                                    {{ Form::text('facebook_url', @$frontSettings['facebook_url'], [
                                                        'id' => 'facebook_url',
                                                        'class' => 'form-control col-md-7 col-xs-12',
                                                        'placeholder' => 'enter map url link',
                                                        'required' => 'required',
                                                    ]) }}
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label">LinkedIn URL </label>
                                                    {{ Form::text('linkedin_url', @$frontSettings['linkedin_url'], [
                                                        'id' => 'linkedin_url',
                                                        'class' => 'form-control col-md-7 col-xs-12',
                                                        'placeholder' => 'enter map url link',
                                                        'required' => 'required',
                                                    ]) }}
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label">Instagram URL </label>
                                                    {{ Form::text('instagram_url', @$frontSettings['instagram_url'], [
                                                        'id' => 'instagram_url',
                                                        'class' => 'form-control col-md-7 col-xs-12',
                                                        'placeholder' => 'enter map url link',
                                                        'required' => 'required',
                                                    ]) }}
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label">Twitter URL </label>
                                                    {{ Form::text('twitter_url', @$frontSettings['twitter_url'], [
                                                        'id' => 'twitter_url',
                                                        'class' => 'form-control col-md-7 col-xs-12',
                                                        'placeholder' => 'enter map url link',
                                                        'required' => 'required',
                                                    ]) }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                                <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Footer Description</label>
                                                {{ Form::textarea('footer_description', @$frontSettings['footer_description'], [
                                                    'class' => 'form-control col-md-7 col-xs-12',
                                                    'rows' => 3,
                                                    'id' => 'footer_description',
                                                ]) }}
                                            </div>
                                        </div>
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-primary w-md">Save Contact info </button>
                                        </div>
                                        </div>

                                    </div>

                               {{ Form::close() }}
                            </div>

                        </div>


                    </div>
                </div>
            </div>


        </div> <!-- end col -->
    </div> <!-- end row -->


@endsection
@section('script')
    {{-- <script>
        $('document').ready(function() {

            var element = $("#datatable-buttons");
            var url = '{{ route('get_user_data_from_admin') }}';
            var column = [{
                    data: 'rownum',
                    defaultContent: '',
                    name: 'rownum',
                    searchable: false,
                    sortable: false,
                    className: 'textcenter'
                },
                {
                    data: 'name',
                    name: 'name',
                    width: '15%'
                },
                {
                    data: 'username',
                    name: 'username',
                    width: '20%'
                },
                {
                    data: 'email',
                    name: 'email',
                    width: '10%',
                    className: 'textcenter'
                },
                {
                    data: 'mobile',
                    name: 'mobile',
                    className: 'textcenter'
                },
                {
                    data: 'group',
                    name: 'group',
                    className: 'textcenter'
                },
                {
                    data: 'status',
                    name: 'users.status',
                    sortable: false,
                    className: 'textcenter'
                },
                {
                    data: 'action',
                    name: 'users.id',
                    searchable: false,
                    sortable: false,
                    className: 'textcenter'
                }
            ];
            var csrf = '{{ csrf_token() }}';

            var options = {
                //order : [ [ 6, "desc" ] ],
                //lengthMenu: [[100, 250, 500], [100, 250, 500]]
                button: [{
                        name: "Publish",
                        url: "{{ route('user_action_from_admin', 1) }}"
                    },
                    {
                        name: "Un Publish",
                        url: "{{ route('user_action_from_admin', 0) }}"
                    },
                    {
                        name: "Trash",
                        url: "{{ route('user_action_from_admin', -1) }}"
                    },
                    {
                        name: "Delete",
                        url: "{{ route('user.destroy', 1) }}",
                        method: "DELETE"
                    }
                ],

            }


            dataTable(element, url, column, csrf, options);

        });
    </script> --}}

@endsection
