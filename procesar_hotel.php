<?php
require_once 'conexion.php'; // Incluir el archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Obtener y sanitizar los datos del formulario
        $nombreHotel = htmlspecialchars($_POST['nombreHotel']);
        $ubicacion = htmlspecialchars($_POST['ubicacion']);
        $habitaciones_disponibles = intval($_POST['habitaciones_disponibles']);
        $tarifa_noche = floatval($_POST['tarifa_noche']);

        // Validar datos (podría implementarse validación adicional aquí)

        // Preparar consulta SQL para insertar en la tabla HOTEL
        $stmt = $conn->prepare("INSERT INTO HOTEL (nombre, ubicacion, habitaciones_disponibles, tarifa_noche) 
                                VALUES (:nombreHotel, :ubicacion, :habitaciones_disponibles, :tarifa_noche)");
        $stmt->bindParam(':nombreHotel', $nombreHotel);
        $stmt->bindParam(':ubicacion', $ubicacion);
        $stmt->bindParam(':habitaciones_disponibles', $habitaciones_disponibles);
        $stmt->bindParam(':tarifa_noche', $tarifa_noche);

        // Ejecutar la consulta
        $stmt->execute();

        echo "Hotel registrado correctamente.";

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null; // Cerrar conexión
}
?>
