<?php

class FiltroViaje {
    private $nombreHotel;
    private $ciudad;
    private $pais;
    private $fechaViaje;
    private $duracionViaje;

    public function __construct($nombreHotel, $ciudad, $pais, $fechaViaje, $duracionViaje) {
        $this->nombreHotel = $nombreHotel;
        $this->ciudad = $ciudad;
        $this->pais = $pais;
        $this->fechaViaje = $fechaViaje;
        $this->duracionViaje = $duracionViaje;
    }

    // Métodos para obtener las propiedades
    public function getNombreHotel() {
        return $this->nombreHotel;
    }

    public function getCiudad() {
        return $this->ciudad;
    }

    public function getPais() {
        return $this->pais;
    }

    public function getFechaViaje() {
        return $this->fechaViaje;
    }

    public function getDuracionViaje() {
        return $this->duracionViaje;
    }

    // Métodos para establecer las propiedades
    public function setNombreHotel($nombreHotel) {
        $this->nombreHotel = $nombreHotel;
    }

    public function setCiudad($ciudad) {
        $this->ciudad = $ciudad;
    }

    public function setPais($pais) {
        $this->pais = $pais;
    }

    public function setFechaViaje($fechaViaje) {
        $this->fechaViaje = $fechaViaje;
    }

    public function setDuracionViaje($duracionViaje) {
        $this->duracionViaje = $duracionViaje;
    }

    // Método para buscar paquetes que coincidan con el filtro
    public function buscarPaquetes($paquetes) {
        $resultados = [];

        foreach ($paquetes as $paquete) {
            if ($this->ciudad == $paquete->getCiudad() && $this->fechaViaje == $paquete->getFechaViaje()) {
                $resultados[] = $paquete;
            }
        }

        return $resultados;
    }
}
?>
