<?php

namespace App\Http\Controllers;

class ManualController extends Controller
{
    /**
     * Descargar el manual de usuario
     * Solo usuarios autenticados pueden descargar
     */
    public function descargar()
    {
        // Ruta completa del manual
        $ruta = public_path('manual/manual.pdf');

        // Verificar que el archivo existe
        if (! file_exists($ruta)) {
            abort(404, 'El manual de usuario no está disponible en este momento.');
        }

        // Descargar el archivo
        return response()->download($ruta, 'Manual_de_Usuario.pdf');
    }
}
