<?php
require_once 'conexion.php'; // Incluir el archivo de conexión

try {
    $conn->beginTransaction();

    // Datos de ejemplo para diez reservas
    $reservas = [
        ['id_cliente' => 1, 'fecha_reserva' => '2024-07-15', 'id_vuelo' => 1, 'id_hotel' => 1],
        ['id_cliente' => 2, 'fecha_reserva' => '2024-07-16', 'id_vuelo' => 2, 'id_hotel' => 2],
        ['id_cliente' => 3, 'fecha_reserva' => '2024-07-17', 'id_vuelo' => 3, 'id_hotel' => 3],
        ['id_cliente' => 4, 'fecha_reserva' => '2024-07-18', 'id_vuelo' => 4, 'id_hotel' => 4],
        ['id_cliente' => 5, 'fecha_reserva' => '2024-07-19', 'id_vuelo' => 5, 'id_hotel' => 5],
        ['id_cliente' => 6, 'fecha_reserva' => '2024-07-20', 'id_vuelo' => 1, 'id_hotel' => 1],
        ['id_cliente' => 7, 'fecha_reserva' => '2024-07-21', 'id_vuelo' => 2, 'id_hotel' => 2],
        ['id_cliente' => 8, 'fecha_reserva' => '2024-07-22', 'id_vuelo' => 3, 'id_hotel' => 3],
        ['id_cliente' => 9, 'fecha_reserva' => '2024-07-23', 'id_vuelo' => 4, 'id_hotel' => 4],
        ['id_cliente' => 10, 'fecha_reserva' => '2024-07-24', 'id_vuelo' => 5, 'id_hotel' => 5]
    ];

    $stmt = $conn->prepare("INSERT INTO RESERVA (id_cliente, fecha_reserva, id_vuelo, id_hotel) 
                            VALUES (:id_cliente, :fecha_reserva, :id_vuelo, :id_hotel)");

    foreach ($reservas as $reserva) {
        $stmt->bindParam(':id_cliente', $reserva['id_cliente']);
        $stmt->bindParam(':fecha_reserva', $reserva['fecha_reserva']);
        $stmt->bindParam(':id_vuelo', $reserva['id_vuelo']);
        $stmt->bindParam(':id_hotel', $reserva['id_hotel']);
        $stmt->execute();
    }

    $conn->commit();
    echo "Diez reservas registradas correctamente.";
} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}

$conn = null; // Cerrar conexión
?>
