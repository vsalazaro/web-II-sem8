<?php
require_once 'conexion.php'; // Incluir el archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Comenzar una transacción para asegurar la integridad de los datos
        $conn->beginTransaction();

        // Procesar cada conjunto de datos enviado por el formulario
        $origen = $_POST['origen'];
        $destino = $_POST['destino'];
        $fecha = $_POST['fecha'];
        $plazas_disponibles = $_POST['plazas_disponibles'];
        $precio = $_POST['precio'];

        $nombreHotel = $_POST['nombreHotel'];
        $ubicacion = $_POST['ubicacion'];
        $habitaciones_disponibles = $_POST['habitaciones_disponibles'];
        $tarifa_noche = $_POST['tarifa_noche'];

        $id_cliente = $_POST['id_cliente'];
        $fecha_reserva = $_POST['fecha_reserva'];
        $id_vuelo = $_POST['id_vuelo'];
        $id_hotel = $_POST['id_hotel'];

        // Insertar en la tabla VUELO
        $stmtVuelo = $conn->prepare("INSERT INTO VUELO (origen, destino, fecha, plazas_disponibles, precio) 
                                     VALUES (:origen, :destino, :fecha, :plazas_disponibles, :precio)");
        $stmtVuelo->bindValue(':origen', $origen);
        $stmtVuelo->bindValue(':destino', $destino);
        $stmtVuelo->bindValue(':fecha', $fecha);
        $stmtVuelo->bindValue(':plazas_disponibles', $plazas_disponibles);
        $stmtVuelo->bindValue(':precio', $precio);
        $stmtVuelo->execute();
        $id_vuelo = $conn->lastInsertId();

        // Insertar en la tabla HOTEL
        $stmtHotel = $conn->prepare("INSERT INTO HOTEL (nombre, ubicacion, habitaciones_disponibles, tarifa_noche) 
                                     VALUES (:nombreHotel, :ubicacion, :habitaciones_disponibles, :tarifa_noche)");
        $stmtHotel->bindValue(':nombreHotel', $nombreHotel);
        $stmtHotel->bindValue(':ubicacion', $ubicacion);
        $stmtHotel->bindValue(':habitaciones_disponibles', $habitaciones_disponibles);
        $stmtHotel->bindValue(':tarifa_noche', $tarifa_noche);
        $stmtHotel->execute();
        $id_hotel = $conn->lastInsertId();

        // Insertar en la tabla RESERVA
        $stmtReserva = $conn->prepare("INSERT INTO RESERVA (id_cliente, fecha_reserva, id_vuelo, id_hotel) 
                                       VALUES (:id_cliente, :fecha_reserva, :id_vuelo, :id_hotel)");
        $stmtReserva->bindValue(':id_cliente', $id_cliente);
        $stmtReserva->bindValue(':fecha_reserva', $fecha_reserva);
        $stmtReserva->bindValue(':id_vuelo', $id_vuelo);
        $stmtReserva->bindValue(':id_hotel', $id_hotel);
        $stmtReserva->execute();

        // Confirmar la transacción
        $conn->commit();
        echo "Datos registrados correctamente.";

    } catch (PDOException $e) {
        // Revertir la transacción si hay un error
        if (isset($conn)) {
            $conn->rollback();
        }
        echo "Error: " . $e->getMessage();
    } finally {
        // Cerrar la conexión
        $conn = null;
    }
}
?>
