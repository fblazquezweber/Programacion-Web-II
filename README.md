# 🚀 Programación Web II - IACC

![Instituto Profesional IACC](img/Instituto_Profesional_IACC.png)  
🔗 [Sitio oficial IACC](https://www.iacc.cl/)

Repositorio de actividades de la asignatura **Programación Web II** del Instituto Profesional IACC. Organizado por semanas con enfoque en el proyecto integrador de la Semana 8.

## 🌟 Proyecto Semana 8: Agencia de Viajes
Sistema completo de reservas de vuelos y paquetes turísticos.

## 🛠️ Cómo Contribuir

### 🔹 Método Fork & Pull Request
1. **Haz Fork del repositorio**:
   - Click en "Fork" (esquina superior derecha en GitHub)
   - Esto creará una copia en tu cuenta (`tucuenta/Programacion-Web-II`)

2. **Clona tu fork localmente**:
   ```bash
   git clone https://github.com/tucuenta/Programacion-Web-II.git

## 🏗️ Estructura Detallada del Proyecto (Semana 8)

```plaintext
/Semana 8/
├── /admin/                  # 🖥️ Panel de administración
│   ├─ cerrar_sesion_admin.php  # 🚪 Cierre de sesión segura
│   ├─ consultar_hoteles.php    # 🏨 Gestión de hoteles
│   ├─ consultar_reservas.php   # 📅 Consulta básica de reservas
│   ├─ consultar_reservas_avanzada.php  # 🔍 Filtros avanzados
│   ├─ consultar_vuelos.php     # ✈️ Gestión de vuelos
│   ├─ gestion.php              # ⚙️ Panel principal de admin
│   └─ procesar.php             # 🔄 Lógica de procesamiento
│
├── /css/                    # 🎨 Hojas de estilo
│   ├─ styles.css            # 🖌️ Estilos generales
│   ├─ stylesheet.css        # 📱 Estilos responsive
│   └─ stylesuser.css        # 👤 Estilos específicos de usuario
│
├── /img/                    # 🖼️ Assets visuales
│   ├─ margarita-venezuela.jpg  # 🏖️ Destino: Margarita (Venezuela)
│   ├─ paris-francia.jpg        # 🗼 Destino: París (Francia)
│   ├─ los_roques-venezuela.jpg # 🏝️ Destino: Los Roques (Venezuela)
│   └─ tokyo-japon.jpg          # 🗾 Destino: Tokio (Japón)
│
├── /user/                   # 👨‍💻 Interfaz de usuario
│   ├─ backend.php           # ⚙️ Endpoints API
│   ├─ cerrar_sesion.php     # 🚪 Cierre de sesión
│   ├─ conexion_user.php     # 🔐 Conexión BD para usuarios
│   ├─ dashboard.html        # 📊 Panel principal
│   ├─ procesar_pago.php     # 💳 Lógica de pagos
│   └─ script.js             # 🛠️ Funcionalidades JS
│
├─ conexion.php              # 🔌 Conexión principal a BD
├─ home.html                 # 🏠 Página de inicio
├─ login.php                 # 🔑 Autenticación
└─ registro.php              # ✏️ Registro de usuarios