<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\VariedadRequest;
use App\Models\Variedad;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class VariedadController extends Controller
{
    use AuthorizesRequests;

    /**
     * Lista las variedades con filtros y paginación
     */
    public function index()
    {
        $this->authorize('viewAny', Variedad::class);
        
        // Incluimos el conteo de plantaciones para informar al usuario
        $variedades = Variedad::withCount('plantaciones')
            ->orderBy('nombre')
            ->paginate(5);

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

        if (!$variedad) {
            return response()->json([
                'success' => false,
                'message' => 'Variedad no encontrada'
            ], 404);
        }
        
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

        if (!$variedad) {
            return response()->json([
                'success' => false,
                'message' => 'Variedad no encontrada'
            ], 404);
        }

        // BLOQUEO DE BORRADO: No permitimos borrar si ya hay plantas de este tipo en el campo
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
}