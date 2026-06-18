<?php

namespace App\Services;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoService
{
    public function guardarFoto(Request $request, ImageService $images): ?string
    {
        if ($request->hasFile('foto')) {
            // Todas las imágenes se guardan en formato webp. "ImageService" se encarga de convertirlas y guardarlas.
            return $images->storeAsWebp($request->file('foto'));
        }

        return null;
    }

    public function crearProducto(Request $request, ?string $fotoPath): Producto
    {
        return Producto::create([
            'nombre' => $request->nombre,
            'foto' => $fotoPath,
            'contenidoPorUnidad' => $request->contenidoPorUnidad,
        ]);
    }
}

?>