<?php

namespace Laralum\Files\Controllers;

use Illuminate\Http\Request;
use Laralum\Users\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Laralum\Files\Models\File as FileORM;

class FileController extends Controller
{
    public function index()
    {
        $files = FileORM::orderByDesc('id')->paginate(50);
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

        $path = 'files';

        $fileORM = FileORM::create([
            'name'    => str_limit($file->getClientOriginalName(), 150, ''),
            'user_id' => Auth::id(),
            'path'    => $path,
            'public'  => $request->public,
        ]);

        $fileORM->update([
            'real_name' => $fileORM->id.'.'.$file->getClientOriginalExtension()
        ]);

        $name = $fileORM->id.'.'.$file->getClientOriginalExtension();

        if ($request->public) {
            $file->move($path, $name);
        } else {
            // Add private/ to ensure that path isn't public directly and avoid
            // unwanted publish
            Storage::putFileAs('private/'.$path, $file, $name);
        }

        return route('laralum::files.display', ['file' => $fileORM]);
    }

    public function confirmDestroy(FileORM $file)
    {
        return view('laralum::pages.confirmation', [
            'method'  => 'DELETE',
            'message' => __('laralum_events::general.sure_del_files', ['file' => $file->name]),
            'action'  => route('laralum::files.destroy', ['file' => $file->id]),
        ]);
    }

    public function display(FileORM $file)
    {
        $file->increment('views');

        if ($file->public) {
            $this->authorize('view', FileORM::class);
        }

        return response()->file($file->getPath(true));
    }

    public function download(FileORM $file)
    {
        $file->increment('downloads');

        return response()->download($file->getPath(true), $file->name);
    }

    public function destroy(FileORM $file)
    {
        if ($file->public) {
            File::delete($file->getPath());
            $file->delete();
        } else {
            Storage::delete($file->getPath());
            $file->delete();
        }

        return redirect()->route('laralum::files.index')->with('success', __('laralum_files::general.file_deleted', ['name' => $file->name]));
    }
}
