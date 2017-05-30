<?php

namespace Laralum\Files\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laralum\Users\Models\User;
use Laralum\Files\Models\File as FileORM;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index()
    {
        return view('laralum_files::laralum.index');
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
            'path'   => 'required',
            'public' => 'required|boolean',
        ]);

        $fileORM = FileORM::create([
            'name' => str_limit($file->getClientOriginalName(), 150, ''),
            'real_name' => time().'.'.$file->getClientOriginalExtension(),
            'path' => $request->path,
            'public' => true,
        ]);

        $fileORM->update(['real_name' => $fileORM->id.'.'.$file->getClientOriginalExtension()]);

        $name = $fileORM->id.'.'.$file->getClientOriginalExtension();

        Storage::putFileAs($request->public ? 'public/'.$request->path : 'private/'.$request->path, $file, $name);

        return $fileORM->getFileURL();
    }

    public function delete(FileORM $file)
    {
        return view('laralum_files::laralum.index');

        return view('laralum::pages.confirmation', [
            'method'  => 'DELETE',
            'message' => __('laralum_events::general.sure_del_files', ['file' => $file->name]),
            'action'  => route('laralum::files.destroy', ['file' => $file->id]),
        ]);
    }

    public function destroy(FileORM $file)
    {
        File::delete('real_name');
    }
}
