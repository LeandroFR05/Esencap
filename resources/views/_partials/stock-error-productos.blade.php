@if(session('stock_error_producto'))
    <script>
        const data = @json(session('stock_error_producto'));
        document.addEventListener('DOMContentLoaded', function() {
            const lotes = Array.isArray(data.lotes) ? data.lotes : [];
            const fechaHoy = new Date();

            let html = `
                <div style="text-align:left;">
                    <p class="mb-3">
                        El producto <strong>${data.producto}</strong> no tiene stock suficiente para completar la operación.
                    </p>
                    <div class="mb-2">
                        <strong>Cantidad solicitada:</strong> ${data.stockSolicitado} unidades.<br>
                        <strong>Stock disponible:</strong> ${data.stockDisponible} unidades.
                    </div>
            `;

            // Si hay lotes creamos la tabla
            if (lotes.length > 0) {
                html += `<h5 style="margin-top:15px;">Información de lotes:</h5>`;
                html += construirTabla(lotes);
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

        function construirTabla(lotes) {
            let totalStockActual = 0;
            let html = `
                <table style="width:100%; border-collapse:collapse; margin-top:15px; font-size:14px;">
                    <thead>
                        <tr style="background-color:#f2f2f2;">
                            <th style="border:1px solid #ddd; padding:8px; text-align:center;">Nº Lote</th>
                            <th style="border:1px solid #ddd; padding:8px; text-align:center;">Fecha de elaboración</th>
                            <th style="border:1px solid #ddd; padding:8px; text-align:center;">Stock actual</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            // Recorremos los lotes para construir las filas de la tabla
            lotes.forEach(function(lote) {
                const stockActual = lote.stockActual;
                const fechaElaboracion = window.formatFecha(lote.fechaElaboracion);

                totalStockActual += (parseFloat(lote.stockActual) || 0);

                html += `
                    <tr>
                        <td style="border:1px solid #ddd; padding:8px; text-align:center;">${lote.numeroLote}</td>
                        <td style="border:1px solid #ddd; padding:8px; text-align:center;">${fechaElaboracion}</td>
                        <td style="border:1px solid #ddd; padding:8px; text-align:center;">${lote.stockActual}</td>
                    </tr>
                `;
            });

            html += `
                        <tr style="background-color:#f9f9f9; font-weight:700;">
                            <td style="border:1px solid #ddd; padding:8px; text-align:center;" colspan="2">Total</td>
                            <td style="border:1px solid #ddd; padding:8px; text-align:center;">${totalStockActual}</td>
                        </tr>
                    </tbody>
                </table>
            `;

            return html;
        }
    </script>
@endif