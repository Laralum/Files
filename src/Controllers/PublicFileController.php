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
    public function display(File $file)
    {
        $file->increment('views');

        if (!$file->public) {
            $this->authorize('view', File::class);
        }

        return response()->file($file->getPath(true));
    }
}
