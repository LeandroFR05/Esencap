<?php

namespace Tests\Feature;

use App\Models\LoteProducto;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
}