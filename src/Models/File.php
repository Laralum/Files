<?php

namespace Laralum\Files\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'laralum_files';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'real_name', 'public', 'path', 'password'];

    public function getFileURL()
    {
        return asset(Storage::url($this->path.'/'.$this->real_name));
    }

    public static function formit($path = 'laralum/files', $public = 1)
    {
        return
        "
        <form class='dropzone' action='".route('laralum::files.save')."' method='POST'>
            ".csrf_field()."
            <input value='$path' hidden='hidden' name='path'/>
            <input value='$public' hidden='hidden' name='public'/>
        </form>
        ";
    }
}
