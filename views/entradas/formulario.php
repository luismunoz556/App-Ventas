<h1 class="nombre-pagina"> <?php echo $titulo_pagina ?? 'Nueva Venta'; ?> </h1>

<?php @include_once __DIR__ . '/../templates/alertas.php'; ?>

<?php if(!empty($errores) && is_array($errores)): ?>
    <div class="alertas">
        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                    <line x1="15" y1="9" x2="9" y2="15" stroke="currentColor" stroke-width="2"/>
                    <line x1="9" y1="9" x2="15" y2="15" stroke="currentColor" stroke-width="2"/>
                </svg>
                <?php echo s($error); ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="contenedor-formulario">
    <div class="formulario-card">
        <div class="formulario-header">
            <h2>Encabezado de Entrada de Producto</h2>
            <p>Completa los datos para <?php echo $descripcion_pagina; ?></p>
        </div>

        <form class="formulario" method="POST" action="<?php echo $action_formulario ?>">
            <div class="grid-2">
                <div class="campo">  <!-- comentario  campo-fecha -->
                    <label for="fecha">Fecha *</label>
                    <input 
                        type="date" 
                        id="fecha" 
                        name="fecha" 
                        value="<?php     
                            $fecha = $entrada->fecha ?? '';
                            if($fecha) {
                                // Si la fecha viene con hora (DATETIME), extraer solo la fecha
                                $fecha = explode(' ', $fecha)[0];
                                // Asegurarse de que esté en formato Y-m-d
                                if(preg_match('/^\d{4}-\d{2}-\d{2}/', $fecha)) {
                                    echo s($fecha);
                                } else {
                                    // Intentar convertir otros formatos
                                    $timestamp = strtotime($fecha);
                                    echo $timestamp ? s(date('Y-m-d', $timestamp)) : date('Y-m-d');
                                }
                            } else {
                                echo date('Y-m-d');
                            }
                        ?>" 
                        required
                    >
                </div>

             
            </div>
            
            <input type="hidden" name="id_usu" id="id_usu" value="<?php echo s($entrada->id_usu ?? ''); ?>">

            <hr class="separador-seccion">

            <div class="seccion-productos">
                <div class="seccion-productos-header">
                    <div>
                        <h3>Productos de la Entrada</h3>
                        <p>Agrega los productos que deseas incluir en esta Entrada</p>
                    </div>
                   
                    <button type="button" class="boton boton-primario" id="btn-agregar-producto">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Agregar Producto
                    </button>
                </div>

                <div id="lista-productos" class="lista-productos">
                    <?php if (!empty($detalles) && is_array($detalles)): ?>
                        <?php foreach($detalles as $index => $detalle): ?>
                        <div class="tarjeta-producto" data-index="<?php echo $index; ?>">
                            <div class="tarjeta-producto-header">
                                <span class="numero-producto">#<?php echo $index + 1; ?></span>
                                <button type="button" class="btn-eliminar-producto" title="Eliminar producto">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                            </div>
                            
                            <div class="tarjeta-producto-body">
                                <div class="campo-tarjeta">
                                    <label>Producto *</label>
                                    <?php if (!empty($productos) && is_array($productos)): ?>
                                        <select name="detalles[<?php echo $index; ?>][id_prod]" class="select-producto" required>
                                            <option value="">-- Seleccione un producto --</option>
                                            <?php foreach ($productos as $p): ?>
                                                <option 
                                                    value="<?php echo s($p->id); ?>" 
                                                    data-precio="<?php echo s($p->precio); ?>"
                                                    data-nombre="<?php echo s($p->nombre ?? ''); ?>"
                                                    <?php echo (isset($detalle['id_prod']) && (string)$p->id === (string)$detalle['id_prod']) ? 'selected' : ''; ?>
                                                >
                                                    <?php echo s(($p->nombre ?? ('Producto #' . $p->id))); ?> - $<?php echo number_format($p->precio ?? 0, 2); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    <?php else: ?>
                                        <input 
                                            type="number" 
                                            name="detalles[<?php echo $index; ?>][id_prod]" 
                                            class="input-producto-id" 
                                            placeholder="ID del Producto" 
                                            value="<?php echo s($detalle['id_prod'] ?? ''); ?>"
                                            required
                                        >
                                    <?php endif; ?>
                                </div>

                                <div class="grid-tarjeta">
                                    <div class="campo-tarjeta">
                                        <label>Cantidad *</label>
                                        <input 
                                            type="number" 
                                            name="detalles[<?php echo $index; ?>][cantidad]" 
                                            class="input-cantidad" 
                                            min="1" 
                                            step="1" 
                                            value="<?php echo s($detalle['cantidad'] ?? 1); ?>" 
                                            required
                                        >
                                    </div>

                                    <!-- <div class="campo-tarjeta"> -->
                                        <!-- <label>Precio Unitario *</label> -->
                                        <!-- <div class="input-group-precio"> -->
                                            <!-- <span class="prefijo-precio">$</span> -->
                                            <!-- <input  -->
                                                <!-- type="number"  -->
                                                <!-- name="detalles[<?php //echo $index; ?>][precio]"  -->
                                                <!-- class="input-precio"  -->
                                                <!-- min="0"  -->
                                                <!-- step="0.01"  -->
                                                <!-- value="<?php //echo number_format($detalle['precio'] ?? 0, 2, '.', ''); ?>"  -->
                                                <!-- required -->
                                            <!-- > -->
                                        <!-- </div> -->
                                    <!-- </div> -->

                              
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <!-- Las tarjetas de productos adicionales se agregarán aquí dinámicamente -->
                </div>

                <div class="resumen-total">
                    <div class="resumen-item">
                        <span>Total de Productos:</span>
                        <strong id="cantidad-productos">0</strong>
                    </div>
                    <!-- <div class="resumen-item resumen-total-final"> -->
                        <!-- <span>Total del Pedido:</span> -->
                        <!-- <strong id="total-pedido">$0.00</strong> -->
                    <!-- </div> -->
                </div>
            </div>

            <div class="formulario-acciones">
                <a href="/entradas-productos" class="boton boton-secundario">Cancelar</a>
                <button type="submit" class="boton boton-primario"><?php echo $boton_formulario; ?></button>
            </div>

        </form>
    </div>

    <div class="info-card">
        <h3>Información</h3>
        <ul>
            <li>El total se recalcula automáticamente según los productos añadidos.</li>
            <li>El campo crédito solo se edita si el tipo de pago es Crédito.</li>
        </ul>
    </div>
