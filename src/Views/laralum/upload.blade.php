@php
    $settings = \Laralum\Files\Models\Settings::first();
@endphp
@extends('laralum::layouts.master')
@section('icon', 'ion-ios-cloud-upload')
@section('title', __('laralum_events::general.create_event'))
@section('subtitle', __('laralum_events::general.create_event_desc'))
@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                        <form class="uk-form-stacked" method="POST" action="{{ route('laralum::events.store') }}">
                            {{ csrf_field() }}
                            <fieldset class="uk-fieldset">


                                <div class="uk-margin">
                                    <label class="uk-form-label">@lang('laralum_events::general.title')</label>
                                    <div class="uk-form-controls">
                                        <input value="{{ old('title') }}" name="title" class="uk-input" type="text" placeholder="@lang('laralum_events::general.title_ph')">
                                    </div>
                                </div>

    <div class="test-upload uk-placeholder uk-text-center">
        <span uk-icon="icon: cloud-upload"></span>
        <span class="uk-text-middle">Attach binaries by dropping them here or</span>
        <div uk-form-custom>
            <input type="file" multiple>
            <span class="uk-link">selecting one</span>
        </div>
    </div>

    <progress id="progressbar" class="uk-progress" value="0" max="100" hidden></progress>

    <script>
    console.log($('meta[name="csrf-token"]').attr('content'));
        (function ($) {

            var bar = $("#progressbar")[0];

            UIkit.upload('.test-upload', {

                url: '',
                multiple: true,
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                },
                beforeAll: function() { console.log('beforeAll', arguments); },
                load: function() { console.log('load', arguments); },
                error: function() { console.log('error', arguments); },
                complete: function() { console.log('complete', arguments); },

                loadStart: function (e) {
                    console.log('loadStart', arguments);

                    bar.removeAttribute('hidden');
                    bar.max =  e.total;
                    bar.value =  e.loaded;
                },

                progress: function (e) {
                    console.log('progress', arguments);
                    bar.max =  e.total;
                    bar.value =  e.loaded;
                },

                loadEnd: function (e) {
                    console.log('loadEnd', arguments);
                    bar.max =  e.total;
                    bar.value =  e.loaded;
                },

                completeAll: function () {
                    console.log('completeAll', arguments);
                    setTimeout(function () {
                        bar.setAttribute('hidden', 'hidden');
                    }, 1000);

                    alert('Upload Completed');
                }
            });

        })(jQuery);

    </script>


                                <div class="uk-margin">
                                    <button type="submit" class="uk-button uk-button-primary uk-align-right">
                                        <span class="ion-forward"></span>&nbsp; {{ __('laralum_events::general.create_event') }}
                                    </button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
            <div class="uk-width-1-1@s uk-width-3-5@l"></div>
        </div>
    </div>
@endsection
