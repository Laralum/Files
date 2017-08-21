<?php

namespace Laralum\Files\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Laralum\Files\Models\File;
use Laralum\Users\Models\User;

class FileController extends Controller
{
    public function index()
    {
        $files = File::orderByDesc('id')->paginate(50);

        return view('laralum_files::laralum.index', ['files' => $files]);
    }

    public function upload()
    {
        return view('laralum_files::laralum.upload');
    }

    public function save(Request $request)
    {
        $file = $request->file('file');

        $this->validate($request, [
            'file'   => 'file',
            'public' => 'required|boolean',
        ]);

        $user = User::findOrFail(Auth::id());

        $fileORM = File::create([
            'name'    => str_limit(rtrim($file->getClientOriginalName(), '.'.$file->getClientOriginalExtension()), 191, ''),
            'user_id' => Auth::id(),
            'public'  => $user->can('publish', File::class) ? $request->public : false,
        ]);

        $fileORM->update([
            'real_name' => $fileORM->id.'.'.$file->getClientOriginalExtension(),
        ]);

        $name = $fileORM->id.'.'.$file->getClientOriginalExtension();

        Storage::putFileAs('laralum/files', $file, $name);

        return route('laralum::files.display', ['file' => $fileORM]);
    }

    public function edit(File $file)
    {
        return view('laralum_files::laralum.edit', ['file' => $file]);
    }

    public function update(Request $request, File $file)
    {
        $this->authorize('update', File::class);
        $this->validate($request, [
            'name'   => 'required|max:191',
            'public' => 'required|boolean',
        ]);

        $user = User::findOrFail(Auth::id());

        $file->update([
            'name'    => $request->name,
            'public'  => $user->can('publish', File::class) ? $request->public : false,
        ]);
        $file->touch();

        return redirect()->route('laralum::files.index')->with('success', __('laralum_files::general.file_updated', ['name' => $file->name]));
    }

    public function confirmDestroy(File $file)
    {
        return view('laralum::pages.confirmation', [
            'method'  => 'DELETE',
            'message' => __('laralum_files::general.sure_del_file', ['name' => $file->name]),
            'action'  => route('laralum::files.destroy', ['file' => $file->id]),
        ]);
    }

    public function display(File $file)
    {
        $file->increment('views');

        if (!$file->public) {
            $this->authorize('view', File::class);
        }

        return response()->file($file->getPath(true));
    }

    public function download(File $file)
    {
        $file->increment('downloads');

        return response()->download($file->getPath(true), $file->name.'.'.$file->extension());
    }

    public function destroy(File $file)
    {
        Storage::delete($file->getPath());
        $file->delete();

        return redirect()->route('laralum::files.index')->with('success', __('laralum_files::general.file_deleted', ['name' => $file->name]));
    }
}
