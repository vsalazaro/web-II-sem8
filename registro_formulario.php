
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Vuelos, Hoteles y Reservas</title>
</head>
<body>

<h2>Registro de Vuelos, Hoteles y Reservas</h2>
<form action="procesar_registro2.php" method="POST">
    <h2>Registro de Vuelos</h2>
    <label for="origen">Origen:</label><br>
    <input type="text" id="origen" name="origen" required><br>

    <label for="destino">Destino:</label><br>
    <input type="text" id="destino" name="destino" required><br>

    <label for="fecha">Fecha:</label><br>
    <input type="date" id="fecha" name="fecha" required><br>

    <label for="plazas_disponibles">Plazas Disponibles:</label><br>
    <input type="number" id="plazas_disponibles" name="plazas_disponibles" required><br>

    <label for="precio">Precio:</label><br>
    <input type="number" step="0.01" id="precio" name="precio" required><br><br>

    <h2>Registro de Hoteles</h2>
    <label for="nombreHotel">Nombre del Hotel:</label><br>
    <input type="text" id="nombreHotel" name="nombreHotel" required><br>

    <label for="ubicacion">Ubicación:</label><br>
    <input type="text" id="ubicacion" name="ubicacion" required><br>

    <label for="habitaciones_disponibles">Habitaciones Disponibles:</label><br>
    <input type="number" id="habitaciones_disponibles" name="habitaciones_disponibles" required><br>

    <label for="tarifa_noche">Tarifa por Noche:</label><br>
    <input type="number" step="0.01" id="tarifa_noche" name="tarifa_noche" required><br><br>

    <h2>Registro de Reservas</h2>
    <label for="id_cliente">ID Cliente:</label><br>
    <input type="number" id="id_cliente" name="id_cliente" required><br>

    <label for="fecha_reserva">Fecha de Reserva:</label><br>
    <input type="date" id="fecha_reserva" name="fecha_reserva" required><br>

    <label for="id_vuelo">ID Vuelo:</label><br>
    <input type="number" id="id_vuelo" name="id_vuelo" required><br>

    <label for="id_hotel">ID Hotel:</label><br>
    <input type="number" id="id_hotel" name="id_hotel" required><br><br>

    <input type="submit" value="Registrar">
</form>

</body>
</html>
