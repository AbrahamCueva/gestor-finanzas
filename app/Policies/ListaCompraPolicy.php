<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\ListaCompra;
use Illuminate\Auth\Access\HandlesAuthorization;

class ListaCompraPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ListaCompra');
    }

    public function view(AuthUser $authUser, ListaCompra $listaCompra): bool
    {
        return $authUser->can('View:ListaCompra');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ListaCompra');
    }

    public function update(AuthUser $authUser, ListaCompra $listaCompra): bool
    {
        return $authUser->can('Update:ListaCompra');
    }

    public function delete(AuthUser $authUser, ListaCompra $listaCompra): bool
    {
        return $authUser->can('Delete:ListaCompra');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:ListaCompra');
    }

    public function restore(AuthUser $authUser, ListaCompra $listaCompra): bool
    {
        return $authUser->can('Restore:ListaCompra');
    }

    public function forceDelete(AuthUser $authUser, ListaCompra $listaCompra): bool
    {
        return $authUser->can('ForceDelete:ListaCompra');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ListaCompra');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ListaCompra');
    }

    public function replicate(AuthUser $authUser, ListaCompra $listaCompra): bool
    {
        return $authUser->can('Replicate:ListaCompra');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ListaCompra');
    }

}