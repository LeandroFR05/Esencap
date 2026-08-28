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

@include('_partials.stock-error-insumos')
@include('_partials.stock-error-productos')

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

<!-- @if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Error',
                    text: "{{ $errors->first() }}",
                    icon: 'error',
                    confirmButtonText: 'Ok'
                });
            }
        });
    </script>
@endif -->


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