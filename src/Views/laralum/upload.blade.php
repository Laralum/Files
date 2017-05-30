@php
    $settings = \Laralum\Files\Models\Settings::first();
@endphp
@extends('laralum::layouts.master')
@section('icon', 'ion-ios-cloud-upload')
@section('title', __('laralum_events::general.create_event'))
@section('subtitle', __('laralum_events::general.create_event_desc'))
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/dropzone.css">
@endsection
@section('breadcrumb')
    <ul class="uk-breadcrumb">
        <li><a href="{{ route('laralum::index') }}">@lang('laralum_events::general.home')</a></li>
        <li><a href="{{ route('laralum::events.index') }}">@lang('laralum_events::general.events_list')</a></li>
        <li><span>@lang('laralum_events::general.create_event')</span></li>
    </ul>
@endsection
@section('content')
    <div class="uk-container uk-container-large">
        <div uk-grid>
            <div class="uk-width-1-1@s uk-width-1-5@l"></div>
            <div class="uk-width-1-1@s uk-width-3-5@l">
                <div class="uk-card uk-card-default">
                    <div class="uk-card-header">
                        {{ __('laralum_events::general.create_event') }}
                    </div>
                    <div class="uk-card-body">
                        <form class="dropzone" action="{{ route('laralum::files.save') }}" method="POST">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </div>
            </div>
            <div class="uk-width-1-1@s uk-width-3-5@l"></div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/dropzone.js"></script>
@endsection
