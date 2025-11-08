<h1 class="nombre-pagina"> <?php echo $titulo_pagina; ?> </h1>

<div class="contenedor-formulario">
    <div class="formulario-card">
        <div class="formulario-header">
            <h2>Información del Producto</h2>
            <p>Completa los datos para <?php echo $descripcion_pagina; ?></p>
        </div>

        <form class="formulario" method="POST" action="<?php echo $action_formulario; ?>">
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
                    readonly
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

            <div class="campo">
                <label class="checkbox-label">
                    <input 
                        type="checkbox" 
                        id="escombo" 
                        name="escombo" 
                        value="1"
                        <?php echo (isset($producto->escombo) && $producto->escombo == 1) ? 'checked' : ''; ?>
                    >
                    <span class="checkbox-text">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Este producto es un combo
                    </span>
                </label>
                <p class="campo-descripcion">Marca esta opción si este producto es un combo que contiene otros productos</p>
            </div>

            <!-- Sección de componentes del combo (solo visible cuando es combo) -->
            <div id="seccion-combo" class="seccion-combo" style="display: <?php echo (isset($producto->escombo) && $producto->escombo == 1) ? 'block' : 'none'; ?>;">
                <div class="combo-header">
                    <h3>
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Productos del Combo
                    </h3>
                    <p>Agrega los productos que forman parte de este combo</p>
                </div>

                <div id="lista-productos-combo" class="lista-productos-combo">
                    <?php 
                    // Si está editando y tiene componentes, mostrarlos
                    $componentesExistentes = $componentesExistentes ?? [];
                    
                    if(!empty($componentesExistentes)): 
                        foreach($componentesExistentes as $index => $componente): 
                    ?>
                        <div class="tarjeta-producto-combo" data-index="<?php echo $index; ?>">
                            <div class="tarjeta-producto-header">
                                <span class="numero-producto">#<?php echo $index + 1; ?></span>
                                <button type="button" class="btn-eliminar-producto-combo" title="Eliminar producto del combo">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                            </div>
                            
                            <div class="tarjeta-producto-body">
                                <div class="campo-tarjeta">
                                    <label>Producto *</label>
                                    <select name="combo_detalle[<?php echo $index; ?>][id_producto]" class="select-producto-combo" required>
                                        <option value="">-- Seleccione un producto --</option>
                                        <?php if (!empty($productos) && is_array($productos) && count($productos) > 0): ?>
                                            <?php foreach ($productos as $p): ?>
                                                <option 
                                                    value="<?php echo s($p->id); ?>"
                                                    <?php echo (isset($componente['id_producto']) && (string)$p->id === (string)$componente['id_producto']) ? 'selected' : ''; ?>
                                                >
                                                    <?php echo s($p->nombre ?? ('Producto #' . $p->id)); ?> - $<?php echo number_format($p->precio ?? 0, 2); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <option value="" disabled>No hay productos disponibles</option>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <div class="campo-tarjeta">
                                    <label>Cantidad en el Combo *</label>
                                    <input 
                                        type="number" 
                                        name="combo_detalle[<?php echo $index; ?>][cantidad]" 
                                        class="input-cantidad-combo" 
                                        placeholder="1"
                                        min="0.01"
                                        step="0.01"
                                        value="<?php echo isset($componente['cantidad']) ? s($componente['cantidad']) : '1'; ?>"
                                        required
                                    >
                                </div>
                            </div>
                        </div>
                    <?php 
                        endforeach; 
                    endif; 
                    ?>
                </div>

                <div class="combo-acciones">
                    <button type="button" id="btn-agregar-producto-combo" class="boton boton-secundario">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Agregar Producto al Combo
                    </button>
                </div>
            </div>

            <!-- Template para nuevos productos del combo -->
            <template id="tpl-producto-combo">
                <div class="tarjeta-producto-combo" data-index="__INDEX__">
                    <div class="tarjeta-producto-header">
                        <span class="numero-producto">#__NUM__</span>
                        <button type="button" class="btn-eliminar-producto-combo" title="Eliminar producto del combo">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="tarjeta-producto-body">
                        <div class="campo-tarjeta">
                            <label>Producto *</label>
                            <select name="combo_detalle[__INDEX__][id_producto]" class="select-producto-combo" required>
                                <option value="">-- Seleccione un producto --</option>
                                <?php 
                                // Generar opciones de productos para el template
                                if (!empty($productos) && is_array($productos) && count($productos) > 0): 
                                    foreach ($productos as $p): 
                                ?>
                                    <option value="<?php echo s($p->id); ?>">
                                        <?php echo s($p->nombre ?? ('Producto #' . $p->id)); ?> - $<?php echo number_format($p->precio ?? 0, 2); ?>
                                    </option>
                                <?php 
                                    endforeach; 
                                else: 
                                ?>
                                    <option value="" disabled>No hay productos disponibles</option>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="campo-tarjeta">
                            <label>Cantidad en el Combo *</label>
                            <input 
                                type="number" 
                                name="combo_detalle[__INDEX__][cantidad]" 
                                class="input-cantidad-combo" 
                                placeholder="1"
                                min="0.01"
                                step="0.01"
                                value="1"
                                required
                            >
                        </div>
                    </div>
                </div>
            </template>

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
                    <?php echo $boton_formulario; ?>
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
                La cantidad inicial puede ser 0
            </li>
        </ul>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxCombo = document.getElementById('escombo');
    const seccionCombo = document.getElementById('seccion-combo');
    const listaProductosCombo = document.getElementById('lista-productos-combo');
    const btnAgregarProducto = document.getElementById('btn-agregar-producto-combo');
    const template = document.getElementById('tpl-producto-combo');
    
    if (!checkboxCombo || !seccionCombo || !listaProductosCombo || !btnAgregarProducto || !template) {
        return;
    }
    
    let indiceCombo = listaProductosCombo.querySelectorAll('.tarjeta-producto-combo').length;
    let numeroProducto = indiceCombo + 1;
    
    // Mostrar/ocultar sección cuando se marca el checkbox
    checkboxCombo.addEventListener('change', function() {
        if (this.checked) {
            seccionCombo.style.display = 'block';
        } else {
            seccionCombo.style.display = 'none';
        }
    });
    
    // Función para agregar un nuevo producto al combo
    function agregarProductoCombo() {
        const contenido = template.innerHTML
            .replace(/__INDEX__/g, indiceCombo)
            .replace(/__NUM__/g, numeroProducto);
        
        const div = document.createElement('div');
        div.innerHTML = contenido;
        const nuevaTarjeta = div.firstElementChild;
        
        listaProductosCombo.appendChild(nuevaTarjeta);
        
        // Enlazar eventos de la nueva tarjeta
        enlazarEventosTarjeta(nuevaTarjeta);
        
        indiceCombo++;
        numeroProducto++;
    }
    
    // Función para eliminar producto del combo
    function eliminarProductoCombo(btn) {
        const tarjeta = btn.closest('.tarjeta-producto-combo');
        if (tarjeta && listaProductosCombo.querySelectorAll('.tarjeta-producto-combo').length > 0) {
            tarjeta.remove();
            // Renumerar productos
            renumerarProductos();
        }
    }
    
    // Renumerar productos después de eliminar
    function renumerarProductos() {
        listaProductosCombo.querySelectorAll('.tarjeta-producto-combo').forEach((tarjeta, index) => {
            const numero = tarjeta.querySelector('.numero-producto');
            if (numero) {
                numero.textContent = '#' + (index + 1);
            }
            // Actualizar índices en los nombres de los campos
            const inputs = tarjeta.querySelectorAll('[name]');
            inputs.forEach(input => {
                const name = input.name;
                if (name.includes('combo_detalle[')) {
                    input.name = name.replace(/combo_detalle\[\d+\]/, `combo_detalle[${index}]`);
                }
            });
        });
        numeroProducto = listaProductosCombo.querySelectorAll('.tarjeta-producto-combo').length + 1;
        indiceCombo = listaProductosCombo.querySelectorAll('.tarjeta-producto-combo').length;
    }
    
    // Enlazar eventos de una tarjeta
    function enlazarEventosTarjeta(tarjeta) {
        const btnEliminar = tarjeta.querySelector('.btn-eliminar-producto-combo');
        if (btnEliminar) {
            btnEliminar.addEventListener('click', function() {
                eliminarProductoCombo(this);
            });
        }
    }
    
    // Evento para agregar producto
    btnAgregarProducto.addEventListener('click', function() {
        agregarProductoCombo();
    });
    
    // Enlazar eventos de productos existentes
    listaProductosCombo.querySelectorAll('.tarjeta-producto-combo').forEach(tarjeta => {
        enlazarEventosTarjeta(tarjeta);
    });
});
</script>
