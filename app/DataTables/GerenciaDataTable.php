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
                return '<a href="'.route('gerencias.show', $gerencia->id).'" class="link-primary">'.$gerencia->nombre.'</a>';
            })
            ->addColumn('Acciones', function(Gerencia $gerencia){
                return
                    Auth::check() && auth()->user()->hasRoles(['administrador']) ?
                    '<div class="btn-group d-none">'.
                        '<a class="btn btn-primary btn-sm" href="'.route('gerencias.edit', $gerencia->id).'">Editar</a>'.
                        '<a class="btn btn-outline-danger btn-sm" href="#" onclick="document.getElementById(\'delete-user-'.$gerencia->id.'\').submit()">Eliminar</a>'.
                    '</div>'.
                    '<form class="d-none" id="delete-user-'.$gerencia->id.'" action="'.route('gerencias.destroy', $gerencia->id).'" method="post">'.
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
     * @param \Gerencia $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Gerencia $model): QueryBuilder
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
                    ->setTableId('gerenciadatatable-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('lfrtip')
                    ->orderBy(0, 'asc')
                                        ->parameters([
                        'initComplete' => "function() {
                            $('#gerenciadatatable-table > tbody > tr').hover(
                                function(){
                                    $(this).find('div.btn-group').removeClass('d-none');
                                },
                                function(){
                                    $(this).find('div.btn-group').addClass('d-none');
                                }
                            );
                        }",
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
        return 'Gerencia_' . date('YmdHis');
    }
}
