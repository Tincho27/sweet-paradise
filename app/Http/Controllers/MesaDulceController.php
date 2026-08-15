<?php

namespace App\Http\Controllers;

use App\Models\EventQuote;
use Illuminate\Http\Request;

class MesaDulceController extends Controller
{
    public function index()
    {
        return view('encuesta-mesa-dulce');
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'personas' => ['required', 'in:50,100,150,200,otro'],
            'personas_otro' => ['nullable', 'required_if:personas,otro', 'integer', 'min:1'],
            'fecha_evento' => ['nullable', 'date', 'after_or_equal:today'],
            'email' => ['required', 'email', 'max:255'],
            'telefono' => ['required', 'string', 'max:30'],
            'servicio' => ['required', 'in:solo-mesa,almuerzo,cena,catering,otro'],
            'servicio_otro' => ['nullable', 'required_if:servicio,otro', 'string', 'max:255'],
            'productos' => ['required', 'array', 'min:1'],
            'productos.*' => ['in:tartas,shots,tartas-minis,tortas-tartas,otro'],
            'producto_otro' => ['nullable', 'string', 'max:255'],
            'observaciones' => ['nullable', 'string', 'max:2000'],
        ]);

        if (in_array('otro', $data['productos'], true) && blank($data['producto_otro'] ?? null)) {
            return back()
                ->withErrors(['producto_otro' => 'Indicá cuál otro producto te gustaría incluir.'])
                ->withInput();
        }

        EventQuote::create([
            'user_id' => $user->id,
            'email' => $data['email'],
            'telefono' => $data['telefono'],
            'cantidad_personas' => $data['personas'] === 'otro' ? null : (int) $data['personas'],
            'cantidad_personas_otro' => $data['personas'] === 'otro' ? $data['personas_otro'] : null,
            'fecha_evento' => $data['fecha_evento'] ?? null,
            'servicio' => $data['servicio'],
            'servicio_otro' => $data['servicio'] === 'otro' ? $data['servicio_otro'] : null,
            'productos_preferidos' => $data['productos'],
            'producto_otro' => in_array('otro', $data['productos'], true) ? $data['producto_otro'] : null,
            'observaciones' => $data['observaciones'] ?? null,
            'estado' => 'pendiente',
        ]);

        return redirect()->route('mesa.dulce')->with('success', 'Recibimos tu solicitud. Te vamos a contactar para preparar la propuesta.');
    }
}
