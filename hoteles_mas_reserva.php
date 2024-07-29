<?php
require_once 'conexion.php';

try {
    $stmt = $conn->query("SELECT h.nombre, h.ubicacion, COUNT(r.id_hotel) AS total_reservas
                          FROM HOTEL h
                          JOIN RESERVA r ON h.id_hotel = r.id_hotel
                          GROUP BY h.id_hotel
                          HAVING COUNT(r.id_hotel) > 2");

    $hoteles = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h2>Hoteles con Más de Dos Reservas</h2>";
    echo "<table border='1'>
            <tr>
                <th>Nombre del Hotel</th>
                <th>Ubicación</th>
                <th>Total de Reservas</th>
            </tr>";
    foreach ($hoteles as $hotel) {
        echo "<tr>
                <td>{$hotel['nombre']}</td>
                <td>{$hotel['ubicacion']}</td>
                <td>{$hotel['total_reservas']}</td>
              </tr>";
    }
    echo "</table>";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>
