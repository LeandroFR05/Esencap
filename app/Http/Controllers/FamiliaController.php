<?php

namespace App\Http\Controllers;

use App\Models\Familia;
use Illuminate\Http\Request;

class FamiliaController extends Controller
{
    public function store(Request $request)
    {
        $familia = Familia::create([
            'nombre' => $request->nombre
        ]);

        return response()->json($familia);
    }

}
