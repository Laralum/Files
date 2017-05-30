<?php

namespace Laralum\Files\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'laralum_files_settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['public_url', 'public_routes'];
}
