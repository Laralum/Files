<?php

namespace Laralum\Files\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laralum\Files\Models\Settings;

class SettingsController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->authorize('update', Settings::class);

        $this->validate($request, [
            'public_url'     => 'required|max:191',
            'public_routes'  => 'required|boolean',
        ]);

        Settings::first()->update([
            'public_url'     => $request->input('public_url'),
            'public_routes'  => $request->input('public_routes'),
        ]);

        return redirect()->route('laralum::settings.index', ['p' => 'Files'])->with('success', __('laralum_files::general.files_settings_updated'));
    }
}
