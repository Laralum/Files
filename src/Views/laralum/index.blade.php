@php
    $settings = \Laralum\Files\Models\Settings::first();
@endphp
@extends('laralum::layouts.master')
@section('icon', 'ion-folder')
@section('title', __('laralum_files::general.file_list'))
@section('subtitle', __('laralum_files::general.file_list_desc'))
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/dropzone.css">
@endsection
@section('breadcrumb')
    <ul class="uk-breadcrumb">
        <li><a href="{{ route('laralum::index') }}">@lang('laralum_files::general.home')</a></li>
        <li>@lang('laralum_files::general.file_list')</li>
    </ul>
@endsection
@section('content')
    <div class="uk-container uk-container-large">
        <div class="uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-3@m uk-child-width-1-4@l uk-grid-match" uk-grid>
            @foreach ($files as $file)
                <div>
                    <div class="uk-card uk-card-default uk-card-body uk-text-center">
                        <span class="{{ $file->icon() }}" style="font-size:40px"></span>
                        <h3 class="uk-card-title uk-text-break">{{ $file->name }}<span class="uk-text-muted">.{{ $file->extension() }}</span></h3>
                        @if ($file->public)
                            <p class="uk-label uk-label-success">@lang('laralum_files::general.public')</p>
                        @else
                            <p class="uk-label">@lang('laralum_files::general.private')</p>
                        @endif
                        <br>
                        <span class="ion-eye"></span>&nbsp;&nbsp;{{ $file->views }}&emsp;&emsp;<span class="ion-android-download"></span>&nbsp;&nbsp;{{ $file->downloads }}
                        <div class="uk-margin-small-top">
                            <br>
                            <button class="btn uk-button uk-button-default uk-button-small uk-width-1-1" data-clipboard-text="{{ route('laralum::files.display', ['file' => $file]) }}">
                                @lang('laralum_files::general.copy_to_clipboard')
                            </button>
                            <a class="btn uk-button uk-button-default uk-button-small uk-width-1-1 uk-margin-small-top" href="{{ route('laralum::files.download', ['file' => $file]) }}">
                                @lang('laralum_files::general.download')
                            </a>
                            <a class="btn uk-button uk-button-default uk-button-small uk-width-1-1 uk-margin-small-top" href="{{ route('laralum::files.edit', ['file' => $file]) }}">
                                @lang('laralum_files::general.edit')
                            </a>
                            <div class="uk-child-width-1-2 uk-margin-small-top" uk-grid>
                                <div>
                                    <a class="uk-button uk-button-danger uk-button-small uk-align-left uk-width-1-1" href="{{ route('laralum::files.destroy.confirm', ['file' => $file->id]) }}"><span class="ion-trash-b"></span></a>
                                </div>
                                <div>
                                    <a class="uk-button uk-button-primary uk-button-small uk-align-right uk-width-1-1" href="{{ route('laralum::files.display', ['file' => $file]) }}"><span class="ion-eye"></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <br>
        {{ $files->links('laralum::layouts.pagination') }}
    </div>
@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.6.1/clipboard.min.js"></script>
    <script>
        new Clipboard('.btn');
    </script>
@endsection
