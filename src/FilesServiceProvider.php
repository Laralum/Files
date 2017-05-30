<?php

namespace Laralum\Files;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laralum\Files\Models\Settings;
use Laralum\Files\Models\File;
use Laralum\Files\Policies\FilePolicy;
use Laralum\Files\Policies\SettingsPolicy;
use Laralum\Permissions\PermissionsChecker;

class FilesServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        File::class => FilePolicy::class,
        Settings::class => SettingsPolicy::class,
    ];

    /**
     * The mandatory permissions for the module.
     *
     * @var array
     */
    protected $permissions = [
        [
            'name' => 'Files Access',
            'slug' => 'laralum::files.access',
            'desc' => 'Grants access to files',
        ],
        [
            'name' => 'Upload Files',
            'slug' => 'laralum::files.upload',
            'desc' => 'Allows uploading files',
        ],
        [
            'name' => 'Update Files',
            'slug' => 'laralum::files.update',
            'desc' => 'Allows updating files',
        ],
        [
            'name' => 'View Private Files',
            'slug' => 'laralum::files.view',
            'desc' => 'Allows viewing files',
        ],
        [
            'name' => 'Delete Files',
            'slug' => 'laralum::files.delete',
            'desc' => 'Allows deleting files',
        ],
        [
            'name' => 'Publish Files',
            'slug' => 'laralum::files.publish',
            'desc' => 'Allows publishing files',
        ],
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $this->publishes([
            __DIR__.'/Views/public' => resource_path('views/vendor/laralum_files/public'),
        ], 'laralum_files');

        $this->loadViewsFrom(__DIR__.'/Views', 'laralum_files');

        $this->loadTranslationsFrom(__DIR__.'/Translations', 'laralum_files');

        if (!$this->app->routesAreCached()) {
            require __DIR__.'/Routes/web.php';
        }

        $this->loadMigrationsFrom(__DIR__.'/Migrations');

        // Make sure the permissions are OK
        PermissionsChecker::check($this->permissions);
    }

    /**
     * I cheated this comes from the AuthServiceProvider extended by the App\Providers\AuthServiceProvider.
     *
     * Register the application's policies.
     *
     * @return void
     */
    public function registerPolicies()
    {
        foreach ($this->policies as $key => $value) {
            Gate::policy($key, $value);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
