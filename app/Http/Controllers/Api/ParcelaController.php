<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Parcela;
use Illuminate\Http\Request;

class ParcelaController extends Controller
{
    /**
     * Lista las parcelas con filtros y paginación
     */
    public function index(Request $request)
    {
        $parcelas = Parcela::withCount('plantaciones')
            ->orderBy('nombre')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $parcelas->items(),
            'meta' => [
                'current_page' => $parcelas->currentPage(),
                'last_page' => $parcelas->lastPage(),
                'per_page' => $parcelas->perPage(),
                'total' => $parcelas->total(),
            ]
        ]);
    }

    /**
     * Crea una nueva parcela
     */
    public function store(Request $request)
    {
        $parcela = Parcela::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Parcela creada correctamente',
            'data' => $parcela
        ], 201);
    }

    /**
     * Muestra una parcela especificada por su id
     */
    public function show(string $id)
    {
        $parcela = Parcela::with([
            'plantaciones' => function ($query) {
                $query->with('variedad:id,nombre')
                    ->orderBy('fecha_siembra', 'desc');
            }
        ])->find($id);

        if (!$parcela) {
            return response()->json([
                'success' => false,
                'message' => 'Parcela no encontrada'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $parcela
        ]);
    }

    /**
     * Actualiza una parcela existente
     */
    public function update(Request $request, string $id)
    {
        $parcela = Parcela::find($id);

        if (!$parcela) {
            return response()->json([
                'success' => false,
                'message' => 'Parcela no encontrada'
            ], 404);
        }

        $parcela->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Parcela actualizada correctamente',
            'data' => $parcela
        ]);
    }

    /**
     * Elimina una parcela (si no tiene plantaciones asociadas)
     */
    public function destroy(string $id)
    {
        $parcela = Parcela::withCount('plantaciones')->find($id);

        if (!$parcela) {
            return response()->json([
                'success' => false,
                'message' => 'Parcela no encontrada'
            ], 404);
        }

        if ($parcela->plantaciones_count > 0) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede eliminar una parcela con plantaciones asociadas'
            ], 400);
        }

        $parcela->delete();

        return response()->json([
            'success' => true,
            'message' => 'Parcela eliminada correctamente'
        ]);
    }
}
