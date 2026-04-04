<?php

namespace App\Observers;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;

class ActivityObserver
{
    public function created(Model $model): void
    {
        ActivityLog::registrar(
            'crear',
            class_basename($model) . ' creado: ' . $this->getNombre($model),
            $model,
            []
        );
    }

    public function updated(Model $model): void
    {
        $cambios = $model->getChanges();

        // 1. Definimos qué campos queremos ignorar
        $ignorar = ['updated_at', 'remember_token', 'last_login_at'];

        // 2. Filtramos el array de cambios
        $cambiosRelevantes = array_diff_key($cambios, array_flip($ignorar));

        // 3. Solo registramos si hay cambios reales después de filtrar
        if (!empty($cambiosRelevantes)) {
            ActivityLog::registrar(
                'editar',
                class_basename($model) . ' actualizado: ' . $this->getNombre($model),
                $model,
                $cambiosRelevantes
            );
        }
    }

    public function deleted(Model $model): void
    {
        ActivityLog::registrar(
            'eliminar',
            class_basename($model) . ' eliminado: ' . $this->getNombre($model),
            $model,
            []
        );
    }

    private function getNombre(Model $model): string
    {
        return $model->nombre
            ?? $model->name
            ?? $model->titulo
            ?? $model->descripcion
            ?? '#' . $model->id;
    }
}