@extends('layouts.master')


@section('style')
@endsection


@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            DashBoard
        @endslot
        @slot('title')
            Permissions
        @endslot
    @endcomponent
    <div id="admin-role-page" class="row">
        <div class="card">
            <div class="card-body">
                {{ Form::open(['role' => 'form', 'route' => ['save_roles_from_admin'], 'method' => 'post', 'class' => 'form-horizontal form-label-left', 'id' => 'role-form']) }}
                <div class="row">


                    <div class="col-xs-12 col-sm-3 col-md-3">
                        <!-- Nav tabs -->
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            @foreach ($groups as $group)
                                <a class="nav-link mb-2 {{ $loop->iteration == 1 ? 'active' : '' }}" id="v-pills-home-tab"
                                    data-bs-toggle="pill" href="#group-{{ str_replace(' ', '', $group->group) }}"
                                    role="tab" aria-controls="v-pills-{{ str_replace(' ', '', $group->group) }}"
                                    aria-selected="true">{{ $group->group }}</a>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-9 col-md-9">


                        <div class="tab-content text-muted mt-4 mt-md-0" id="v-pills-tabContent">
                            @foreach ($groups as $group)
                                <div class="tab-pane {{ $loop->iteration == 1 ? 'active' : '' }}"
                                    id="group-{{ str_replace(' ', '', $group->group) }}">
                                    <div class="row">
                                        @foreach ($module as $key => $value)
                                            @if (count((array) $value->permissions) != 0)
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <fieldset>
                                                        <legend>{{ $value->name }}</legend>
                                                        @foreach ($value->permissions as $values)
                                                            <input type="hidden"
                                                                id="role-hidden-{{ $group->group . '-' . $values->id }}"
                                                                name="role[{{ $group->id }}][{{ $values->id }}]"
                                                                value="0" />
                                                            {!! Form::checkbox(
                                                                'role[' . $group->id . '][' . $values->id . ']',
                                                                '1',
                                                                @$permission[$group->id][$values->id] == 1 ? true : false,
                                                                ['id' => 'role-' . $group->group . '-' . $values->id],
                                                            ) !!}
                                                            <label
                                                                for="role-{{ $group->group . '-' . $values->id }}">{{ $values->name }}</label>
                                                            <br />
                                                        @endforeach
                                                    </fieldset>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>

                </div>

                <div>
                    <button type="submit" class="btn btn-primary w-md">Submit</button>
                </div>
                {{ Form::close() }}


            </div>
        </div>

    </div>
@endsection
