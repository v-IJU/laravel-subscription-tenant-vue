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
            Users List
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="top_button mb-4">
                        <div class="d-flex align-items-center justify-content-end">

                            <div class="flex-shrink-0">
                                <a href="{{ route('user.create') }}" class="btn btn-primary">Add New User</a>
                                <a href="#!" class="btn btn-light"><i class="mdi mdi-refresh"></i></a>
                                <!-- <div class="dropdown d-inline-block">

                                        <button type="menu" class="btn btn-success" id="dropdownMenuButton1"
                                            data-bs-toggle="dropdown" aria-expanded="false" fdprocessedid="7mibg"><i
                                                class="mdi mdi-dots-vertical"></i></button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li><a class="dropdown-item" href="#">Action</a></li>
                                            <li><a class="dropdown-item" href="#">Another action</a></li>
                                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                                        </ul>
                                    </div> -->
                            </div>
                        </div>
                    </div>

                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>

                                <th>No</th>
                                <th>Image</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
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
        </div> <!-- end col -->
    </div> <!-- end row -->


@endsection
@section('script')
    <script>
        window.statuschange = '{{ route('user_action_from_admin') }}';
        $('document').ready(function() {

            var element = $("#datatable-buttons");
            var url = '{{ route('get_user_data_from_admin') }}';
            var column = [{
                    data: 'rownum',
                    defaultContent: '',
                    name: 'rownum',
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
                    data: 'first_name',
                    name: 'first_name',
                    width: '15%'
                },
                {
                    data: 'last_name',
                    name: 'last_name',
                    width: '15%'
                },
                {
                    data: 'username',
                    name: 'username',
                    width: '20%'
                },
                {
                    data: 'email',
                    name: 'email',
                    width: '10%',
                    className: 'textcenter'
                },
                {
                    data: 'mobile',
                    name: 'mobile',
                    className: 'textcenter'
                },
                {
                    data: 'group',
                    name: 'group',
                    className: 'textcenter'
                },
                {
                    data: 'status',
                    name: 'users.status',
                    sortable: false,
                    className: 'textcenter'
                },
                {
                    data: 'action',
                    name: 'users.id',
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
