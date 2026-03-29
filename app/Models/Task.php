<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';

    protected $fillable = [
        'title',
        'description',
        'status',
        'position',
    ];

    protected $casts = [
        'position' => 'decimal:10',
    ];

    /*
    |--------------------------------------------------------------------------
    | ESTADOS (para tu Kanban)
    |--------------------------------------------------------------------------
    */
    const STATUS_PENDING = 'pending';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETED = 'completed';

    public static function getStatuses(): array
    {
        return [
            self::STATUS_PENDING => 'Pendiente',
            self::STATUS_IN_PROGRESS => 'En progreso',
            self::STATUS_COMPLETED => 'Completado',
        ];
    }
}