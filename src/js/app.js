// Menú móvil
document.addEventListener('DOMContentLoaded', function() {
    console.log('JavaScript cargado correctamente');
    
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenuDropdown = document.getElementById('mobile-menu-dropdown');
    
    console.log('Botón encontrado:', mobileMenuBtn);
    console.log('Dropdown encontrado:', mobileMenuDropdown);
    
    if (mobileMenuBtn && mobileMenuDropdown) {
        console.log('Agregando event listeners');
        
        // Toggle del menú móvil
        mobileMenuBtn.addEventListener('click', function(e) {
            console.log('Click en botón hamburguesa');
            e.stopPropagation();
            mobileMenuDropdown.classList.toggle('active');
            console.log('Clase active toggleada');
        });
        
        // Cerrar menú al hacer clic fuera
        document.addEventListener('click', function(e) {
            if (!mobileMenuBtn.contains(e.target) && !mobileMenuDropdown.contains(e.target)) {
                mobileMenuDropdown.classList.remove('active');
            }
        });
        
        // Cerrar menú al hacer clic en un enlace
        const mobileNavItems = mobileMenuDropdown.querySelectorAll('.mobile-nav-item');
        mobileNavItems.forEach(item => {
            item.addEventListener('click', function() {
                mobileMenuDropdown.classList.remove('active');
            });
        });
        
        // Prevenir que el clic en el menú lo cierre
        mobileMenuDropdown.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    } else {
        console.log('No se encontraron los elementos del menú móvil');
    }
    
    // Inicializar funcionalidades de productos si existen
    inicializarProductos(); 
    inicializarClientes();
    
    // Inicializar formulario de ventas si existe
    inicializarFormularioVentas();
});

// Funciones de gestión de productos
function eliminarProducto(id, nombre) {
    document.getElementById('id-producto-eliminar').value = id;
    document.getElementById('nombre-producto').textContent = nombre;
    document.getElementById('modal-eliminar').style.display = 'flex';
}

function eliminarCliente(id, nombre) {
    //console.log('Eliminando cliente:', id, nombre);
    document.getElementById('id-cliente-eliminar').value = id;
    document.getElementById('nombre-cliente').textContent = nombre;
    document.getElementById('modal-eliminar').style.display = 'flex';
}

function eliminarVenta(id, nombre) {
    document.getElementById('id-venta-eliminar').value = id;
    document.getElementById('nombre-venta').textContent = nombre;
    document.getElementById('modal-eliminar').style.display = 'flex';
}

function eliminarEntrada(id, nombre) {
    document.getElementById('id-entrada-eliminar').value = id;
    document.getElementById('nombre-entrada').textContent = nombre;
    document.getElementById('modal-eliminar').style.display = 'flex';
}

function cerrarModal() {
    document.getElementById('modal-eliminar').style.display = 'none';
}

function inicializarProductos() {
    // Búsqueda en tiempo real de productos
    const campoBusqueda = document.getElementById('buscar-productos');
    if (campoBusqueda) {
        campoBusqueda.addEventListener('input', function(e) {
            const termino = e.target.value.toLowerCase();
            const filas = document.querySelectorAll('.tabla-productos tbody tr');
            
            filas.forEach(fila => {
                const texto = fila.textContent.toLowerCase();
                if (texto.includes(termino)) {
                    fila.style.display = '';
                } else {
                    fila.style.display = 'none';
                }
            });
        });
    }
    
    // Cerrar modal al hacer clic fuera
    const modalEliminar = document.getElementById('modal-eliminar');
    if (modalEliminar) {
        modalEliminar.addEventListener('click', function(e) {
            if (e.target === this) {
                cerrarModal();
            }
        });
    }
}

