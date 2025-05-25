<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Detalle de Producto</title>
  <style>
    body { font-family: sans-serif; }
    h1 { font-size: 24px; }
    p { margin: 4px 0; }
    .field { margin-bottom: 8px; }
  </style>
</head>
<body>
  <h1>Producto: {{ $producto->nombre }}</h1>

  <div class="field"><strong>ID:</strong> {{ $producto->id_producto }}</div>
  <div class="field"><strong>Marca:</strong> {{ $producto->marca }}</div>
  <div class="field"><strong>Referencia:</strong> {{ $producto->referencia }}</div>
  <div class="field"><strong>Capacidad:</strong> {{ $producto->capacidad }}</div>
  <div class="field"><strong>Características:</strong> {{ $producto->caracteristicas }}</div>
  <div class="field"><strong>Categoría:</strong> {{ $producto->categoria->nombre_categoria }}</div>

  @if($producto->imagen)
    <div class="field">
      <strong>Imagen:</strong><br>
      {{-- Para incluir la imagen en el PDF puedes usar data-uri o una ruta absoluta de servidor --}}
      <img src="{{ public_path($producto->imagen) }}" style="max-width:200px; margin-top:8px;">
    </div>
  @endif
</body>
</html>
