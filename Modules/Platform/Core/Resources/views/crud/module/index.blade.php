@extends('layouts.app')

@section('content')

    <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>

                            <div class="header-buttons">
                                @if($settingsPermission != '' && Auth::user()->hasPermissionTo($settingsPermission))
                                    @if(count($moduleSettingsLinks) > 0 )
                                    <div class="btn-group btn-crud pull-right">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            @lang('core::core.settings') <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            @foreach($moduleSettingsLinks as $link)
                                             <li>
                                                 <a href="{{ route($link['route']) }}">{{ trans($language_file.'.'.$link['label']) }}</a>
                                             </li>
                                            @endforeach

                                        </ul>
                                    </div>
                                    @endif
                                @endif

                                @if($permissions['create'] == '' or Auth::user()->hasPermissionTo($permissions['create']))
                                    <a href="{{ route($routes['create']) }}" title="@lang('core::core.crud.create')" class="btn btn-primary btn-create btn-crud">@lang('core::core.crud.create')</a>
                                @endif
                                @if($settingsBackRoute != '')
                                    <a href="{{ route($settingsBackRoute) }}" title="@lang('core::core.crud.back')" class="btn btn-default btn-crud">@lang('core::core.crud.back')</a>
                                @endif
                            </div>
                            <div class="header-text">
                                @lang($language_file.'.module')  - @lang('core::core.crud.list')
                                <small>@lang($language_file.'.module_description')</small>
                            </div>

                        </h2>


                    </div>
                    <div class="body">

                        <div class="table-responsive  col-lg-12 col-md-12 col-sm-12">
                            {!! $dataTable->table(['width' => '100%']) !!}
                        </div>

                    </div>
                </div>
            </div>

    </div>




@endsection

@push('css')
    @foreach($cssFiles as $file)
        <link rel="stylesheet" href="{!! Module::asset($moduleName.':css/'.$file) !!}"></link>
    @endforeach
@endpush

@push('scripts')
    @foreach($jsFiles as $jsFile)
        <script src="{!! Module::asset($moduleName.':js/'.$jsFile) !!}"></script>
    @endforeach
@endpush

@push('scripts')
    {!! $dataTable->scripts() !!}
@endpush


