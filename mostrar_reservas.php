<?php
require_once 'conexion.php'; // Incluir el archivo de conexión

try {
    $stmt = $conn->query("SELECT * FROM RESERVA");
    $reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h2>Contenido de la Tabla RESERVA</h2>";
    echo "<table border='1'>
            <tr>
                <th>ID Reserva</th>
                <th>ID Cliente</th>
                <th>Fecha de Reserva</th>
                <th>ID Vuelo</th>
                <th>ID Hotel</th>
            </tr>";
    foreach ($reservas as $reserva) {
        echo "<tr>
                <td>{$reserva['id_reserva']}</td>
                <td>{$reserva['id_cliente']}</td>
                <td>{$reserva['fecha_reserva']}</td>
                <td>{$reserva['id_vuelo']}</td>
                <td>{$reserva['id_hotel']}</td>
              </tr>";
    }
    echo "</table>";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null; // Cerrar conexión
?>
