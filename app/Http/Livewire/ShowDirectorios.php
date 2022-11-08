<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Directorio;

class ShowDirectorios extends Component
{
    public $nameFilter = '';
    public $orderByName = 'asc';

    public function render()
    {
        $nameFilter = str_replace(' ', '%', $this->nameFilter);
        return view('livewire.show-directorios', [
            'directorios' => Directorio::with(['dependencia','area','issue'])->where('nombre', 'like', '%'.$nameFilter.'%')->orderBy('nombre', $this->orderByName)->paginate(8),
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
