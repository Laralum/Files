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
    protected $fillable = ['name', 'real_name', 'user_id', 'public', 'password'];

    public function getPath($absolute = false)
    {
        $path = $absolute ? storage_path('app/') : '';
        return $path.'laralum/files/'.$this->real_name;
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

    public function extension() {
        return pathinfo($this->getPath(true))['extension'];
    }

    public function type() {
        if (in_array($this->extension(), ['mpg', 'mp3', 'wav', 'ogg', '3ga', 'aac', 'm4a', 'wma'])) {
            return "music";
        } elseif (in_array($this->extension(), ['rst', 'md', 'env', 'config', 'txt'])) {
            return "text";
        } elseif (in_array($this->extension(), ['png', 'jpg', 'jpeg', 'bmp', 'gif', 'ico', 'psd', 'tga', 'tif', 'tiff', 'svg'])) {
            return "image";
        } elseif (in_array($this->extension(), ['wmv', 'mp4', 'avi', 'flv', 'mpeg', 'ogv'])) {
            return "video";
        } elseif (in_array($this->extension(), ['pdf', 'docx', 'doc'])) {
            return "document";
        } elseif (in_array($this->extension(), ['php', 'html', 'css', 'js', 'py', 'pyc', 'c', 'sql', 'asm', 'json'])) {
            return "code";
        } elseif (in_array($this->extension(), ['tar', '7z', 'zip'])) {
            return "compressed";
        }
    }

    public function icon() {
        switch ($this->type()) {
            case 'document':
                return "ion-document";
            case 'text':
                return "ion-document-text";
            case 'image':
                return "ion-image";
            case 'music':
                return "ion-music-note";
            case 'video':
                return "ion-videocamera";
            case 'code':
                return "ion-code";
            case 'compressed':
                return "ion-briefcase";
            default:
                return "ion-document-text";
        }
    }
}
