// Variables
const producto = document.getElementById('producto');
const idProducto = document.getElementById('idProducto');
const lista = document.getElementById('lista-productos');
const cantidad = document.getElementById('cantidad');
const precioUnitario = document.getElementById('precioUnitario');
const btnAgregar = document.getElementById('btn-agregar');
const carritoBody = document.getElementById('carrito-body');
const carritoInput = document.getElementById('carrito-input');
const totalGeneral = document.getElementById('total-general');
const btnRegistrar = document.getElementById('btn-registrar');
const formVenta = document.getElementById('form-venta');

let carrito = [];
let controller;
let timeout;
let busquedaActiva = false;

// Recuperar carrito guardado si existe
const carritoOld = document.getElementById('carrito-old')?.value;
if (carritoOld) {
    try {
        carrito = JSON.parse(carritoOld);
        renderizarCarrito();
    } catch (e) {
        console.error('Error al parsear carrito guardado:', e);
    }
}

// Buscar producto (con mínimo 2 caracteres)
producto.addEventListener('input', function() {
    clearTimeout(timeout);
    const texto = this.value.trim();

    if (texto.length < 2) {
        lista.innerHTML = '';
        busquedaActiva = false;
        return;
    }

    timeout = setTimeout(() => {
        lista.innerHTML = '';
        
        if (controller) {
            controller.abort();
        }

        controller = new AbortController();
        fetch(`/productos/buscar?query=${texto}`, { 
            signal: controller.signal 
        })
        .then(response => response.json())
        .then(data => {
            lista.innerHTML = '';
            if (data.length === 0) {
                const li = document.createElement('li');
                li.className = 'list-group-item text-muted';
                li.textContent = 'No se encontraron productos';
                lista.appendChild(li);
                busquedaActiva = false;
                return;
            }

            data.forEach(item => {
                const li = document.createElement('li');
                li.className = 'list-group-item list-group-item-action';
                li.textContent = item.nombre;
                lista.appendChild(li);

                li.addEventListener('click', () => {
                    producto.value = item.nombre;
                    idProducto.value = item.idProducto;
                    lista.innerHTML = '';
                    busquedaActiva = false;
                    cantidad.focus();
                });
            });
            busquedaActiva = true;
        })
        .catch(error => {
            if (error.name !== 'AbortError') {
                console.error(error);
            }
        });
    }, 400);
});

// Ocultar lista al perder foco
producto.addEventListener('blur', function() {
    setTimeout(() => {
        if (!busquedaActiva) {
            lista.innerHTML = '';
        }
    }, 200);
});

// Agregar producto al carrito
btnAgregar.addEventListener('click', function() {
    const id = idProducto.value;
    const nombre = producto.value.trim();
    const cant = parseInt(cantidad.value);
    const precio = parseFloat(precioUnitario.value);

    if (!nombre) {
        producto.setCustomValidity('Complete este campo');
        producto.reportValidity();
        producto.focus();
        return;
    }

    if (!id) {
        producto.setCustomValidity('Debe seleccionar un producto válido');
        producto.reportValidity();
        return;
    }

    if (!cant || cant < 1) {
        cantidad.setCustomValidity('Ingrese una cantidad válida');
        cantidad.reportValidity();
        cantidad.focus();
        return;
    }

    if (isNaN(precio) || precio < 0) {
        precioUnitario.setCustomValidity('Ingrese un precio válido');
        precioUnitario.reportValidity();
        precioUnitario.focus();
        return;
    }

    const existente = carrito.findIndex(item => item.idProducto == id);
    if (existente !== -1) {
        carrito[existente].cantidad += cant;
        carrito[existente].precioUnitario = precio;
    } else {
        carrito.push({ idProducto: id, nombre: nombre, cantidad: cant, precioUnitario: precio });
    }

    renderizarCarrito();
    producto.value = '';
    idProducto.value = '';
    cantidad.value = '1';
    precioUnitario.value = '0.00';
    producto.focus();
});

