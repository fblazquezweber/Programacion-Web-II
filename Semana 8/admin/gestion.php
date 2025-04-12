<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Servicios</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Gestión de Servicios</h1>
        <div style="text-align: right;">
            <a href="cerrar_sesion_admin.php" class="btn-cerrar-sesion">Cerrar Sesión</a>
        </div>
        
        <div class="tabs">
            <button class="tab-btn active" onclick="mostrarTab('vuelos')">Vuelos</button>
            <button class="tab-btn" onclick="mostrarTab('hoteles')">Hoteles</button>
            <button class="tab-btn" onclick="mostrarTab('reservas')">Reservas</button>
            <button class="tab-btn" onclick="mostrarTab('avanzada')">Reservas por Hotel</button>
        </div>
        
        <!-- Sección Vuelos -->
        <div id="vuelos" class="tab-content active">
            <form class="form-acciones" action="procesar.php" method="post">
                <input type="hidden" name="tipo" value="vuelo">
                <div class="form-group">
                    <label>Origen: <input type="text" name="origen" required></label>
                </div>
                <div class="form-group">
                    <label>Destino: <input type="text" name="destino" required></label>
                </div>
                <div class="form-group">
                    <label>Fecha: <input type="date" name="fecha" required></label>
                </div>
                <div class="form-group">
                    <label>Plazas: <input type="number" name="plazas" min="1" required></label>
                </div>
                <div class="form-group">
                    <label>Precio ($): <input type="number" name="precio" min="0" step="0.01" required></label>
                </div>
                <div class="botones-accion">
                    <button type="submit" class="btn-agregar">Agregar Vuelo</button>
                    <button type="button" class="btn-consulta" onclick="cargarConsulta('vuelos')">Consultar Vuelos</button>
                </div>
            </form>
            
            <div id="resultados-vuelos" class="resultados-consulta">
                <?php if(isset($_GET['consulta']) && $_GET['consulta'] == 'vuelos'): ?>
                    <h3>Resultados de Vuelos</h3>
                    <?php include 'consultar_vuelos.php'; ?>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Sección Hoteles -->
        <div id="hoteles" class="tab-content">
            <form class="form-acciones" action="procesar.php" method="post">
                <input type="hidden" name="tipo" value="hotel">
                <div class="form-group">
                    <label>Nombre: <input type="text" name="nombre" required></label>
                </div>
                <div class="form-group">
                    <label>Ubicación: <input type="text" name="ubicacion" required></label>
                </div>
                <div class="form-group">
                    <label>Habitaciones: <input type="number" name="habitaciones" min="1" required></label>
                </div>
                <div class="form-group">
                    <label>Tarifa ($): <input type="number" name="tarifa" min="0" step="0.01" required></label>
                </div>
                <div class="botones-accion">
                    <button type="submit" class="btn-agregar">Agregar Hotel</button>
                    <button type="button" class="btn-consulta" onclick="cargarConsulta('hoteles')">Consultar Hoteles</button>
                </div>
            </form>
            
            <div id="resultados-hoteles" class="resultados-consulta">
                <?php if(isset($_GET['consulta']) && $_GET['consulta'] == 'hoteles'): ?>
                    <h3>Resultados de Hoteles</h3>
                    <?php include 'consultar_hoteles.php'; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Sección Reservas -->
        <div id="reservas" class="tab-content">
            <div class="botones-accion">
                <button type="button" class="btn-consulta" onclick="cargarConsulta('reservas')">Consultar Reservas</button>
            </div>
            
            <div id="resultados-reservas" class="resultados-consulta">
                <?php if(isset($_GET['consulta']) && $_GET['consulta'] == 'reservas'): ?>
                    <h3>Resultados de Reservas</h3>
                    <?php include 'consultar_reservas.php'; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Sección Avanzada -->
        <div id="avanzada" class="tab-content">
    <div class="botones-accion">
        <button type="button" class="btn-consulta" onclick="cargarConsulta('avanzada')">Consultar Reservas Avanzadas</button>
    </div>
    <div id="resultados-avanzada" class="resultados-consulta">
        <?php if(isset($_GET['consulta']) && $_GET['consulta'] == 'avanzada'): ?>
            <h3>Lista de Hoteles Ordenados por Reservas</h3>
            <?php include 'consultar_reservas_avanzada.php'; ?>
        <?php endif; ?>
    </div>
</div>

    <script>
        // Función para mostrar pestañas
        function mostrarTab(tabId) {
            // Ocultar todos los contenidos
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Desactivar todos los botones
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Mostrar el contenido seleccionado
            document.getElementById(tabId).classList.add('active');
            
            // Activar el botón clickeado
            event.target.classList.add('active');
        }

        // Función para cargar consultas
        function cargarConsulta(tipo) {
            window.location.href = 'gestion.php?consulta=' + tipo;
        }

        // Cargar la pestaña correcta al inicio
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const consulta = urlParams.get('consulta');
            
            const tabId = consulta || 'vuelos'; // Default a vuelos si no hay parámetro
            
            // Mostrar la pestaña correspondiente
            if (tabId) {
                document.querySelectorAll('.tab-content').forEach(tab => {
                    tab.classList.remove('active');
                });
                document.querySelectorAll('.tab-btn').forEach(btn => {
                    btn.classList.remove('active');
                });
                
                document.getElementById(tabId).classList.add('active');
                
                // Activar el botón correspondiente
                const botones = document.querySelectorAll('.tab-btn');
                for (let btn of botones) {
                    if (btn.textContent.trim().toLowerCase().includes(tabId)) {
                        btn.classList.add('active');
                        break;
                    }
                }
            }
        });
    </script>
</body>
</html>