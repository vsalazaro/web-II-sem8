<?php
require_once 'conexion.php'; // Incluir el archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Obtener y sanitizar los datos del formulario
        $origen = htmlspecialchars($_POST['origen']);
        $destino = htmlspecialchars($_POST['destino']);
        $fecha = $_POST['fecha'];
        $plazas_disponibles = intval($_POST['plazas_disponibles']);
        $precio = floatval($_POST['precio']);

        // Validar datos (podría implementarse validación adicional aquí)

        // Preparar consulta SQL para insertar en la tabla VUELO
        $stmt = $conn->prepare("INSERT INTO VUELO (origen, destino, fecha, plazas_disponibles, precio) 
                                VALUES (:origen, :destino, :fecha, :plazas_disponibles, :precio)");
        $stmt->bindParam(':origen', $origen);
        $stmt->bindParam(':destino', $destino);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':plazas_disponibles', $plazas_disponibles);
        $stmt->bindParam(':precio', $precio);

        // Ejecutar la consulta
        $stmt->execute();

        echo "Vuelo registrado correctamente.";

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null; // Cerrar conexión
}
?>
