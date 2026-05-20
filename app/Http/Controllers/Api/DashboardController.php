<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $hoy = Carbon::today();

        if (!$user) {
            return response()->json(['data' => ['welcome' => 'Bienvenido']], 200);
        }

        $data = [
            'welcome' => $user ? "Hola, {$user->name}" : "Bienvenido",
        ];

        // 🔵 ADMIN
        if ($user->rol === 'administrador') {

            $kilosHoy = DB::table('recolecciones')
                ->whereDate('fecha', $hoy)
                ->sum(DB::raw('num_cajas * kilos_caja'));

            $ventasHoy = DB::table('ventas_diarias')
                ->whereDate('fecha', $hoy)
                ->sum('importe_total');

            $usuariosActivos = DB::table('users')
                ->whereNull('fecha_baja')
                ->count();

            $actividad = DB::table('recolecciones')
                ->orderByDesc('fecha')
                ->limit(5)
                ->get();

            $data['stats'] = [
                'kilos_hoy' => $kilosHoy,
                'ventas_hoy' => $ventasHoy,
                'usuarios_activos' => $usuariosActivos,
            ];

            $data['actividad_reciente'] = $actividad;
        }

        // 🟡 ENCARGADO
        if ($user->rol === 'encargado') {

            $kilosHoy = DB::table('recolecciones')
                ->whereDate('fecha', $hoy)
                ->sum(DB::raw('num_cajas * kilos_caja'));

            $tareasHoy = DB::table('tareas')
                ->whereDate('fecha', $hoy)
                ->get();

            $actividad = DB::table('recolecciones')
                ->orderByDesc('fecha')
                ->limit(5)
                ->get();

            $data['stats'] = [
                'kilos_hoy' => $kilosHoy,
            ];

            $data['tareas_hoy'] = $tareasHoy;
            $data['actividad_reciente'] = $actividad;
        }

        // 🟢 RECOLECTOR
        if ($user->rol === 'recolector') {

            $misKilos = DB::table('recolecciones')
                ->where('user_id', $user->id)
                ->whereDate('fecha', $hoy)
                ->sum(DB::raw('num_cajas * kilos_caja'));

            $misCajas = DB::table('recolecciones')
                ->where('user_id', $user->id)
                ->whereDate('fecha', $hoy)
                ->sum('num_cajas');

            $tareas = DB::table('tareas')
                ->where('user_id', $user->id)
                ->where('estado', 'pendiente')
                ->get();

            $data['stats'] = [
                'mis_kilos' => $misKilos,
                'mis_cajas' => $misCajas,
            ];

            $data['tareas_pendientes'] = $tareas;
        }

        return response()->json([
            'data' => $data
        ]);
    }
}
