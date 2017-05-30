<?php

use Laralum\Files\Models\Settings;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLaralumFilesSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laralum_files_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('public_url');
            $table->boolean('public_routes');
            $table->timestamps();
        });

        Settings::create([
            'public_url'  => 'files',
            'public_routes'  => true,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laralum_files_settings');
    }
}
