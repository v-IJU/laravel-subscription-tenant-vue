@extends('layouts.master')

@section('title') @lang('translation.Profile') @endsection
@section('content')

@component('components.breadcrumb')
@slot('li_1') Dashboard @endslot
@slot('title')Payment Gateway Information @endslot
@endcomponent

<div class="row">
    <div class="col-xl-8">

        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Secret Key and ID Details:</h4>

                <p class="text-muted mb-8"></p>
                <div class="table-responsive">
                    <table class="table table-nowrap mb-0">
                        <tbody>
                            <tr>
                                <th scope="row">GATEWAY NAME :</th>
                                <td>{{ @$data->gateway_name }}</td>
                            </tr>
                            <tr>
                                <th scope="row">RAZORPAY MODE :</th>
                                <td>{{  @$data->razorpay_mode }}</td>
                            </tr>
                            @if (@$data->razorpay_mode =="live")
                                <tr>
                                <th scope="row">RAZORPAY KEY ID-LIVE :</th>
                                <td>{{ @$data->live_key_id }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">RAZORPAY KEY SECRET -LIVE :</th>
                                    <td>{{ @$data->live_key_secret  }}</td>
                                </tr>
                            @endif
                            @if (@$data->razorpay_mode =="sandbox")
                                <tr>
                                <th scope="row">RAZORPAY KEY ID-TEST :</th>
                                <td>{{ @$data->test_key_id }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">RAZORPAY KEY SECRET -TEST :</th>
                                    <td>{{ @$data->test_key_secret  }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <a href="{{ route("paymentgateway.index") }}" class="btn btn-primary w-md">Back</a>
            </div>
        </div>
        <!-- end card -->

        {{-- <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-5">Experience</h4>
                <div class="">
                    <ul class="verti-timeline list-unstyled">
                        <li class="event-list active">
                            <div class="event-timeline-dot">
                                <i class="bx bx-right-arrow-circle bx-fade-right"></i>
                            </div>
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <i class="bx bx-server h4 text-primary"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div>
                                        <h5 class="font-size-15"><a href="javascript: void(0);" class="text-dark">Back end Developer</a></h5>
                                        <span class="text-primary">2016 - 19</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="event-list">
                            <div class="event-timeline-dot">
                                <i class="bx bx-right-arrow-circle"></i>
                            </div>
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <i class="bx bx-code h4 text-primary"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div>
                                        <h5 class="font-size-15"><a href="javascript: void(0);" class="text-dark">Front end Developer</a></h5>
                                        <span class="text-primary">2013 - 16</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="event-list">
                            <div class="event-timeline-dot">
                                <i class="bx bx-right-arrow-circle"></i>
                            </div>
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <i class="bx bx-edit h4 text-primary"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div>
                                        <h5 class="font-size-15"><a href="javascript: void(0);" class="text-dark">UI /UX Designer</a></h5>
                                        <span class="text-primary">2011 - 13</span>

                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

            </div>
        </div> --}}
        <!-- end card -->
    </div>

    {{-- <div class="col-xl-8">

        <div class="row">
            <div class="col-md-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium mb-2">Students</p>
                                <h4 class="mb-0">125</h4>
                            </div>

                            <div class="flex-shrink-0 align-self-center">
                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                    <span class="avatar-title">
                                        <i class="bx bx-check-circle font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium mb-2">Students</p>
                                <h4 class="mb-0">12</h4>
                            </div>

                            <div class="flex-shrink-0 align-self-center">
                                <div class="avatar-sm mini-stat-icon rounded-circle bg-primary">
                                    <span class="avatar-title">
                                        <i class="bx bx-hourglass font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium mb-2">Total Revenue</p>
                                <h4 class="mb-0">$36,524</h4>
                            </div>

                            <div class="flex-shrink-0 align-self-center">
                                <div class="avatar-sm mini-stat-icon rounded-circle bg-primary">
                                    <span class="avatar-title">
                                        <i class="bx bx-package font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Revenue</h4>
                <div id="revenue-chart" class="apex-charts" dir="ltr"></div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">My Projects</h4>
                <div class="table-responsive">
                    <table class="table table-nowrap table-hover mb-0">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Projects</th>
                                <th scope="col">Start Date</th>
                                <th scope="col">Deadline</th>
                                <th scope="col">Budget</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Skote admin UI</td>
                                <td>2 Sep, 2019</td>
                                <td>20 Oct, 2019</td>
                                <td>$506</td>
                            </tr>

                            <tr>
                                <th scope="row">2</th>
                                <td>Skote admin Logo</td>
                                <td>1 Sep, 2019</td>
                                <td>2 Sep, 2019</td>
                                <td>$94</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Redesign - Landing page</td>
                                <td>21 Sep, 2019</td>
                                <td>29 Sep, 2019</td>
                                <td>$156</td>
                            </tr>
                            <tr>
                                <th scope="row">4</th>
                                <td>App Landing UI</td>
                                <td>29 Sep, 2019</td>
                                <td>04 Oct, 2019</td>
                                <td>$122</td>
                            </tr>
                            <tr>
                                <th scope="row">5</th>
                                <td>Blog Template</td>
                                <td>05 Oct, 2019</td>
                                <td>16 Oct, 2019</td>
                                <td>$164</td>
                            </tr>
                            <tr>
                                <th scope="row">6</th>
                                <td>Redesign - Multipurpose Landing</td>
                                <td>17 Oct, 2019</td>
                                <td>05 Nov, 2019</td>
                                <td>$192</td>
                            </tr>
                            <tr>
                                <th scope="row">7</th>
                                <td>Logo Branding</td>
                                <td>04 Nov, 2019</td>
                                <td>05 Nov, 2019</td>
                                <td>$94</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> --}}
</div>
<!-- end row -->

<!--  Update Profile example -->
<div class="modal fade update-profile" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Edit Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" enctype="multipart/form-data" id="update-profile">
                    @csrf
                    <input type="hidden" value="{{ Auth::user()->id }}" id="data_id">
                    <div class="mb-3">
                        <label for="useremail" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="useremail" value="{{ Auth::user()->email }}" name="email" placeholder="Enter email" autofocus>
                        <div class="text-danger" id="emailError" data-ajax-feedback="email"></div>
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ Auth::user()->name }}" id="username" name="name" autofocus placeholder="Enter username">
                        <div class="text-danger" id="nameError" data-ajax-feedback="name"></div>
                    </div>

                    <div class="mb-3">
                        <label for="userdob">Date of Birth</label>
                        <div class="input-group" id="datepicker1">
                            <input type="text" class="form-control @error('dob') is-invalid @enderror" placeholder="dd-mm-yyyy" data-date-format="dd-mm-yyyy" data-date-container='#datepicker1' data-date-end-date="0d" value="{{ date('d-m-Y', strtotime(Auth::user()->dob)) }}" data-provide="datepicker" name="dob" autofocus id="dob">
                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                        </div>
                        <div class="text-danger" id="dobError" data-ajax-feedback="dob"></div>
                    </div>

                    <div class="mb-3">
                        <label for="avatar">Profile Picture</label>
                        <div class="input-group">
                            <input type="file" class="form-control @error('avatar') is-invalid @enderror" id="avatar" name="avatar" autofocus>
                            <label class="input-group-text" for="avatar">Upload</label>
                        </div>
                        <div class="text-start mt-2">
                            <img src="{{ asset(Auth::user()->avatar) }}" alt="" class="rounded-circle avatar-lg">
                        </div>
                        <div class="text-danger" role="alert" id="avatarError" data-ajax-feedback="avatar"></div>
                    </div>

                    <div class="mt-3 d-grid">
                        <button class="btn btn-primary waves-effect waves-light UpdateProfile" data-id="{{ Auth::user()->id }}" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection
@section('script')
<!-- apexcharts -->
<script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>

<!-- profile init -->
<script src="{{ URL::asset('build/js/pages/profile.init.js') }}"></script>



@endsection
