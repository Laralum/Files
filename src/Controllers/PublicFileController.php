<?php

namespace Laralum\Files\Controllers;

use App\Http\Controllers\Controller;
use Laralum\Files\Models\File;

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
