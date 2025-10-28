<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solarix</title>
    <link rel="stylesheet" href="/build/css/app.css">
</head>
<body>
    <header class="header">
        <div class="contenido-header">
            <!-- Logo siempre visible -->
            <div class="header-izquierda">
                <a href="">
                    <img class="logo" src="/build/img/logo_solarix.png" alt="imagen logo">
                </a>
            </div>
            
            <!-- Menú móvil -->
            <div class="mobile-menu">
                <button class="mobile-menu-btn" id="mobile-menu-btn">
                    <span class="hamburger"></span>
                    <span class="hamburger"></span>
                    <span class="hamburger"></span>
                </button>
                
                <!-- Menú desplegable móvil -->
                <div class="mobile-menu-dropdown" id="mobile-menu-dropdown">
                    <div class="mobile-menu-content">
                        <div class="usuario-info-mobile">
                            <span class="nombre-usuario-mobile">
                                <?php echo isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Usuario'; ?>
                            </span>
                            <div class="fecha-hora-mobile">
                                <span class="fecha-actual-mobile">
                                    <?php echo date('d/m/Y'); ?>
                                </span>
                                <span class="hora-actual-mobile">
                                    <?php echo date('H:i'); ?>
                                </span>
                            </div>
                        </div>
                        
                        <nav class="mobile-nav">
                            <a href="#" class="mobile-nav-item">Dashboard</a>
                            <a href="#" class="mobile-nav-item">Perfil</a>
                            <a href="/logout" class="mobile-nav-item cerrar-sesion">Cerrar Sesión</a>
                        </nav>
                    </div>
                </div>
            </div>
            
            <!-- Título al centro -->
            <div class="header-centro">
                <h1>Bienvenido a Solarix</h1>
            </div>
            
            <!-- Usuario y hora a la derecha -->
            <div class="header-derecha">
                <div class="usuario-info">
                    <div class="info-usuario">
                        <span class="nombre-usuario">
                            <?php echo isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Usuario'; ?>
                        </span>
                        <div class="fecha-hora">
                            <span class="fecha-actual">
                                <?php echo date('d/m/Y'); ?>
                            </span>
                            <span class="hora-actual">
                                <?php echo date('H:i'); ?>
                            </span>
                        </div>
                    </div>
                    <a href="/logout" class="btn-cerrar-sesion">
                        Cerrar Sesión
                    </a>
                </div>
            </div>
        </div>
    </header>
    <?php echo $contenido; ?>
    
    <footer class="footer seccion">
       
        

        <p class="copyright">Todos los derechos son reservados <?php echo date('Y'); ?> &copy</p>
    </footer>
    <script src="build/js/app.js"></script>
</body>
</html>