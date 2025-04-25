@extends('layouts.master')

@section('title', 'Import Log')
@section('style')
    {!! Cms::style('theme/vendors/switchery/dist/switchery.min.css') !!}
    {!! Cms::style('theme/vendors/select2/select2.css') !!}
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            DashBoard
        @endslot
        @slot('title')
            Logs
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-xl-12">

            <h2>📜 Import Log</h2>
            <pre style="background: #000; color: #0f0; padding: 10px; overflow:auto; height: 500px;">{{ $filteredLogs }}</pre>

        </div>
    </div>


    </div>
@endsection


@section('script')
    <script src="{{ URL::asset('build/libs/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>

@endsection
