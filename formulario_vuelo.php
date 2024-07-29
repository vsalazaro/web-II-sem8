<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Vuelo</title>
    <script>
        function validarFormulario() {
            // Validar campos aquí según sea necesario
            return true; // Cambiar según las validaciones
        }
    </script>
</head>
<body>
    <h2>Registro de Vuelo</h2>
    <form action="procesar_vuelo.php" method="POST" onsubmit="return validarFormulario()">
        <label for="origen">Origen:</label>
        <input type="text" id="origen" name="origen" required><br><br>

        <label for="destino">Destino:</label>
        <input type="text" id="destino" name="destino" required><br><br>

        <label for="fecha">Fecha:</label>
        <input type="date" id="fecha" name="fecha" required><br><br>

        <label for="plazas_disponibles">Plazas Disponibles:</label>
        <input type="number" id="plazas_disponibles" name="plazas_disponibles" required><br><br>

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" step="0.01" required><br><br>

        <input type="submit" value="Registrar Vuelo">
    </form>
</body>
</html>
