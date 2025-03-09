class PaqueteTuristico {
    constructor(destino, fechaSalida, precio, servicios) {
      this.destino = destino;
      this.fechaSalida = fechaSalida;
      this.precio = precio;
      this.servicios = servicios;
    }
    mostrarDetalles() {
      return `
        <strong>Destino:</strong> ${this.destino}<br>
        <strong>Fecha de salida:</strong> ${this.fechaSalida}<br>
        <strong>Precio:</strong> $${this.precio}<br>
        <strong>Servicios:</strong> ${this.servicios.join(", ")}
      `;
    }
    aplicarDescuento(porcentaje) {
      this.precio -= this.precio * (porcentaje / 100);
    }
  }
  // Array de paquetes turísticos de ejemplo
  const paquetes = [
    new PaqueteTuristico("Madrid", "2025-07-15", 500, ["Vuelo", "Hotel"]),
    new PaqueteTuristico("París", "2025-08-10", 600, ["Vuelo", "Hotel", "Tour"]),
    new PaqueteTuristico("Londres", "2025-09-05", 700, ["Vuelo", "Hotel", "Traslado"])
  ];
  
  // Función para paquetes
  function search() {
    const destinoInput = document.getElementById("destino").value.toLowerCase();
    const fechaInput = document.getElementById("fecha-viaje").value;
    const resultsContainer = document.getElementById("contenedor-resultado");
  
    let resultsHTML = `<h2>Resultados de la búsqueda</h2>`;
    // Filtra por fecha o destino
    const filtrados = paquetes.filter(p =>
      p.destino.toLowerCase().includes(destinoInput) &&
      (fechaInput === "" || p.fechaSalida === fechaInput)
    );
  
    if (filtrados.length === 0) {
      resultsHTML += `<p>No hay resultados</p>`;
    } else {
      filtrados.forEach(p => {
        resultsHTML += `<div class="paquete">${p.mostrarDetalles()}</div>`;
      });
    }
    resultsContainer.innerHTML = resultsHTML;
  }
  
  // Función para mostrar notificaciones 
  function showNotification(mensaje) {
    const notificationDiv = document.getElementById("notificacion");
    notificationDiv.innerHTML = mensaje;
    notificationDiv.style.display = "block";
  
    // Oculta la notificación después de 2 segundos
    setTimeout(() => {
      notificationDiv.style.display = "none";
    }, 5000);
  }
  
  // Notificaciones periódicas cada 10 segundos
  setInterval(() => {
    const ofertas = [
      "¡Oferta especial en París: 20% de descuento!",
      "¡Reserva ahora y obtén 15% de descuento en Londres!",
      "¡Oferta exclusiva en Madrid: paquete completo a precio especial!"
    ];
    const indice = Math.floor(Math.random() * ofertas.length);
    showNotification(ofertas[indice]);
  }, 10000);
  