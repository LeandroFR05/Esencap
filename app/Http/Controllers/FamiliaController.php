<?php

namespace App\Http\Controllers;

use App\Models\Familia;
use Illuminate\Http\Request;

class FamiliaController extends Controller
{
    public function store(Request $request) {
        Familia::create($request->all());
        return redirect()->back()->with('success', 'Familia creada exitosamente.');
    }
}
