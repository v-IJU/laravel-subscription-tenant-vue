@extends('layouts.master')

@section('title','parent')
@section('style')
<style>

   .form-control{
    border: var(--bs-border-width) solid var(--bs-border-color-translucent) !important;
    border-radius: var(--bs-border-radius);
    transition: border-color .15s
   }


</style>

@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            DashBoard
        @endslot
        @slot('title')
            @if ($layout == 'create')
                Add Parent/Child Information
            @elseif ($layout == 'edit')
                Edit Parent/Child Information
            @endif
        @endslot
    @endcomponent

    @if ($layout == 'create')
        {{ Form::open(['role' => 'form', 'route' => ['parent.store'], 'method' => 'post', 'enctype' => 'multipart/form-data', 'class' => 'custom-validation form-horizontal form-label-left', 'id' => 'user-form', 'novalidate' => 'novalidate']) }}
    @elseif($layout == 'edit')
        {{ Form::open(['role' => 'form', 'route' => ['parent.update', $data->id], 'method' => 'put', 'enctype' => 'multipart/form-data', 'class' => 'custom-validation form-horizontal form-label-left', 'id' => 'user-form', 'novalidate' => 'novalidate']) }}
    @endif

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title mb-4">Parent Details</h4>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">First Name</label><span class="required"></span>
                                <div>
                                    {{ Form::text('parent_first_name', @$data->first_name, [
                                        'id' => 'parent_first_name',
                                        'class' => 'form-control col-md-7 col-xs-12',
                                        'data-validate-length-range' => '20',
                                        'placeholder' => 'first name',
                                        'required' => 'required',
                                        'autofocus' => 'autofocus',
                                    ]) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Last Name</label>
                                <div>
                                    {{ Form::text('parent_last_name', @$data->last_name, [
                                        'id' => 'parent_last_name',
                                        'class' => 'form-control col-md-7 col-xs-12',
                                        'data-validate-length-range' => '20',
                                        'placeholder' => 'last name',
                                    ]) }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Parent Email</label><span class="required"></span>
                                <div>
                                    {{ Form::email('parent_email', @$data->parent_email, [
                                        'id' => 'parent_email',
                                        'class' => 'form-control col-md-7 col-xs-12',
                                        'placeholder' => 'Email',
                                        'required' => 'required',
                                    ]) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Parent Phone</label><span class="required"></span>
                            <div>
                                {{ Form::number('parent_phone', @$data->parent_phone, [
                                    'id' => 'parent_phone',
                                    'class' => 'form-control col-md-7 col-xs-12',
                                    'data-validate-length' => '9,15',
                                    'placeholder' => 'Phone Number',
                                    'required' => 'required',
                                ]) }}
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Select Gender</label><span class="required"></span>
                                <div>
                                {{ Form::select('parent_gender', @$genders, @$data->gender, [
                                    'id' => 'parent_gender',
                                    'class' => 'select2 form-control',
                                    'required' => 'required',
                                    'placeholder' => 'Select'
                                ]) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Parent Profile Image</label>
                                <div>
                                    <input type="file" name="parent_imagec" class="form-control" />
                                    <input type="hidden" name="old_parent_icon" value="{{ @$data->parent_image_url }}" />
                                    @if (@$data->image_url)
                                        <img src="{{ @$data->parent_image_url }}" width="100px" />
                                    @endif
                                </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Address 1</label><span class="required"></span>
                                <div>
                                    {{ Form::text('address1', @$addressData->address1, [
                                        'id' => 'address1',
                                        'class' => 'form-control col-md-7 col-xs-12',
                                        'data-validate-length-range' => '20',
                                        'placeholder' => 'Enter address',
                                        'required' => 'required',
                                    ]) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Address 2 </label><span class="required"></span>
                                <div>
                                    {{ Form::text('address2', @$addressData->address2, [
                                        'id' => 'address2',
                                        'class' => 'form-control col-md-7 col-xs-12',
                                        'data-validate-length-range' => '20',
                                        'placeholder' => ' Enter address',
                                        'required' => 'required',
                                    ]) }}
                                </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">City </label><span class="required"></span>
                                <div>
                                    {{ Form::text('city', @$addressData->city, [
                                        'id' => 'city',
                                        'class' => 'form-control col-md-7 col-xs-12',
                                        'data-validate-length-range' => '20',
                                        'placeholder' => 'Enter your city',
                                        'required' => 'required',
                                    ]) }}
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Zipcode </label>
                                <div>
                                    {{ Form::text('zip', @$addressData->zip, [
                                        'id' => 'zip',
                                        'class' => 'form-control col-md-7 col-xs-12',
                                        'data-validate-length-range' => '20',
                                        'placeholder' => 'Enter your zip code',

                                    ]) }}
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Relation to Child </label>
                                <div>
                                    {{ Form::select('child_relation', @$relations, @$data->relationship, [
                                    'id' => 'child_relation',
                                    'class' => 'select2 form-control',
                                    'required' => 'required',
                                    'placeholder' => 'Select'
                                ]) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
    </div>

    @if ($layout == 'create')
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Add Child Information</h4>
                        <div class="mb-3 row align-items-center">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">Child First Name</label><span class="required"></span>
                                        <div>
                                            {{ Form::text('addmore[0][child_fname]', @$data->child_first_name, [
                                                'id' => 'addmore[0][child_fname]',
                                                'class' => 'form-control col-md-7 col-xs-12',
                                                'data-validate-length-range' => '20',
                                                'placeholder' => 'first name',
                                                'required' => 'required',
                                            ]) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Child Last Name</label>
                                        <div>
                                            {{ Form::text('addmore[0][child_lname]', @$data->child_last_name, [
                                                'id' => 'addmore[0][child_lname]',
                                                'class' => 'form-control col-md-7 col-xs-12',
                                                'data-validate-length-range' => '20',
                                                'placeholder' => 'last name',
                                            ]) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">Select School</label><span class="required"></span>
                                        <div>
                                        {{ Form::select('addmore[0][child_school_name]', @$schoolNames, @$data->school_name, [
                                            'id' => 'school_name',
                                            'class' => 'school_select select2 form-control ',
                                            'required' => 'required',
                                            'placeholder' => 'Select'
                                        ]) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">School Classes</label><span class="required"></span>
                                        <div>
                                        {{ Form::select('addmore[0][child_school_class]', [], null, [
                                            'id' => 'school_class',
                                            'class' => 'school_class select2 form-control ',
                                            'required' => 'required',
                                            'placeholder' => 'Select'
                                        ]) }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Child Image</label>
                                        <div>
                                            <input type="file" name="addmore[0][child_image]" class="form-control" />
                                            <input type="hidden" name="old_child_icon" value="{{ @$data->child_image_url }}" />
                                            @if (@$data->image_url)
                                                <img src="{{ @$data->child_image_url }}" width="100px" />
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Child Birth Date</label><span class="required"></span>
                                        <div class="input-daterange input-group" data-provide="datepicker">
                                            {{ Form::text('addmore[0][child_dob]', @$data->child_dob, [
                                                'id' => 'child_dob',
                                                'class' => 'form-control datepicker col-md-7 col-xs-12',
                                                'required' => 'required',
                                                'placeholder' => 'Select Date'
                                            ]) }}
                                        </div>
                                    </div>
                                </div>

                               
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Child Gender</label><span class="required"></span>
                                        <div>
                                        {{ Form::select('addmore[0][child_gender]', @$genders, isset($selectedChildGender) ? $selectedChildGender : [], [
                                            'id' => 'child_gender',
                                            'class' => 'select2 form-control ',
                                            'required' => 'required',
                                            'placeholder' => 'Select'
                                        ]) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-10">
                                <input type="button" id="addMoreBtn" class="btn btn-success inner" value="Add Child" />
                            </div>
                        </div>

                        <div id="newRow" class="row">

                        </div>
                    </div>



                    <div class="row justify-content-start m-3">
                        <div class="col-lg-10">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="reset"  class="btn btn-primary w-md">Reset</button>
                            <a href="{{ route('parent.index')}}" class="btn btn-primary w-md">Back</a>
                        </div>
                    </div>

                    <br/>


                </div>
            </div>
        </div>
    @endif
    @if ($layout == 'edit')

        <div class="row">
            <div class="col-xl-12">
                <div class="card">

                        <h4 class="card-title mb-4">Edit Child Information</h4>
                        @foreach($childInfoArray as $key => $child)

                        <div class="card-body">
                        <div class="mb-3 row align-items-center">
                            <div class="col-md-6">
                                <div class="row">
                                        <div>
                                            {{ Form::hidden("addmore[$key][child_id]", @$child->id, [
                                            'id' => 'child_fname_$key',
                                        ]) }}
                                        </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Child First Name</label>
                                        <div>
                                            {{ Form::text("addmore[$key][child_fname]", @$child->first_name, [
                                            'id' => 'child_fname_$key',
                                            'class' => 'form-control col-md-7 col-xs-12',
                                            'data-validate-length-range' => '20',
                                            'placeholder' => 'first name',
                                            'required' => 'required',
                                            'autofocus' => 'autofocus',
                                        ]) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Child Last Name</label>
                                        <div>
                                            {{ Form::text("addmore[$key][child_lname]", @$child->last_name, [
                                            'id' => 'child_lname_$key',
                                            'class' => 'form-control col-md-7 col-xs-12',
                                            'data-validate-length-range' => '20',
                                            'placeholder' => 'first name',
                                            'required' => 'required',
                                            'autofocus' => 'autofocus',
                                        ]) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">Select School</label><span class="required"></span>
                                        <div>
                                        {{ Form::select("addmore[$key][child_school_name]", $schoolNames, $child->school_id ?? null, [
                                            'id' => "school_name_$key",
                                            'class' => 'school_select select2 form-control',
                                            'required' => 'required',
                                            'placeholder' => 'Select',
                                            'onchange' => "alert('Inline onchange works')"
                                        ]) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">School Classes</label><span class="required"></span>
                                        <div>
                                        {{ Form::select("addmore[$key][child_school_class]", $schoolClasses, $child->class_id ?? null, [
                                            'id' => "school_class_$key",
                                            'class' => 'school_class select2 form-control',
                                            'required' => 'required',
                                            'placeholder' => 'Select'
                                        ]) }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Child Image</label>
                                        <div>
                                            <div class="mb-3">
                                                <label for="child_image_{{ $key }}" class="form-label">Profile Picture</label>
                                                @if(!empty($child->image_url))
                                                    <div class="mb-2">
                                                        <img src="{{ $child->image_url }}" alt="Profile Picture" width="100">
                                                    </div>
                                                @endif
                                                <input type="file"
                                                    name="addmore[{{ $key }}][child_image]"
                                                    id="child_image_{{ $key }}"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Child Birth Date</label><span class="required"></span>
                                        <div class="input-daterange input-group" data-provide="datepicker">
                                            {{ Form::text("addmore[$key][dob]", @$child->dob, [
                                            'id' => 'child_dob_$key',
                                            'class' => 'form-control datepicker col-md-7 col-xs-12',
                                            'required' => 'required',
                                            'multiple' => 'multiple',
                                            'placeholder' => 'Select'
                                        ]) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Child Gender</label><span class="required"></span>
                                        <div>
                                         {{ Form::select("addmore[$key][child_gender]", $genders, $child->gender ?? null, [
                                            'id' => "child_gender_$key",
                                            'class' => 'select2 form-control',
                                            'required' => 'required',
                                            'placeholder' => 'Select'
                                        ]) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                @endforeach
                </div>
            </div>
        </div>

        <div class="row justify-content-end">
            <div class="col-lg-10">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset"  class="btn btn-primary w-md">Reset</button>
                    {{-- <a href="{{ route('parent.index')}}" class="btn btn-primary w-md">Back</a> --}}
            </div>
        </div>
        <br/>
    @endif
    {{ Form::close() }}

@endsection

@section('script')
    <script src="{{ URL::asset('build/libs/parsleyjs/parsley.min.js') }}"></script>

    <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>

    <!-- form repeater js -->
    <script src="{{ URL::asset('build/libs/jquery.repeater/jquery.repeater.min.js') }}"></script>

    <script src="{{ URL::asset('build/js/pages/task-create.init.js') }}"></script>

    <script type="text/javascript">
        var i = 0;

        $("#addMoreBtn").click(function() {

            i++;
            console.log("Value of I:" +i);
            var newField = `
                            <div id="existRow" class="row">
                                <div class="mb-3 row align-items-center">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label">Child First Name</label><span class="required"></span>
                                                <div>
                                                    <input type="text" name="addmore[${i}][child_fname]"
                                                        id = "addmore_${i}_child_fname"
                                                        class = "form-control col-md-7 col-xs-12"
                                                        data-validate-length-range = "20"
                                                        placeholder = "First Name"
                                                        required />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Child Last Name</label>
                                                <div>
                                                    <input type="text" name="addmore[${i}][child_lname]"
                                                        id = "addmore_${i}_child_lname"
                                                        class = "form-control col-md-7 col-xs-12"
                                                        data-validate-length-range = "20"
                                                        placeholder = "Last Name"
                                                        required />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label">Select School</label><span class="required"></span>
                                                <div>
                                                    <select name="addmore[${i}][child_school_name]" class="form-control select2 school_select" required>
                                                        <option value="">Select</option>
                                                        @foreach ($schoolNames as $id => $name)
                                                            <option value="{{ $id }}">{{ $name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">School Classes</label><span class="required"></span>
                                                <div>
                                                    <select name="addmore[${i}][child_school_class]" class="form-control select2 school_class" required>
                                                        <option value="">Select</option>
                                                        @foreach ($schoolClasses as $id => $name)
                                                            <option value="{{ $id }}">{{ $name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label class="form-label">Child Image</label>
                                                <div>
                                                    <input type="file" name="addmore[${i}][child_image]" class="form-control" />
                                                    <input type="hidden" name="old_child_icon" value="{{ @$data->child_image_url }}" />
                                                    @if (@$data->image_url)
                                                        <img src="{{ @$data->child_image_url }}" width="100px" />
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label class="form-label">Child Birth Date</label><span class="required"></span>
                                                <div class="input-daterange input-group" data-provide="datepicker">
                                                    <div>
                                                        <input type="text" name="addmore[${i}][child_dob]"
                                                        id = "addmore_${i}_child_dob"
                                                        class = "form-control datepicker col-md-7 col-xs-12"
                                                        data-validate-length-range = "20"
                                                        placeholder = "select date"

                                                        required />
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label class="form-label">Child Gender</label><span class="required"></span>
                                                <div>
                                                <select name="addmore[${i}][child_gender]" class="form-control select2" required>
                                                    <option value="">Select</option>
                                                    @foreach ($genders as $id => $name)
                                                        <option value="{{ $id }}">{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-10">
                                    <input type="button" class="deleteMoreBtn btn btn-warning" value="Delete" />
                                </div>

                            </div>`;

                            $('#newRow').append(newField);
        });

        $(document).on('click', '.deleteMoreBtn', function(){
            $(this).closest("#existRow").remove();
        });

    </script>

    <script>
        $(document).ready(function () {

             $(document).on('change', '.school_select', function() {
                console.log('school select onchange');

            let schoolId = $(this).val();

            var inputData = new FormData();
            inputData.append('schoolId', schoolId);

            axios.post('{{ route('parent.filterclasslist') }}', inputData)
                .then(response => {
                        if (response.data.classes) {
                            console.log(response.data.classes);
                             $('select.school_class')
                            .empty()
                            .append('<option selected="" value="">Select Class...</option>');

                        response.data.classes.forEach((singleClass) => {
                            const optionSingleClass = `<option value="${singleClass.id}">${singleClass.text}</option>`;
                            $('select.school_class').append(optionSingleClass);
                        });

                        $('select.school_class').select2({
                            allowClear: true,
                            placeholder: "Select Class...",
                        });
                    }
                })

                .catch(error => {
                    console.error('Error:', error);
                });

        });
        });


    </script>

@endsection
