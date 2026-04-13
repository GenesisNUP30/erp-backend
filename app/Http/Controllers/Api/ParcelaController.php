<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ParcelaRequest;
use App\Models\Parcela;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ParcelaController extends Controller
{
    use AuthorizesRequests;
    /**
     * Lista las parcelas con filtros y paginación
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Parcela::class);

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
    public function store(ParcelaRequest $request)
    {
        $this->authorize('create', Parcela::class);

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
        ])->findOrFail($id);

        $this->authorize('view', $parcela);

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
    public function update(ParcelaRequest $request, string $id)
    {
        $parcela = Parcela::findOrFail($id);

        $this->authorize('update', $parcela);

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
        $parcela = Parcela::withCount('plantaciones')->findOrFail($id);

        $this->authorize('delete', $parcela);

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
