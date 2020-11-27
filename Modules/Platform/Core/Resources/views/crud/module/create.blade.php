@extends('layouts.app')

@section('content')

    <div class="row">


        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        <div class="header-buttons">
                            <a href="{{ route($routes['index']) }}" title="@lang('core::core.crud.back')" class="btn btn-primary btn-back btn-crud">@lang('core::core.crud.back')</a>
                        </div>

                        <div class="header-text">
                            @lang($language_file.'.module') - @lang('core::core.crud.create')
                            <small>@lang($language_file.'.module_description')</small>
                        </div>

                    </h2>


                </div>
                <div class="body">

                    @include('core::crud.module.create_form')
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


    @if($form_request != null && !$modal_form)
        @push('scripts')
            {!! JsValidator::formRequest($form_request, '#module_form') !!}
        @endpush
    @endif
