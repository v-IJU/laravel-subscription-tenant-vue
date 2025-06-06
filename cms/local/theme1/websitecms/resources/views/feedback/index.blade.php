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
            Feedback Form
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
                                    data-bs-target="#add_feedback_modal">Add New Feedback
                                </a>
                                {{ Form::hidden('indexPopupUrl', url('administrator/feedback'), ['id' => 'indexPopupUrl']) }}
                                {{ Form::hidden('indexPopupCreateUrl', route('feedback.store'), ['id' => 'indexPopupCreateUrl']) }}
                                @include('websitecms::feedback.create-modal')
                                @include('websitecms::feedback.edit-modal')
                            </div>
                        </div>
                    </div>

                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th class="noExport">Image</th>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Description</th>
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
        window.statuschange = '{{ route('websitecms_feedback_action_from_admin') }}';
        window.update_feedback = "{{ route('update_feedback') }}";
        $('document').ready(function() {

            var element = $("#datatable-buttons");
            window.element = element;
            var url = '{{ route('get_websitecms_feedback_data_from_admin') }}';
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
                    data: 'name',
                    name: 'name',
                    width: '15%'
                },
                 {
                    data: 'designation',
                    name: 'designation',
                    width: '15%'
                },
                {
                    data: 'message',
                    name: 'message',
                    width: '60%',
                    render: function(data, type, row, meta) {
                        // You could also manipulate the content before rendering if needed
                        return '<div style="word-wrap: break-word; overflow-wrap: break-word; white-space: normal;">' + data + '</div>';
                    }
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
