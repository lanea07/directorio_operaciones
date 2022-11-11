<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Directorio;
use App\Models\Area;
use App\Models\Dependencia;
use Livewire\WithPagination;

class ShowDirectorios extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $nameFilter = '';
    public $orderByName = 'asc';
    public $areasFilter = [];
    public $dependenciasFilter = [];

    public function render()
    {
        $nameFilter = str_replace(' ', '%', $this->nameFilter);
        $areasFilter = $this->areasFilter;
        $dependenciasFilter = $this->dependenciasFilter;
        return view('livewire.show-directorios', [
            'directorios' => Directorio::with(['dependencia','area','issue'])
                                ->where(function($query) use($nameFilter, $areasFilter, $dependenciasFilter) {
                                    if ($nameFilter){
                                        $query->where('nombre', 'LIKE', '%'.$nameFilter.'%');
                                    }
                                    if ($areasFilter) {
                                        $query->WhereIn('area_id', $areasFilter);
                                    }
                                    if ($dependenciasFilter) {
                                        $query->WhereIn('dependencia_id', $dependenciasFilter);
                                    }
                                })
                                ->orderBy('nombre', $this->orderByName)
                                ->paginate(8),
            'areas' => Area::orderBy('nombre')->get(),
            'dependencias' => Dependencia::orderBy('nombre')->get(),
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
