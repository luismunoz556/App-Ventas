<h1 class="nombre-pagina">Detalles del Producto</h1>

<div class="contenedor-detalles">
    <!-- Tarjeta principal del producto -->
    <div class="detalle-card">
        <div class="detalle-header">
            <div class="detalle-titulo">
                <h2><?php echo htmlspecialchars($producto->nombre ?? 'Sin nombre'); ?></h2>
                <span class="producto-id">ID: <?php echo htmlspecialchars($producto->id ?? 'N/A'); ?></span>
            </div>
            <div class="estado-producto">
                <?php if(($producto->cantidad ?? 0) > 0): ?>
                    <span class="estado-badge disponible">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                            <path d="M9 12L11 14L15 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Disponible
                    </span>
                <?php else: ?>
                    <span class="estado-badge agotado">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                            <line x1="15" y1="9" x2="9" y2="15" stroke="currentColor" stroke-width="2"/>
                            <line x1="9" y1="9" x2="15" y2="15" stroke="currentColor" stroke-width="2"/>
                        </svg>
                        Agotado
                    </span>
                <?php endif; ?>
            </div>
        </div>

        <div class="detalle-contenido">
            <!-- Información principal -->
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 7L9 18L4 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Nombre del Producto
                    </div>
                    <div class="info-valor"><?php echo htmlspecialchars($producto->nombre ?? 'Sin nombre'); ?></div>
                </div>

                <div class="info-item">
                    <div class="info-label">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 1V23M17 5H9.5C8.57174 5 7.6815 5.36875 7.02513 6.02513C6.36875 6.6815 6 7.57174 6 8.5C6 9.42826 6.36875 10.3185 7.02513 10.9749C7.6815 11.6312 8.57174 12 9.5 12H14.5C15.4283 12 16.3185 12.3687 16.9749 13.0251C17.6312 13.6815 18 14.5717 18 15.5C18 16.4283 17.6312 17.3185 16.9749 17.9749C16.3185 18.6312 15.4283 19 14.5 19H6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Precio
                    </div>
                    <div class="info-valor precio">$<?php echo number_format($producto->precio ?? 0, 2); ?></div>
                </div>

                <div class="info-item">
                    <div class="info-label">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 2L3 6V20C3 20.5304 3.21071 21.0391 3.58579 21.4142C3.96086 21.7893 4.46957 22 5 22H19C19.5304 22 20.0391 21.7893 20.4142 21.4142C20.7893 21.0391 21 20.5304 21 20V6L18 2H6Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M3 6H21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Cantidad en Stock
                    </div>
                    <div class="info-valor cantidad">
                        <span class="cantidad-numero"><?php echo $producto->cantidad ?? 0; ?></span>
                        <span class="cantidad-unidad">unidades</span>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 12L11 14L15 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Estado del Inventario
                    </div>
                    <div class="info-valor">
                        <?php if(($producto->cantidad ?? 0) > 10): ?>
                            <span class="estado-inventario alto">Stock Alto</span>
                        <?php elseif(($producto->cantidad ?? 0) > 0): ?>
                            <span class="estado-inventario medio">Stock Medio</span>
                        <?php else: ?>
                            <span class="estado-inventario bajo">Sin Stock</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Valor total del inventario -->
            <div class="valor-inventario">
                <div class="valor-label">Valor Total del Inventario</div>
                <div class="valor-monto">$<?php echo number_format(($producto->precio ?? 0) * ($producto->cantidad ?? 0), 2); ?></div>
            </div>
        </div>

        <!-- Acciones -->
        <div class="detalle-acciones">
            <a href="/maestros/productos" class="boton boton-secundario">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19 12H5M12 19L5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Volver a la Lista
            </a>
            <a href="/maestros/productos/editar?id=<?php echo $producto->id; ?>" class="boton boton-primario">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11 4H4C3.46957 4 2.96086 4.21071 2.58579 4.58579C2.21071 4.96086 2 5.46957 2 6V20C2 20.5304 2.21071 21.0391 2.58579 21.4142C2.96086 21.7893 3.46957 22 4 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M18.5 2.5C18.8978 2.10218 19.4374 1.87868 20 1.87868C20.5626 1.87868 21.1022 2.10218 21.5 2.5C21.8978 2.89782 22.1213 3.43739 22.1213 4C22.1213 4.56261 21.8978 5.10218 21.5 5.5L12 15L8 16L9 12L18.5 2.5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Editar Producto
            </a>
        </div>
    </div>

    <!-- Información adicional -->
    <div class="info-adicional">
        <div class="info-card">
            <h3>Información del Producto</h3>
            <ul>
                <li>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                        <path d="M9 12L11 14L15 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <strong>ID del Producto:</strong> <?php echo htmlspecialchars($producto->id ?? 'N/A'); ?>
                </li>
                <li>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                        <path d="M9 12L11 14L15 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <strong>Precio Unitario:</strong> $<?php echo number_format($producto->precio ?? 0, 2); ?>
                </li>
                <li>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                        <path d="M9 12L11 14L15 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <strong>Unidades Disponibles:</strong> <?php echo $producto->cantidad ?? 0; ?>
                </li>
                <li>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                        <path d="M9 12L11 14L15 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <strong>Valor Total:</strong> $<?php echo number_format(($producto->precio ?? 0) * ($producto->cantidad ?? 0), 2); ?>
                </li>
            </ul>
        </div>

        <div class="info-card">
            <h3>Estados de Inventario</h3>
            <div class="estados-explicacion">
                <div class="estado-item">
                    <span class="estado-indicador alto"></span>
                    <span>Stock Alto: Más de 10 unidades</span>
                </div>
                <div class="estado-item">
                    <span class="estado-indicador medio"></span>
                    <span>Stock Medio: 1-10 unidades</span>
                </div>
                <div class="estado-item">
                    <span class="estado-indicador bajo"></span>
                    <span>Sin Stock: 0 unidades</span>
                </div>
            </div>
        </div>
    </div>
</div>
