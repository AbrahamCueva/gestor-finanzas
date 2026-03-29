<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Meta;
use Illuminate\Auth\Access\HandlesAuthorization;

class MetaPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Meta');
    }

    public function view(AuthUser $authUser, Meta $meta): bool
    {
        return $authUser->can('View:Meta');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Meta');
    }

    public function update(AuthUser $authUser, Meta $meta): bool
    {
        return $authUser->can('Update:Meta');
    }

    public function delete(AuthUser $authUser, Meta $meta): bool
    {
        return $authUser->can('Delete:Meta');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Meta');
    }

    public function restore(AuthUser $authUser, Meta $meta): bool
    {
        return $authUser->can('Restore:Meta');
    }

    public function forceDelete(AuthUser $authUser, Meta $meta): bool
    {
        return $authUser->can('ForceDelete:Meta');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Meta');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Meta');
    }

    public function replicate(AuthUser $authUser, Meta $meta): bool
    {
        return $authUser->can('Replicate:Meta');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Meta');
    }

}