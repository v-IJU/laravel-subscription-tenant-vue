@extends('layouts.master')

@section('title', 'product')
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
Product lists
@endslot
@endcomponent
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="top_button mb-4">
                    <div class="d-flex align-items-center justify-content-end">
                        <div class="flex-shrink-0 ">
                            <a href="{{ route('product.import') }}" class="btn btn-info">Import Product</a>
                        </div>
                        <div class="flex-shrink-0 ms-1">
                            <a href="{{ route('product.create') }}" class="btn btn-primary">Add New Product</a>
                        </div>
                    </div>
                </div>

                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th class="noExport">Image</th>
                            <th>Item Code</th>
                            <th>Product Name</th>
                            <th>School Name</th>
                            <th>Class Name</th>
                            {{-- <th>Variant Product</th> --}}
                            <th class="noExport">Status</th>
                            <th class="noExport">Action</th>
                        </tr>
                    </thead>


                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->


@endsection
@section('script')
<script>
    window.statuschange = '{{ route('product_action_from_admin') }}';
        $('document').ready(function() {

            var element = $("#datatable-buttons");
            var url = '{{ route('get_product_data_from_admin') }}';
            var column = [{
                    data: 'DT_RowIndex',
                    defaultContent: '',
                    name: 'DT_RowIndex',
                    searchable: false,
                    sortable: false,
                    className: 'textcenter'
                },
                {
                    data: 'pimage',
                    name: 'pimage',
                    width: '15%'
                },
                {
                    data: 'product_code',
                    name: 'product_code',
                    width: '15%'
                },
                {
                    data: 'product_name',
                    name: 'product_name',
                    width: '20%'
                },
                {
                    data: 'school_name',
                    name: 'school_master.school_name',
                    width: '20%'
                },
                {
                    data: 'class_name',
                    name: 'school_class.name',
                    width: '20%'
                },
                // {
                //     data: 'is_variable_product',
                //     name: 'is_variable_product',
                //     width: '20%'
                // },
                {
                    data: 'status',
                    name: 'id',
                    searchable: false,
                    sortable: false,
                    width: '15%',
                },
                {
                    data: 'action',
                    name: 'id',
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
</script>

@endsection