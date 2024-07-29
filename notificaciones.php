<?php
function obtenerNotificaciones() {
    $notificaciones = [
        "Oferta especial: 10% de descuento en vuelos a París.",
        "Reserva ahora y obtén 15% de descuento en hoteles en Roma.",
        "Descuento del 20% en paquetes turísticos a Tokio."
    ];
    return $notificaciones[array_rand($notificaciones)];
}

$notificacion = obtenerNotificaciones();
?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var mensaje = "<?php echo $notificacion; ?>";
        alert(mensaje);
    });
</script>
