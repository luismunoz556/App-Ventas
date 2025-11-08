<div class="kardex-header">
    <div class="kardex-header-content">
        <div class="kardex-header-icon">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3 12H21M3 6H21M3 18H21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <path d="M9 3V21M15 3V21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </div>
        <div class="kardex-header-text">
<h1 class="nombre-pagina">Kardex - Movimientos de Inventario</h1>
            <p class="kardex-subtitulo">Seguimiento completo de todas las transacciones de inventario</p>
        </div>
    </div>
</div>

<div class="contenedor-general kardex-container">
    <!-- Tarjetas de estadísticas -->
    <div class="kardex-stats">
        <div class="stat-card stat-movimientos">
            <div class="stat-icon">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 12H21M3 6H21M3 18H21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M9 3V21M15 3V21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Movimientos</div>
                <div class="stat-value"><?php echo number_format($estadisticas['totalMovimientos'] ?? 0, 0); ?></div>
            </div>
        </div>
        
        <div class="stat-card stat-entradas">
            <div class="stat-icon">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M3 12H21M3 6H21M3 18H21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-label">Entradas Totales</div>
                <div class="stat-value"><?php echo number_format($estadisticas['totalEntradas'] ?? 0, 2); ?></div>
            </div>
        </div>
        
        <div class="stat-card stat-ventas">
            <div class="stat-icon">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 3H5L5.4 5M7 13H17L21 5H5.4M7 13L5.4 5M7 13L4.707 15.293C4.077 15.923 4.523 17 5.414 17H17M17 17C16.4477 17 16 17.4477 16 18C16 18.5523 16.4477 19 17 19C17.5523 19 18 18.5523 18 18C18 17.4477 17.5523 17 17 17ZM9 17C8.44772 17 8 17.4477 8 18C8 18.5523 8.44772 19 9 19C9.55228 19 10 18.5523 10 18C10 17.4477 9.55228 17 9 17Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-label">Ventas Totales</div>
                <div class="stat-value"><?php echo number_format($estadisticas['totalVentas'] ?? 0, 2); ?></div>
            </div>
        </div>
        
        <div class="stat-card stat-saldo">
            <div class="stat-icon">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-label">Saldo Actual</div>
                <div class="stat-value"><?php echo number_format($estadisticas['saldoActual'] ?? 0, 2); ?></div>
            </div>
        </div>
    </div>

    <!-- Barra de acciones superiores -->
    <div class="acciones-superiores kardex-filtros">
        <div class="acciones-izquierda">
            <a href="/principal" class="boton boton-secundario">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19 12H5M12 19L5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Volver
            </a>
        </div>
        <div class="busqueda">
            <form method="GET" action="/kardex" class="kardex-filtro-form">
                <div class="filtro-select-wrapper <?php echo $productoSeleccionado ? 'producto-seleccionado' : ''; ?>">
                    <?php if(!$productoSeleccionado): ?>
                    <!-- <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="filtro-icon"> -->
                        <!-- <path d="M21 21L16.65 16.65" stroke="currentColor" stroke-width="2" stroke-linecap="round"/> -->
                        <!-- <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2"/> -->
                    <!-- </svg> -->
                    <?php endif; ?>
                    <select name="producto" id="filtro-producto" class="campo-busqueda kardex-select">
                    <option value="">Todos los productos</option>
                    <?php foreach($productos as $producto): ?>
                        <option value="<?php echo $producto->id; ?>" <?php echo ($productoSeleccionado == $producto->id) ? 'selected' : ''; ?>>
                            <?php echo s($producto->nombre); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                </div>
                <button type="submit" class="boton boton-primario kardex-btn-filtrar">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2"/>
                        <path d="M21 21L16.65 16.65" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    Filtrar
                </button>
                <?php if($productoSeleccionado): ?>
                    <a href="/kardex" class="boton boton-secundario kardex-btn-limpiar">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Limpiar Filtro
                    </a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <!-- Tabla de kardex -->
    <div class="tabla-contenedor kardex-tabla-contenedor">
        <table class="tabla-general kardex-tabla">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Producto</th>
                    <th>Tipo</th>
                    <th>Cantidad</th>
                    <th>Saldo</th>
                    <th>Referencia Venta</th>
                    <th>Referencia Entrada</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($kardex)): ?>
                <tr>
                    <td colspan="8" class="sin-datos">
                        <div class="mensaje-vacio kardex-vacio">
                            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 12H21M3 6H21M3 18H21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                <path d="M9 3V21M15 3V21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                            <h3>No hay movimientos registrados</h3>
                            <p>Los movimientos de inventario aparecerán aquí</p>
                        </div>
                    </td>
                </tr>
                <?php else: ?>
                    <?php foreach($kardex as $movimiento): ?>
                    <tr class="kardex-fila">
                        <td class="id kardex-id"><?php echo s($movimiento->id ?? 'N/A'); ?></td>
                        <td class="fecha kardex-fecha"><?php echo s($movimiento->fecha ?? 'N/A'); ?></td>
                        <td class="producto kardex-producto"><?php echo s($movimiento->producto_nombre ?? 'N/A'); ?></td>
                        <td class="tipo kardex-tipo">
                            <span class="badge-tipo badge-<?php 
                                echo match($movimiento->tipo ?? '') {
                                    'venta' => 'venta',
                                    'entrada' => 'entrada',
                                    'reversoVenta' => 'reverso',
                                    'reversoEntrada' => 'reverso',
                                    'ajusteVenta' => 'ajuste',
                                    default => 'default'
                                };
                            ?>">
                                <?php 
                                    $icono = match($movimiento->tipo ?? '') {
                                        'venta' => '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 3H5L5.4 5M7 13H17L21 5H5.4M7 13L5.4 5M7 13L4.707 15.293C4.077 15.923 4.523 17 5.414 17H17M17 17C16.4477 17 16 17.4477 16 18C16 18.5523 16.4477 19 17 19C17.5523 19 18 18.5523 18 18C18 17.4477 17.5523 17 17 17ZM9 17C8.44772 17 8 17.4477 8 18C8 18.5523 8.44772 19 9 19C9.55228 19 10 18.5523 10 18C10 17.4477 9.55228 17 9 17Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                                        'entrada' => '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                                        'reversoVenta', 'reversoEntrada' => '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 12H21M3 6H21M3 18H21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
                                        'ajusteVenta' => '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 8V16M8 12H16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                                        default => ''
                                    };
                                    echo $icono;
                                ?>
                                <span><?php echo s($movimiento->tipo ?? 'N/A'); ?></span>
                            </span>
                        </td>
                        <td class="cantidad kardex-cantidad <?php echo ($movimiento->cantidad ?? 0) < 0 ? 'negativo' : 'positivo'; ?>">
                            <span class="cantidad-icono">
                                <?php if(($movimiento->cantidad ?? 0) >= 0): ?>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                <?php else: ?>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                <?php endif; ?>
                            </span>
                            <span class="cantidad-valor">
                            <?php echo ($movimiento->cantidad ?? 0) >= 0 ? '+' : ''; ?><?php echo number_format($movimiento->cantidad ?? 0, 2); ?>
                            </span>
                        </td>
                        <td class="saldo kardex-saldo">
                            <span class="saldo-valor"><?php echo number_format($movimiento->saldo ?? 0, 2); ?></span>
                        </td>
                        <td class="referencia kardex-referencia">
                            <?php if($movimiento->id_refV): ?>
                                <a href="/ventas/ver?id=<?php echo $movimiento->id_refV; ?>" class="link-referencia">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 12S5 4 12 4S23 12 23 12S19 20 12 20S1 12 1 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    Venta #<?php echo $movimiento->id_refV; ?>
                                </a>
                            <?php else: ?>
                                <span class="sin-referencia">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="referencia kardex-referencia">
                            <?php if($movimiento->id_refE): ?>
                                <a href="/entradas-productos/editar?id=<?php echo $movimiento->id_refE; ?>" class="link-referencia">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 12S5 4 12 4S23 12 23 12S19 20 12 20S1 12 1 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    Entrada #<?php echo $movimiento->id_refE; ?>
                                </a>
                            <?php else: ?>
                                <span class="sin-referencia">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
