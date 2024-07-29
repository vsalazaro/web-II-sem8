<?php
// Incluir la clase FiltroViaje
require 'FiltroViaje.php';
session_start(); // Iniciar la sesión para usar el carrito

// Inicializar la variable $mensaje
$mensaje = "";

// Función para obtener notificaciones
function obtenerNotificaciones() {
    $notificaciones = [
        "Oferta especial: 10% de descuento en vuelos a París.",
        "Reserva ahora y obtén 15% de descuento en hoteles en Roma.",
        "Descuento del 20% en paquetes turísticos a Tokio."
    ];
    return $notificaciones;
}

// Inicializar el carrito de compras si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Procesar el formulario de registro
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nombreHotel'])) {
    $nombreHoteles = $_POST['nombreHotel'];
    $ciudades = $_POST['ciudad'];
    $paises = $_POST['pais'];
    $fechasViaje = $_POST['fechaViaje'];
    $duracionesViaje = $_POST['duracionViaje'];
    $destinos = $_POST['destino'];

    // Verificar que todas las entradas sean arrays antes de procesarlas
    if (is_array($nombreHoteles) && is_array($ciudades) && is_array($paises) && is_array($fechasViaje) && is_array($duracionesViaje) && is_array($destinos)) {
        for ($i = 0; $i < count($destinos); $i++) {
            $paquete = [
                'nombre_hotel' => $nombreHoteles[$i],
                'ciudad' => $ciudades[$i],
                'pais' => $paises[$i],
                'fecha_viaje' => $fechasViaje[$i],
                'duracion_viaje' => $duracionesViaje[$i],
                'destino' => $destinos[$i]
            ];
            $_SESSION['carrito'][] = $paquete;
        }
    }
}

// Procesar el carrito de compras
if (isset($_POST['accion']) && $_POST['accion'] == 'procesar_carrito') {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "agencia_viajes";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insertar los datos del carrito en la base de datos
        foreach ($_SESSION['carrito'] as $paquete) {
            $stmt = $conn->prepare("INSERT INTO paquetes (nombre_hotel, ciudad, pais, fecha_viaje, duracion_viaje, destino) VALUES (:nombre_hotel, :ciudad, :pais, :fecha_viaje, :duracion_viaje, :destino)");
            $stmt->bindParam(':nombre_hotel', $paquete['nombre_hotel']);
            $stmt->bindParam(':ciudad', $paquete['ciudad']);
            $stmt->bindParam(':pais', $paquete['pais']);
            $stmt->bindParam(':fecha_viaje', $paquete['fecha_viaje']);
            $stmt->bindParam(':duracion_viaje', $paquete['duracion_viaje']);
            $stmt->bindParam(':destino', $paquete['destino']);
            $stmt->execute();
        }

        // Limpiar el carrito después de procesar
        $_SESSION['carrito'] = [];
        $mensaje = "Carrito procesado y paquetes registrados en la base de datos.";
    } catch(PDOException $e) {
        $mensaje = "Error: " . $e->getMessage();
    }

    $conn = null;
}

require_once 'conexion.php'; // Incluir el archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Comenzar una transacción para asegurar la integridad de los datos
        $conn->beginTransaction();

        // Procesar cada conjunto de datos enviado por el formulario
        foreach ($_POST['nombreHotel'] as $index => $nombreHotel) {
            $ciudad = $_POST['ciudad'][$index];
            $pais = $_POST['pais'][$index];
            $fechaViaje = $_POST['fechaViaje'][$index];
            $duracionViaje = $_POST['duracionViaje'][$index];
            $destino = $_POST['destino'][$index];

            // Insertar en la tabla HOTEL
            $stmtHotel = $conn->prepare("INSERT INTO HOTEL (nombre, ubicacion) VALUES (:nombreHotel, :ciudadPais)");
            $stmtHotel->bindValue(':nombreHotel', $nombreHotel);
            $stmtHotel->bindValue(':ciudadPais', "$ciudad, $pais");
            $stmtHotel->execute();
            $id_hotel = $conn->lastInsertId();

            // Insertar en la tabla VUELO
            $stmtVuelo = $conn->prepare("INSERT INTO VUELO (origen, destino, fecha, plazas_disponibles, precio) 
                                         VALUES (:origen, :destino, :fecha, :plazas_disponibles, :precio)");
            // Valores estáticos para demostración, ajustar según necesidad real
            $origen = 'Ciudad de Origen';
            $fecha = date('Y-m-d');
            $plazas_disponibles = 100;
            $precio = 500.00;
            $stmtVuelo->bindValue(':origen', $origen);
            $stmtVuelo->bindValue(':destino', $destino);
            $stmtVuelo->bindValue(':fecha', $fecha);
            $stmtVuelo->bindValue(':plazas_disponibles', $plazas_disponibles);
            $stmtVuelo->bindValue(':precio', $precio);
            $stmtVuelo->execute();
            $id_vuelo = $conn->lastInsertId();

            // Insertar en la tabla RESERVA
            $fechaReserva = date('Y-m-d');
            $id_cliente = 1; // Ejemplo de cliente, ajustar según el sistema de autenticación
            $stmtReserva = $conn->prepare("INSERT INTO RESERVA (id_cliente, fecha_reserva, id_vuelo, id_hotel) 
                                           VALUES (:id_cliente, :fechaReserva, :id_vuelo, :id_hotel)");
            $stmtReserva->bindValue(':id_cliente', $id_cliente);
            $stmtReserva->bindValue(':fechaReserva', $fechaReserva);
            $stmtReserva->bindValue(':id_vuelo', $id_vuelo);
            $stmtReserva->bindValue(':id_hotel', $id_hotel);
            $stmtReserva->execute();
        }

        // Confirmar la transacción si todo fue exitoso
        $conn->commit();
        echo "Paquetes registrados correctamente.";

    } catch (PDOException $e) {
        // Revertir la transacción si hay un error
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }

    $conn = null; // Cerrar conexión
}


