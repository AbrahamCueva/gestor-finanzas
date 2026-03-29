<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Deuda;
use Illuminate\Auth\Access\HandlesAuthorization;

class DeudaPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Deuda');
    }

    public function view(AuthUser $authUser, Deuda $deuda): bool
    {
        return $authUser->can('View:Deuda');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Deuda');
    }

    public function update(AuthUser $authUser, Deuda $deuda): bool
    {
        return $authUser->can('Update:Deuda');
    }

    public function delete(AuthUser $authUser, Deuda $deuda): bool
    {
        return $authUser->can('Delete:Deuda');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Deuda');
    }

    public function restore(AuthUser $authUser, Deuda $deuda): bool
    {
        return $authUser->can('Restore:Deuda');
    }

    public function forceDelete(AuthUser $authUser, Deuda $deuda): bool
    {
        return $authUser->can('ForceDelete:Deuda');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Deuda');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Deuda');
    }

    public function replicate(AuthUser $authUser, Deuda $deuda): bool
    {
        return $authUser->can('Replicate:Deuda');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Deuda');
    }

}