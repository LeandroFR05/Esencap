<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        private DashboardService $dashboardService
    ) {}

    public function index()
    {
        // Gráficos
        $ventas_data = $this->dashboardService->ventasRegistradasPorMes();
        $aniosDisponibles = $this->dashboardService->aniosDisponibles();
        $porcentajeStockBajo = $this->dashboardService->insumosConBajoStock();
        $cantProductosVendidos = $this->dashboardService->productosMasVendidos();
        $ventasDiarias = $this->dashboardService->cantidadDeProductosVendidosPorDia();

        // Tarjetas
        $lotesProximosaVencer = $this->dashboardService->lotesProximosAVencer();
        $lotesBajoStock = $this->dashboardService->lotesConBajoStock();
        $insumosRegistrados = $this->dashboardService->insumosRegistrados();
        $productosRegistrados = $this->dashboardService->productosRegistrados();
        
        return view('dashboard', compact('ventas_data', 'aniosDisponibles', 'porcentajeStockBajo', 'cantProductosVendidos', 'ventasDiarias', 
            'lotesProximosaVencer', 'lotesBajoStock', 'insumosRegistrados', 'productosRegistrados'));
    }


    public function ventasPorAnio(Request $request)
    {
        $anio = $request->filled('anio') ? (int) $request->input('anio') : null;
        return response()->json($this->dashboardService->ventasRegistradasPorMes($anio));
    }


    public function productosMasVendidosFiltrados(Request $request)
    {
        $anio = $request->filled('anio') ? (int) $request->input('anio') : null;
        $mes = $request->filled('mes') ? (int) $request->input('mes') : null;
        return response()->json($this->dashboardService->productosMasVendidos($anio, $mes));
    }
}
