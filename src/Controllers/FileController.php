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

    public function save($request)
    {
        User::first()->update([
            'name' => 'eeeeeeeeeeeeeeegreeee'
        ]);
        // if (isset($_FILES['files'])) {
        //     User::first()->update([
        //         'name' => 'sireq'
        //     ]);
        //     for($i=0;$i<count($_FILES['files']['name']);$i++){
        //             foreach($_FILES['files'] as $v=>$file) {
        //                 $errors = array();
        //                 $file_name = $_FILES['files']['name'][$i];
        //                 \Laralum\Users\Model\User::first()->update([
        //                     'name' => $file_name
        //                 ]);
        //                 $file_size = $_FILES['files']['size'][$i];
        //                 $file_tmp = $_FILES['files']['tmp_name'][$i];
        //                 $file_type = $_FILES['files']['type'][$i];
        //                 $file_ext = strtolower(end(explode('.',$_FILES['files']['name'][$i])));
        //             }
        //         }
        // } else {
        //     User::first()->update([
        //         'name' => 'noreq'
        //     ]);
        // }
        // // if $request->files
        // // return view('laralum_files::laralum.upload');
        // return '200';
    }
}
