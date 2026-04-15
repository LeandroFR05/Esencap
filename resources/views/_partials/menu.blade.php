<div class="sidebar-menu">
    <ul class="menu">
        <li class="sidebar-title">Menu</li>
        
            <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class='sidebar-link'>
                    <i class="bi bi-grid-fill"></i>
                    <span>Inicio</span>
                </a>
            </li>
            
            <li class="sidebar-item has-sub {{ (request()->routeIs('productos.*')) ? 'active' : '' }}">
                <a class="sidebar-link" href="#">
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span>Productos</span>
                </a>

                <ul class="submenu {{ (request()->routeIs('productos.estante') || request()->routeIs('productos.create')) ? 'active' : '' }}">
                    <li class="submenu-item {{ request()->routeIs('productos.estante') ? 'active' : '' }}">
                        <a href="{{ route('productos.estante') }}" class="submenu-link">
                            <i class="bi bi-list-task"></i> Estante
                        </a>
                    </li>
                    <li class="submenu-item {{ request()->routeIs('productos.create') ? 'active' : '' }}">
                        <a href="{{ route('productos.create') }}" class="submenu-link">
                            <i class="bi bi-plus"></i> Nuevo producto
                        </a>
                    </li>
                </ul>
            </li>

            <li class="sidebar-item has-sub {{ (request()->routeIs('insumos.*')) ? 'active' : '' }}">
                <a class="sidebar-link" href="#">
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span>Insumos</span>
                </a>

                <ul class="submenu {{ (request()->routeIs('insumos.estante')) ? 'active' : '' }}">
                    <li class="submenu-item {{ request()->routeIs('insumos.estante') ? 'active' : '' }}">
                        <a href="{{ route('insumos.estante') }}" class="submenu-link">
                            <i class="bi bi-list-task"></i> Estante
                        </a>
                    </li>
                    <li class="submenu-item {{ request()->routeIs('insumos.create') ? 'active' : '' }}">
                        <a href="{{ route('insumos.create') }}" class="submenu-link">
                            <i class="bi bi-plus"></i> Nuevo insumo
                        </a>
                    </li>
                </ul>
            </li>

            <li class="sidebar-item has-sub {{ (request()->routeIs('ventas.*')) ? 'active' : '' }}">
                <a class="sidebar-link" href="#">
                    <i class="bi bi-bag-check-fill"></i>
                    <span>Ventas</span>
                </a>

                <ul class="submenu {{ (request()->routeIs('ventas.index')) ? 'active' : '' }}">
                    <li class="submenu-item {{ request()->routeIs('ventas.index') ? 'active' : '' }}">
                        <a href="{{ route('ventas.index') }}" class="submenu-link">
                            <i class="bi bi-plus"></i> Registrar venta
                        </a>
                    </li>
                    <li class="submenu-item {{ request()->routeIs('ventas.historial') ? 'active' : '' }}">
                        <a href="{{ route('ventas.historial') }}" class="submenu-link">
                            <i class="bi bi-list-task"></i> Historial
                        </a>
                    </li>
                </ul>
            </li>

            <li class="sidebar-item {{ request()->routeIs('historial.general') ? 'active' : '' }}">
                <a href="{{ route('historial.general') }}" class='sidebar-link'>
                    <i class="bi bi-list-task"></i>
                    <span>Historial de elaboración</span>
                </a>
            </li>

            <!-- <li class="sidebar-item {{ request()->routeIs('send-email') ? 'active' : '' }}">
                <a href="#" class='sidebar-link'>
                    <i class="bi bi-envelope"></i>
                    <span>Enviar email</span>
                </a>
            </li> -->
        
        <li class="sidebar-title">Ajustes</li>
            <li class="sidebar-item has-sub {{ (request()->routeIs('profile')) ? 'active' : '' }}">
                <a class="sidebar-link" href="#">
                    <i class="bi bi-person-circle"></i>
                    <span>{{ Auth::user()->name }}</span>
                </a>

                <ul class="submenu {{ (request()->routeIs('profile')) ? 'active' : '' }}">
                    <li class="submenu-item {{ request()->routeIs('profile') ? 'active' : '' }}">
                        <a href="{{ route('profile') }}" class="submenu-link">
                            <i class="bi bi-door-open"></i> Perfil
                        </a>
                    </li>
                    <li class="submenu-item">
                        <a href="{{ route('logout') }}" class="submenu-link"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-left"></i> Cerrar Sesión
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


