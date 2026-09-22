<?php

namespace Tests\Feature;

use App\Models\LoteProducto;
use App\Models\Producto;
use App\Models\User;
use App\Services\LoteProductoService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class ProductoSoftDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_eliminar_producto_aplica_soft_delete_a_sus_lotes(): void
    {
        User::factory()->create();
        $producto = Producto::factory()->create();
        LoteProducto::factory()->create(['idProducto' => $producto->idProducto]);
        $loteIds = $producto->lotes()->pluck('idLote');

        $producto->delete();

        $this->assertSoftDeleted('productos', ['idProducto' => $producto->idProducto]);
        $this->assertCount(
            $loteIds->count(),
            LoteProducto::onlyTrashed()->whereIn('idLote', $loteIds)->get()
        );
        $this->assertDatabaseHas('lote_productos', [
            'idLote' => $loteIds->first(),
            'estado' => 0,
        ]);
        $this->assertDatabaseCount('lote_productos', $loteIds->count());

        $producto->restore();

        $this->assertDatabaseHas('productos', [
            'idProducto' => $producto->idProducto,
            'deleted_at' => null,
        ]);
        $this->assertDatabaseHas('lote_productos', [
            'idLote' => $loteIds->first(),
            'estado' => 1,
            'deleted_at' => null,
        ]);
    }

    public function test_lotes_del_mismo_dia_se_ordenan_por_hora_y_no_solo_por_fecha(): void
    {
        $producto = Producto::factory()->create();

        $loteMasViejo = LoteProducto::create([
            'idUsuario' => User::factory()->create()->id,
            'idProducto' => $producto->idProducto,
            'stockInicial' => 10,
            'stockActual' => 10,
            'fechaElaboracion' => '2026-09-21 09:00:00',
        ]);

        $loteMasNuevo = LoteProducto::create([
            'idUsuario' => User::factory()->create()->id,
            'idProducto' => $producto->idProducto,
            'stockInicial' => 15,
            'stockActual' => 15,
            'fechaElaboracion' => '2026-09-21 09:15:00',
        ]);

        $orden = $producto->lotes()->orderBy('fechaElaboracion', 'desc')->pluck('idLote')->all();

        $this->assertSame([$loteMasNuevo->idLote, $loteMasViejo->idLote], $orden);
    }
}