function inicializarClientes() {
    // Búsqueda en tiempo real de clientes
    const campoBusqueda = document.getElementById('buscar-clientes');
    //console.log('Campo de búsqueda encontrado:', campoBusqueda);
    if (campoBusqueda) {
        campoBusqueda.addEventListener('input', function(e) {
            const termino = e.target.value.toLowerCase();
            const filas = document.querySelectorAll('.tabla-clientes tbody tr');
            
            filas.forEach(fila => {
                const texto = fila.textContent.toLowerCase();
                if (texto.includes(termino)) {
                    fila.style.display = '';
                } else {
                    fila.style.display = 'none';
                }
            });
        });
    }
    // Cerrar modal al hacer clic fuera
    const modalEliminar = document.getElementById('modal-eliminar');
    if (modalEliminar) {
        modalEliminar.addEventListener('click', function(e) {
            if (e.target === this) {
                cerrarModal();
            }
        });
    }
}

// Funcionalidad del formulario de ventas
function inicializarFormularioVentas() {
    const listaProductos = document.getElementById('lista-productos');
    const tpl = document.getElementById('tpl-tarjeta-producto');
    const btnAgregar = document.getElementById('btn-agregar-producto');
    const totalInput = document.getElementById('total');
    const tipoPago = document.getElementById('tipo_pago');
    const creditoInput = document.getElementById('credito');
    const cantidadProductos = document.getElementById('cantidad-productos');
    const totalPedido = document.getElementById('total-pedido');

    // Si no existe el formulario de pedidos, salir
    if (!listaProductos || !tpl || !btnAgregar) {
        return;
    }

    let indice = 0;
    let numeroProducto = 1;

    function formatearMoneda(valor) {
        return parseFloat(valor || 0).toLocaleString('es-ES', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    function recalcularTotales() {
        let total = 0;
        let cantidadTotal = 0;
        let tieneProductosConValor = false;
        
        listaProductos.querySelectorAll('.tarjeta-producto').forEach(tarjeta => {
            const cantidad = parseFloat(tarjeta.querySelector('.input-cantidad')?.value || '0');
            const precio = parseFloat(tarjeta.querySelector('.input-precio')?.value || '0');
            const subtotal = cantidad * precio;
            const subtotalInput = tarjeta.querySelector('.input-subtotal');
            
            if (!Number.isNaN(subtotal)) {
                total += subtotal;
                cantidadTotal += cantidad;
                if (subtotalInput) {
                    subtotalInput.value = formatearMoneda(subtotal);
                }
                // Si tiene cantidad y precio válidos (mayores a 0), hay productos válidos
                if (cantidad > 0 && precio > 0) {
                    tieneProductosConValor = true;
                }
            }
        });
        
        // Guardar el total inicial que viene de PHP (solo la primera vez)
        if (typeof recalcularTotales.totalInicial === 'undefined' && totalInput) {
            
            recalcularTotales.totalInicial = parseFloat(totalInput.value || '0');
        }
        
        // Actualizar totales solo si hay productos con valores válidos
        // Esto evita sobrescribir el total inicial cuando no hay productos cargados aún
        if (tieneProductosConValor) {
            if (totalInput) totalInput.value = total.toFixed(2);
            if (totalPedido) totalPedido.textContent = '$' + formatearMoneda(total);
            if (cantidadProductos) cantidadProductos.textContent = cantidadTotal;
            if (tipoPago.value === 'credito'){
                creditoInput.value = total.toFixed(2);
            }
        }
    }
    
    // Inicializar totales desde el valor que viene de PHP (si existe)
    function inicializarTotalesDesdePHP() {
        if (totalInput && totalPedido) {
            const totalPHP = parseFloat(totalInput.value || '0');
            if (!Number.isNaN(totalPHP) && totalPHP > 0) {
                // Inicializar el display con el valor que viene de PHP
                totalPedido.textContent = '$' + formatearMoneda(totalPHP);
            }
        }
    }

    function enlazarEventosTarjeta(tarjeta) {
        const selectProd = tarjeta.querySelector('.select-producto, .input-producto-id');
        const cantidad = tarjeta.querySelector('.input-cantidad');
        const precio = tarjeta.querySelector('.input-precio');
        const eliminar = tarjeta.querySelector('.btn-eliminar-producto');

        // Evento para seleccionar producto
        if (selectProd && selectProd.tagName === 'SELECT') {
            selectProd.addEventListener('change', function() {
                const opt = this.options[this.selectedIndex];
                const precioData = parseFloat(opt.getAttribute('data-precio') || '0');
                if (!Number.isNaN(precioData) && precio) {
                    precio.value = precioData.toFixed(2);
                    recalcularTotales();
                }
            });
        }

        // Eventos para cantidad y precio
        [cantidad, precio].forEach(inp => {
            if (inp) {
                inp.addEventListener('input', function() {
                    recalcularTotales();
                });
            }
        });

        // Evento para eliminar
        if (eliminar) {
            eliminar.addEventListener('click', function() {
                if (listaProductos.querySelectorAll('.tarjeta-producto').length <= 1) {
                    alert('Debe haber al menos un producto en el pedido');
                    return;
                }
                tarjeta.style.animation = 'fadeOut 0.3s ease-out';
                setTimeout(() => {
                    tarjeta.remove();
                    recalcularTotales();
                }, 300);
            });
        }
    }

    function agregarProducto() {
        const html = tpl.innerHTML
            .replaceAll('__INDEX__', String(indice++))
            .replace('__NUM__', String(numeroProducto++));
        
        const temp = document.createElement('div');
        temp.innerHTML = html;
        const tarjeta = temp.querySelector('.tarjeta-producto');
        
        if (tarjeta) {
            tarjeta.style.opacity = '0';
            tarjeta.style.transform = 'translateY(-10px)';
            listaProductos.appendChild(tarjeta);
            
            // Animación de entrada
            setTimeout(() => {
                tarjeta.style.transition = 'all 0.3s ease-in';
                tarjeta.style.opacity = '1';
                tarjeta.style.transform = 'translateY(0)';
            }, 10);
            
            enlazarEventosTarjeta(tarjeta);
            recalcularTotales();
        }
    }

    // Event listeners
    btnAgregar.addEventListener('click', agregarProducto);

    // Control de crédito
    function toggleCredito() {
        if (tipoPago && creditoInput) {
            if (tipoPago.value === 'credito') {
                creditoInput.removeAttribute('readonly');
                creditoInput.style.backgroundColor = '#fff';
            } else {
                creditoInput.setAttribute('readonly', 'readonly');
                creditoInput.value = '0';
                creditoInput.style.backgroundColor = '#f5f5f5';
            }
        }
    }

    if (tipoPago) {
        tipoPago.addEventListener('change', toggleCredito);
        toggleCredito();
    }

    // Inicializar totales desde PHP (si estamos editando)
    inicializarTotalesDesdePHP();

    // Enlazar eventos a las tarjetas existentes (si vienen renderizadas desde PHP)
    listaProductos.querySelectorAll('.tarjeta-producto').forEach(tarjeta => {
        enlazarEventosTarjeta(tarjeta);
        // Actualizar número de producto si es necesario
        const numeroProd = tarjeta.querySelector('.numero-producto');
        if (numeroProd) {
            const index = Array.from(listaProductos.querySelectorAll('.tarjeta-producto')).indexOf(tarjeta);
            numeroProd.textContent = '#' + (index + 1);
        }
    });

    // Ajustar índices para nuevas tarjetas
    indice = listaProductos.querySelectorAll('.tarjeta-producto').length;
    numeroProducto = indice + 1;

    // Si no hay productos, agregar primera tarjeta por defecto
    if (listaProductos.querySelectorAll('.tarjeta-producto').length === 0) {
        agregarProducto();
    } else {
        // Si ya hay productos (renderizados desde PHP), recalcular para actualizar totales
        recalcularTotales();
    }
}