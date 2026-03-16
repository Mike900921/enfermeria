<?php

namespace App\Http\Controllers\Caracterizacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CaracterizacionController extends Controller
{
    public function index()
    {
        return view('caracterizacion/caracterizacion');
    }
}