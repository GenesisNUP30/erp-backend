<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CosechaRequest;
use App\Models\Cosecha;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CosechaController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $this->authorize('viewAny', Cosecha::class);

        $cosechas = Cosecha::with(['plantacion:id,parcela_id,variedad_id', 'campania:id,nombre'])
            ->orderBy('fecha_inicio', 'desc')
            ->paginate($request->input('per_page', 5));

        return response()->json([
            'success' => true,
            'data' => $cosechas->items(),
            'meta' => [
                'current_page' => $cosechas->currentPage(),
                'last_page'    => $cosechas->lastPage(),
                'per_page'     => $cosechas->perPage(),
                'total'        => $cosechas->total(),
            ]
        ]);
    }

    public function store(CosechaRequest $request)
    {
        $this->authorize('create', Cosecha::class);
        $cosecha = Cosecha::create($request->validated());
        return response()->json(['success' => true, 'message' => 'Cosecha creada correctamente', 'data' => $cosecha], 201);
    }

    public function show(string $id)
    {
        $cosecha = Cosecha::with(['plantacion.parcela:id,nombre', 'plantacion.variedad:id,nombre', 'campania:id,nombre'])
            ->withCount('recolecciones')->findOrFail($id);
        $this->authorize('view', $cosecha);
        return response()->json(['success' => true, 'data' => $cosecha]);
    }

    public function update(CosechaRequest $request, string $id)
    {
        $cosecha = Cosecha::findOrFail($id);
        $this->authorize('update', $cosecha);
        $cosecha->update($request->validated());
        return response()->json(['success' => true, 'message' => 'Cosecha actualizada correctamente', 'data' => $cosecha]);
    }

    public function destroy(string $id)
    {
        $cosecha = Cosecha::withCount('recolecciones')->findOrFail($id);
        $this->authorize('delete', $cosecha);
        if ($cosecha->recolecciones_count > 0) {
            return response()->json(['success' => false, 'message' => 'No se puede eliminar una cosecha con recolecciones registradas'], 400);
        }
        $cosecha->delete();
        return response()->json(['success' => true, 'message' => 'Cosecha eliminada correctamente']);
    }

    public function activas()
    {
        $cosechas = Cosecha::whereIn('estado', ['en_crecimiento', 'en_recoleccion', 'en_poda'])
            ->with('campania:id,nombre')->select('id', 'nombre_cosecha', 'campania_id')->orderBy('nombre_cosecha')->get();
        return response()->json(['success' => true, 'data' => $cosechas]);
    }
}
