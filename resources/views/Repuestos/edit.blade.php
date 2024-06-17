@extends('adminlte::page')

@section('title', 'Editar Repuesto')

@section('content_header')
    <h1>Editar Repuesto</h1>
@stop

@section('content')
    <form action="{{ route('repuestos.update', $Articulo->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $Articulo->nombre }}" required>
        </div>
        <div class="form-group">
            <label for="marca">Marca:</label>
            <input type="text" class="form-control" id="marca" name="marca" value="{{ $Articulo->marca }}" required>
        </div>
        <div class="form-group">
            <label for="modelo">Modelo:</label>
            <input type="text" class="form-control" id="modelo" name="modelo" value="{{ $Articulo->modelo }}" required>
        </div>
        <div class="form-group">
            <label for="categoria">Categoría:</label>
            <input type="text" class="form-control" id="categoria" name="categoria" value="{{ $Articulo->categoria }}" required>
        </div>
        <div class="form-group">
            <label for="precio">Precio:</label>
            <input type="text" class="form-control" id="precio" name="precio" value="{{ $Articulo->precio }}" required>
        </div>
        <div class="form-group">
            <label for="stock">Stock:</label>
            <input type="number" class="form-control" id="stock" name="stock" value="{{ $Articulo->stock }}" required>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required>{{ $Articulo->descripcion }}</textarea>
        </div>
        <div class="form-group">
            <label for="imagen">Imagen:</label>
            <input type="file" class="form-control-file" id="imagen" name="imagen">
            @if ($Articulo->imagen)
                <div>
                    <img src="{{ asset('images/' . $Articulo->imagen) }}" alt="Imagen actual" style="max-width: 200px; max-height: 200px; margin-top: 10px;">
                </div>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
@stop

@section('css')
    {{-- Aquí puedes incluir estilos CSS adicionales específicos de esta página --}}
@stop

@section('js')
    <script>
        // Aquí puedes incluir scripts JS específicos de esta página
    </script>
@stop
