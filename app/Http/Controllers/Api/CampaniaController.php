<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CampaniaRequest;
use App\Models\Campania;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CampaniaController extends Controller
{
    use AuthorizesRequests;
    /**
     * Lista las campañas con filtros y paginación
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Campania::class);

        $campanias = Campania::orderBy('fecha_inicio', 'desc')
            ->paginate($request->input('per_page', 5));

        return response()->json([
            'success' => true,
            'data' => $campanias->items(),
            'meta' => [
                'current_page' => $campanias->currentPage(),
                'last_page' => $campanias->lastPage(),
                'per_page' => $campanias->perPage(),
                'total' => $campanias->total(),
            ]
        ]);
    }

    /**
     * Crea una nueva campaña
     */
    public function store(CampaniaRequest $request)
    {
        $this->authorize('create', Campania::class);

        $campania = Campania::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Campaña creada correctamente',
            'data' => $campania
        ], 201);
    }

    /**
     * Muestra una campaña especificada por su id
     */
    public function show(string $id)
    {
        $campania = Campania::findOrFail($id);

        $this->authorize('view', $campania);

        if (!$campania) {
            return response()->json([
                'success' => false,
                'message' => 'Campaña no encontrada'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $campania
        ]);
    }

    /**
     * Actualiza una campaña existente
     */
    public function update(CampaniaRequest $request, string $id)
    {
        $campania = Campania::findOrFail($id);

        $this->authorize('update', $campania);

        if (!$campania) {
            return response()->json([
                'success' => false,
                'message' => 'Campaña no encontrada'
            ], 404);
        }

        $campania->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Campaña actualizada correctamente',
            'data' => $campania
        ]);
    }

    /**
     * Elimina una campaña (si no tiene plantaciones asociadas)
     */
    public function destroy(string $id)
    {
        $campania = Campania::withCount('plantaciones', 'cosechas')->findOrFail($id);

        $this->authorize('delete', $campania);

        if (!$campania) {
            return response()->json([
                'success' => false,
                'message' => 'Campaña no encontrada'
            ], 404);
        }

        if ($campania->plantaciones_count > 0) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede eliminar una campaña con plantaciones asociadas'
            ], 400);
        }

        if ($campania->cosechas_count > 0) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede eliminar una campaña con cosechas asociadas'
            ], 400);
        }

        $campania->delete();

        return response()->json([
            'success' => true,
            'message' => 'Campaña eliminada correctamente'
        ]);
    }
}