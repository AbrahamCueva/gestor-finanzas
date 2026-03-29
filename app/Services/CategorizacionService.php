<?php

namespace App\Services;

use App\Models\Categoria;
use App\Models\Subcategoria;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CategorizacionService
{
    public function sugerir(string $descripcion, float $monto = 0, string $tipo = 'egreso'): \Illuminate\Http\JsonResponse
    {
        if (strlen(trim($descripcion)) < 3) {
            return response()->json(['sugerencia' => null]);
        }

        $cacheKey = 'cat_' . md5(strtolower(trim($descripcion)) . $tipo);
        if ($cached = Cache::get($cacheKey)) {
            return response()->json(['sugerencia' => $cached]);
        }

        $categorias = Categoria::where('tipo', $tipo)
            ->where('activa', true)
            ->with('subcategorias')
            ->get();

        if ($categorias->isEmpty()) {
            return response()->json(['sugerencia' => null]);
        }

        $listaCategorias = $categorias->map(fn ($c) => [
            'id'            => $c->id,
            'nombre'        => $c->nombre,
            'subcategorias' => $c->subcategorias->map(fn ($s) => [
                'id'     => $s->id,
                'nombre' => $s->nombre,
            ])->toArray(),
        ])->toArray();

        $categoriasStr = $categorias->map(fn ($c) =>
            "- ID:{$c->id} {$c->nombre}" .
            ($c->subcategorias->isNotEmpty()
                ? ' (subcategorías: ' . $c->subcategorias->pluck('nombre')->join(', ') . ')'
                : '')
        )->join("\n");

        $response = Http::withHeaders([
            'x-api-key'         => config('services.anthropic.key'),
            'anthropic-version' => '2023-06-01',
            'content-type'      => 'application/json',
        ])->post('https://api.anthropic.com/v1/messages', [
            'model'      => 'claude-haiku-4-5-20251001',
            'max_tokens' => 150,
            'system'     => "Eres un categorizador de movimientos financieros. Tu tarea es analizar la descripción de un movimiento y sugerir la categoría y subcategoría más apropiada de la lista disponible. Responde ÚNICAMENTE con un JSON válido con esta estructura exacta: {\"categoria_id\": NUMBER, \"categoria_nombre\": \"STRING\", \"subcategoria_id\": NUMBER_OR_NULL, \"subcategoria_nombre\": \"STRING_OR_NULL\", \"confianza\": \"alta|media|baja\"}. Sin explicaciones, sin texto adicional, solo el JSON.",
            'messages'   => [[
                'role'    => 'user',
                'content' => "Descripción del movimiento: \"{$descripcion}\"\nMonto: S/ {$monto}\nTipo: {$tipo}\n\nCategorías disponibles:\n{$categoriasStr}\n\nSugiere la categoría más apropiada.",
            ]],
        ]);

        if (!$response->ok()) {
            return response()->json(['sugerencia' => null]);
        }

        $text = $response->json()['content'][0]['text'] ?? '';

        try {
            $text      = preg_replace('/```json|```/', '', $text);
            $sugerencia = json_decode(trim($text), true, 512, JSON_THROW_ON_ERROR);

            $categoriaValida = $categorias->firstWhere('id', $sugerencia['categoria_id']);
            if (!$categoriaValida) {
                return response()->json(['sugerencia' => null]);
            }

            Cache::put($cacheKey, $sugerencia, now()->addHour());

            return response()->json(['sugerencia' => $sugerencia]);

        } catch (\Exception $e) {
            return response()->json(['sugerencia' => null]);
        }
    }
}
