@extends('layouts.master')

@section('title', 'file manager')
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
            Product Filemanager
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <iframe src="/filemanager" style="width: 100%; height: 700px; overflow: hidden; border: none;"></iframe>
                    {{-- render file manager --}}

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->


@endsection
