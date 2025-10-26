<?php

namespace App\Http\Controllers;

use App\Models\Familia;
use Illuminate\Http\Request;

class FamiliaController extends Controller
{
    public function create() {
        return view('familias.create');
    }

    public function store(Request $request) {
        Familia::create($request->all());
        return redirect()->route('insumos.create')->with('success', 'Familia creada exitosamente.');
    }
}
