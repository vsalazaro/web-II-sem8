<?php
session_start();

// Verificar si existen paquetes en el carrito
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    echo "<p>No hay paquetes en el carrito.</p>";
} else {
    echo "<h2>Carrito de Compras</h2>";
    echo "<table>";
    echo "<tr><th>Destino</th><th>Fecha de Viaje</th><th>Duración</th><th>Acciones</th></tr>";
    
    foreach ($_SESSION['carrito'] as $indice => $paquete) {
        echo "<tr>";
        echo "<td>{$paquete['destino']}</td>";
        echo "<td>{$paquete['fechaViaje']}</td>";
        echo "<td>{$paquete['duracionViaje']} días</td>";
        echo "<td><a href='actualizar_carrito.php?indice={$indice}'>Actualizar</a> | <a href='eliminar_del_carrito.php?indice={$indice}'>Eliminar</a></td>";
        echo "</tr>";
    }
    
    echo "</table>";
}

// Puedes incluir botones adicionales como "Continuar Comprando" o "Procesar Pago"
?>

<a href="index.php">Continuar Comprando</a> | <a href="procesar_pago.php">Procesar Pago</a>
