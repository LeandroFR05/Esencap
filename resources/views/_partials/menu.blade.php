<div class="sidebar-menu">
    <ul class="menu">
        <li class="sidebar-title">Menu</li>
        
            <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class='sidebar-link'>
                    <i class="bi bi-grid-fill"></i>
                    <span>Inicio</span>
                </a>
            </li>
            
            <li class="sidebar-item {{ request()->routeIs('productos.*') ? 'active' : '' }}">
                <a href="{{ route('productos.estante') }}" class='sidebar-link'>
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span>Productos</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->routeIs('insumos.*') || request()->routeIs('lotes.*') ? 'active' : '' }}">
                <a href="{{ route('insumos.estante') }}" class='sidebar-link'>
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span>Insumos</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->routeIs('historial.general') ? 'active' : '' }}">
                <a href="{{ route('historial.general') }}" class='sidebar-link'>
                    <i class="bi bi-list-task"></i>
                    <span>Historial de elaboración</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->routeIs('ventas.historial') ? 'active' : '' }}">
                <a href="{{ route('ventas.historial') }}" class='sidebar-link'>
                    <i class="bi bi-list-task"></i>
                    <span>Historial de ventas</span>
                </a>
            </li>
        
        <li class="sidebar-title">Operaciones</li>
            <li class="sidebar-item {{ request()->routeIs('productos.create') ? 'active' : '' }}">
                <a href="{{ route('productos.create') }}" class='sidebar-link'>
                    <i class="bi bi-plus-square-fill"></i>
                    <span>Nuevo producto</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->routeIs('insumos.create') ? 'active' : '' }}">
                <a href="{{ route('insumos.create') }}" class='sidebar-link'>
                    <i class="bi bi-plus-square-fill"></i>
                    <span>Nuevo insumo</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->routeIs('ventas.index') ? 'active' : '' }}">
                <a href="{{ route('ventas.index') }}" class='sidebar-link'>
                    <i class="bi bi-bag-check-fill"></i>
                    <span>Registrar venta</span>
                </a>
            </li>
        
        <li class="sidebar-title">Ajustes</li>
            <li class="sidebar-item has-sub">
                <a class="sidebar-link" href="#">
                    <i class="bi bi-person-circle"></i>
                    <span>{{ Auth::user()->name }}</span>
                </a>

                <ul class="submenu">
                    <li class="submenu-item">
                        <a href="#" class="submenu-link">Perfil</a>
                    </li>
                    <!-- <li class="submenu-item">
                        <a href="#" class="submenu-link">Seguridad</a>
                    </li> -->
                    <li class="submenu-item">
                        <a href="{{ route('logout') }}" class="submenu-link"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Cerrar Sesión
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                            @method('POST')
                        </form>
                    </li>
                </ul>
            </li>
            @auth
            <li class="sidebar-item">
                <a href="{{ route('register') }}" class="sidebar-link">
                    <i class="bi bi-person-add"></i>
                    <span>{{ __('Nuevo usuario') }}</span>
                </a>
            </li>
            @endauth
    </ul>
</div>


