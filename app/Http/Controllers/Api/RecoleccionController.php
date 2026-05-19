<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RecoleccionRequest;
use App\Models\Recoleccion;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RecoleccionController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $this->authorize('viewAny', Recoleccion::class);

        $query = Recoleccion::with(['cosecha:id,nombre_cosecha', 'recolector:id,name'])->orderBy('fecha', 'desc');
        if ($request->filled('cosecha_id')) $query->where('cosecha_id', $request->input('cosecha_id'));

        $recolecciones = $query->paginate($request->input('per_page', 5));
        return response()->json([
            'success' => true,
            'data' => $recolecciones->items(),
            'meta' => ['current_page' => $recolecciones->currentPage(), 'last_page' => $recolecciones->lastPage(), 'per_page' => $recolecciones->perPage(), 'total' => $recolecciones->total()]
        ]);
    }

    public function store(RecoleccionRequest $request)
    {
        $this->authorize('create', Recoleccion::class);
        $recoleccion = Recoleccion::create($request->validated());
        return response()->json(['success' => true, 'message' => 'Recolección registrada correctamente', 'data' => $recoleccion->load(['cosecha:id,nombre_cosecha', 'recolector:id,name'])], 201);
    }

    public function show(string $id)
    {
        $recoleccion = Recoleccion::with(['cosecha.plantacion.parcela:id,nombre', 'cosecha.plantacion.variedad:id,nombre', 'recolector:id,name,username'])->findOrFail($id);
        $this->authorize('view', $recoleccion);
        return response()->json(['success' => true, 'data' => $recoleccion]);
    }

    public function update(RecoleccionRequest $request, string $id)
    {
        $recoleccion = Recoleccion::findOrFail($id);
        $this->authorize('update', $recoleccion);
        $recoleccion->update($request->validated());
        return response()->json(['success' => true, 'message' => 'Recolección actualizada correctamente', 'data' => $recoleccion]);
    }

    public function destroy(string $id)
    {
        $recoleccion = Recoleccion::findOrFail($id);
        $this->authorize('delete', $recoleccion);
        $recoleccion->delete();
        return response()->json(['success' => true, 'message' => 'Recolección eliminada correctamente']);
    }

    public function resumenPorCosecha(string $cosechaId)
    {
        $total = Recoleccion::where('cosecha_id', $cosechaId)->where('estado', '!=', 'anulada')
            ->selectRaw('SUM(num_cajas * kilos_caja) as total_kilos, SUM(num_cajas) as total_cajas, COUNT(*) as total_registros')->first();
        return response()->json(['success' => true, 'data' => $total]);
    }
}
