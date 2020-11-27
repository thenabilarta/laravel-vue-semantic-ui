@extends('layouts.app')

@section('content')

    <div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>

                            <div class="header-buttons">
                                <a href="{{ route($routes['show'],$entity) }}" title="@lang('core::core.crud.back')" class="btn btn-primary btn-back btn-crud">@lang('core::core.crud.back')</a>
                            </div>
                            <div class="header-text">
                                @lang($language_file.'.module')  - @lang('core::core.crud.edit')
                                <small>@lang($language_file.'.module_description')</small>
                            </div>
                        </h2>


                    </div>
                    <div class="body">
                        <div class="row">


                            {!! form_start($form) !!}

                            @foreach($show_fields as $panelName => $panel)

                                    {{ Html::section($language_file,$panelName,$sectionButtons) }}


                                    @foreach($panel as $fieldName => $options)

                                        @if(!isset($options['hide_in_form']))
                                            @if($loop->iteration % 2 == 0)
                                                <div class="{{ isset($options['col-class']) ? $options['col-class'] : 'col-lg-6 col-md-6 col-sm-6' }}">
                                            @else
                                                <div class="{{ isset($options['col-class']) ? $options['col-class'] : 'col-lg-6 col-md-6 col-sm-6 clear-left' }}">
                                            @endif

                                               {!! form_row($form->{$fieldName}) !!}
                                            </div>
                                        @endif

                                    @endforeach

                            @endforeach



                            {!! form_end($form, $renderRest = true) !!}

                    </div>

                        </div>
                </div>
            </div>
        </div>

        @foreach($includeViews as $v)
            @include($v)
        @endforeach



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



@if($form_request != null )
    @push('scripts')
        {!! JsValidator::formRequest($form_request, '#module_form') !!}
    @endpush
@endif
