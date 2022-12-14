<?php

namespace App\DataTables;

use App\Models\Directorio;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Auth;

class DirectorioDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            // ->addColumn('action', '')
            ->addColumn('nombre', function(Directorio $directorio){
                return
                        Auth::check() && auth()->user()->hasRoles(['administrador']) ?
                        '<div class="d-flex">'.
                            '<a href="'.route('directorios.show', $directorio->id).'" class="link-primary me-auto">'.$directorio->nombre.'</a>'.
                            '<div>'.
                                '<a class="mx-1 link-primary" href="'.route('directorios.edit', $directorio->id).'" title="Editar"><i class="fa-solid fa-pen "></i></a>'.
                                '<a class="mx-1 link-warning" href="'.route('issues.create', ['directorio_id' => $directorio->id]).'"  title="Reportar Novedad"><i class="fa-solid fa-file-circle-plus "></i></a>'.
                                '<a class="mx-1 link-danger" href="#" onclick="document.getElementById(\'delete-user-'.$directorio->id.'\').submit()"  title="Eliminar"><i class="fa-solid fa-trash-can "></i></a>'.
                            '</div>'.
                        '</div>'.
                        '<form class="d-none" id="delete-user-'.$directorio->id.'" action="'.route('directorios.destroy', $directorio->id).'" method="post">'.
                            method_field('delete').
                            csrf_field().
                        '</form>'  :
                        '<div class="d-flex">'.
                            '<a href="'.route('directorios.show', $directorio->id).'" class="link-primary me-auto">'.$directorio->nombre.'</a>'.
                            '<div>'.
                                '<a class="mx-1 link-warning" href="'.route('issues.create', ['directorio_id' => $directorio->id]).'"><i class="fa-solid fa-file-circle-plus "></i></a>'.
                            '</div>'.
                        '</div>'
                        ;
            })
            ->addColumn('correo', function(Directorio $directorio){
                return '<a href="mailto:'.$directorio->correo.'" class="link-primary">'.$directorio->correo.'</a>';
            })
            ->addColumn('area', function(Directorio $directorio){
                return '<a href="'.route('areas.show', $directorio->area->id).'" class="link-primary">'.$directorio->area->nombre.'</a>';
            })
            ->addColumn('dependencia', function(Directorio $directorio){
                return '<a href="'.route('dependencias.show', $directorio->dependencia->id).'" class="link-primary">'.$directorio->dependencia->nombre.'</a>';
            })
            ->addColumn('telefono', function(Directorio $directorio){
                return '<a href="tel:'.$directorio->dependencia->telefono.'" class="link-primary">'.$directorio->dependencia->telefono.'</a>';
            })
            ->addColumn('extension', function(Directorio $directorio){
                return $directorio->extension;
            })
            ->filter(function($query){
                $request = request()->query('search');
                if ($request['value']) {
                    $searchValues = explode(" ", $request['value']);
                    foreach ($searchValues as $value) {
                        $orderBy[] = 'SIGN(LOCATE(\''.$value.'\',`nombre`)) +';
                        $orderBy[] = 'SIGN(LOCATE(\''.$value.'\',`usuario_de_red`)) +';
                    }
                    $query
                    ->Where(function ($query) use ($searchValues) {
                        foreach ($searchValues as $value) {
                            $query->where('nombre', 'like', "%{$value}%");
                            $query->orWhere('usuario_de_red', 'like', "%{$value}%");
                        }
                    })
                    ->orWhereHas('area', function ($query) use ($searchValues){
                        foreach ($searchValues as $value) {
                            $query->where('areas.nombre', 'like', "%{$value}%");
                        }
                    })
                    ->orWhereHas('dependencia', function ($query) use ($searchValues){
                        foreach ($searchValues as $value) {
                            $query->where('dependencias.nombre', 'like', "%{$value}%");
                        }
                    })
                    ->orderByRaw(substr(implode(' ', $orderBy),0,strlen(implode(' ', $orderBy))-1).'DESC')
                    ;
                };
            })

            ->rawColumns(['nombre','correo','area','dependencia','telefono','Acciones']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Directorio $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Directorio $model)
    {
        return $model
                ->newQuery()
                ->select('directorios.*')
                ->with(['dependencia','area'])
                //->orderBy('nombre', 'asc')
                ;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('directorio-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('
                            <"d-md-flex"
                                <"mx-2"B>
                                <"m-2"l>
                                <"toggler m-2">
                                <"m-2 ms-auto"f>
                            >
                            <tr>
                            <"d-md-flex"
                                <"mx-2"i>
                                <"mx-2 ms-auto"p>
                            >'
                        )
                    ->orderBy(0, 'asc')
                    ->parameters([
                        'responsive' => true,
                        'buttons' => [
                            [
                                'extend' => 'excel',
                                'text' => '<i class="fas fa-file-excel fa-lg"></i><span class="ml-2">A Excel</span>',
                                'className' => 'btn btn-sm btn-success m-2',
                            ]
                        ],
                        'initComplete' => 'function(){
                            if(getQueryParameter(\'searchInputTrigger\')){
                                var table = $("#directorio-table").DataTable();
                                table.search( getQueryParameter(\'searchInputTrigger\') ).draw()

                                const removeValue = (params, key, valueToRemove) => {
                                    const values = params.getAll(key);
                                    if (values.length) {
                                        params.delete(key);
                                        for (const value of values) {
                                            // BEWARE, remember the values will have been
                                            // covnerted to string
                                            if (value !== valueToRemove) {
                                                params.append(key, value);
                                            }
                                        }
                                    }
                                    return params; // For chaining if desired
                                };

                                const params = new URLSearchParams();
                                removeValue(params, "searchInputTrigger", getQueryParameter(\'searchInputTrigger\'));

                            }
                        }',
                    ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        return [
            // Column::computed('action')
            //       ->exportable(false)
            //       ->printable(false)
            //       ->width(60)
            //       ->addClass('dt-control'),
            Column::make('nombre'),
            Column::make('usuario_de_red'),
            Column::make('telefono'),
            Column::make('extension'),
            Column::make('area'),
            Column::make('dependencia'),
            Column::make('correo'),
            // Column::make('Acciones'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Directorio_' . date('YmdHis');
    }
}
