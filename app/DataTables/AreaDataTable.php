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
                return '<a href="'.route('areas.show', $area->id).'" class="link-primary">'.$area->nombre.'</a>';
            })
            ->addColumn('Gerencia', function(Area $area){
                return '<a href="'.route('gerencias.show', $area->gerencia->id).'" class="link-primary">'.$area->gerencia->nombre.'</a>';
            })
            ->addColumn('Acciones', function(Area $area){
                return
                    Auth::check() && auth()->user()->hasRoles(['administrador']) ?
                    '<div class="btn-group d-none">'.
                        '<a class="btn btn-primary btn-sm" href="'.route('areas.edit', $area->id).'">Editar</a>'.
                        '<a class="btn btn-outline-danger btn-sm" href="#" onclick="document.getElementById(\'delete-user-'.$area->id.'\').submit()">Eliminar</a>'.
                    '</div>'.
                    '<form class="d-none" id="delete-user-'.$area->id.'" action="'.route('areas.destroy', $area->id).'" method="post">'.
                        method_field('delete').
                        csrf_field().
                    '</form>' :
                    '<div class="btn-group d-none">'.
                        '<a class="btn btn-success btn-sm" href="'.route('login').'">Iniciar Sesión</a>'.
                    '</div>'
                    ;
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
        return $model->with(['gerencia'])->newQuery()->orderBy('nombre', 'asc');
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
                    ->dom('lfrtip')
                    ->orderBy(0, 'asc')
                    ->parameters([
                        'initComplete' => "function() {
                            $('#areadatatable-table > tbody > tr').hover(
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
            Column::make('Gerencia')
                ->searchable(true),
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
        return 'Area_' . date('YmdHis');
    }
}
