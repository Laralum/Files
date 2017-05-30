<?php

if (\Illuminate\Support\Facades\Schema::hasTable('laralum_files_settings')) {
    $public_url = \Laralum\Files\Models\Settings::first()->public_url;
    $public_routes = \Laralum\Files\Models\Settings::first()->public_routes;
} else {
    $public_url = 'files';
    $public_routes = true;
}

// Public Routes
if ($public_routes) {
    Route::group([
            'middleware' => [
                'web', 'laralum.base',
            ],
            'namespace' => 'Laralum\Files\Controllers',
            'as'        => 'laralum_public::files.',
        ], function () use ($public_url) {
            Route::post($public_url.'/{filename}', 'PublicFileController@show')->name('show');
        });
}

// Administration Routes
Route::group([
        'middleware' => [
            'web', 'laralum.base', 'laralum.auth',
            // 'can:access-files',
        ],
        'prefix'    => config('laralum.settings.base_url'),
        'namespace' => 'Laralum\Files\Controllers',
        'as'        => 'laralum::',
    ], function () {
        Route::get('files', 'FileController@index')->name('files.index');
        Route::get('files/upload', 'FileController@upload')->name('files.upload');
        Route::post('files/upload', 'FileController@save')->name('files.save');
        Route::get('files/{filename}/delete', 'FileController@confirmDestroy')->name('files.destroy.confirm');
        Route::post('files/{filename}/delete', 'FileController@confirmDestroy')->name('files.destroy');
    });

// Settings Routes
Route::group([
        'middleware' => [
            'web', 'laralum.base', 'laralum.auth',
            'can:access,Laralum\Files\Models\Settings',
        ],
        'prefix'    => config('laralum.settings.base_url'),
        'namespace' => 'Laralum\Files\Controllers',
        'as'        => 'laralum::files.',
    ], function () {
        Route::post('/files/settings', 'SettingsController@update')->name('settings.update');
    });
