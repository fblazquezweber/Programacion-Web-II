document.addEventListener('DOMContentLoaded', function() {
    // Elementos del DOM
    const btnBuscar = document.getElementById('btnBuscar');
    const tipoBusqueda = document.getElementById('tipoBusqueda');
    const resultadosDiv = document.getElementById('resultados');
    const listaCarrito = document.getElementById('listaCarrito');
    const totalElement = document.getElementById('total');
    const btnPagar = document.getElementById('btnPagar');
    
    // Variables de estado
    let carrito = [];
    let total = 0;

    // Event Listeners
    btnBuscar.addEventListener('click', buscar);
    btnPagar.addEventListener('click', realizarPago);

    // Función principal de búsqueda
    async function buscar() {
        const tipo = tipoBusqueda.value;
        
        // Mostrar estado de carga
        resultadosDiv.innerHTML = `
            <div class="loading">
                <p>Buscando ${getTextoBusqueda(tipo)}...</p>
                <div class="spinner"></div>
            </div>
        `;
        
        try {
            const response = await fetch(`backend.php?tipo=${tipo}`);
            
            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }
            
            const data = await response.json();
            
            if (!data.success) {
                throw new Error(data.error || 'Error desconocido del servidor');
            }
            
            if (data.count === 0) {
                mostrarMensajeSinResultados(tipo);
                return;
            }
            
            mostrarResultados(data.data);
            
        } catch (error) {
            console.error('Error en la búsqueda:', error);
            mostrarErrorBusqueda(error);
        }
    }

    // Función para mostrar resultados
    function mostrarResultados(resultados) {
        resultadosDiv.innerHTML = '';
        
        if (tipoBusqueda.value === 'todos') {
            mostrarResultadosCombinados(resultados);
        } else {
            mostrarResultadosIndividuales(resultados);
        }
    }

    // Función para mostrar vuelos y hoteles juntos
    function mostrarResultadosCombinados(resultados) {
        const vuelos = resultados.filter(item => item.tipo === 'vuelo');
        const hoteles = resultados.filter(item => item.tipo === 'hotel');
        
        if (vuelos.length > 0) {
            const section = document.createElement('section');
            section.className = 'vuelos-section';
            section.innerHTML = '<h2>✈️ Vuelos Disponibles</h2>';
            vuelos.forEach(vuelo => {
                section.appendChild(crearCardVuelo(vuelo));
            });
            resultadosDiv.appendChild(section);
        }
        
        if (hoteles.length > 0) {
            const section = document.createElement('section');
            section.className = 'hoteles-section';
            section.innerHTML = '<h2>🏨 Hoteles Disponibles</h2>';
            hoteles.forEach(hotel => {
                section.appendChild(crearCardHotel(hotel));
            });
            resultadosDiv.appendChild(section);
        }
    }

    // Función para mostrar solo un tipo de resultado
    function mostrarResultadosIndividuales(resultados) {
        resultados.forEach(item => {
            if (item.tipo === 'vuelo') {
                resultadosDiv.appendChild(crearCardVuelo(item));
            } else if (item.tipo === 'hotel') {
                resultadosDiv.appendChild(crearCardHotel(item));
            }
        });
    }

    // Función para crear tarjeta de vuelo
    function crearCardVuelo(vuelo) {
        const precio = asegurarNumero(vuelo.precio);
        
        const card = document.createElement('div');
        card.className = 'card vuelo';
        card.innerHTML = `
            <div class="card-header">
                <h3>${vuelo.origen} → ${vuelo.destino}</h3>
            </div>
            <div class="card-body">
                <p><strong>Fecha:</strong> ${formatearFecha(vuelo.fecha)}</p>
                <p><strong>Plazas:</strong> ${vuelo.plazas_disponibles}</p>
                <p><strong>Precio:</strong> $${precio.toFixed(2)}</p>
            </div>
            <div class="card-footer">
                <button class="btn-reservar" onclick="agregarAlCarrito(${vuelo.id_vuelo}, 'vuelo', ${precio}, '${vuelo.origen} → ${vuelo.destino}')">
                    Reservar vuelo
                </button>
            </div>
        `;
        return card;
    }

    // Función para crear tarjeta de hotel
    function crearCardHotel(hotel) {
        const tarifa = asegurarNumero(hotel.tarifa_noche);
        
        const card = document.createElement('div');
        card.className = 'card hotel';
        card.innerHTML = `
            <div class="card-header">
                <h3>${hotel.nombre}</h3>
                <p class="ubicacion">📍 ${hotel.ubicacion}</p>
            </div>
            <div class="card-body">
                <p><strong>Habitaciones:</strong> ${hotel.habitaciones_disponibles}</p>
                <p><strong>Precio/noche:</strong> $${tarifa.toFixed(2)}</p>
            </div>
            <div class="card-footer">
                <button class="btn-reservar" onclick="agregarAlCarrito(${hotel.id_hotel}, 'hotel', ${tarifa}, '${hotel.nombre}')">
                    Reservar hotel
                </button>
            </div>
        `;
        return card;
    }

    // Función para agregar items al carrito
    window.agregarAlCarrito = function(id, tipo, precio, descripcion) {
        const item = {
            id,
            tipo,
            precio: asegurarNumero(precio),
            descripcion
        };
        
        carrito.push(item);
        total += item.precio;
        
        actualizarCarrito();
    };

    // Función para actualizar la visualización del carrito
    function actualizarCarrito() {
        listaCarrito.innerHTML = '';
        
        carrito.forEach((item, index) => {
            const li = document.createElement('li');
            li.innerHTML = `
                ${item.descripcion} - $${item.precio.toFixed(2)}
                <button onclick="eliminarDelCarrito(${index})" class="btn-eliminar">✕</button>
            `;
            listaCarrito.appendChild(li);
        });
        
        totalElement.textContent = total.toFixed(2);
    }

    // Función para eliminar items del carrito
    window.eliminarDelCarrito = function(index) {
        total -= carrito[index].precio;
        carrito.splice(index, 1);
        actualizarCarrito();
    };

    // Función para realizar el pago
    async function realizarPago() {
        if (carrito.length === 0) {
            alert('El carrito está vacío');
            return;
        }
        
        // Mostrar estado de carga
        btnPagar.disabled = true;
        btnPagar.textContent = 'Procesando...';
        
        try {
            const response = await fetch('procesar_pago.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    items: carrito,
                    total: total
                })
            });
            
            const data = await response.json();
            
            if (!response.ok) {
                throw new Error(data.message || 'Error en la respuesta del servidor');
            }
            
            if (data.success) {
                // Mostrar mensaje de éxito con detalles
                resultadosDiv.innerHTML = `
                    <div class="reserva-exitosa">
                        <h2>✅ Reserva completada con éxito</h2>
                        <p>ID de reserva: ${data.reserva_id}</p>
                        ${data.id_vuelo ? `<p>Vuelo reservado: ID ${data.id_vuelo}</p>` : ''}
                        ${data.id_hotel ? `<p>Hotel reservado: ID ${data.id_hotel}</p>` : ''}
                        <p>Total pagado: $${total.toFixed(2)}</p>
                        <button onclick="window.location.reload()">Hacer nueva reserva</button>
                    </div>
                `;
                
                // Limpiar carrito
                carrito = [];
                total = 0;
                actualizarCarrito();
            } else {
                throw new Error(data.message || 'Error al procesar el pago');
            }
        } catch (error) {
            console.error('Error en el pago:', error);
            
            // Mostrar error en la interfaz
            resultadosDiv.innerHTML += `
                <div class="error-reserva">
                    <h3>Error en la reserva</h3>
                    <p>${error.message}</p>
                </div>
            `;
        } finally {
            btnPagar.disabled = false;
            btnPagar.textContent = 'Realizar Pago';
        }
    }

    //Funcion cerrar sesion
    document.getElementById('btnCerrarSesion').addEventListener('click', cerrarSesion);