// Renderizar carrito
function renderizarCarrito() {
    if (carrito.length === 0) {
        carritoBody.innerHTML = '<tr id="fila-vacia"><td colspan="5" class="text-center text-muted py-4">No hay productos agregados</td></tr>';
        if (totalGeneral) totalGeneral.textContent = '$ 0.00';
        carritoInput.value = '';
        return;
    }

    carritoBody.innerHTML = '';
    let total = 0;

    carrito.forEach((item, index) => {
        const subtotal = item.cantidad * item.precioUnitario;
        total += subtotal;

        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${item.nombre}</td>
            <td>
                <input type="number" class="form-control form-control-sm input-cantidad" value="${item.cantidad}" min="1" data-index="${index}" style="width: 80px;">
            </td>
            <td>
                <div class="input-group input-group-sm">
                    <span class="input-group-text">$</span>
                    <input type="number" class="form-control input-precio" value="${item.precioUnitario.toFixed(2)}" min="0" step="0.01" data-index="${index}">
                </div>
            </td>
            <td class="fw-semibold subtotal">$ ${subtotal.toFixed(2)}</td>
            <td>
                <button type="button" class="btn btn-danger btn-sm" data-index="${index}">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        `;
        carritoBody.appendChild(tr);
    });

    if (totalGeneral) totalGeneral.textContent = `$ ${total.toFixed(2)}`;
    carritoInput.value = JSON.stringify(carrito);

    // Event listeners para botones de eliminar
    carritoBody.querySelectorAll('button[data-index]').forEach(btn => {
        btn.addEventListener('click', function() {
            const index = parseInt(this.getAttribute('data-index'));
            carrito.splice(index, 1);
            renderizarCarrito();
        });
    });

    // Event listeners para inputs de cantidad
    carritoBody.querySelectorAll('.input-cantidad').forEach(input => {
        input.addEventListener('change', function() {
            const index = parseInt(this.getAttribute('data-index'));
            const nuevaCantidad = parseInt(this.value);
            if (nuevaCantidad < 1) {
                this.value = carrito[index].cantidad;
                return;
            }
            carrito[index].cantidad = nuevaCantidad;
            renderizarCarrito();
        });
    });

    // Event listeners para inputs de precio unitario
    carritoBody.querySelectorAll('.input-precio').forEach(input => {
        input.addEventListener('change', function() {
            const index = parseInt(this.getAttribute('data-index'));
            const nuevoPrecio = parseFloat(this.value);
            if (isNaN(nuevoPrecio) || nuevoPrecio < 0) {
                this.value = carrito[index].precioUnitario.toFixed(2);
                return;
            }
            carrito[index].precioUnitario = nuevoPrecio;
            renderizarCarrito();
        });
    });
}

// Registrar venta
btnRegistrar.addEventListener('click', function() {
    const clienteInput = document.getElementById('cliente');
    const fechaInput = document.getElementById('fecha');

    const cliente = clienteInput.value.trim();
    const fecha = fechaInput.value;

    // Limpiar mensajes previos
    clienteInput.setCustomValidity('');
    fechaInput.setCustomValidity('');

    // Validar cliente
    if (!cliente) {
        clienteInput.setCustomValidity('Complete este campo');
        clienteInput.reportValidity();
        clienteInput.focus();
        return;
    }

    // Validar fecha
    if (!fecha) {
        fechaInput.setCustomValidity('Seleccione una fecha');
        fechaInput.reportValidity();
        fechaInput.focus();
        return;
    }

    if (carrito.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Carrito vacío',
            text: 'Agregue al menos un producto al carrito.',
            confirmButtonText: 'Entendido',
            confirmButtonColor: '#3085d6'
        });
        return;
    }

    // Actualizar inputs ocultos para enviar
    const inputs = formVenta.querySelectorAll('input[name="carrito"], input[name="cliente"], input[name="fecha"]');
    inputs.forEach(input => {
        if (input.name === 'carrito') {
            input.value = JSON.stringify(carrito);
        } else if (input.name === 'cliente') {
            input.value = cliente;
        } else if (input.name === 'fecha') {
            input.value = fecha;
        }
    });

    formVenta.submit();
});

// Inicializar fecha con hoy (solo si no hay un valor previo)
const fechaInput = document.getElementById('fecha');
if (!fechaInput.value) {
    fechaInput.valueAsDate = new Date();
}
