<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Directorio;
use App\Models\Area;

class ShowDirectorios extends Component
{
    public $nameFilter = '';
    public $orderByName = 'asc';
    public $areasFilter = [];

    public function render()
    {
        $nameFilter = str_replace(' ', '%', $this->nameFilter);
        $areasFilter = $this->areasFilter;
        return view('livewire.show-directorios', [
            'directorios' => Directorio::with(['dependencia','area','issue'])
                                ->where(function($query) use($nameFilter, $areasFilter) {
                                    if ($nameFilter){
                                        $query->where('nombre', 'LIKE', '%'.$nameFilter.'%');
                                    }
                                    if ($areasFilter) {
                                        $query->WhereIn('area_id', $areasFilter);
                                    }
                                })
                                ->orderBy('nombre', $this->orderByName)
                                ->paginate(8),
            'areas' => Area::all(),
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
