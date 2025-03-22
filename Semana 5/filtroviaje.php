<?php
class FiltroViaje {
    public $nombreHotel;
    public $ciudad;
    public $pais;
    public $fechaViaje;
    public $duracion;
    public $precio; // Nuevo campo: precio

    public function __construct($nombreHotel, $ciudad, $pais, $fechaViaje, $duracion, $precio) {
        $this->nombreHotel = $nombreHotel;
        $this->ciudad = $ciudad;
        $this->pais = $pais;
        $this->fechaViaje = $fechaViaje;
        $this->duracion = $duracion;
        $this->precio = $precio; // Inicializar el precio
    }

    // Método estático para filtrar los viajes
    public static function filtrarViajes($viajes, $criterios) {
        $resultados = [];
        foreach ($viajes as $viaje) {
            if ((!$criterios['pais'] || stripos($viaje->pais, $criterios['pais']) !== false) &&
                (!$criterios['ciudad'] || stripos($viaje->ciudad, $criterios['ciudad']) !== false) &&
                (!$criterios['nombreHotel'] || stripos($viaje->nombreHotel, $criterios['nombreHotel']) !== false) &&
                (!$criterios['fechaViaje'] || $viaje->fechaViaje == $criterios['fechaViaje']) &&
                (!$criterios['duracion'] || $viaje->duracion == $criterios['duracion'])) {
                $resultados[] = $viaje;
            }
        }
        return $resultados;
    }
}
?>