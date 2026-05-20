<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\VariedadRequest;
use App\Models\Variedad;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;

class VariedadController extends Controller
{
    use AuthorizesRequests;

    /**
     * Lista las variedades con filtros y paginación
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Variedad::class);

        // Incluimos el conteo de plantaciones para informar al usuario
        $variedades = Variedad::withCount('plantaciones')
            ->orderBy('nombre')
            ->paginate($request->input('per_page', 5));

        return response()->json([
            'success' => true,
            'data' => $variedades->items(),
            'meta' => [
                'current_page' => $variedades->currentPage(),
                'last_page' => $variedades->lastPage(),
                'per_page' => $variedades->perPage(),
                'total' => $variedades->total(),
            ]
        ]);
    }

    /**
     * Crea una nueva variedad
     */
    public function store(VariedadRequest $request)
    {
        $this->authorize('create', Variedad::class);

        $variedad = Variedad::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Variedad creada correctamente',
            'data' => $variedad
        ], 201);
    }

    /**
     * Muestra una variedad específica
     */
    public function show(string $id)
    {
        $variedad = Variedad::withCount('plantaciones')->findOrFail($id);
        $this->authorize('view', $variedad);

        return response()->json(['success' => true, 'data' => $variedad]);
    }

    /**
     * Actualiza una variedad específica
     */
    public function update(VariedadRequest $request, string $id)
    {
        $variedad = Variedad::findOrFail($id);

        $this->authorize('update', $variedad);

        $variedad->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Variedad actualizada',
            'data' => $variedad
        ]);
    }

    public function destroy(string $id)
    {
        $variedad = Variedad::withCount('plantaciones')->findOrFail($id);

        $this->authorize('delete', $variedad);

        // No permitimos borrar si ya hay plantas de este tipo en el campo
        if ($variedad->plantaciones_count > 0) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede eliminar la variedad: existen plantaciones vinculadas.'
            ], 422);
        }

        $variedad->delete();

        return response()->json([
            'success' => true,
            'message' => 'Variedad eliminada con éxito'
        ]);
    }

    public function todas(Request $request)
    {
        $currentId = $request->query('current_id');

        $variedades = Variedad::orderBy('nombre')
            ->get()
            ->map(fn($v) => [
                'id' => $v->id,
                'nombre' => $v->nombre,
            ]);

        // Si hay un current_id y no está en los resultados (fue borrada), lo añadimos
        if ($currentId) {
            $existe = $variedades->firstWhere('id', $currentId);
            if (!$existe) {
                $variedadBorrada = Variedad::withTrashed()->find($currentId);
                if ($variedadBorrada) {
                    $variedades->push([
                        'id' => $variedadBorrada->id,
                        'nombre' => $variedadBorrada->nombre . ' (eliminada)',
                    ]);
                }
            }
        }

        return response()->json(['success' => true, 'data' => $variedades]);
    }
}
