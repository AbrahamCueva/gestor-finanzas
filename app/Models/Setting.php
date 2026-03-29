<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_name',
        'logo_light',
        'logo_dark',
        'favicon',
        'mantenimiento_activo',
        'mantenimiento_titulo',
        'mantenimiento_mensaje',
        'mantenimiento_fin',
        'vacaciones_activo',
        'vacaciones_inicio',
        'vacaciones_fin',
        'vacaciones_mensaje',
        'vacaciones_pausar_presupuestos',
        'vacaciones_pausar_recurrentes',
        'vacaciones_pausar_notificaciones',
    ];

    protected $casts = [
        'mantenimiento_activo' => 'boolean',
        'vacaciones_activo'               => 'boolean',
        'vacaciones_inicio'               => 'date',
        'vacaciones_fin'                  => 'date',
        'vacaciones_pausar_presupuestos'  => 'boolean',
        'vacaciones_pausar_recurrentes'   => 'boolean',
        'vacaciones_pausar_notificaciones' => 'boolean',
    ];

    public static function get($column)
    {
        $settings = static::first();

        return $settings?->$column;
    }
}
