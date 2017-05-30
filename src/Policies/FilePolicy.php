<?php

namespace Laralum\Files\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Laralum\Users\Models\User;

class FilePolicy
{
    use HandlesAuthorization;

    /**
     * Filters the authoritzation.
     *
     * @param mixed $user
     * @param mixed $ability
     */
    public function before($user, $ability)
    {
        if (User::findOrFail($user->id)->superAdmin()) {
            return true;
        }
    }

    /**
     * Determine if the current user can access files.
     *
     * @param mixed $user
     *
     * @return bool
     */
    public function access($user)
    {
        return User::findOrFail($user->id)->hasPermission('laralum::files.access');
    }

    /**
     * Determine if the current user can upload files.
     *
     * @param mixed $user
     *
     * @return bool
     */
    public function create($user)
    {
        return User::findOrFail($user->id)->hasPermission('laralum::files.upload');
    }

    /**
     * Determine if the current user can view private files.
     *
     * @param mixed $user
     *
     * @return bool
     */
    public function view($user, Event $event)
    {
        if ($event->user->id == $user->id) {
            return true;
        }

        return User::findOrFail($user->id)->hasPermission('laralum::files.view');
    }

    /**
     * Determine if the current user can delete events.
     *
     * @param mixed $user
     *
     * @return bool
     */
    public function delete($user, Event $event)
    {
        if ($event->user->id == $user->id) {
            return true;
        }

        return User::findOrFail($user->id)->hasPermission('laralum::files.delete');
    }

    /**
     * Determine if the current user can publish events.
     *
     * @param mixed $user
     *
     * @return bool
     */
    public function publish($user)
    {
        return User::findOrFail($user->id)->hasPermission('laralum::files.publish');
    }
}
