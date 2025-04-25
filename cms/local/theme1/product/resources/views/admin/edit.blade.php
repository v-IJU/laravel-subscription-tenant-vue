@extends('layouts.master')

@section('title', 'Product')

@section('content')
@component('components.breadcrumb')
@slot('li_1')
DashBoard
@endslot
@slot('title')
@if ($layout == 'create')
Add Product
@elseif ($layout == 'clone')
Clone Product
@elseif($layout == 'edit')
Edit Product
@endif
@endslot
@endcomponent

@if ($layout == 'create')
{{ Form::open(['role' => 'form', 'route' => ['product.store'], 'method' => 'post', 'enctype' => 'multipart/form-data',
'class' => 'form-horizontal form-label-left', 'id' => 'product-form', 'novalidate' => 'novalidate']) }}
@elseif($layout == 'clone')
{{ Form::open(['role' => 'form', 'method' => 'post', 'route' => ['product.duplicateproduct'], 'enctype' =>
'multipart/form-data', 'class' => 'custom-validation form-horizontal form-label-left', 'id' =>
'product-clone-form-create', 'novalidate' => 'novalidate']) }}
@elseif($layout == 'edit')
{{ Form::open(['role' => 'form', 'route' => ['product.update', $data->id], 'method' => 'put', 'enctype' =>
'multipart/form-data', 'class' => 'custom-validation form-horizontal form-label-left', 'id' => 'product-form-edit',
'novalidate' => 'novalidate']) }}
@endif

