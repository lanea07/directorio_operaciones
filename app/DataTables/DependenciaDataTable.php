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
            return '<a href="'.route('dependencias.show', $dependencia->id).'" class="link-primary">'.$dependencia->nombre.'</a>';
        })
        ->addColumn('Acciones', function(Dependencia $dependencia){
            return
                Auth::check() && auth()->user()->hasRoles(['administrador']) ?
                '<div class="btn-group d-none">'.
                    '<a class="btn btn-primary btn-sm" href="'.route('dependencias.edit', $dependencia->id).'">Editar</a>'.
                    '<a class="btn btn-outline-danger btn-sm" href="#" onclick="document.getElementById(\'delete-user-'.$dependencia->id.'\').submit()">Eliminar</a>'.
                '</div>'.
                '<form class="d-none" id="delete-user-'.$dependencia->id.'" action="'.route('dependencias.destroy', $dependencia->id).'" method="post">'.
                    method_field('delete').
                    csrf_field().
                '</form>' :
                '<div class="btn-group d-none">'.
                    '<a class="btn btn-success btn-sm" href="'.route('login').'">Iniciar Sesión</a>'.
                '</div>'
                ;
        })
        ->rawColumns(['nombre','Acciones']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \Dependencia $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Dependencia $model): QueryBuilder
    {
        return $model->newQuery()->orderBy('nombre', 'asc');
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
                    ->dom('lfrtip')
                    ->orderBy(1, 'asc')
                    ->parameters([
                        'initComplete' => "function() {
                            $('#dependenciadatatable-table > tbody > tr').hover(
                                function(){
                                    $(this).find('div.btn-group').removeClass('d-none');
                                },
                                function(){
                                    $(this).find('div.btn-group').addClass('d-none');
                                }
                            );
                        }",
                        'responsive' => true,
                    ])
                    // ->buttons(
                    //     Button::make('create'),
                    //     Button::make('export'),
                    //     Button::make('print'),
                    //     Button::make('reset'),
                    //     Button::make('reload')
                    // );
                    ;
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
            Column::make('Acciones'),
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
