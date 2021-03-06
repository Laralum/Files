@php
    $settings = \Laralum\Files\Models\Settings::first();
@endphp
@extends('laralum::layouts.master')
@section('icon', 'ion-upload')
@section('title', __('laralum_files::general.upload_file'))
@section('subtitle', __('laralum_files::general.upload_file_desc'))
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/dropzone.css">
@endsection
@section('breadcrumb')
    <ul class="uk-breadcrumb">
        <li><a href="{{ route('laralum::index') }}">@lang('laralum_files::general.home')</a></li>
        <li><a href="{{ route('laralum::files.index') }}">@lang('laralum_files::general.file_list')</a></li>
        <li><span>@lang('laralum_files::general.upload_file')</span></li>
    </ul>
@endsection
@section('content')
    <div class="uk-container uk-container-large">
        <div uk-grid>
            <div class="uk-width-1-1@s uk-width-1-5@l"></div>
            <div class="uk-width-1-1@s uk-width-3-5@l">
                <div class="uk-card uk-card-default">
                    <div class="uk-card-header">
                        {{ __('laralum_files::general.upload_file') }}
                    </div>
                    <div class="uk-card-body">
                        <form class='dropzone' action="{{ route('laralum::files.save') }}" method='POST'>
                            {{ csrf_field() }}
                            <div class='dz-message'><span class='ion-ios-cloud-upload-outline' style='font-size:50px;vertical-align:middle'></span>&emsp;@lang('laralum_files::general.drop_public_files')</div>
                            <input value='1' hidden='hidden' name='public'/>
                        </form>

                        <br>

                        <form class='dropzone' action="{{ route('laralum::files.save') }}" method='POST'>
                            {{ csrf_field() }}
                            <div class='dz-message'><span class='ion-ios-cloud-upload-outline' style='font-size:50px;vertical-align:middle'></span>&emsp;@lang('laralum_files::general.drop_private_files')</div>
                            <input value='0' hidden='hidden' name='public'/>
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
