<?php

namespace App\DataTables;

use App\Models\Dependencia;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Auth;

class DependenciaDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('action', '')
        ->addColumn('nombre', function(Dependencia $dependencia){
            return
                Auth::check() && auth()->user()->hasRoles(['administrador']) ?
                '<div class="d-flex">'.
                '<a href="'.route('dependencias.show', $dependencia->id).'" class="link-primary me-auto">'.$dependencia->nombre.'</a>'.
                    '<div>'.
                        '<a class="mx-1 link-primary" href="'.route('dependencias.edit', $dependencia->id).'" title="Editar"><i class="fa-solid fa-pen "></i></a>'.
                        '<a class="mx-1 link-warning" href="'.route('issues.create', ['dependencia_id' => $dependencia->id]).'"  title="Reportar Novedad"><i class="fa-solid fa-file-circle-plus "></i></a>'.
                        '<a class="mx-1 link-danger" href="#" onclick="document.getElementById(\'delete-user-'.$dependencia->id.'\').submit()"  title="Eliminar"><i class="fa-solid fa-trash-can "></i></a>'.
                    '</div>'.
                '</div>'.
                '<form class="d-none" id="delete-user-'.$dependencia->id.'" action="'.route('dependencias.destroy', $dependencia->id).'" method="post">'.
                    method_field('delete').
                    csrf_field().
                '</form>'  :
                '<div class="d-flex">'.
                '<a href="'.route('dependencias.show', $dependencia->id).'" class="link-primary me-auto">'.$dependencia->nombre.'</a>'.
                    '<div>'.
                        '<a class="mx-1 link-warning" href="'.route('issues.create', ['dependencia_id' => $dependencia->id]).'"><i class="fa-solid fa-file-circle-plus"></i></a>'.
                    '</div>'.
                '</div>'
                ;
        })
        ->rawColumns(['nombre']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \Dependencia $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Dependencia $model): QueryBuilder
    {
        return $model
                ->newQuery()
                ->orderBy('nombre', 'asc')
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
                    ->setTableId('dependenciadatatable-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Blfrtip')
                    ->orderBy(1, 'asc')
                    ->parameters([
                        'responsive' => true,
                        'buttons' => [
                            [
                                'extend' => 'excelHtml5',
                                'className' => 'btn btn-sm btn-success m-2',
                                'text' => '<i class="fas fa-file-excel fa-lg"></i><span class="ml-2">A Excel</span>',
                            ]
                        ],
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
            Column::make('nombre'),
            Column::make('direccion'),
            Column::make('telefono'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Dependencia_' . date('YmdHis');
    }
}
