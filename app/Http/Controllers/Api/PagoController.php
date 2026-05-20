<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PagoRequest;
use App\Models\Pago;
use App\Models\HorasTrabajada;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;

class PagoController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $this->authorize('viewAny', Pago::class);

        $authUser = $request->user();
        $query = Pago::with('trabajador:id,name')
            ->orderBy('anio', 'desc')
            ->orderBy('mes', 'desc');

        if ($authUser && $authUser->rol === 'recolector') {
            $query->where('user_id', $authUser->id);
        } else {
            if ($request->filled('user_id')) $query->where('user_id', $request->input('user_id'));
            if ($request->filled('estado'))  $query->where('estado', $request->input('estado'));
        }

        $pagos = $query->paginate($request->input('per_page', 5));
        return response()->json([
            'success' => true,
            'data' => $pagos->items(),
            'meta' => ['current_page' => $pagos->currentPage(), 'last_page' => $pagos->lastPage(), 'per_page' => $pagos->perPage(), 'total' => $pagos->total()]
        ]);
    }

    public function store(PagoRequest $request)
    {
        $this->authorize('create', Pago::class);
        $data = $request->validated();

        $pago = DB::transaction(function () use ($data) {
            $pago = Pago::create($data);
            HorasTrabajada::where('user_id', $data['user_id'])->whereNull('pago_id')
                ->whereMonth('fecha', $data['mes'])->whereYear('fecha', $data['anio'])
                ->update(['pago_id' => $pago->id]);
            return $pago;
        });

        return response()->json(['success' => true, 'message' => 'Pago creado correctamente', 'data' => $pago->load('trabajador:id,name')], 201);
    }

    public function show(string $id)
    {
        $pago = Pago::with(['trabajador:id,name,username,dni', 'horasTrabajadas.cosecha:id,nombre_cosecha'])->findOrFail($id);
        $this->authorize('view', $pago);
        return response()->json(['success' => true, 'data' => $pago]);
    }

    public function update(PagoRequest $request, string $id)
    {
        $pago = Pago::findOrFail($id);
        $this->authorize('update', $pago);
        
        $pago->update($request->validated());
        return response()->json(['success' => true, 'message' => 'Pago actualizado correctamente', 'data' => $pago]);
    }

    public function destroy(string $id)
    {
        $pago = Pago::findOrFail($id);
        $this->authorize('delete', $pago);

        DB::transaction(function () use ($pago) {
            HorasTrabajada::where('pago_id', $pago->id)->update(['pago_id' => null]);
            $pago->delete();
        });
        return response()->json(['success' => true, 'message' => 'Pago eliminado correctamente']);
    }

    public function generarBorrador(Request $request)
    {
        $this->authorize('create', Pago::class);
        $request->validate(['user_id' => 'required|exists:users,id', 'mes' => 'required|integer|min:1|max:12', 'anio' => 'required|integer|min:2020']);

        $horas = HorasTrabajada::where('user_id', $request->user_id)->whereNull('pago_id')
            ->whereMonth('fecha', $request->mes)->whereYear('fecha', $request->anio)
            ->selectRaw('SUM(horas) as total_horas, SUM(horas * precio_hora) as monto_total')->first();

        if (!$horas->total_horas) {
            return response()->json(['success' => false, 'message' => 'No hay horas sin pago asignado para este trabajador en el período indicado'], 404);
        }
        return response()->json(['success' => true, 'data' => ['user_id' => $request->user_id, 'mes' => $request->mes, 'anio' => $request->anio, 'total_horas' => $horas->total_horas, 'monto_total' => $horas->monto_total, 'estado' => 'borrador']]);
    }
}
