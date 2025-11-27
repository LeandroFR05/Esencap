<header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">ESENCAP</a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ route('dashboard') }}">INICIO</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('productos.estante') }}">PRODUCTOS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('insumos.estante') }}">INSUMOS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">HISTORIAL</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<style>
    .nav-item{
        margin-left: 20px;
    }
</style>


