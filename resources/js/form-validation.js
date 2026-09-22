document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('form').forEach(function (form) {
    form.noValidate = true; // Desactiva la validación nativa del navegador (ventana emergente)

    // El usuario intenta enviar el formulario
    form.addEventListener('submit', function (event) {
      // Busca el primer campo required inválido
      const firstInvalid = Array.from(form.querySelectorAll('[required]')).find(function (input) {
        return !input.checkValidity();
      });

      // Si el formulario es inválido, cancela el envío
      if (!form.checkValidity()) {
        event.preventDefault();

        // Hace scroll y foco al primer error
        if (firstInvalid) {
          firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
          firstInvalid.focus({ preventScroll: true });
          
          firstInvalid.classList.add('is-invalid'); // Marca el campo como inválido

          let feedback = firstInvalid.parentNode.querySelector('.invalid-feedback');
          if (!feedback) {
            feedback = document.createElement('div');
            feedback.className = 'invalid-feedback';
            firstInvalid.parentNode.appendChild(feedback);
          }
          
          // Escribe el texto del error
          feedback.textContent = firstInvalid.validationMessage || 'Complete este campo';
        }
      }
    }, true);

    // Se bloquea también el evento invalid nativo
    form.addEventListener('invalid', function (event) {
      event.preventDefault();
      event.stopPropagation();
    }, true);
  });
});
