<div id="notificacion" class="notificacion">
  <?php
    // Ofertas disponibles
    $ofertas = [
      "¡Oferta especial en París: 20% de descuento!",
      "¡Reserva ahora y obtén 15% de descuento en Londres!",
      "¡Oferta exclusiva en Madrid: paquete completo a precio especial!"
    ];

    // Selección aleatoria de oferta
    $ofertaSeleccionada = $ofertas[array_rand($ofertas)];

    // Mostrar la oferta seleccionada
    echo $ofertaSeleccionada;
  ?>
</div>