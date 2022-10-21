    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <div id="sidebarHeader" class="row d-flex justify-content-around p-3">
                <button type="button" id="homeLogo" class="btn bg-transparent d-sm-block border border-secondary py-3">
                    <a class="d-sm-block" href="">
                        <img src="/img/logo_banner.png" height="35" class="d-inline-block" alt="">
                    </a>
                </button>
            </div>
        </div>

        <div class="offcanvas-body">
            @if (Auth::check())
            <div class="accordion mb-2" id="directorioAcordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseDirectorioAcordion" aria-expanded="true" aria-controls="collapseDirectorioAcordion">
                            Opciones de Directorio
                        </button>
                    </h2>
                    <div id="collapseDirectorioAcordion" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#directorioAcordion">
                        <div class="accordion-body">
                            <ul class="nav flex-column pl-3">

                                <li class="nav-item">
                                    <a id="nuevousuario" class="nav-link {{ setActive('areas.create')}}" href="{{ route('areas.create') }}">
                                        <i class="mr-2 fa-solid fa-folder-tree"></i>Nueva Área
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a id="nuevousuario" class="nav-link {{ setActive('dependencias.create')}}" href="{{ route('dependencias.create') }}">
                                        <i class="mr-2 fa-solid fa-layer-group"></i>Nueva Dependencia
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a id="nuevousuario" class="nav-link {{ setActive('gerencias.create')}}" href="{{ route('gerencias.create') }}">
                                        <i class="mr-2 fa-brands fa-screenpal"></i>Nueva Gerencia
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a id="nuevousuario" class="nav-link {{ setActive('directorios.create')}}" href="{{ route('directorios.create') }}">
                                        <i class="mr-2 fas fa-user"></i> Nuevo Contacto
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion mb-2" id="usersAcordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseUsersAcordion" aria-expanded="true" aria-controls="collapseUsersAcordion">
                            Opciones de Usuarios
                        </button>
                    </h2>
                    <div id="collapseUsersAcordion" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#usersAcordion">
                        <div class="accordion-body">
                            <ul class="nav flex-column pl-3">

                                <li class="nav-item">
                                    <a id="nuevousuario" class="nav-link {{ setActive('users.create')}}" href="{{ route('users.create') }}">
                                        <i class="mr-2 fa-solid fa-user-plus"></i>Crear Usuario
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a id="nuevousuario" class="nav-link {{ setActive('users.index')}}" href="{{ route('users.index') }}">
                                        <i class="mr-2 fa-solid fa-users-gear"></i>Listado
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="row d-flex justify-content-center align-items-center mx-3 h-75 text-secondary">
                <a class="btn d-flex flex-column btn-outline-light" href="{{ route('login') }}">
                    Debes iniciar sesión
                    <i class="fas fa-sign-in-alt fa-6x"></i>
                    para ver este contenido
                </a>
            </div>
            @endif
        </div>
    </div>
