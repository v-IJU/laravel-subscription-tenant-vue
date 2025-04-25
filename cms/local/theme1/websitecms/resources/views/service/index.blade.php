@extends('layouts.master')

@section('title', 'users')
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
            Services
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="top_button mb-4">
                        <div class="d-flex align-items-center justify-content-end">

                            <div class="flex-shrink-0">
                                <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#add_service_modal">Add New Service
                                </a>
                                {{ Form::hidden('indexPopupUrl', url('administrator/service'), ['id' => 'indexPopupUrl']) }}
                                {{ Form::hidden('indexPopupCreateUrl', route('service.store'), ['id' => 'indexPopupCreateUrl']) }}
                                @include('websitecms::service.create-modal')
                                @include('websitecms::service.edit-modal')
                            </div>
                        </div>
                    </div>

                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Service Name</th>
                                <th>Description</th>
                                <th>Status</th>
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
        window.statuschange = '{{ route('websitecms_service_action_from_admin') }}';
        $('document').ready(function() {

            var element = $("#datatable-buttons");
            window.element = element;
            var url = '{{ route('get_websitecms_service_data_from_admin') }}';
            var column = [{
                    data: 'DT_RowIndex',
                    defaultContent: '',
                    name: 'DT_RowIndex',
                    searchable: false,
                    sortable: false,
                    className: 'textcenter'
                },
                {
                    data: 'service_name',
                    name: 'service_name',
                    width: '15%'
                },
                {
                    data: 'description',
                    name: 'description',
                    width: '20%'
                },
                {
                    data: 'status',
                    name: 'status',
                    sortable: false,
                    className: 'textcenter'
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
