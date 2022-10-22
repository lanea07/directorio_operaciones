<?php

namespace App\DataTables;

use App\Models\Area;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Auth;

class AreaDataTable extends DataTable
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
            ->addColumn('nombre', function(Area $area){
                return
                        Auth::check() && auth()->user()->hasRoles(['administrador']) ?
                        '<div class="d-flex">'.
                            '<a href="'.route('areas.show', $area->id).'" class="link-primary me-auto">'.$area->nombre.'</a>'.
                            '<div>'.
                                '<a class="mx-1" href="'.route('areas.edit', $area->id).'" title="Editar"><i class="fa-solid fa-pen text-primary"></i></a>'.
                                '<a class="mx-1" href="'.route('issues.create', ['area_id' => $area->id]).'"  title="Reportar Novedad"><i class="fa-solid fa-file-circle-plus text-warning"></i></a>'.
                                '<a class="mx-1" href="#" onclick="document.getElementById(\'delete-user-'.$area->id.'\').submit()"  title="Eliminar"><i class="fa-solid fa-trash-can text-danger"></i></a>'.
                            '</div>'.
                        '</div>'.
                        '<form class="d-none" id="delete-user-'.$area->id.'" action="'.route('areas.destroy', $area->id).'" method="post">'.
                            method_field('delete').
                            csrf_field().
                        '</form>'  :
                        '<div class="d-flex">'.
                            '<a href="'.route('areas.show', $area->id).'" class="link-primary me-auto">'.$area->nombre.'</a>'.
                            '<div>'.
                                '<a class="mx-1" href="'.route('issues.create', ['area_id' => $area->id]).'"><i class="fa-solid fa-file-circle-plus text-warning"></i></a>'.
                            '</div>'.
                        '</div>'
                        ;
            })
            ->addColumn('Gerencia', function(Area $area){
                return '<a href="'.route('gerencias.show', $area->gerencia->id).'" class="link-primary">'.$area->gerencia->nombre.'</a>';
            })
            ->rawColumns(['nombre','Gerencia','Acciones']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \Area $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Area $model): QueryBuilder
    {
        return $model
                ->newQuery()
                ->select('areas.*')
                ->with(['gerencia'])
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
                    ->setTableId('areadatatable-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Blfrtip')
                    ->orderBy(0, 'asc')
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
            Column::make('Gerencia'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Area_' . date('YmdHis');
    }
}