async function cerrarSesion() {
    try {
        const response = await fetch('cerrar_sesion.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Redirigir al login o página principal
            window.location.href = '../home.html';
        } else {
            alert('Error al cerrar sesión: ' + (result.message || 'Error desconocido'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error de conexión al intentar cerrar sesión');
    }
}

    // Funciones auxiliares
    function asegurarNumero(valor) {
        if (typeof valor === 'string') {
            return parseFloat(valor.replace(',', '.'));
        }
        return Number(valor);
    }

    function formatearFecha(fechaString) {
        const opciones = { year: 'numeric', month: 'long', day: 'numeric' };
        return new Date(fechaString).toLocaleDateString('es-ES', opciones);
    }

    function getTextoBusqueda(tipo) {
        return {
            'todos': 'vuelos y hoteles',
            'vuelos': 'vuelos',
            'hoteles': 'hoteles'
        }[tipo];
    }

    function mostrarMensajeSinResultados(tipo) {
        resultadosDiv.innerHTML = `
            <div class="no-results">
                <p>No se encontraron ${getTextoBusqueda(tipo)}</p>
                <p>Intenta con otros criterios de búsqueda</p>
            </div>
        `;
    }

    function mostrarErrorBusqueda(error) {
        resultadosDiv.innerHTML = `
            <div class="error-message">
                <h3>Error al realizar la búsqueda</h3>
                <p>${error.message}</p>
                <details>
                    <summary>Detalles técnicos</summary>
                    <p>${error.stack || 'No hay más detalles disponibles'}</p>
                </details>
                <p>Por favor, verifica:</p>
                <ul>
                    <li>Que el servidor esté funcionando</li>
                    <li>Que la base de datos esté accesible</li>
                    <li>Que el archivo backend.php exista</li>
                </ul>
            </div>
        `;
    }
});