<?php 
$cantidad = $producto->cantidad ?? 0;
?>
<h1 class="nombre-pagina">Editar Producto</h1>

<div class="contenedor-formulario">
    <div class="formulario-card">
        <div class="formulario-header">
            <h2>Información del Producto</h2>
            <p>Modifica los datos del producto seleccionado</p>
        </div>

        <form class="formulario" method="POST" action="/maestros/productos/editar?id=<?php echo $producto->id; ?>">
            <div class="campo">
                <label for="nombre">Nombre del Producto *</label>
                <input 
                    type="text" 
                    id="nombre" 
                    name="nombre" 
                    placeholder="Producto"
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
                <label for="precio">Precio *</label>
                <div class="input-group">
                    <span class="input-prefix">$</span>
                    <input 
                        type="number" 
                        id="precio" 
                        name="precio" 
                        placeholder="0.00"
                        step="0.01"
                        min="0"
                        value="<?php echo s($producto->precio ?? ''); ?>"
                        required
                    >
                </div>
                <?php if(isset($errores['precio'])): ?>
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
                <label for="cantidad">Cantidad en Stock *</label>
                <input 
                    type="number" 
                    id="cantidad" 
                    name="cantidad" 
                    placeholder="0"
                    min="0"
                    value="<?php echo s($cantidad); ?>"
                    required
                >
                <?php if(isset($errores['cantidad'])): ?>
                    <div class="error">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                            <line x1="15" y1="9" x2="9" y2="15" stroke="currentColor" stroke-width="2"/>
                            <line x1="9" y1="9" x2="15" y2="15" stroke="currentColor" stroke-width="2"/>
                        </svg>
                        <?php echo $errores['cantidad']; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="formulario-acciones">
                <a href="/maestros/productos" class="boton boton-secundario">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19 12H5M12 19L5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Cancelar
                </a>
                <button type="submit" class="boton boton-primario">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Actualizar Producto
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
                El precio debe ser mayor a 0
            </li>
            <li>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                    <path d="M9 12L11 14L15 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                La cantidad puede ser 0 o mayor
            </li>
            <li>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                    <path d="M9 12L11 14L15 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Los cambios se guardarán inmediatamente
            </li>
        </ul>
    </div>
</div>
