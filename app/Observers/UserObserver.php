<?php

namespace App\Observers;

use App\Models\User;
use App\Services\AuditoriaService;

class UserObserver
{
    public function updated(User $user): void
    {
        if ($user->wasChanged('password')) {
            app(AuditoriaService::class)->cambioPassword($user);
        }
    }
}