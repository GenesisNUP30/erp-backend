<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\HorasTrabajadaRequest;
use App\Models\HorasTrabajada;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class HorasTrabajadaController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $this->authorize('viewAny', HorasTrabajada::class);

        $query = HorasTrabajada::with(['trabajador:id,name', 'cosecha:id,nombre_cosecha'])->orderBy('fecha', 'desc');
        if ($request->filled('user_id'))    $query->where('user_id', $request->input('user_id'));
        if ($request->filled('cosecha_id')) $query->where('cosecha_id', $request->input('cosecha_id'));
        if ($request->filled('pago_id'))    $query->where('pago_id', $request->input('pago_id'));

        $horas = $query->paginate($request->input('per_page', 5));
        return response()->json([
            'success' => true,
            'data' => $horas->items(),
            'meta' => ['current_page' => $horas->currentPage(), 'last_page' => $horas->lastPage(), 'per_page' => $horas->perPage(), 'total' => $horas->total()]
        ]);
    }

    public function store(HorasTrabajadaRequest $request)
    {
        $this->authorize('create', HorasTrabajada::class);
        $horas = HorasTrabajada::create($request->validated());
        return response()->json(['success' => true, 'message' => 'Horas registradas correctamente', 'data' => $horas->load(['trabajador:id,name', 'cosecha:id,nombre_cosecha'])], 201);
    }

    public function show(string $id)
    {
        $horas = HorasTrabajada::with(['trabajador:id,name,username,dni', 'cosecha:id,nombre_cosecha', 'pago:id,mes,anio,estado'])->findOrFail($id);
        $this->authorize('view', $horas);
        return response()->json(['success' => true, 'data' => $horas]);
    }

    public function update(HorasTrabajadaRequest $request, string $id)
    {
        $horas = HorasTrabajada::findOrFail($id);
        $this->authorize('update', $horas);

        if ($horas->pago_id) {
            $pago = $horas->pago;
            if ($pago && in_array($pago->estado, ['validado', 'pagado', 'archivado'])) {
                return response()->json(['success' => false, 'message' => 'No se pueden editar horas vinculadas a un pago ya procesado'], 400);
            }
        }
        $horas->update($request->validated());
        return response()->json(['success' => true, 'message' => 'Horas actualizadas correctamente', 'data' => $horas]);
    }

    public function destroy(string $id)
    {
        $horas = HorasTrabajada::findOrFail($id);
        $this->authorize('delete', $horas);
        if ($horas->pago_id) {
            return response()->json(['success' => false, 'message' => 'No se pueden eliminar horas ya vinculadas a un pago'], 400);
        }
        $horas->delete();
        return response()->json(['success' => true, 'message' => 'Registro de horas eliminado correctamente']);
    }

    public function resumenMensual(Request $request)
    {
        $request->validate(['mes' => 'required|integer|min:1|max:12', 'anio' => 'required|integer|min:2020']);
        $resumen = HorasTrabajada::with('trabajador:id,name')->whereNull('pago_id')
            ->whereMonth('fecha', $request->mes)->whereYear('fecha', $request->anio)
            ->selectRaw('user_id, SUM(horas) as total_horas, SUM(horas * precio_hora) as monto_total')
            ->groupBy('user_id')->get();
        return response()->json(['success' => true, 'data' => $resumen]);
    }
}
