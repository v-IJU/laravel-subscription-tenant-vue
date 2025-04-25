@extends('layouts.master')

@section('title','parent')
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
            Contact Us- Form
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Subject</th>
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

        $('document').ready(function() {

            var element = $("#datatable-buttons");
            var url = '{{ route('get_contact_us_data_from_admin') }}';
            var column = [{
                    data: 'DT_RowIndex',
                    defaultContent: '',
                    name: 'DT_RowIndex',
                    searchable: false,
                    sortable: false,
                    className: 'textcenter'
                },
                {
                    data: 'first_name',
                    name: 'first_name',
                    width: '15%'
                },
                {
                    data: 'phone',
                    name: 'phone',
                    width: '20%'
                },
                {
                    data: 'email',
                    name: 'email',
                    width: '20%'
                },
                {
                    data: 'subject',
                    name: 'subject',
                    width: '20%'
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