// Obtener las notificaciones
$notificaciones = obtenerNotificaciones();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procesar Registro</title>
    <style>
        .register-container {
            text-align: center;
            margin-top: 20px;
        }
        #notifications-container {
            margin-top: 20px;
            text-align: center;
            color: rgb(255, 0, 0);
            font-weight: bold;
        }
        /* Estilos para el contenedor del carrito */
        .cart-container {
            margin-top: 20px;
            padding: 20px;
            background-color: #f9f9f9; /* Color de fondo más suave */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra más suave para profundidad */
            border-radius: 15px; /* Bordes redondeados */
            max-width: 400px;
            position: relative; /* Posición relativa para el ícono absoluto */
            margin: auto; /* Centrar en la página */
            text-align: left; /* Alinear texto a la izquierda */
        }

        /* Estilos para el ícono del carrito */
        .cart-icon {
            position: absolute; /* Posición absoluta para colocar sobre el contenedor */
            top: -30px; /* Ajusta la posición superior según sea necesario */
            right: 20px; /* Ajusta la posición derecha según sea necesario */
            font-size: 30px; /* Tamaño del ícono */
        }
    </style>
</head>
<body>
    <div class="register-container">
        <p><?php echo $mensaje; ?></p>

        <div id="notifications-container">
            <!-- Las notificaciones en tiempo real se mostrarán aquí -->
        </div>

        <div class="cart-container">
            <!-- Ícono del carrito -->
            <img src="carrito-icon.png" alt="" class="cart-icon">

            <h2>Carrito de Compras</h2>
            <?php if (!empty($_SESSION['carrito'])) { ?>
                <ul>
                    <?php foreach ($_SESSION['carrito'] as $index => $paquete) { ?>
                        <li>
                            <?php echo "Destino: " . htmlspecialchars($paquete['destino']) . ", Fecha: " . htmlspecialchars($paquete['fecha_viaje']); ?>
                            <form action="procesar_registro.php" method="POST" style="display:inline;">
                                <input type="hidden" name="index" value="<?php echo $index; ?>">
                                <input type="hidden" name="accion" value="eliminar">
                                <button type="submit">Eliminar</button>
                            </form>
                        </li>
                    <?php } ?>
                </ul>
                <form action="procesar_registro.php" method="POST">
                    <input type="hidden" name="accion" value="procesar_carrito">
                    <button type="submit">Procesar Carrito</button>
                </form>
            <?php } else {
                echo "<p>No hay destinos en el carrito de compras.</p>";
            } ?>
        </div>

        <br>
        <a href="index.php">Volver al registro</a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Array de notificaciones desde PHP
            var notificaciones = <?php echo json_encode($notificaciones); ?>;
            var index = 0;
            var notificationsContainer = document.getElementById('notifications-container');

            // Función para mostrar notificación
            function mostrarNotificacion() {
                notificationsContainer.textContent = notificaciones[index];
                index = (index + 1) % notificaciones.length;
            }

            // Mostrar la primera notificación
            mostrarNotificacion();

            // Intervalo para cambiar notificaciones
            setInterval(mostrarNotificacion, 5000);
        });
    </script>
</body>
</html>

