<?php

namespace Laralum\Files\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laralum\Users\Models\User;

class FileController extends Controller
{
    public function upload()
    {
        return view('laralum_files::laralum.upload');
    }

    public function save(Request $request)
    {
        $file = $request->file('file');
        $name = time().'-'.str_limit($file->getClientOriginalName(), 150, '');

        $file->move('laralum/files', $name);
        return "File uploaded";
    }
}
