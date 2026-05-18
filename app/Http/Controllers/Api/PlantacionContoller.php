<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlantacionRequest;
use App\Models\Plantacion;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PlantacionController extends Controller
{
    use AuthorizesRequests;
    /**
     * Lista las plantaciones con relaciones y paginación
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Plantacion::class);

        $plantaciones = Plantacion::with(['parcela:id,nombre', 'variedad:id,nombre', 'campania:id,nombre'])
            ->withCount('cosechas')
            ->orderBy('fecha_siembra', 'desc')
            ->paginate($request->input('per_page', 5));

        return response()->json([
            'success' => true,
            'data' => $plantaciones->items(),
            'meta' => [
                'current_page' => $plantaciones->currentPage(),
                'last_page' => $plantaciones->lastPage(),
                'per_page' => $plantaciones->perPage(),
                'total' => $plantaciones->total(),
            ]
        ]);
    }

    /**
     * Crea una nueva plantación
     */
    public function store(PlantacionRequest $request)
    {
        $this->authorize('create', Plantacion::class);

        $plantacion = Plantacion::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Plantación creada correctamente',
            'data' => $plantacion
        ], 201);
    }

    /**
     * Muestra una plantación específica
     */
    public function show(string $id)
    {
        $plantacion = Plantacion::with(['parcela', 'variedad', 'campania'])->findOrFail($id);

        $this->authorize('view', $plantacion);

        if (!$plantacion) {
            return response()->json([
                'success' => false,
                'message' => 'Plantación no encontrada'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $plantacion
        ]);
    }

    /**
     * Actualiza una plantación existente
     */
    public function update(PlantacionRequest $request, string $id)
    {
        $plantacion = Plantacion::findOrFail($id);

        $this->authorize('update', $plantacion);

        if (!$plantacion) {
            return response()->json([
                'success' => false,
                'message' => 'Plantación no encontrada'
            ], 404);
        }

        $plantacion->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Plantación actualizada correctamente',
            'data' => $plantacion
        ]);
    }

    /**
     * Elimina una plantación (si no tiene cosechas asociadas)
     */
    public function destroy(string $id)
    {
        // Importante: usamos withCount para verificar hijos antes de borrar
        $plantacion = Plantacion::withCount('cosechas')->findOrFail($id);

        $this->authorize('delete', $plantacion);

        // RESTRICCIÓN: Si ya hay cosechas registradas para esta planta, no dejamos borrar
        if ($plantacion->cosechas_count > 0) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede eliminar una plantación con cosechas registradas'
            ], 400);
        }

        $plantacion->delete();

        return response()->json([
            'success' => true,
            'message' => 'Plantación eliminada correctamente'
        ]);
    }
}