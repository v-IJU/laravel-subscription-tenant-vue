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
            User Group
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="top_button ">
                        <div class="d-flex align-items-center justify-content-end">

                            <div class="flex-shrink-0">
                                <a href="{{ route('usergroup.create') }}" class="btn btn-primary">Add New Group</a>


                            </div>
                        </div>
                    </div>

                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100 p-5">
                        <thead>
                            <tr>

                                <th>No</th>
                                <th>Group</th>
                                <th>Status</th>

                                <th class="noExport">Action</th>
                            </tr>
                        </thead>


                        <tbody>

                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div> <!-- end col -->



@endsection
@section('script')
    <script>
        $('document').ready(function() {
            window.statuschange='{{route('usergroup_action_from_admin')}}';
            var element = $("#datatable-buttons");
            var url = '{{ route('get_user_group_data_from_admin') }}';
            var column = [{
                    data: 'rownum',
                    defaultContent: '',
                    name: 'rownum',
                    searchable: false,
                    sortable: false,
                    className: 'textcenter'
                },
                {
                    data: 'group',
                    name: 'group',
                    width: '35%'
                },
                {
                    data: 'status',
                    name: 'usergroup.status',
                    sortable: false,
                    className: 'textcenter'
                },
                {
                    data: 'action',
                    name: 'usergroup.id',
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
                        url: "{{ route('user_group_action_from_admin', 1) }}"
                    },
                    {
                        name: "Un Publish",
                        url: "{{ route('user_group_action_from_admin', 0) }}"
                    },
                    {
                        name: "Trash",
                        url: "{{ route('user_group_action_from_admin', -1) }}"
                    },
                    {
                        name: "Delete",
                        url: "{{ route('usergroup.destroy', 1) }}",
                        method: "DELETE"
                    }
                ],

            }


            dataTable(element, url, column, csrf, options);

        });
    </script>

@endsection
