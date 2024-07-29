<?php
// Incluir la clase FiltroViaje
require 'FiltroViaje.php';

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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombreHotel = $_POST['nombreHotel'];
    $ciudad = $_POST['ciudad'];
    $pais = $_POST['pais'];
    $fechaViaje = $_POST['fechaViaje'];
    $duracionViaje = $_POST['duracionViaje'];
    $destino = $_POST['destino'];

    // Crear una nueva instancia de FiltroViaje
    $nuevoPaquete = new FiltroViaje($nombreHotel, $ciudad, $pais, $fechaViaje, $duracionViaje);

    // Configuración de la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "agencia_viajes";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insertar los datos del paquete en la base de datos
        $stmt = $conn->prepare("INSERT INTO paquetes (nombre_hotel, ciudad, pais, fecha_viaje, duracion_viaje, destino) VALUES (:nombre_hotel, :ciudad, :pais, :fecha_viaje, :duracion_viaje, :destino)");
        $stmt->bindParam(':nombre_hotel', $nombreHotel);
        $stmt->bindParam(':ciudad', $ciudad);
        $stmt->bindParam(':pais', $pais);
        $stmt->bindParam(':fecha_viaje', $fechaViaje);
        $stmt->bindParam(':duracion_viaje', $duracionViaje);
        $stmt->bindParam(':destino', $destino);

        $stmt->execute();

        // Notificación de éxito
        $mensaje = "Paquete registrado y guardado en la base de datos.";
    } catch(PDOException $e) {
        $mensaje = "Error: " . $e->getMessage();
    }

    $conn = null;

    // Obtener las notificaciones
    $notificaciones = obtenerNotificaciones();
}
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
    </style>
</head>
<body>
    <div class="register-container">
        <p><?php echo $mensaje; ?></p>

        <div id="notifications-container">
            <!-- Las notificaciones en tiempo real se mostrarán aquí -->
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

<?php
// Procesar múltiples destinos enviados desde el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $destinos = $_POST['destino'];
    $nombreHoteles = $_POST['nombreHotel'];
    $ciudades = $_POST['ciudad'];
    $paises = $_POST['pais'];
    $fechasViaje = $_POST['fechaViaje'];
    $duracionesViaje = $_POST['duracionViaje'];

    // Configuración de la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "agencia_viajes";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Iterar sobre cada destino y guardar en la base de datos
        for ($i = 0; $i < count($destinos); $i++) {
            $nombreHotel = $nombreHoteles[$i];
            $ciudad = $ciudades[$i];
            $pais = $paises[$i];
            $fechaViaje = $fechasViaje[$i];
            $duracionViaje = $duracionesViaje[$i];
            $destino = $destinos[$i];

            // Insertar los datos del paquete en la base de datos
            $stmt = $conn->prepare("INSERT INTO paquetes (nombre_hotel, ciudad, pais, fecha_viaje, duracion_viaje, destino) VALUES (:nombre_hotel, :ciudad, :pais, :fecha_viaje, :duracion_viaje, :destino)");
            $stmt->bindParam(':nombre_hotel', $nombreHotel);
            $stmt->bindParam(':ciudad', $ciudad);
            $stmt->bindParam(':pais', $pais);
            $stmt->bindParam(':fecha_viaje', $fechaViaje);
            $stmt->bindParam(':duracion_viaje', $duracionViaje);
            $stmt->bindParam(':destino', $destino);

            $stmt->execute();
        }

        // Notificación de éxito
        $mensaje = "Paquetes registrados y guardados en la base de datos correctamente.";
    } catch(PDOException $e) {
        $mensaje = "Error: " . $e->getMessage();
    }

    $conn = null;
}
?>


</body>
</html>
