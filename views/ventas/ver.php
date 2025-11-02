<h1 class="nombre-pagina">Detalle de Venta</h1>

<div class="contenedor-venta-detalle">
    <!-- Header de la venta con diseño tipo factura -->
    <div class="venta-header">
        <div class="venta-header-superior">
            <div class="venta-info-principal">
                <div class="venta-badge">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14 2H6C5.46957 2 4.96086 2.21071 4.58579 2.58579C4.21071 2.96086 4 3.46957 4 4V20C4 20.5304 4.21071 21.0391 4.58579 21.4142C4.96086 21.7893 5.46957 22 6 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V8L14 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M14 2V8H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M16 13H8M16 17H8M10 9H8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Venta #<?php echo htmlspecialchars($venta->id ?? 'N/A'); ?></span>
                </div>
                <div class="venta-fecha">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M16 2V6M8 2V6M3 10H21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span><?php 
                        $fecha = $venta->fecha ?? '';
                        if($fecha) {
                            $fechaObj = new DateTime($fecha);
                            echo $fechaObj->format('d/m/Y');
                        } else {
                            echo 'N/A';
                        }
                    ?></span>
                </div>
            </div>
            <div class="venta-estado-badge">
                <?php 
                $tipoPago = strtolower($venta->tipo_pago ?? 'contado');
                $claseTipoPago = 'estado-' . $tipoPago;
                ?>
                <span class="estado-venta <?php echo $claseTipoPago; ?>">
                    <?php 
                    $tiposPago = [
                        'contado' => 'Efectivo',
                        'tarjeta' => 'Tarjeta',
                        'transferencia' => 'Transferencia',
                        'credito' => 'Crédito'
                    ];
                    echo $tiposPago[$tipoPago] ?? ucfirst($tipoPago);
                    ?>
                </span>
            </div>
        </div>
        
        <div class="venta-header-inferior">
            <div class="venta-cliente-info">
                <h3>Cliente</h3>
                <div class="cliente-datos">
                    <p class="cliente-nombre">
                        <?php 
                        $nombreCompleto = '';
                        if($cliente) {
                            $nombreCompleto = htmlspecialchars($cliente->nombre ?? '') . ' ' . htmlspecialchars($cliente->apellido ?? '');
                        } else {
                            $nombreCompleto = 'Cliente no encontrado';
                        }
                        echo trim($nombreCompleto);
                        ?>
                    </p>
                    <?php if($cliente && $cliente->telefono): ?>
                    <p class="cliente-telefono">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22 16.92V19.92C22.0011 20.1985 21.9441 20.4742 21.8325 20.7293C21.7209 20.9845 21.5573 21.2136 21.3521 21.4019C21.1468 21.5901 20.9046 21.7335 20.6407 21.8227C20.3769 21.9119 20.0974 21.9451 19.82 21.92C16.7428 21.5856 13.787 20.5341 11.19 18.85C8.77382 17.3147 6.72533 15.2662 5.18999 12.85C3.49997 10.2412 2.44824 7.27099 2.11999 4.18C2.095 3.90347 2.12787 3.62476 2.21649 3.36162C2.30512 3.09849 2.44756 2.85669 2.63476 2.65162C2.82196 2.44655 3.0498 2.28271 3.30479 2.17052C3.55977 2.05833 3.83626 2.00026 4.11999 2H7.11999C7.59531 1.99522 8.06669 2.16708 8.43376 2.48353C8.80083 2.79999 9.04007 3.23945 9.10999 3.72C9.23662 4.68007 9.47144 5.62273 9.80999 6.53C9.94454 6.88792 9.97366 7.27691 9.89391 7.65088C9.81415 8.02485 9.62886 8.36811 9.35999 8.64L8.08999 9.91C9.51355 12.4135 11.5865 14.4864 14.09 15.91L15.36 14.64C15.6319 14.3711 15.9751 14.1858 16.3491 14.1061C16.7231 14.0263 17.1121 14.0555 17.47 14.19C18.3773 14.5286 19.3199 14.7634 20.28 14.89C20.7658 14.9586 21.2094 15.2032 21.5265 15.5775C21.8437 15.9518 22.0122 16.4296 22 16.92Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <?php echo htmlspecialchars($cliente->telefono); ?>
                    </p>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="venta-total-display">
                <span class="total-label">Total de la Venta</span>
                <span class="total-monto">$<?php echo number_format($venta->total ?? 0, 2); ?></span>
                <?php if($venta->credito > 0): ?>
                <span class="credito-info">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2V22M17 5H9.5C8.57174 5 7.6815 5.36875 7.02513 6.02513C6.36875 6.6815 6 7.57174 6 8.5C6 9.42826 6.36875 10.3185 7.02513 10.9749C7.6815 11.6312 8.57174 12 9.5 12H14.5C15.4283 12 16.3185 12.3687 16.9749 13.0251C17.6312 13.6815 18 14.5717 18 15.5C18 16.4283 17.6312 17.3185 16.9749 17.9749C16.3185 18.6312 15.4283 19 14.5 19H6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Crédito: $<?php echo number_format($venta->credito, 2); ?>
                </span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Tabla de productos -->
    <div class="venta-productos">
        <div class="productos-header">
            <h2>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6 2L3 6V20C3 20.5304 3.21071 21.0391 3.58579 21.4142C3.96086 21.7893 4.46957 22 5 22H19C19.5304 22 20.0391 21.7893 20.4142 21.4142C20.7893 21.0391 21 20.5304 21 20V6L18 2H6Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M3 6H21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Productos de la Venta
            </h2>
        </div>
        
        <div class="tabla-productos-contenedor">
            <table class="tabla-productos-venta">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($detalles)): ?>
                    <tr>
                        <td colspan="4" class="sin-productos">
                            <div class="mensaje-vacio-productos">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6 2L3 6V20C3 20.5304 3.21071 21.0391 3.58579 21.4142C3.96086 21.7893 4.46957 22 5 22H19C19.5304 22 20.0391 21.7893 20.4142 21.4142C20.7893 21.0391 21 20.5304 21 20V6L18 2H6Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <p>No hay productos en esta venta</p>
                            </div>
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php 
                        $totalCalculado = 0;
                        foreach($detalles as $detalle): 
                            $subtotal = floatval($detalle['cantidad'] ?? 0) * floatval($detalle['precio'] ?? 0);
                            $totalCalculado += $subtotal;
                        ?>
                        <tr>
                            <td class="producto-nombre">
                                <strong><?php echo htmlspecialchars($detalle['producto_nombre'] ?? 'Producto #' . ($detalle['id_prod'] ?? 'N/A')); ?></strong>
                            </td>
                            <td class="producto-cantidad">
                                <span class="cantidad-badge"><?php echo number_format($detalle['cantidad'] ?? 0, 0); ?></span>
                            </td>
                            <td class="producto-precio">
                                $<?php echo number_format($detalle['precio'] ?? 0, 2); ?>
                            </td>
                            <td class="producto-subtotal">
                                <strong>$<?php echo number_format($subtotal, 2); ?></strong>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr class="total-fila">
                        <td colspan="3" class="total-label-footer">
                            <strong>TOTAL</strong>
                        </td>
                        <td class="total-valor-footer">
                            <strong>$<?php echo number_format($venta->total ?? 0, 2); ?></strong>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Información adicional y acciones -->
    <div class="venta-informacion-extra">
        <div class="info-card">
            <h3>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12 16V12M12 8H12.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Información Adicional
            </h3>
            <div class="info-detalle">
                <div class="info-item-extra">
                    <label>Tipo de Pago:</label>
                    <span><?php 
                    $tiposPago = [
                        'contado' => 'Efectivo',
                        'tarjeta' => 'Tarjeta',
                        'transferencia' => 'Transferencia',
                        'credito' => 'Crédito'
                    ];
                    echo $tiposPago[strtolower($venta->tipo_pago ?? 'contado')] ?? ucfirst($venta->tipo_pago ?? 'N/A');
                    ?></span>
                </div>
                <?php if($venta->credito > 0): ?>
                <div class="info-item-extra">
                    <label>Monto a Crédito:</label>
                    <span class="credito-valor">$<?php echo number_format($venta->credito, 2); ?></span>
                </div>
                <?php endif; ?>
                <div class="info-item-extra">
                    <label>ID Usuario:</label>
                    <span>#<?php echo htmlspecialchars($venta->id_usu ?? 'N/A'); ?></span>
                </div>
            </div>
        </div>
        
        <div class="acciones-venta">
            <h3>Acciones</h3>
            <div class="acciones-grid-venta">
                <a href="/ventas" class="accion-venta-item">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19 12H5M12 19L5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Volver a Ventas</span>
                </a>
                <a href="/ventas/editar?id=<?php echo $venta->id; ?>" class="accion-venta-item accion-editar">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11 4H4C3.46957 4 2.96086 4.21071 2.58579 4.58579C2.21071 4.96086 2 5.46957 2 6V20C2 20.5304 2.21071 21.0391 2.58579 21.4142C2.96086 21.7893 3.46957 22 4 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M18.5 2.5C18.8978 2.10218 19.4374 1.87868 20 1.87868C20.5626 1.87868 21.1022 2.10218 21.5 2.5C21.8978 2.89782 22.1213 3.43739 22.1213 4C22.1213 4.56261 21.8978 5.10218 21.5 5.5L12 15L8 16L9 12L18.5 2.5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Editar Venta</span>
                </a>
                <?php if($cliente): ?>
                <a href="/maestros/clientes/ver?id=<?php echo $cliente->id; ?>" class="accion-venta-item accion-cliente">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 21V19C20 17.9391 19.5786 16.9217 18.8284 16.1716C18.0783 15.4214 17.0609 15 16 15H8C6.93913 15 5.92172 15.4214 5.17157 16.1716C4.42143 16.9217 4 17.9391 4 19V21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Ver Cliente</span>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

