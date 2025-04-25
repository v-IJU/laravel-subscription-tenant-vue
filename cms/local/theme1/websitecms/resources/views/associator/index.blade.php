@extends('layouts.master')

@section('title', 'users')
@section('style')
    <!-- Datatables -->
    @include('layout::admin.head.list_head')
    <style>
        .table-div table {
            width: 100% !important;
        }
        .wrap-text {
            word-wrap: break-word;
            white-space: normal;
            overflow-wrap: break-word;
        }
    </style>


@endsection
@section('content')

    @component('components.breadcrumb')
        @slot('li_1')
            Dashboard
        @endslot
        @slot('title')
            Associator Form
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
                                    data-bs-target="#add_associator_modal">Add New Associator
                                </a>
                                {{ Form::hidden('indexPopupUrl', url('administrator/associator'), ['id' => 'indexPopupUrl']) }}
                                {{ Form::hidden('indexPopupCreateUrl', route('associator.store'), ['id' => 'indexPopupCreateUrl']) }}
                                @include('websitecms::associator.create-modal')
                                @include('websitecms::associator.edit-modal')
                            </div>
                        </div>
                    </div>

                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th class="noExport">Logos</th>
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
        window.statuschange = '{{ route('websitecms_associator_action_from_admin') }}';
        window.update_associator = "{{ route('update_associator') }}";
        $('document').ready(function() {

            var element = $("#datatable-buttons");
            window.element = element;
            var url = '{{ route('get_websitecms_associator_data_from_admin') }}';
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
                    name: 'created_at',
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
                order : [ [ 1, "desc" ] ],
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
