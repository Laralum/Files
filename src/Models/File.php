<?php

namespace Laralum\Files\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Laralum\Files\Models\Settings;

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
    protected $fillable = ['name', 'real_name', 'user_id', 'public', 'path', 'password'];

    public function getPath($absolute = false)
    {
        if ($this->public) {
            return 'files/'.$this->real_name;
        }
        $path = $absolute ? storage_path('app/') : '';
        return $path.'private/files/'.$this->real_name;
    }

    public static function form($public = 1)
    {
        $trans = $public ? __('laralum_files::general.drop_public_files') : __('laralum_files::general.drop_private_files');
        return
        "
        <form class='dropzone' action='".route('laralum::files.save')."' method='POST'>
            ".csrf_field().
            "<div class='dz-message'><span class='ion-ios-cloud-upload-outline' style='font-size:50px;vertical-align:middle'></span>&emsp;".$trans."</div>
            <input value='$public' hidden='hidden' name='public'/>
        </form>
        ";
    }
}
