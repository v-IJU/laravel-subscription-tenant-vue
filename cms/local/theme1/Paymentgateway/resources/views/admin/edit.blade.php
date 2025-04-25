@extends('layouts.master')

@section('title', 'Paymentgateway')
@section('style')


@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            DashBoard
        @endslot
        @slot('title')
             @if ($layout == 'create')
                Add Payment Gateway
            @elseif($layout == 'edit')
                Edit Payment Gateway
            @endif
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">

                    @if ($layout == 'create')
                        {{ Form::open(['role' => 'form', 'route' => ['paymentgateway.store'], 'method' => 'post', 'enctype' => 'multipart/form-data', 'class' => 'custom-validation form-horizontal form-label-left', 'id' => 'user-form', 'novalidate' => 'novalidate']) }}
                    @elseif($layout == 'edit')
                        {{ Form::open(['role' => 'form', 'route' => ['paymentgateway.update', $data->id], 'method' => 'put', 'enctype' => 'multipart/form-data', 'class' => 'custom-validation form-horizontal form-label-left', 'id' => 'user-form', 'novalidate' => 'novalidate']) }}
                    @endif
                    <div class="row">
                            {{-- added this to prevent form submission on clicking enter button --}}
                            <button type=submit onclick="return false;" style="display:none;"></button>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Gateway Name</label><span class="required"></span>
                                <div>
                                    {{ Form::text('gateway_name', @$data->gateway_name, [
                                        'id' => 'gateway_name',
                                        'class' => 'form-control col-md-7 col-xs-12',
                                        'data-validate-length-range' => '6',
                                        'placeholder' => 'type name here',
                                        'required' => 'required',
                                        'autofocus' => 'autofocus'
                                    ]) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Razorpay Mode</label><span class="required"></span>
                                <div>
                                    {{ Form::select('razorpay_mode', @$razorpay_modes, @$data->razorpay_mode, [
                                        'id' => 'razorpay_mode',
                                        'class' => 'select2 form-control',
                                        'required' => 'required',
                                        'placeholder' => 'Select',
                                    ]) }}
                                </div>
                            </div>
                        </div>

                        {{-- if  @$data from the database has razorpay mode as sandbox,
                        test fields div element is shown
                        else div element is hidden from the layout --}}

                        @if (@$data->razorpay_mode == 'sandbox')
                            <div id="test-fields" class="col-md-6">
                        @else
                            <div id="test-fields" class="col-md-6" style="display: none">
                        @endif

                                <div class="mb-3">
                                    <label class="form-label">RAZORPAY KEY ID-TEST </label><span class="required"></span>
                                    <div>
                                        {{ Form::text('test_key_id', @$data->test_key_id, [
                                            'id' => 'test_key_id',
                                            'class' => 'form-control col-md-7 col-xs-12',
                                            'data-validate-length-range' => '6',
                                            'placeholder' => 'type test key id here',

                                        ]) }}
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">RAZORPAY KEY SECRET -TEST</label><span class="required"></span>
                                    <div>
                                        {{ Form::text('test_key_secret', @$data->test_key_secret, [
                                            'id' => 'test_key_secret',
                                            'class' => 'form-control col-md-7 col-xs-12',
                                            'data-validate-length-range' => '6',
                                            'placeholder' => 'type test secret key here',

                                        ]) }}
                                    </div>
                                </div>
                            </div>


                    @if (@$data->razorpay_mode == 'live')
                        <div id="live-fields" class="col-md-6">
                    @else
                        <div id="live-fields" class="col-md-6" style="display: none">
                    @endif

                            <div class="row">
                                <div class="mb-3">
                                    <label class="form-label">RAZORPAY KEY ID-LIVE </label><span class="required"></span>
                                    <div>
                                        {{ Form::text('live_key_id', @$data->live_key_id, [
                                            'id' => 'live_key_id',
                                            'class' => 'form-control col-md-7 col-xs-12',
                                            'data-validate-length-range' => '6',
                                            'placeholder' => 'type live key id here',

                                        ]) }}
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">RAZORPAY KEY SECRET -LIVE</label><span class="required"></span>
                                    <div>
                                        {{ Form::text('live_key_secret', @$data->live_key_secret, [
                                            'id' => 'live_key_secret',
                                            'class' => 'form-control col-md-7 col-xs-12',
                                            'data-validate-length-range' => '6',
                                            'placeholder' => 'type live secret key here',

                                        ]) }}
                                    </div>
                                </div>
                            </div>
                         </div>

                    </div>

            <div>
                <button type="submit" class="btn btn-primary w-md">Submit</button>
                <a href="{{ route("paymentgateway.index") }}" class="btn btn-primary w-md">Back</a>
            </div>


            {{ Form::close() }}

        </div>
    </div>

@endsection

@section('script')
    <script src="{{ URL::asset('build/libs/parsleyjs/parsley.min.js') }}"></script>

    <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>

    <script>

      $(document).on('change', '#razorpay_mode', function() {

            var selectedPayMode = $(this).val();
            console.log(selectedPayMode);

            if(selectedPayMode === "live") {
                $('#live-fields').find('input').val('');
                $('#live-fields').show();
                $('#test-fields').hide();

            }
            else if(selectedPayMode === "sandbox") {
                $('#test-fields').find('input').val('');
                $('#live-fields').hide();
                $('#test-fields').show();
            }

      });

    </script>
@endsection
