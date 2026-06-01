@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: '¡Éxito!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonText: 'Ok'
                });
            }
        });
    </script>
@endif

@if(session('stock_error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const data = JSON.parse(@json(session('stock_error')));

            let html = `
                <div style="text-align:left;">
                    <p class="mb-3">
                        El insumo <strong>${data.insumo}</strong> no tiene stock suficiente para completar la operación.
                    </p>
                    <div class="mb-2">
                        <strong>Faltan:</strong> ${data.necesario} gramos para completar la cantidad solicitada.
                    </div>
                    <br>
            `;

            if (data.lotes && data.lotes.length > 0) {
                html += `
                    <h5>Información de lotes:</h5>
                    <table style="width:100%; border-collapse:collapse; margin-top:15px; font-size:14px;">
                        <thead>
                            <tr style="background-color:#f2f2f2;">
                                <th style="border:1px solid #ddd; padding:8px; text-align:center;">Nº Lote</th>
                                <th style="border:1px solid #ddd; padding:8px; text-align:center;">Fecha de compra</th>
                                <th style="border:1px solid #ddd; padding:8px; text-align:center;">Stock actual</th>
                                <th style="border:1px solid #ddd; padding:8px; text-align:center;">Unidad de medida</th>
                                <th style="border:1px solid #ddd; padding:8px; text-align:center;">Fecha de vencimiento</th>
                            </tr>
                        </thead>
                        <tbody>
                `;

                data.lotes.forEach(function(lote) {
                    html += `
                            <tr>
                                <td style="border:1px solid #ddd; padding:8px; text-align:center;">${lote.numeroLote}</td>
                                <td style="border:1px solid #ddd; padding:8px; text-align:center;">${lote.fechaCompra}</td>
                                <td style="border:1px solid #ddd; padding:8px; text-align:center;">${lote.stockActual}</td>
                                <td style="border:1px solid #ddd; padding:8px; text-align:center;">${lote.unidadMedida}</td>
                                <td style="border:1px solid #ddd; padding:8px; text-align:center;">${lote.fechaVencimiento}</td>
                            </tr>
                    `;
                });

                html += `
                        </tbody>
                    </table>
                `;
            }

            html += '</div>';

            Swal.fire({
                icon: 'warning',
                title: 'Stock insuficiente',
                html: html,
                confirmButtonText: 'Entendido',
                width: '750px'
            });
        });
    </script>
@endif

@if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Error',
                    text: "{{ session('error') }}",
                    icon: 'error',
                    confirmButtonText: 'Ok'
                });
            }
        });
    </script>
@endif

@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            let lista = `
                <ul style="text-align:left;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            `;

            Swal.fire({
                icon: 'error',
                title: 'Errores encontrados',
                html: lista,
                confirmButtonText: 'Aceptar'
            });

        });
    </script>
@endif


@if(session('warning'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Cuidado',
                    text: "{{ session('warning') }}",
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                });
            }
        });
    </script>
@endif

@if(session('info'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Información',
                    text: "{{ session('info') }}",
                    icon: 'info',
                    confirmButtonText: 'Ok'
                });
            }
        });
    </script>
@endif