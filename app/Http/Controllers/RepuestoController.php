<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Repuesto;
use Illuminate\Support\Facades\Auth;
class RepuestoController extends Controller
{
    public function index(Request $request)
    {
        $categorias = Repuesto::select('categoria')->distinct()->pluck('categoria', 'categoria');
        $query = Repuesto::with('user');

        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        $Articulo = $query->paginate(10);

        if ($request->ajax()) {
            return view('Repuestos.tabla_articulos', compact('Articulo'))->render();
        }

        return view('Repuestos.index', compact('Articulo', 'categorias'));
    }

    public function buscar(Request $request)
    {
        $query = Repuesto::with('user');

        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        $Articulo = $query->paginate(10);

        return view('Repuestos.tabla_articulos', compact('Articulo'))->render();
    }

    public function create()
    {
        return view('Repuestos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'marca' => 'required',
            'modelo' => 'required',
            'categoria' => 'required',
            'precio' => 'required',
            'stock' => 'required',
            'descripcion' => 'required',
            'imagen' => 'required|image',
        ]);

        $Articulo = new Repuesto();
        $Articulo->nombre = $request->nombre;
        $Articulo->marca = $request->marca;
        $Articulo->modelo = $request->modelo;
        $Articulo->categoria = $request->categoria;
        $Articulo->precio = $request->precio;
        $Articulo->stock = $request->stock;
        $Articulo->descripcion = $request->descripcion;
        $Articulo->user_id = auth()->id();

        if ($request->hasFile('imagen')) {
            $image = $request->file('imagen');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $Articulo->imagen = $imageName;
        }

        $Articulo->save();
        return redirect()->route('repuestos.index');
    }

    public function edit($id)
    {
        $Articulo = Repuesto::findOrFail($id);
        return view('Repuestos.edit', compact('Articulo'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'marca' => 'required',
            'modelo' => 'required',
            'categoria' => 'required',
            'precio' => 'required',
            'stock' => 'required',
            'descripcion' => 'required',
            'imagen' => 'image',
        ]);

        $Articulo = Repuesto::findOrFail($id);
        $Articulo->nombre = $request->nombre;
        $Articulo->marca = $request->marca;
        $Articulo->modelo = $request->modelo;
        $Articulo->categoria = $request->categoria;
        $Articulo->precio = $request->precio;
        $Articulo->stock = $request->stock;
        $Articulo->descripcion = $request->descripcion;

        if ($request->hasFile('imagen')) {
            $image = $request->file('imagen');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $Articulo->imagen = $imageName;
        }

        $Articulo->user_id = Auth::id();
        $Articulo->save();
        return redirect()->route('repuestos.index');
    }

    public function destroy($id)
    {
        $Articulo = Repuesto::findOrFail($id);
        $Articulo->delete();
        return redirect()->route('repuestos.index');
    }

}
