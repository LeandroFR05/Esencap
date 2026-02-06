//Variables
const producto = document.getElementById('producto');
const idProducto = document.getElementById('idProducto');
const lista = document.getElementById('lista-productos');

let controller;
let timeout;

//Con este evento escucho el input que ingresa el usuario para buscar productos relacionados
producto.addEventListener('input', function() {
    clearTimeout(timeout); //Limpio el timeout anterior

    timeout = setTimeout(() => {
        const texto = this.value.trim();
        lista.innerHTML = '';
        
        if (texto.length > 0) {
            //Si vuelve a entrar en el controlador, y todavia no se terminó de procesar la consulta anterior, la aborta
            if (controller) {
                controller.abort();
            }

            controller = new AbortController();
            fetch(`/productos/buscar?query=${texto}`, { 
                signal: controller.signal 
            })
            .then(response => response.json())
            .then(data => {
                data.forEach(item => {
                    const li = document.createElement('li');
                    li.className = 'list-group-item';
                    li.textContent = item.nombre;
                    lista.appendChild(li);

                    //Con este evento selecciono el producto de la lista <li> y lo pongo en el input
                    li.addEventListener('click', () => {
                        producto.value = item.nombre;
                        idProducto.value = item.idProducto;
                        lista.innerHTML = '';
                    });
                });
            })
            .catch(error => {
                if (error.name !== 'AbortError') {
                    console.error(error);
                }
            });
        }
    }, 300); //Espera 300ms después de que el usuario deja de escribir para hacer la búsqueda, así no se traba
});