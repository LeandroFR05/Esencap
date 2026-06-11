<?php

namespace App\Http\Controllers;

use App\Models\Historial;
use App\Models\Insumo;
use App\Models\LoteInsumo;
use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Gráficos
        $ventas_data = $this->ventasRegistradasPorMes();
        $aniosDisponibles = $this->aniosDisponibles();
        $porcentajeStockBajo = $this->insumosConBajoStock();
        $cantProductosVendidos = $this->productosMasVendidos();
        $ventasDiarias = $this->cantidadDeProductosVendidosPorDia();

        // Tarjetas
        $lotesProximosaVencer = $this->lotesProximosAVencer();
        $lotesBajoStock = $this->lotesConBajoStock();
        $insumosRegistrados = $this->insumosRegistrados();
        $productosRegistrados = $this->productosRegistrados();
        
        return view('dashboard', compact('ventas_data', 'aniosDisponibles', 'porcentajeStockBajo', 'cantProductosVendidos', 'ventasDiarias', 
            'lotesProximosaVencer', 'lotesBajoStock', 'insumosRegistrados', 'productosRegistrados'));
    }


    public function ventasPorAnio(Request $request)
    {
        $anio = $request->input('anio');
        return response()->json($this->ventasRegistradasPorMes($anio));
    }


    public function productosMasVendidosFiltrados(Request $request)
    {
        $anio = $request->input('anio');
        $mes = $request->input('mes');
        return response()->json($this->productosMasVendidos($anio, $mes));
    }



    // FUNCIONES PRIVADAS DE INDEX
    // Gráficos
    private function ventasRegistradasPorMes($anio = null)
    {
        $query = Venta::select(
            DB::raw('MONTH(fecha) as mes'),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('mes')
            ->orderBy('mes');

        if (!is_null($anio)) {
            $query->whereYear('fecha', $anio);
        }

        $ventas_mensuales = $query->get()->toArray();

        $ventas_data = array_fill(1, 12, 0);
        foreach ($ventas_mensuales as $venta) {
            $ventas_data[$venta['mes']] = $venta['total'];
        }

        return $ventas_data;
    }


    private function aniosDisponibles()
    {
        $anios = Venta::select(DB::raw('DISTINCT YEAR(fecha) as anio'))
            ->orderBy('anio', 'desc')
            ->pluck('anio')
            ->toArray();

        if (empty($anios)) {
            $anios = [date('Y')];
        }

        return $anios;
    }


    private function insumosConBajoStock()
    {
        $insumos = Insumo::where('estado', 1)->get();
        $totalInsumos = LoteInsumo::count();
        $stockBajo = 0;

        // Vamos a contar cuántos lotes tienen bajo stock según la unidad de medida del insumo
        foreach ($insumos as $insumo) {
            $stockMinimo = match (strtolower($insumo->unidadDeMedida)) {
                'gramos'   => 500,
                'kilos'    => 1,
                'unidades' => 10,
                'litros'   => 2,
            };

            $stockBajo += LoteInsumo::where('idInsumo', $insumo->idInsumo)->where('stockActual', '<=', $stockMinimo)->count();
        }

        $porcentajeStockBajo = $totalInsumos > 0 ? round(($stockBajo / $totalInsumos) * 100, 2) : 0;

        return $porcentajeStockBajo;
    }


    private function productosMasVendidos($anio = null, $mes = null)
    {
        $query = DB::table('ventas as v')
            ->join('detalleVentas as d', 'd.idVenta', '=', 'v.idVenta')
            ->join('productos as p', 'p.idProducto', '=', 'd.idProducto')
            ->select(
                'p.idProducto',
                'p.nombre as nombre',
                DB::raw('SUM(d.cantidad) as total_vendidos')
            )
            ->groupBy('p.idProducto', 'p.nombre')
            ->orderBy('total_vendidos', 'desc');

        if (!is_null($anio)) {
            $query->whereYear('v.fecha', $anio);
        }

        if (!is_null($mes)) {
            $query->whereMonth('v.fecha', $mes);
        }

        return $query->get()->toArray();
    }


    private function cantidadDeProductosVendidosPorDia()
    {
        $ventas_diarias = DB::table('ventas as v')
            ->join('detalleVentas as d', 'd.idVenta', '=', 'v.idVenta')
            ->select(
                DB::raw('DATE(v.fecha) as dia'),
                DB::raw('SUM(d.cantidad) as total')
            )
            ->groupBy('dia')
            ->orderBy('dia')
            ->get()
            ->toArray();

        return $ventas_diarias;
    }


    // Tarjetas
    public function lotesProximosAVencer()
    {
        $hoy = date('Y-m-d');
        return LoteInsumo::where('fechaVencimiento', '<=', date('Y-m-d', strtotime($hoy.' +10 days')))->count();
    }
    
    public function lotesConBajoStock()
    {
        $insumos = Insumo::where('estado', 1)->get();
        $lotesBajoStock = 0;

        foreach ($insumos as $insumo) {
            // Definir el stock mínimo según la unidad de medida
            $stockMinimo = match (strtolower($insumo->unidadDeMedida)) {
                'gramos' => 500,
                'kilos' => 1,
                'unidades' => 10,
                'litros' => 2,
            };

            // Buscar lotes de ese insumo con stock bajo
            $lotesBajoStock += LoteInsumo::where('idInsumo', $insumo->idInsumo)
                ->where('stockActual', '<=', $stockMinimo)
                ->count();
        }

        return $lotesBajoStock;
    }


    private function insumosRegistrados()
    {
        return Insumo::count();
    }


    private function productosRegistrados()
    {
        return Producto::count();
    }
}
