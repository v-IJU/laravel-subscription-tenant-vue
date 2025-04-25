@extends('layouts.master')

@section('title') @lang('translation.Product_Detail') @endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') DashBoard @endslot
@slot('title') Product Detail @endslot
@endcomponent

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="product-detai-imgs">
                            <div class="row">
                      
                                <div class="col-md-7 offset-md-1 col-sm-9 col-8">

                                    @if (!empty($data->image_url))                        
                                        <img src="{{ $data->image_url }}" width="500px" alt="Product Image" class="img-fluid rounded mb-2" />                                        
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6">
                        <div class="mt-4 mt-xl-3">
                            <h4 class="mt-1 mb-3"> {{ @$data->product_name}} </h4>

                            <h5 class="mb-">Product Rate : <span class="text-muted me-2"> <b> ₹ {{ @$data->rate }} </b></h5>
                            <h6 class="mb-3">GST Rate : <span class="text-muted me-2"> {{ @$data->gst }} % </h6>

                            <h6 class="mb-4">Product Code : <span class="text-muted me-2"> {{ @$data->product_code }} </h6>

                            <h6 class="mb-3">Product Description : </h6>
                            <p class="text-muted mb-4"> {!! @$data->product_description !!} </p>

                            <div class="d-flex align-items-center mb-4">
                                <div>

                                    <a href="{{ asset($sizeChartUrl) }}" target="_blank" class="btn btn-success">SIZE CHART</a>

                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <!-- end row -->

                @if ( !empty($data->variant) )
                    <div class="row mt-3">
                        <div class="col-lg-12">
                            <div>
                                <h5 class="mb-3">Product Variant: </h5>

                                <div class="row">
                                    @foreach (@$data->variant as $variant)
                                        <div class="col-xl-4 col-sm-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-4">
                                                            @if (!empty($variant->image_url))
                                                                @foreach ($variant->image_url as $imageUrl)
                                                                    <div class="image-preview" style="display: inline-block; margin: 5px;">
                                                                        <img src="{{ $imageUrl }}" width="100px" alt="Product Image" class="img-fluid mx-auto d-block">
                                                                    </div>
                                                                @endforeach
                                                            @else
                                                            <p class="text-muted"> No images available </p>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="text-center text-md-start pt-3 pt-md-0">

                                                                {{-- <h6 class="mb-4">Category : <span class="text-muted me-2"> {{ @$data->variant->sizecategoryinfo->category_name }} </h6>
                                                                <h6 class="mb-4">Product Size : <span class="text-muted me-2"> {{ @$data->variant->sizeinfo->size }} </h6> --}}

                                                                <h6 class="my-0 mb-2">Product Category: <span class="text-muted me-2"></span> <b>{{ @$variant->sizecategoryinfo->category_name ?? 'N/A' }}</b></h6>
                                                                <h6 class="my-0 mb-2">Product Size: <span class="text-muted me-2"></span> <b>{{ @$variant->sizeinfo->size ?? 'N/A' }}</b></h6>
                                                                <h6 class="my-0 mb-2">Item Code: <span class="text-muted me-2"></span> <b>{{ @$variant->item_code }}</b></h6>
                                                                <h6 class="my-0 mb-2">Price: <span class="text-muted me-2"></span> <b>₹{{ @$variant->rate ?? 0, 2}}</b></h6>
                                                                {{-- <h6 class="my-0 mb-2">GST: <span class="text-muted me-2"></span> <b>{{ @$variant->gst }}%</b></h6> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- end row -->
                            </div>
                        </div>
                    </div>
                @endif

                <!-- end row -->

                <div class="mt-5">
                    <h5 class="mb-3">Added Details :</h5>

                    <div class="table-responsive">
                        <table class="table mb-0 table-bordered">
                            <tbody>
                                <tr>
                                    <th scope="row" style="width: 400px;">School Name Info :</th>
                                    <td> {{ $data->school->school_name }} </td>
                                </tr>
                                <tr>
                                    <th scope="row">Class Details Info :</th>
                                    <td> {{ $data->classes->name }} </td>
                                </tr>
                                <tr>
                                    <th scope="row">Gender Info :</th>
                                    <td>{{ @$gender }} </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- end product -->

                <div class="row justify-content-start m-3">
                    <div class="col-lg-10">
                        <a href="{{ route("product.index") }}" class="btn btn-primary w-md">Back</a>
                    </div>
                </div>

            </div>
        </div>
        <!-- end card -->
    </div>
</div>
<!-- end row -->

@endsection
