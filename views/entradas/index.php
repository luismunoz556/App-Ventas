<h1 class="nombre-pagina">Gestión de Entradas de Productos</h1>
<?php  if(isset($_GET['creado']) && $_GET['creado'] == '1'): ?>
    <div class="alerta alerta-exito">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
            <path d="M9 12L11 14L15 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Entrada de producto creada exitosamente
    </div>
<?php endif; ?>

<?php  if(isset($_GET['actualizado']) && $_GET['actualizado'] == '1'): ?>
    <div class="alerta alerta-exito">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
            <path d="M9 12L11 14L15 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Entrada de producto actualizada exitosamente
    </div>
<?php endif; ?>

<?php  if(isset($_GET['eliminado']) && $_GET['eliminado'] == '1'): ?>
    <div class="alerta alerta-exito">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
            <path d="M9 12L11 14L15 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Entrada de producto eliminada exitosamente
    </div>
<?php endif; ?>

<?php  if(isset($_GET['error']) && $_GET['error'] == '1'): ?>
    <div class="alerta alerta-error">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
            <line x1="15" y1="9" x2="9" y2="15" stroke="currentColor" stroke-width="2"/>
            <line x1="9" y1="9" x2="15" y2="15" stroke="currentColor" stroke-width="2"/>
        </svg>
        Error al procesar la solicitud. Inténtalo de nuevo.
    </div>
<?php endif; ?>

<div class="contenedor-general">
    <!-- Barra de acciones superiores -->
    <div class="acciones-superiores">
        <div class="acciones-izquierda">
            <a href="/principal" class="boton boton-secundario">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19 12H5M12 19L5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Volver
            </a>
            <a href="/entradas-productos/crear" class="boton boton-primario">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Nueva Entrada de Producto
            </a>
        </div>
        <div class="busqueda">
            <input type="text" placeholder="Buscar entradas de productos..." class="campo-busqueda" id="buscar-entradas-productos">
        </div>
    </div>

    <!-- Tabla de productos -->
    <div class="tabla-contenedor">
        <table class="tabla-general">
            <thead>
                <tr>
                    <th>Id_Entrada</th>
                    <th>Fecha</th>
                    <th>Usuario Digitador</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($entradas)): ?>
                <tr>
                    <td colspan="8" class="sin-datos">
                        <div class="mensaje-vacio">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6 2L3 6V20C3 20.5304 3.21071 21.0391 3.58579 21.4142C3.96086 21.7893 4.46957 22 5 22H19C19.5304 22 20.0391 21.7893 20.4142 21.4142C20.7893 21.0391 21 20.5304 21 20V6L18 2H6Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M3 6H21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <h3>No hay entradas de productos registradas</h3>
                            <p>Comienza creando tu primera entrada de producto</p>
                            <a href="/entradas-productos/crear" class="boton">Crear Entrada de Producto</a>
                        </div>
                    </td>
                </tr>
                <?php else: ?>
                    <?php foreach($entradas as $entrada): ?>
                    <tr>
                        <td class="id"><?php echo s($entrada->id ?? 'N/A'); ?></td>
                        <td class="fecha"><?php echo s($entrada->fecha ?? 'N/A'); ?></td>
                        <td class="id-usuario"><?php echo s($entrada->usuario_nombre ?? 'N/A'); ?></td>
                        <td class="acciones-tabla">
                            <a href="/entradas-productos/editar?id=<?php echo $entrada->id; ?>" 
                               class="btn-accion btn-editar" title="Editar">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11 4H4C3.46957 4 2.96086 4.21071 2.58579 4.58579C2.21071 4.96086 2 5.46957 2 6V20C2 20.5304 2.21071 21.0391 2.58579 21.4142C2.96086 21.7893 3.46957 22 4 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M18.5 2.5C18.8978 2.10218 19.4374 1.87868 20 1.87868C20.5626 1.87868 21.1022 2.10218 21.5 2.5C21.8978 2.89782 22.1213 3.43739 22.1213 4C22.1213 4.56261 21.8978 5.10218 21.5 5.5L12 15L8 16L9 12L18.5 2.5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                            <button onclick="eliminarEntrada(<?php echo $entrada->id; ?>, '<?php echo 'Entrada de producto #' . $entrada->id; ?>')" 
                                    class="btn-accion btn-eliminar" title="Eliminar">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 6H5H21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M8 6V4C8 3.46957 8.21071 2.96086 8.58579 2.58579C8.96086 2.21071 9.46957 2 10 2H14C14.5304 2 15.0391 2.21071 15.4142 2.58579C15.7893 2.96086 16 3.46957 16 4V6M19 6V20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22H7C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20V6H19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- Modal de confirmación para eliminar -->
<div id="modal-eliminar" class="modal">
    <div class="modal-contenido">
        <div class="modal-header">
            <h3>Confirmar Eliminación</h3>
            <button class="cerrar-modal" onclick="cerrarModal()">&times;</button>
        </div>
        <div class="modal-body">
            <p>¿Estás seguro de que deseas eliminar <strong id="nombre-entrada"></strong>?</p>
            <p class="advertencia">Esta acción eliminará la Entrada de Producto y todos sus productos asociados. Esta acción no se puede deshacer.</p>
        </div>
        <div class="modal-footer">
            <button class="boton boton-secundario" onclick="cerrarModal()">Cancelar</button>
            <form id="form-eliminar" method="POST" action="/entradas-productos/eliminar" style="display: inline;">
                <input type="hidden" name="id" id="id-venta-eliminar">
                <button type="submit" class="boton boton-peligro">Eliminar</button>
            </form>
        </div>
    </div>
</div>