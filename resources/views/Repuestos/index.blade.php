@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 style="text-align: center;">Stock</h1>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <form id="searchForm" action="{{ route('repuestos.index') }}" method="GET">
                    <div class="form-group">
                        <label for="categoria">Buscar por Categoría:</label>
                        <select name="categoria" id="categoria" class="form-control">
                            <option value="">Todas las categorías</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria }}" @if(request('categoria') == $categoria) selected @endif>{{ $categoria }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>
            </div>
            <div class="col-md-4" id="nombreSearch" style="display: {{ request()->has('categoria') && request('categoria') != '' ? 'block' : 'none' }}">
                <form id="nameForm" action="{{ route('repuestos.index') }}" method="GET">
                    <div class="form-group">
                        <label for="nombre">Buscar por Nombre:</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="{{ request('nombre') }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>
            </div>
        </div>
        <br>
        <div id="tablaArticulos">
            <table id="tablaArticulosContent" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Descripción</th>
                        <th>Imagen</th>
                        <th>Usuario</th>
                        <th>Última Actualización</th>
                        <th>Eliminar</th>
                        <th>Actualizar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($Articulo as $stock)
                        <tr>
                            <td>{{ $stock->nombre }}</td>
                            <td>{{ $stock->marca }}</td>
                            <td>{{ $stock->modelo }}</td>
                            <td>{{ $stock->categoria }}</td>
                            <td>{{ $stock->precio }}</td>
                            <td>{{ $stock->stock }}</td>
                            <td>{{ $stock->descripcion }}</td>
                            <td><img src="{{ asset('images/' . $stock->imagen) }}" alt="Imagen de repuesto" style="width: 100px; height: auto;"></td>
                            <td>{{ $stock->user->name }}</td>
                            <td>{{ $stock->updated_at->format('d/m/Y H:i:s') }}</td>
                            <td>
                                <form action="{{ route('repuestos.destroy', $stock->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </td>
                            <td>
                                <a href="{{ route('repuestos.edit', $stock->id) }}" class="btn btn-primary">Actualizar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $Articulo->appends(request()->query())->links() }}
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 50px;
        }
    </style>
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Función para enviar el formulario de búsqueda por AJAX
            $('#searchForm').submit(function(event) {
                event.preventDefault(); // Evita el envío estándar del formulario

                // Obtiene los datos del formulario
                var formData = $(this).serialize();

                // Realiza la petición AJAX
                $.ajax({
                    url: $(this).attr('action'), // URL del endpoint
                    type: $(this).attr('method'), // Método HTTP (GET por defecto)
                    data: formData, // Datos a enviar
                    success: function(response) {
                        // Actualiza la tabla de artículos con los datos recibidos
                        $('#tablaArticulosContent').html(response);
                    }
                });
            });

            // Mostrar o ocultar el campo de búsqueda por nombre según la categoría seleccionada
            if ($('#categoria').val() != '') {
                $('#nombreSearch').show();
            } else {
                $('#nombreSearch').hide();
            }

            // Evitar que se borre el valor del campo de nombre al cambiar la categoría
            $('#categoria').change(function() {
                if ($(this).val() != '') {
                    $('#nombreSearch').slideDown();
                } else {
                    $('#nombreSearch').slideUp();
                    $('#nombre').val('');
                }
            });
        });
    </script>
@stop
