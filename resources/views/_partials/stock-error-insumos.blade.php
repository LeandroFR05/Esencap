@if(session('stock_error_insumo'))
    <script>
        const data = @json(session('stock_error_insumo'));
        document.addEventListener('DOMContentLoaded', function() {
            const lotes = Array.isArray(data.lotes) ? data.lotes : [];
            const fechaHoy = new Date();

            let html = `
                <div style="text-align:left;">
                    <p class="mb-3">
                        El insumo <strong>${data.insumo}</strong> no tiene stock suficiente para completar la operación.
                    </p>
                    <div class="mb-2">
                        <strong>Cantidad solicitada:</strong> ${data.necesario} gramos.<br>
                        <strong>Stock disponible:</strong> ${data.stockDisponible} ${data.unidad}.<br>
                        <strong>Lotes vencidos:</strong> ${data.lotesVencidos}.
                    </div>
            `;
            
            // Si hay lotes creamos la tabla
            if (lotes.length > 0) {
                html += `<h5 style="margin-top:15px;">Información de lotes:</h5>`;
                html += construirTabla(lotes, fechaHoy);
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

        function construirTabla(lotes, fechaHoy) {
            let totalStockActual = 0;
            let html = `
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
            
            // Recorremos los lotes para construir las filas de la tabla
            lotes.forEach(function(lote) {
                const stockActual = lote.stockActual;
                const fechaCompra = window.formatFecha(lote.fechaCompra);
                const fechaVencimiento = window.formatFecha(lote.fechaVencimiento);
                const estaVencido = new Date(lote.fechaVencimiento) < fechaHoy;

                // Si el lote no está vencido, sumamos su stock al total disponible
                if (!estaVencido) {
                    totalStockActual += (parseFloat(lote.stockActual) || 0);
                }

                html += `
                    <tr style="${estaVencido ? 'background-color:#ffd6d6;' : ''}">
                        <td style="border:1px solid #ddd; padding:8px; text-align:center;">${lote.numeroLote}</td>
                        <td style="border:1px solid #ddd; padding:8px; text-align:center;">${fechaCompra}</td>
                        <td style="border:1px solid #ddd; padding:8px; text-align:center;">${estaVencido ? '-' : ''}${lote.stockActual}</td>
                        <td style="border:1px solid #ddd; padding:8px; text-align:center;">${data.unidad}</td>
                        <td style="border:1px solid #ddd; padding:8px; text-align:center;">${fechaVencimiento}</td>
                    </tr>
                `;
            });

            html += `
                        <tr style="background-color:#f9f9f9; font-weight:700;">
                            <td style="border:1px solid #ddd; padding:8px; text-align:center;" colspan="2">Total</td>
                            <td style="border:1px solid #ddd; padding:8px; text-align:center;">${totalStockActual}</td>
                            <td style="border:1px solid #ddd; padding:8px; text-align:center;">${data.unidad}</td>
                            <td style="border:1px solid #ddd; padding:8px; text-align:center;"></td>
                        </tr>
                    </tbody>
                </table>
            `;

            return html;
        }
    </script>
@endif
