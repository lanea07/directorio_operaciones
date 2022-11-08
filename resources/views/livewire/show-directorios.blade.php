<div class="container-fluid mt-5">
    <div class="d-flex justify-content-end">
        <div class="m-3 col-2">
            <input wire:model="nameFilter" type="text" class="form-control" id="nameFilter" placeholder="Buscar...">
        </div>
    </div>

    <div class="row">
        <div class="col-2">
            <select class="form-select" aria-label="Ordenar por nombre..." wire:model="orderByName">
                <option value="asc">Ascendente</option>
                <option value="desc">Descendente</option>
            </select>
        </div>
        <div class="col-10">
            <div class="row">

                @foreach ($directorios as $directorio)
                    <article class="col-12 col-sm-6 col-xl-4 col-xxl-3  d-flex justify-content-center  pb-5">

                        <div class="card" style="width: 18rem;">
                            <div class="imgContainer">
                                <img class="card-img-top" src="https://ui-avatars.com/api/?name={{ $directorio->nombre }}&size=128&format=svg" >
                            </div>

                            <div class="card-body" style="height: 5rem;">
                                <p class="card-title">{{ $directorio->nombre }}</p>
                                <h6>{{ $directorio->dependencia->nombre }} - {{ $directorio->area->nombre }}</h6>
                            </div>
                        </div>
                    </article>

                @endforeach

            </div>
        </div>
        <div class="mt-5">
            {{ $directorios->links() }}
        </div>
    </div>

</div>
