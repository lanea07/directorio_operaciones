<div class="container-fluid mt-5">
    <div class="d-flex justify-content-end">
        <div class="m-3 col-2">
            <input wire:model="nameFilter" type="text" class="form-control" id="nameFilter" placeholder="Buscar...">
        </div>
    </div>

    <div class="row">
        <div class="col-2 vh-100 overflow-auto">

            <select class="form-select form-select-lg" aria-label="Ordenar por nombre..." wire:model="orderByName">
                <option value="asc">Ascendente</option>
                <option value="desc">Descendente</option>
            </select>


            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAreas" aria-expanded="true" aria-controls="collapseAreas">
                        Áreas
                    </button>
                    </h2>
                    <div id="collapseAreas" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        @foreach ($areas as $area)
                            <div class="form-check">
                                <input id="area-{{ $area->id }}" wire:model="areasFilter" class="form-check-input" type="checkbox" value="{{ $area->id }}">
                                <label class="form-check-label" for="area-{{ $area->id }}">{{ $area->nombre }}</label>
                            </div>
                        @endforeach
                    </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDependencias" aria-expanded="true" aria-controls="collapseDependencias">
                        Dependencias
                    </button>
                    </h2>
                    <div id="collapseDependencias" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        @foreach ($dependencias as $dependencia)
                            <div class="form-check">
                                <input id="dependencia-{{ $dependencia->id }}" wire:model="dependenciasFilter" class="form-check-input" type="checkbox" value="{{ $dependencia->id }}">
                                <label class="form-check-label" for="dependencia-{{ $dependencia->id }}">{{ $dependencia->nombre }}</label>
                            </div>
                        @endforeach
                    </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-10">
            <div class="row">

                @foreach ($directorios as $directorio)
                    <article class="col-12 col-sm-6 col-xl-4 col-xxl-3  d-flex justify-content-center  pb-5">

                        <div class="card" style="width: 18rem;">
                            <div class="imgContainer">
                                <img class="card-img-top" src="https://ui-avatars.com/api/?name={{ $directorio->nombre }}&size=128&format=svg&background=random&length=3" >
                            </div>

                            <div class="card-body" style="height: 5rem;">
                                <a href="{{ route('directorios.show', $directorio->id) }}" class="link-info">{{ $directorio->nombre }}</a>
                                <h6>{{ $directorio->dependencia->nombre }} - {{ $directorio->area->nombre }}</h6>
                            </div>
                        </div>
                    </article>

                @endforeach

            </div>
        </div>
        <div class="mt-5">
            {{ $directorios->withQueryString()->links() }}
        </div>
    </div>

</div>
