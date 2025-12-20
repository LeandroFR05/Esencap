document.getElementById("formProductos").addEventListener("submit", function(e) {

    if (!validarPorcentajes()) {
        e.preventDefault();
        alert("La suma de todos los porcentajes debe ser 100%.");
    }

});

function validarPorcentajes() {

    let resultado = false;
    let inputs = document.querySelectorAll(".porcentaje");
    let suma = 0;

    inputs.forEach(input => {
        let valor = parseFloat(input.value) || 0;
        suma += valor;
    });

    if(suma === 100) 
        resultado = true;

    return resultado;
    
}
