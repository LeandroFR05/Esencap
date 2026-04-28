<div class="sidebar-wrapper">
    <nav class="mt-2">
        <!--begin::Sidebar Menu-->
        <ul
            class="nav sidebar-menu flex-column"
            data-lte-toggle="treeview"
            role="navigation"
            aria-label="Main navigation"
            data-accordion="false"
            id="navigation"
        >
            {{-- Título --}}
                <li class="nav-header">MENU</li>

                {{-- Inicio --}}
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                    class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-grid-fill"></i>
                        <p>Inicio</p>
                    </a>
                </li>

                {{-- PRODUCTOS --}}
                <li class="nav-item {{ request()->routeIs('productos.*') ? 'menu-open' : '' }}">
                    <a href="#"
                    class="nav-link {{ request()->routeIs('productos.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-box-seam"></i>
                        <p>
                            Productos
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ route('productos.estante') }}"
                            class="nav-link ps-4 {{ request()->routeIs('productos.estante') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-list-task"></i>
                                <p>Estante</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('productos.create') }}"
                            class="nav-link ps-4 {{ request()->routeIs('productos.create') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-plus"></i>
                                <p>Nuevo producto</p>
                            </a>
                        </li>

                    </ul>
                </li>

                {{-- INSUMOS --}}
                <li class="nav-item {{ request()->routeIs('insumos.*') ? 'menu-open' : '' }}">
                    <a href="#"
                    class="nav-link {{ request()->routeIs('insumos.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-box"></i>
                        <p>
                            Insumos
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ route('insumos.estante') }}"
                            class="nav-link ps-4 {{ request()->routeIs('insumos.estante') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-list-task"></i>
                                <p>Estante</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('insumos.create') }}"
                            class="nav-link ps-4 {{ request()->routeIs('insumos.create') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-plus"></i>
                                <p>Nuevo insumo</p>
                            </a>
                        </li>

                    </ul>
                </li>

                {{-- VENTAS --}}
                <li class="nav-item {{ request()->routeIs('ventas.*') ? 'menu-open' : '' }}">
                    <a href="#"
                    class="nav-link {{ request()->routeIs('ventas.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-bag-check-fill"></i>
                        <p>
                            Ventas
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ route('ventas.index') }}"
                            class="nav-link ps-4 {{ request()->routeIs('ventas.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-plus"></i>
                                <p>Registrar venta</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('ventas.historial') }}"
                            class="nav-link ps-4 {{ request()->routeIs('ventas.historial') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-clock-history"></i>
                                <p>Historial</p>
                            </a>
                        </li>

                    </ul>
                </li>

                {{-- HISTORIAL --}}
                <li class="nav-item">
                    <a href="{{ route('historial.general') }}"
                    class="nav-link {{ request()->routeIs('historial.general') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-list-task"></i>
                        <p>Historial de elaboración</p>
                    </a>
                </li>

                {{-- AJUSTES --}}
                <li class="nav-header">AJUSTES</li>

                <li class="nav-item {{ request()->routeIs('profile') ? 'menu-open' : '' }}">
                    <a href="#"
                    class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-person-circle"></i>
                        <p>
                            {{ Auth::user()->name }}
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ route('profile') }}"
                            class="nav-link ps-4 {{ request()->routeIs('profile') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-person"></i>
                                <p>Perfil</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('logout') }}"
                            class="nav-link ps-4"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">

                                <i class="nav-icon bi bi-box-arrow-left"></i>
                                <p>Cerrar Sesión</p>
                            </a>

                            <form id="logout-form"
                                action="{{ route('logout') }}"
                                method="POST"
                                style="display:none;">
                                @csrf
                            </form>
                        </li>

                    </ul>
                </li>

                @auth
                <li class="nav-item">
                    <a href="{{ route('register') }}" class="nav-link">
                        <i class="nav-icon bi bi-person-add"></i>
                        <p>Nuevo usuario</p>
                    </a>
                </li>
                @endauth

        </ul>
    </div>


