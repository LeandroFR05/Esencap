document.getElementById("formProductos").addEventListener("submit", function(e) {

    let errorDiv = document.getElementById("error-porcentaje");
    if (!validarPorcentajes()) {
        e.preventDefault();
        if (errorDiv) {
            errorDiv.style.display = "block";
        }
    } else {
        if (errorDiv) {
            errorDiv.style.display = "none";
        }
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

    if(Math.round(suma * 100) / 100 === 100) 
        resultado = true;

    return resultado;
    
}
