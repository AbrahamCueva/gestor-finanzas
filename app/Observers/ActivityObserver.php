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
        ActivityLog::registrar(
            'editar',
            class_basename($model) . ' actualizado: ' . $this->getNombre($model),
            $model,
            $model->getChanges()
        );
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