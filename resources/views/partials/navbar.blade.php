<nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark d-flex flex-md-nowrap sticky-top navbar-expand-xl shadow px-5">
    <div class="container-fluid">
        <button class="navbar-toggler mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">

                @if (auth()->check())
                    <li class="nav-item">
                        <button class="btn btn-dark d-sm-block border border-secondary" type="button" id="sidebarCollapse" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                            <a class="d-md-block">
                                <img src="/img/logo_banner.png" class="d-inline-block" alt="">
                            </a>
                        </button>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link ml-2 {{ setActive('/')}}" href="/">Inicio</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link ml-2 {{ setActive('directorios.*')}}" href="{{ route('directorios.index') }}">Directorio<span class="sr-only">(current)</span></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link ml-2 {{ setActive('gerencias.*')}}" href="{{ route('gerencias.index') }}">Gerencias<span class="sr-only">(current)</span></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link ml-2 {{ setActive('areas.*')}}" href="{{ route('areas.index') }}">Áreas<span class="sr-only">(current)</span></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link ml-2 {{ setActive('dependencias.*')}}" href="{{ route('dependencias.index') }}">Dependencias<span class="sr-only">(current)</span></a>
                </li>

                @if (auth()->check() && auth()->user()->hasRoles(['administrador']))
                    <li class="nav-item">
                        <a class="nav-link ml-2 {{ setActive('issues.*')}}" href="{{ route('issues.index') }}">Novedades<span class="sr-only">(current)</span></a>
                    </li>
                @endif

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle ml-2" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Enlaces
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" target="_blank" href="https://amigo.flamingo.com.co/otrs/index.pl">Amigo</a></li>
                        <li><a class="dropdown-item" target="_blank" href="https://360.flamingo.com.co/otrs/index.pl">Flamingo 360</a></li>
                        <li><a class="dropdown-item" target="_blank" href="https://almacenesflamingo.sharepoint.com/sites/servicioclienteoficinas/">Manual de Operaciones</a></li>
                    </ul>
                </li>
            </ul>
            @if (Auth::check() && auth()->user()->hasRoles(['administrador']))
                <div id="notifyContainer" class="mr-5">
                    <a href="{{ App\Models\Issue::all()->count() > 0 ? route('issues.index') : '#' }}" class="position-relative badge rounded-pill {{ App\Models\Issue::all()->count() > 0 ? 'bg-warning' : '' }}">
                        <i class="fa-solid fa-bell"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">@if ( App\Models\Issue::all()->count() > 0 ) {{ App\Models\Issue::all()->count() }} @endif</span>
                    </a>
                </div>
            @endif
            @if (Auth::check())
            <div class=" sm:flex sm:items-center sm:ml-6">
                <!-- Teams Dropdown -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                <div class="ml-3 relative">
                    <x-jet-dropdown align="right" width="60">
                        <x-slot name="trigger">
                            <span class="inline-flex rounded-md">
                                <button type="button"
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                                    {{ Auth::user()->currentTeam->name }}

                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </span>
                        </x-slot>

                        <x-slot name="content">
                            <div class="w-60">
                                <!-- Team Management -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Manage Team') }}
                                </div>

                                <!-- Team Settings -->
                                <x-jet-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                    {{ __('Team Settings') }}
                                </x-jet-dropdown-link>

                                @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                <x-jet-dropdown-link href="{{ route('teams.create') }}">
                                    {{ __('Create New Team') }}
                                </x-jet-dropdown-link>
                                @endcan

                                <div class="border-t border-gray-100"></div>

                                <!-- Team Switcher -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Switch Teams') }}
                                </div>

                                @foreach (Auth::user()->allTeams() as $team)
                                <x-jet-switchable-team :team="$team" />
                                @endforeach
                            </div>
                        </x-slot>
                    </x-jet-dropdown>
                </div>
                @endif

                <!-- Settings Dropdown -->
                <div class="ml-3 relative">
                    <x-jet-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                            <button
                                class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                                    alt="{{ Auth::user()->name }}" />
                            </button>
                            @else
                            <span class="inline-flex rounded-md">
                                <button type="button"
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                    {{ Auth::user()->name }}

                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>

                            <x-jet-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Profile') }}
                            </x-jet-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                            <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                                {{ __('API Tokens') }}
                            </x-jet-dropdown-link>
                            @endif

                            <div class="border-t border-gray-100"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-jet-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                    {{ __('Log Out') }}
                                </x-jet-dropdown-link>
                            </form>
                        </x-slot>
                    </x-jet-dropdown>
                </div>
            </div>
            @else
            <span class="inline-flex rounded-md">
                <a class="btn btn-light" href="{{ route('login') }}">Iniciar Sesión</a>
            </span>
            @endif

        </div>
    </div>
</nav>