<!-- school details col -->
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">

            {{-- added this to prevent form submission on clicking enter button --}}
            <button type=submit onclick="return false;" style="display:none;"></button>

            <h4 class="card-title mb-4">School Details</h4>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">School Name:</label><span class="required"></span>
                        <div>
                            {{ Form::select('school_name', $schoolNames, @$data->school_id ?? null, [
                            'id' => 'school-dropdown',
                            'data-class-id' => 'school_class',
                            'class' => 'school_select select2 form-control',
                            'required' => 'required',
                            'placeholder' => 'Select school',
                            ]) }}
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <div class="mb-3">
                            <label class="form-label required">School Classes:</label>
                            <div>
                                {{ Form::select('school_class', $totalActiveClasses, @$data->class_id ?? null, [
                                'id' => 'class-dropdown',
                                'class' => 'select2 form-control',
                                'required' => 'required',
                                ]) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Child Gender:</label><span class="required"></span>
                        <div>
                            {{ Form::select('child_gender', $genders, @$data->gender_id ?? null, [
                            'id' => 'child_gender_category',
                            'class' => 'gender_select select2 form-control',
                            'required' => 'required',
                            'placeholder' => 'Select gender',
                            ]) }}
                        </div>
                    </div>
                </div>
                <div class="mb-3 col-md-4">
                    <label class="form-label">Product Category: </label><span class="required"></span>
                    <div>
                        {{ Form::select('product_category', @$userSelectedCategory ?? [], @$data->category_attribute_id
                        ?? null, [
                        'id' => 'size_category',
                        'class' => 'select2 size_category form-control',
                        'required' => 'required',
                        ]) }}
                    </div>
                </div>
            </div>
            <div id="color-container" class="alert alert-warning" role="alert" style="display: none;">
                Color product variants.
            </div>


        </div>
    </div>
</div>
<!-- end school details col -->

<!-- product details col -->
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">

            <h4 class="card-title mb-4">Product Details</h4>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Product Name</label><span class="required"></span>
                        <div>
                            {{ Form::text('product_name', @$data->product_name, [
                            'id' => 'product_name',
                            'class' => 'form-control col-md-7 col-xs-12',
                            'data-validate-length-range' => '20',
                            'placeholder' => 'Enter product name...',
                            'required' => 'required',
                            ]) }}
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Product Base Rate </label><span class="required"></span>
                        <div>
                            {{ Form::text('product_rate', @$data->base_rate, [
                            'id' => 'product_rate',
                            'class' => 'form-control col-md-7 col-xs-12',
                            'data-validate-length-range' => '20',
                            'placeholder' => 'Enter rate..',
                            ]) }}
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Product GST(%) </label><span class="required"></span>
                        <div>
                            {{ Form::text('product_gst', @$data->gst, [
                            'id' => 'product_gst',
                            'class' => 'form-control col-md-7 col-xs-12',
                            'data-validate-length-range' => '20',
                            'placeholder' => 'Enter gst rate',
                            'required' => 'required',
                            ]) }}
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Product Rate Inclusive of GST </label>
                        <div>
                            {{-- <span id="inclusive_rate_span" name="inclusive_rate_span"
                                class="form-control col-md-7 col-xs-12">0.00</span> --}}

                            {{ Form::text('inclusive_rate', @$data->rate, [
                            'id' => 'inclusive_rate',
                            'class' => 'form-control col-md-7 col-xs-12',
                            'readonly',
                            ]) }}
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Product Images: </label>
                        <div class="fallback">

                            {{-- input tag to browse images --}}
                            <input id="file" name="pimage[]" type="file" type="file" class="form-control tex_img"
                                accept="image/*"
                                onchange="document.getElementById('pimage').src = window.URL.createObjectURL(this.files[0])">

                            {{-- image tag to display user selected images / previously stored image --}}
                            <div class="item form-group mt-3">
                                <img id="pimage" name="pimage" class="image"
                                    src="{{ @$data->image_url ? @$data->image_url : asset('/skin/theme1/img/no-image.png') }}"
                                    alt="profile_image" style="width: 150px;height: 150px; padding: px; margin: 0px; ">
                                <input type="hidden" name="old_product_icon[]" value="{{ @$data->image_url }}" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Product Description</label>
                        {{ Form::textarea('product_desc', @$data->product_description, [
                        'class' => 'form-control col-md-5 col-xs-8',
                        'rows' => 1,
                        'name' => 'product_desc',
                        'id' => 'product_desc',
                        'placeholder' => 'Enter product description..',
                        ]) }}

                    </div>
                </div>
            </div>

            <div id="alert-container" class="alert alert-danger d-none" role="alert">
                Please select a gender to proceed with product variants.
            </div>

            <div class="row">
                <div class="collapse none" id="collapseExample1">
                    <div class="form-check mb-3">
                        <input id="formCheck1" class="form-check-input" name="is_variable_product" type="checkbox"
                            data-bs-toggle="collapse" href="#collapseExample" aria-expanded="false"
                            aria-controls="collapseExample" {{ old('is_variable_product', $data->is_variable_product ??
                        0) == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="formCheck1">
                            Is the above product have variants?
                        </label>

                    </div>
                </div>
            </div>

            @if ($layout == 'create')
            <div class="collapse none" id="collapseExample2">
                <div class="card border shadow-none card-body text-muted mb-0">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="mb-3 col-lg-4">
                                <label class="form-label">Varient Size </label><span class="required"></span>
                                <div>
                                    {{ Form::select('addmore[0][pvsizes]', [], $data->pvsizes ?? null, [
                                    'id' => 'addmore[0][pvsizes]',
                                    'class' => 'select2 addmore_pvsizes form-control',
                                    'required' => 'required',
                                    'placeholder' => 'Select',
                                    ]) }}
                                </div>
                            </div>
                            <div class="mb-3 col-lg-2">
                                <label class="form-label"> Varient Rate </label><span class="required"></span>
                                <div>
                                    {{ Form::text('addmore[0][pvrate]', @$data->rate, [
                                    'id' => 'pvrate',
                                    'class' => 'form-control col-md-7 col-xs-12 varient_rate',
                                    'data-validate-length-range' => '20',
                                    'placeholder' => 'Enter rate..',
                                    ]) }}
                                </div>
                            </div>
                            <div class="mb-3 col-lg-2">
                                <label class="form-label"> Varient Inclusive Gst </label><span class="required"></span>
                                <div>
                                    {{ Form::text('addmore[0][inclusive_rate]', @$data->base_rate, [
                                    'id' => 'varient_inclusive_rate',
                                    'class' => 'form-control col-md-7 col-xs-12 inclusive_rate',
                                    'readonly',
                                    ]) }}
                                </div>
                            </div>

                            <div class="mb-4 col-lg-4">
                                <div class="mb-2">
                                    <label class="form-label">Varient Images: </label>

                                    <div class="fallback">
                                        <input name="addmore[0][pvimage]" type="file" multiple="multiple"
                                            class="form-control tex_img" accept="image/*">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="mb-2">
                                    <input type="button" id="addMoreBtn" data-class-id="" class="btn btn-success"
                                        value="Add" />
                                </div>
                            </div>

                            {{-- html appending row --}}
                            <div id="newRow" class="row">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            {{-- end of product create --}}

            {{-- to edit & clone product --}}
            @if ($layout == 'edit' || $layout == 'clone')

            <div>
                <h4 class="card-title mb-4">Product Varients</h4>
                @foreach ($variantData as $key => $variant)
                <div class="row">
                    {{ Form::hidden("addmore[$key][variant_id]", @$variant->id, [
                    'id' => "variantid_$key",
                    ]) }}

                    <div class="mb-3 col-lg-2">
                        <label class="form-label">Product Size </label><span class="required"></span>
                        <div>
                            {{ Form::select('addmore[' . $key . '][pvsizes]', @$totalSizes, $variant->product_size_id ??
                            null, [
                            'id' => 'pvsizes_' . $key,
                            'class' => 'select2 form-control',
                            'required' => 'required',
                            'placeholder' => 'Select',
                            ]) }}
                        </div>
                    </div>

                    <div class="mb-3 col-lg-2">
                        <label class="form-label"> Varient Rate </label><span class="required"></span>
                        <div>
                            {{ Form::text('addmore[' . $key . '][pvrate]', @$variant->base_rate, [
                            'id' => 'pvrate_' . $key,
                            'class' => 'form-control col-md-7 col-xs-12 varient_rate',
                            'data-validate-length-range' => '20',
                            'placeholder' => 'Enter rate..',
                            ]) }}
                        </div>
                    </div>

                    <div class="mb-3 col-lg-2">
                        <label class="form-label"> Varient Inclusive Gst </label><span class="required"></span>
                        <div>
                            {{ Form::text('addmore[' . $key . '][inclusive_rate]', @$variant->rate, [
                            'id' => 'varient_inclusive_rate_' . $key,
                            'class' => 'form-control col-md-7 col-xs-12 inclusive_rate',
                            'readonly',
                            ]) }}
                        </div>
                    </div>

                    <div class="mb-4 col-lg-4">
                        <div class="mb-4">
                            <label class="form-label">Product Images: </label>
                            <div class="fallback">

                                <input type="file" name="addmore[{{ $key }}][pvimage]" id="pvimage{{ $key }}"
                                    class="form-control tex_img" accept="image/*">
                            </div>
                            @if (!empty($variant->image_url))
                            @foreach ($variant->image_url as $imageUrl)
                            <img src="{{ @$imageUrl }}" width="100px" />
                            <input type="hidden" name="old_product_icon[]" value="{{ @$imageUrl }}" />
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>


            @endif

            <div class="d-flex align-items-center justify-content-end mt-4">
                @if ($layout == 'create' || $layout == 'edit')
                <button type="submit" id="product_register" class="btn btn-success">
                    <i class="mdi mdi-checkbox-marked-outline"></i>
                    Submit</button>
                @elseif($layout == 'clone')
                <button type="submit" id="clone_product_register" class="btn btn-success">
                    <i class="mdi mdi-checkbox-marked-outline"></i>
                    Clone_Submit</button>
                @endif
                <button type="reset" class="btn btn-outline-danger waves-effect waves-light">
                    <i class="mdi mdi-backup-restore"></i>
                    Clear </button>
                {{-- {{ Form::button('<i class="fa fa-refresh"></i>&nbsp;&nbsp;&nbsp;Clear', ['type' => 'reset', 'class'
                => 'btn btn-danger btn-sm m-1 px-3']) }} --}}
                <a href="{{ route('product.index') }}"
                    class="btn btn-outline-dark waves-effect waves-light mdi mdi-menu-left">Back</a>
            </div>

        </div>
        <!-- end card body -->
    </div>
    <!-- end card -->
</div>
<!-- end product details col -->

{{ Form::close() }}

@endsection

@section('script')
<script src="{{ URL::asset('build/libs/parsleyjs/parsley.min.js') }}"></script>

<script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/project-create.init.js') }}"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
            const formCheck1 = document.getElementById("formCheck1");
            const collapse1 = document.getElementById("collapseExample1");
            const collapse2 = document.getElementById("collapseExample2");

            if (formCheck1.checked) {
                collapse1.classList.remove("show");
                collapse2.classList.add("show");
            } else {
                collapse1.classList.add("show");
                collapse2.classList.remove("show");
            }

            // Add event listener to handle changes
            formCheck1.addEventListener("change", function() {
                const genderId = document.getElementById("child_gender_category").value;
                const alertContainer = document.getElementById("alert-container");

                if (!genderId) {
                    {
                        alertContainer.classList.remove("d-none");
                        this.checked = false;
                    }
                } else {
                    alertContainer.classList.add("d-none");
                }

                if (this.checked) {
                    //collapse1.classList.remove("show");
                    collapse2.classList.add("show");
                } else {
                    collapse1.classList.add("show");
                    collapse2.classList.remove("show");
                }
            });
        });
</script>

<script type="text/javascript">
    $(document).on("input", "#product_gst, #product_rate", function() {

            $("#inclusive_rate").empty();

            //get values and convert to parse value
            let basePrice = $("#product_rate").val();
            let gstRate = $("#product_gst").val();

            if (gstRate == "") {
                gstRate = 0;
            }

            //validate inputs
            if (!basePrice || isNaN(basePrice) || basePrice <= 0) {
                alert("Please check the base price");
                $("#product_rate").val("");
                return;
                if (!gstRate || isNaN(gstRate) || gstRate <= 0) {
                    alert("Please check the gst rate");
                    $("#product_gst").val("");
                }
            } else {
                basePrice = parseFloat(basePrice);
                gstRate = parseFloat(gstRate);

                // calculate inclusive rate
                let gstCalculated = (basePrice * gstRate) / 100;
                let inclusivePrice = basePrice + gstCalculated;

                // append the result
                $("#inclusive_rate").text(inclusivePrice.toFixed(2));
                $("#inclusive_rate").val(inclusivePrice.toFixed(2));

                console.log("inclusiveprice is:", inclusivePrice);

            }


        });
</script>

<script type="text/javascript">
    var i = 0;

        $("#addMoreBtn").click(function() {
            handleSizeCategorySelection();
            i++;
            console.log("Value of I:" + i);
            var newField = `
                <div id="existRow" class="row">
                    <div class="mb-3 col-lg-4">
                        <label class="form-label">Varient Size </label><span class="required"></span>
                        <select name="addmore[${i}][pvsizes]" id="addmore[${i}][pvsizes]" class="form-control addmore_pvsizes sizes select2" required>
                            <option value="">Select Size</option>
                        </select>
                    </div>
                    <div class="mb-3 col-lg-2">
                        <label class="form-label"> Varient Rate </label><span class="required"></span>

                        <div>
                            <input type="text" name="addmore[${i}][pvrate]"
                            id = "addmore_${i}_pvrate"
                            class = "form-control col-md-7 col-xs-12 varient_rate"
                            data-validate-length-range = "20"
                            placeholder = "Enter rate.."
                            />
                        </div>
                    </div>
                    <div class="mb-3 col-lg-2">
                        <label class="form-label">  Varient Inclusive Gst  </label><span class="required"></span>
                        <div>
                            <input type="text" name="addmore[${i}][inclusive_rate]"
                            id = "addmore_${i}_inclusive_rate"
                            class = "form-control col-md-7 col-xs-12 inclusive_rate" readonly=true
                            
                            />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label class="form-label">Product Images: </label>
                            <input type="file" name="addmore[${i}][pvimage]" multiple="multiple" class="form-control tex_img" accept="image/*" />
                            <input type="hidden" name="old_variant_icon" value="{{ @$data->pvimage }}" />
                        </div>
                    </div>

                    <div class="col-lg-2">
                            <div class="mt-2 mb-3">
                                <input type="button" class="deleteMoreBtn btn btn-warning" value="Delete" />
                            </div>
                    </div>
                </div>`;

            // Append the new row to the container
            $('#newRow').append(newField);

        });

        // function to load sizes for dynamic rows on product category selection
        function handleSizeCategorySelection() {
            let url = window.filtersizelist;

            let sizeCategoryId = $("#size_category").val();
            var inputData = new FormData();
            inputData.append("sizeCategoryId", sizeCategoryId);

            const Index = $("#newRow").children().length;
            const newIndex = Index + 1;

            axios
                .post(url, inputData)

                .then((response) => {
                    if (response.data.sizes) {
                        let selectElement = $(
                            `#addmore\\[${newIndex}\\]\\[pvsizes\\]`
                        );

                        selectElement.empty();
                        selectElement.append("<option>Select sizes</option>");

                        // Format the data for Select2
                        let formattedData = response.data.sizes.map((item) => {
                            return {
                                id: item.id,
                                text: item.size
                            }; // Rename 'size' to 'text'
                        });

                        // Initialize or reinitialize Select2 with formatted data
                        selectElement.select2({
                            allowClear: true,
                            placeholder: "Select category...",
                            data: formattedData,
                        });
                    }
                })

                .catch((error) => {
                    console.error("Error:", error);
                });
        }

        $(document).on('click', '.deleteMoreBtn', function() {
            $(this).closest("#existRow").remove();
        });
</script>

<script>
    window.filterclasslist = "{{ route('parent.filterclasslist') }}"
        window.filtercategorylist = "{{ route('product.filtercategorylist') }}"
        window.filtersizelist = "{{ route('product.filtersizelist') }}"
        window.filtercolorlist = "{{ route('product.filtercolorlist') }}"
        window.registerproduct = "{{ route('product.newproduct') }}"
        window.registercloneproduct = "{{ route('product.duplicateproduct') }}"
</script>

<!-- CKEditor init -->
<script src="//cdnjs.cloudflare.com/ajax/libs/ckeditor/4.5.11/ckeditor.js"></script>
<script>
    CKEDITOR.replace('product_desc', {
            toolbar: [{
                    name: 'basicstyles',
                    items: ['Bold', 'Italic', 'Underline']
                },
                {
                    name: 'paragraph',
                    items: ['NumberedList', 'BulletedList']
                },
                {
                    name: 'styles',
                    items: ['Format', 'Font', 'FontSize']
                },
                {
                    name: 'links',
                    items: ['Link', 'Unlink']
                },
            ],
            removePlugins: 'image,uploadimage',
        });
</script>
<script>
    $('form').on('reset', function() {
            $('.select2').val(null).trigger('change'); // Reset Select2 fields
        });
</script>

@endsection