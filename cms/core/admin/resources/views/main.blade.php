@extends('layouts.master')

@section('title')
    @lang('translation.Dashboards')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Dashboards
        @endslot
        @slot('title')
            Dashboard
        @endslot
    @endcomponent

    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="d-flex align-items-center">
                <img src="{{ isset($image_url) ? asset($image_url) : asset('build/images/users/user-dummy-img.jpg') }}"
                    alt="User Profile Image" class="avatar-sm rounded">
                <div class="ms-3 flex-grow-1">
                    <h5 class="mb-2 card-title">Hello, {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h5>
                    <p class="text-muted mb-0">{{ Auth::user()->username }}</p>

                </div>

            </div>
        </div>
        <!--end col-->
    </div>
    <div class="row">


        @if (User::hasRole('Super Admin'))
            <div class="col-lg-3">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Total Customer</p>
                                <h4 class="mb-0">1</h4>
                            </div>

                            <div class="avatar-sm ms-auto">
                                <div class="avatar-title bg-light rounded-circle text-primary font-size-20">
                                    <i class='bx bx-user-circle'></i>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        @endif

        {{-- <example-component /> --}}





    </div>
    <!--end row-->
@endsection
@section('script')
    <!-- dashboard init -->
    <script src="{{ URL::asset('build/js/pages/dashboard.init.js') }}"></script>
@endsection
