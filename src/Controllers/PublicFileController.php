<?php

namespace Laralum\Files\Controllers;

use Laralum\Users\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Laralum\Files\Models\File;
use Illuminate\Http\Request;

class PublicFileController extends Controller
{
    public function display($file)
    {
        $file = File::where('real_name', $file)->first();

        if (!$file) {
            abort(404, 'File not Found');
        }

        if (!$file->public) {
            $this->authorize('view', File::class);
        }

        $file->increment('views');

        return response()->file($file->getPath(true));
    }
}
