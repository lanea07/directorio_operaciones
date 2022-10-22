<?php

namespace App\DataTables;

use App\Models\Gerencia;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Auth;

class GerenciaDataTable extends DataTable
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
            ->addColumn('nombre', function(Gerencia $gerencia){
                return
                    Auth::check() && auth()->user()->hasRoles(['administrador']) ?
                    '<div class="d-flex">'.
                    '<a href="'.route('gerencias.show', $gerencia->id).'" class="link-primary me-auto">'.$gerencia->nombre.'</a>'.
                        '<div>'.
                            '<a class="mx-1" href="'.route('gerencias.edit', $gerencia->id).'" title="Editar"><i class="fa-solid fa-pen text-primary"></i></a>'.
                            '<a class="mx-1" href="'.route('issues.create', ['gerencia_id' => $gerencia->id]).'"  title="Reportar Novedad"><i class="fa-solid fa-file-circle-plus text-warning"></i></a>'.
                            '<a class="mx-1" href="#" onclick="document.getElementById(\'delete-user-'.$gerencia->id.'\').submit()"  title="Eliminar"><i class="fa-solid fa-trash-can text-danger"></i></a>'.
                        '</div>'.
                    '</div>'.
                    '<form class="d-none" id="delete-user-'.$gerencia->id.'" action="'.route('gerencias.destroy', $gerencia->id).'" method="post">'.
                        method_field('delete').
                        csrf_field().
                    '</form>'  :
                    '<div class="d-flex">'.
                    '<a href="'.route('gerencias.show', $gerencia->id).'" class="link-primary">'.$gerencia->nombre.'</a>'.
                        '<div>'.
                            '<a class="mx-1" href="'.route('issues.create', ['gerencia_id' => $gerencia->id]).'"><i class="fa-solid fa-file-circle-plus text-warning"></i></a>'.
                        '</div>'.
                    '</div>'
                    ;
            })
            ->rawColumns(['nombre']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \Gerencia $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Gerencia $model): QueryBuilder
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
                    ->setTableId('gerenciadatatable-table')
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
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Gerencia_' . date('YmdHis');
    }
}
