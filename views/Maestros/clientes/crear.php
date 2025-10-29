<h1 class="nombre-pagina">Creacion de Clientes</h1>

<div class="contenedor-formulario">
    <div class="formulario-card">
        <div class="formulario-header">
            <h2>Información del Cliente</h2>
            <p>Completa los datos para crear un nuevo cliente</p>
        </div>

        <form class="formulario" method="POST" action="/maestros/clientes/crear">
            <div class="campo">
                <label for="nombre">Nombre del Cliente *</label>
                <input 
                    type="text" 
                    id="nombre" 
                    name="nombre" 
                    placeholder="Cliente"
                    value="<?php echo s($producto->nombre ?? ''); ?>"
                    required
                >
                <?php if(isset($errores['nombre'])): ?>
                    <div class="error">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                            <line x1="15" y1="9" x2="9" y2="15" stroke="currentColor" stroke-width="2"/>
                            <line x1="9" y1="9" x2="15" y2="15" stroke="currentColor" stroke-width="2"/>
                        </svg>
                        <?php echo $errores['nombre']; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="campo">
                <label for="apellido">Apellido del Cliente *</label>                
                <input 
                    type="text" 
                    id="apellido" 
                    name="apellido" 
                    placeholder="Apellido"
                    value="<?php echo s($cliente->apellido ?? ''); ?>"
                    required
                    >
                
                <?php if(isset($errores['apellido'])): ?>
                    <div class="error">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                            <line x1="15" y1="9" x2="9" y2="15" stroke="currentColor" stroke-width="2"/>
                            <line x1="9" y1="9" x2="15" y2="15" stroke="currentColor" stroke-width="2"/>
                        </svg>
                        <?php echo $errores['precio']; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="campo">
                <label for="telefono">Telefono del Cliente *</label>
                <input 
                    type="tel" 
                    id="telefono" 
                    name="telefono" 
                    placeholder="Telefono"
                    value="<?php echo s($cliente->telefono ?? ''); ?>"
                    required
                
                >
                <?php if(isset($errores['telefono'])): ?>
                    <div class="error">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                            <line x1="15" y1="9" x2="9" y2="15" stroke="currentColor" stroke-width="2"/>
                            <line x1="9" y1="9" x2="15" y2="15" stroke="currentColor" stroke-width="2"/>
                        </svg>
                        <?php echo $errores['telefono']; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="formulario-acciones">
                <a href="/maestros/clientes" class="boton boton-secundario">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19 12H5M12 19L5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Cancelar
                </a>
                <button type="submit" class="boton boton-primario">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Crear Cliente
                </button>
            </div>
        </form>
    </div>

    <!-- Información adicional -->
    <div class="info-card">
        <h3>Información Importante</h3>
        <ul>
            <li>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                    <path d="M9 12L11 14L15 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                El nombre debe ser descriptivo y único
            </li>
            <li>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                    <path d="M9 12L11 14L15 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                El apellido debe ser descriptivo y único
            </li>
            <li>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                    <path d="M9 12L11 14L15 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                El telefono debe ser un numero de telefono valido
            </li>
        </ul>
    </div>
</div>