</div>

<template id="tpl-tarjeta-producto">
    <div class="tarjeta-producto" data-index="__INDEX__">
        <div class="tarjeta-producto-header">
            <span class="numero-producto">#__NUM__</span>
            <button type="button" class="btn-eliminar-producto" title="Eliminar producto">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>
        
        <div class="tarjeta-producto-body">
            <div class="campo-tarjeta">
                <label>Producto *</label>
                <?php if (!empty($productos) && is_array($productos)): ?>
                    <select name="detalles[__INDEX__][id_prod]" class="select-producto" required>
                        <option value="">-- Seleccione un producto --</option>
                        <?php foreach ($productos as $p): ?>
                            <option value="<?php echo s($p->id); ?>" data-precio="<?php echo s($p->precio); ?>" data-nombre="<?php echo s($p->nombre ?? ''); ?>">
                                <?php echo s(($p->nombre ?? ('Producto #' . $p->id))); ?> - $<?php echo number_format($p->precio ?? 0, 2); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php else: ?>
                    <input type="number" name="detalles[__INDEX__][id_prod]" class="input-producto-id" placeholder="ID del Producto" required>
                <?php endif; ?>
            </div>

            <div class="grid-tarjeta">
                <div class="campo-tarjeta">
                    <label>Cantidad *</label>
                    <input 
                        type="number" 
                        name="detalles[__INDEX__][cantidad]" 
                        class="input-cantidad" 
                        min="1" 
                        step="1" 
                        value="1" 
                        required
                    >
                </div>
                <!-- <div class="campo-tarjeta"> -->
                    <!-- <label>Precio Unitario *</label> -->
                    <!-- <div class="input-group-precio"> -->
                        <!-- <span class="prefijo-precio">$</span> -->
                        <!-- <input  -->
                            <!-- type="number"  -->
                            <!-- name="detalles[<?php //echo $index; ?>][precio]"  -->
                            <!-- class="input-precio"  -->
                            <!-- min="0"  -->
                            <!-- step="0.01"  -->
                            <!-- value="<?php //echo number_format($detalle['precio'] ?? 0, 2, '.', ''); ?>"  -->
                            <!-- required -->
                        <!-- > -->
                    <!-- </div> -->
                <!-- </div>                -->
               
            </div>
        </div>
    </div>
</template>


